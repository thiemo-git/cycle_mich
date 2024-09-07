<?php

use App\Models\Trashtype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $default_trashtypes = [
        ['key' => 'plastik', 'note' => 'Plastikmüll gehört in die gelbe Tonne.'],
        ['key' => 'papier', 'note' => 'Papiermüll gehört in die blaue Tonne.'],
        ['key' => 'bio'],
        ['key' => 'rest'],
        ['key' => 'pfand', 'note' => 'Pfandflaschen können beispielsweise bei Getränkemärkten abgegeben werden.']
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->default_trashtypes as $trashtype) {
            Trashtype::create($trashtype);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->default_trashtypes as $trashtype) {
            $model = Trashtype::where('key', $trashtype['key'])->first();
            if (!empty($model)) $model->delete();
        }
    }
};
