<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Tienda de cerveza Online - Operations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/lumen/bootstrap.min.css" integrity="sha384-VMuWne6iwiifi8iEWNZMw8sDatgb6ntBpBIr67q0rZAyOQwfu/VKpnFntQrjxB5W" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lemonada:wght@500&family=Lobster+Two:ital,wght@1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/mainAdmin.css')}}">
    
</head>
<style type="text/css">
    #foot{margin-bottom:0px;}
    body {
    background-image:url("../imagenes/backgroundOperator.jpg");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
        }
</style>
<body>
    
    @if(\Session::has('message'))
		@include('Administrador.partials.message')
	@endif

    @if(\Session::has('messageError'))
		@include('Administrador.partials.messageError')
	@endif

    @include('include.menuOperator')

    @yield('content')

    @include('Administrador.partials.footer')
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{asset('admin/js/main.js')}}"></script>
</body>
</html>