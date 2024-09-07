<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarcodeResource;
use Illuminate\Http\Request;
use App\Models\Barcode;

class BarcodeController extends Controller
{
    public function show(Request $request, int $id) {
        $barcode = Barcode::where(['id' => $id])->whereHas('trashtypes')->first();
        if (empty($barcode)) {
            // Logik für die Speicherung von nicht gefundenen Artikeln

            $barcode = $this->save_to_not_found($id);

            if (!empty($barcode->title)) {
                return response()->json([
                    'message' => "Das Produkt wurde $barcode->title noch nicht verarbeitet",
                    'title' => $barcode->title
                ], 404);
            }
            return response()->json(['message' => 'Das Produkt wurde nicht gefunden'], 404);
        }

        return new BarcodeResource($barcode);
    }

    private function save_to_not_found(int $barcode_id) {
        $barcode = Barcode::where(['id' => $barcode_id])->first();
        if (!empty($barcode)) {
            return $barcode;
        };

        $title = $this->request_product($barcode_id);
        $barcode = Barcode::create([
            'id' => $barcode_id,
            'title' => $title
        ]);

        return $barcode;
    }

    private function request_product(int $barcode_id) {
        $url = "https://ean-db.com/api/v2/product/$barcode_id";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Gibt die Antwort als String zurück
        curl_setopt($ch, CURLOPT_HEADER, false); // Keine Header in der Ausgabe
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Setzt den Content-Type Header
            'Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIyZTg5MjQyOC1kYWU3LTQ5ZjAtYjU3MS00NzFjZDcwZmY5MDkiLCJpc3MiOiJjb20uZWFuLWRiIiwiaWF0IjoxNzI1NzE0MzkwLCJleHAiOjE3NTcyNTAzOTAsImlzQXBpIjoidHJ1ZSJ9.vMmnxIei7RWvH0Rn0o44IqCBJL4yJGqyGoL8FWFwUwDTY0ggNdgfwr2jj1yxxGYkrprtaftLKGYcbVp0HWlenQ' // Falls erforderlich, setze den Authorization Header
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return NULL;
        }
        curl_close($ch);

        $response = json_decode($response, true);
        $titles = $response['product']['titles'];
        if (array_key_exists('de', $titles)) {
            return $titles['de'];
        } else if (array_key_exists('en', $titles)) {
            return $titles['en'];
        } else {
            return $titles[0];
        }
    }
}
