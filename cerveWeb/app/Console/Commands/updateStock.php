<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mensaje;
use App\Cerveza;
use App\User;

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
            $administradores = User::where('id_tipo_usuario', '=',2)->get();
            foreach($cervezas as $cerveza)
            {
                $cerveza->cantidadStock+= $cerveza->loteOptimo;
                $cerveza->update();
                
                foreach($administradores as $admin)
                {
                    $mensaje = new Mensaje();
                    $mensaje->id_usuario=$admin->id;
                    $mensaje->cuerpo='Stock: Ingresaron '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre;
                    $mensaje->leido=false;
                    $mensaje->procesado=false;
                    $mensaje->informativo=true;
                    $mensaje->save();
                }
            }

            foreach($mensajes as $mensaje)
            {
                $mensaje->delete();       
            }
        }
        
    }
}
