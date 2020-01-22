<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YA FALTA POCO PARA COMPLETAR TU REGISTRO EN ARENA 2020</title>
</head>
<body>
    <h2><b>Ya falta poco para completar tu registro en ARENA 2020</b></h2>

    <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
        Para finalizar debes pagar tu inscripción en la categoría <b> {{ $atleta->categoria->nombre_categoria . ' ' . $atleta->categoria->nombre }} </b> por medio de una transferencia bancaria con los datos que se indican a continuación:
    </p>

    <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
        Transferencia bancaria (<b>recuerda que en esta opción debes enviar el comprobante de transferencia a pagos@torneoarena.cl indicando correctamente en el asunto tu nombre (la de la dupla o trio) y categoría</b>). <br><br>
        <b>El valor a transferir de la categoría <b> {{ $atleta->categoria->nombre_categoria . ' ' . $atleta->categoria->nombre }}  </b> es <b> {{ $atleta->categoria->valor }} </b>.-</b><br><br>
        Datos:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;VIVALLOS Y ARIAS LIMITADA<br>
        &nbsp;&nbsp;&nbsp;&nbsp;CUENTA CORRIENTE BANCO BCI<br>
        &nbsp;&nbsp;&nbsp;&nbsp;Nº 61991431<br>
        &nbsp;&nbsp;&nbsp;&nbsp;R.U.T. 76.691.998-7<br>
        &nbsp;&nbsp;&nbsp;&nbsp;pagos@torneoarena.cl
    </p>

    <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">
        - Una vez realizado el pago y dentro de las próximas horas te enviaremos un correo de confirmación validando que ya estas inscrito correctamente.<br>
        - El solo hecho de de haber  completado el formulario de registro no es válido como inscripción ni como reserva de cupos.
        - La inscripción debe ser pagada en su totalidad, en caso de duplas y tríos, no se puede pagar de forma individual.
        - Recuerda incluir el nombre de los atletas en el comprobante de pago.
    </p>

    <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
        <b>DE PARTE DE LA ORGANIZACIÓN, GRACIAS POR QUERER FORMAR PARTE DE TORNEO ARENA 2019</b><br><br><br><br>
        <img src="{{ asset('img/logo-arena.png') }}" alt="" height="150" width="auto">
    </p>
</body>
</html>
</html>
