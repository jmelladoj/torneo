<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PAGO DESDE WEB PAY</title>
</head>
<body>
        <h2><b>PAGO DESDE WEB PAY</b></h2>

        <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
            Detalle de transacción: <br><br>

            <ul>
                <li>Rut atleta: {{ $atleta->rut }} </li>
                <li>Nombre atleta: {{ $atleta->nombre }}</li>
                <li>Correo atleta: {{ $atleta->correo }} </li>
                <li>Categoría: {{ $categoria }} </li>
                <li>Valor pagado: {{ $valor_pagado }}</li>
            </ul>
        </p>

        <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
            <br>
            <br>
            <br>
            <img src="{{ asset('img/logo-arena.png') }}" alt="" height="150" width="auto">
        </p>

</body>
</html>
