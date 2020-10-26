<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mensaje;
use App\Cerveza;

class updateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualización de unidades en stock de cada cerveza artesanal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::all()->where('procesado',true);
        $cervezas=array();
        if(count($mensajes)>0)
        {
            foreach($mensajes as $mensaje)
            {
                foreach($cervezasCerveWeb as $cerveza)
                {
                    $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                    if($pos==true)
                    {
                        array_push($cervezas,$cerveza);
                    }
                }         
            }

            foreach($cervezas as $cerveza)
            {
                $cerveza->cantidadStock+= $cerveza->loteOptimo;
                $cerveza->update();
            }

            foreach($mensajes as $mensaje)
            {
                $mensaje->delete();       
            }
        }
        
    }
}
