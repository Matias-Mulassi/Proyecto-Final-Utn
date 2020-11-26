<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FormatoCuit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cuit=\Session::get('cuitcuil');
        \Session::forget('cuitcuil');
        $cuit=str_replace("-", "", $cuit);
        $ac=0;
        for($i=0;$i<strlen($cuit)-1;$i++)
        {
          switch ($i) 
          {
            case 0:
                $ac+=$cuit[$i]*5;
                break;
            case 1:
                $ac+=$cuit[$i]*4;
                break;
            case 2:
                $ac+=$cuit[$i]*3;
                break;
            case 3:
                $ac+=$cuit[$i]*2;
                break;
            
            case 4:
                $ac+=$cuit[$i]*7;
                break;
  
            case 5:
                $ac+=$cuit[$i]*6;
                break;
            case 6:
                $ac+=$cuit[$i]*5;
                break;
            case 7:
                $ac+=$cuit[$i]*4;
                break;
            case 8:
                $ac+=$cuit[$i]*3;
                break;
            case 9:
                $ac+=$cuit[$i]*2;
                break;
          }
  
        }
  
        $decimal=explode('.',round( $ac/11, 1, PHP_ROUND_HALF_UP));
        if(isset($decimal[1]))
        {
            $digitoverificador=11-$decimal[1];
        }

        else
        {
            return false;
        }
        if($digitoverificador==(int)$cuit[strlen($cuit)-1])
        {

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El codigo verificador no es valido o el cuit no verifica.';
    }
}
