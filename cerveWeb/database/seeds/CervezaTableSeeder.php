<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Cerveza;

class CervezaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'nombre' => 'GOLDEN ALE',
                'descripcion' => 'Bastante Suave',
                'precio' => 275.00,
                'image' => 'https://d26lpennugtm8s.cloudfront.net/stores/852/895/products/aga1-2e74632a01ed9eec3d15862910470698-1024-1024.jpg',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime,
                'id_categoria' => 1
            ],

            [
                'nombre' => 'PORTER',
                'descripcion' => 'Bastante Fuerte',
                'precio' => 350.00,
                'image' => 'data:image/jpeg;base64,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',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime,
                'id_categoria' => 2
            ],

            [
                'nombre' => 'AMBER LAGER',
                'descripcion' => 'Bastante Fuerte',
                'precio' => 400.00,
                'image' => 'https://recetasdecerveza.net/wp-content/uploads/2018/07/Recetas-de-International-Amber-Lager.jpg',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime,
                'id_categoria' => 3
            ],


        );
    
        Cerveza::insert($data);
    }
}
