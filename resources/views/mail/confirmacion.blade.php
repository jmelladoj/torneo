<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YA ERES PARTE DE TORNEO ARENA 2020</title>
</head>
<body>
        <h2><b>YA ERES PARTE DE TORNEO ARENA 2020</b></h2>

        <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
            Hemos validado tu inscripción en la categoría <b> {{ $atleta->categoria->nombre_categoria . ' ' . $atleta->categoria->nombre }} </b> y ya eres parte de los atletas que competirán este 4 y 5 de abril en el COLISEO MONUMENTAL LA TORTUGA DE TALCAHUANO.
            Recuerda estar atento a nuestras redes sociales para estar al día respecto a horarios, wods y novedades del TORNEO.
            También te recomendamos leer las bases para que estes al tanto del método con que se efectuará la competencia así mismo enviar el deslinde de responsabilidad con todos tus datos
            a contacto@torneoarena.cl.
        </p>

        <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
            <h2><b>DESDE YA BIENVENIDO</b></h2>
        </p>

        <p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
            <img src="{{ asset('img/logo-arena.png') }}" alt="" height="200" width="auto">
        </p>

</body>
</html>
