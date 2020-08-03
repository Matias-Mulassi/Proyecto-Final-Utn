<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data= array(
            [
                'nombre'=> 'Rubia',
                'descripcion' => 'Suave',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime
            
            ],

            [

                'nombre'=> 'Negra',
                'descripcion'=>'Fuerte',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime
            ],

            [
                'nombre'=>'Roja',
                'descripcion'=>'Amarga',
                'created_at' =>new DateTime,
                'updated_at' =>new DateTime

            ]

        );

        Categoria::insert($data);
    }
}
