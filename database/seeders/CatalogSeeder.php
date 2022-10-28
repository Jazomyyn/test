<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    protected static $CATEGORIES= 'categories',
                     $ITEMS = 'items';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addCategories();
        $this->addItems();
    }


    private function addCategories(){
        DB::table(self::$CATEGORIES)->insert([
            [   'name' => 'Playa'],
            [   'name' => 'Bosque'],
            [   'name' => 'Parque de diversiones'],
        ]);
    }

    private function addItems(){
        DB::table(self::$ITEMS)->insert([
            [   'name' => 'Comida'],
            [   'name' => 'Desayuno'],
            [   'name' => 'Tour en español e inglés'],
            [   'name' => 'Paseo en caballo'],
            [   'name' => 'Bebidas'],
            [   'name' => 'Tirolesa'],
            [   'name' => 'Buffet'],
            [   'name' => 'Recorrido en Buggy'],
            [   'name' => 'Espectáculo nocturno'],
            [   'name' => 'Admisión a todos los juegos'],
            [   'name' => 'Niños gratis'],
            [   'name' => 'Casa de terror sin costo adicional'],
            [   'name' => 'Hotel'],
            [   'name' => 'Vuelo'],
        ]);
    }

}
