<?php

// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-6391965913754360-102213-e7262e422b291696a0281379b42283bf-662083387'); //aqui va credencial vendedor

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

$preference->back_urls = array(
  "success" => "http://localhost/Proyecto-Final-Utn/cerveWeb/thankyou.php",
  "failure" => "http://localhost/Proyecto-Final-Utn/cerveWeb/errorpago.php?error=failure",
  "pending" => "http://localhost/Proyecto-Final-Utn/cerveWeb/errorpago.php?error=pending"
);
$preference->auto_return = "approved";

$datos=array();
// Crea un ítem en la preferencia
for($x=0;$x<10;$x++)
{
  $item = new MercadoPago\Item();
  $item->title = 'Pantalon';
  $item->quantity = 1;
  $item->unit_price = 12.50;
  $datos[$x]=$item;
}
$preference->items = $datos;
$preference->save();

//credencial cuenta verdadera : TEST-8349645930251561-081120-03354f43073ee47c96641ab439d30f1b-406746381

//curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-6391965913754360-102213-e7262e422b291696a0281379b42283bf-662083387" -d "{'site_id':'MLA'}"


//VENDEDOR
//{"id":662083387,"nickname":"TESTDPWADUEW","password":"qatest2786","site_status":"active","email":"test_user_63532902@testuser.com"}

//COMPRADOR
//{"id":662084793,"nickname":"TESTKO9UJZDY","password":"qatest8998","site_status":"active","email":"test_user_28740156@testuser.com"}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form action="http://localhost/Proyecto-Final-Utn/cerveWeb/insertarpago.php" method="POST">
    <script
    src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
    data-preference-id="<?php echo $preference->id; ?>">
    </script>
  </form>
</body>
</html>

