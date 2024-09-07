<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Trashtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request) {
        if (empty(Auth::user())) {
            return view('login');
        }

        return redirect('/admin/list');
    }

    public function list(Request $request) {
        if ($request->get('filter') == 'valid') {
            $barcodes = Barcode::whereHas('trashtypes')->get();
            $heading = 'Öffentliche Barcodes';
        } else if ($request->get('filter') == 'invalid') {
            $barcodes = Barcode::whereDoesntHave('trashtypes')->get();
            $heading = 'Unvollständige Barcodes';
        } else {
            $barcodes = Barcode::all();
            $heading = 'Alle Barcodes';
        }


        return view('list')->with(['barcodes' => $barcodes, 'heading' => $heading]);
    }

    public function login(Request $request) {
        if (Auth::user()) {
            return redirect('/admin/list');
        }
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->forget('language');
            return redirect()->intended('/admin/list');
        }

        return redirect('/admin')->withErrors([
            'credentials' => 'invalid_credentials'
        ]);
    }

    public function item(Request $request, int $id) {
        $barcode = Barcode::findOrFail($id);
        $own_keys = $barcode->trashtypes->pluck('key')->toArray();
        $keys = array();
        foreach(Trashtype::query()->pluck('key')->toArray() as $key) {
            $keys[$key] = in_array($key, $own_keys);
        }

        return view('item')->with(['barcode' => $barcode, 'keys' => $keys]);
    }

    public function edit(Request $request, int $id) {
        $barcode = Barcode::findOrFail($id);
        if (!empty($request->post('title'))) $barcode->title = $request->post('title');
        if (!empty($request->post('notes'))) $barcode->notes = $request->post('notes');

        foreach ($request->post() as $key => $value) {
            if (!str_starts_with($key, 'key_')) continue;
            $key = substr($key, 4);

            $trashtype = Trashtype::where('key', $key)->first();
            if (!empty($trashtype) && !$barcode->trashtypes->contains($trashtype->id)) $barcode->trashtypes()->attach($trashtype->id);
        }

        $barcode->save();

        return redirect('/admin/list');
    }
}
