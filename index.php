<?php

require 'vendor/autoload.php';

use Tms\Van;
use Tms\Pasajero;

$vans = array();
$pasajeros = array();

for ($v = 1; $v <= 10; $v ++)
{
    $vans[] = new Van();
}

for ($p = 1; $p <= 30; $p ++)
{
    $pasajeros[] = new Pasajero();
}

/*
for ($t = 1; $t <= 5; $t++) {
	$np = rand (1, 3);
	for($p = 1; $p <= $np; $p++) {
		$pasajeros[] = new Pasajero();
	}
		
}
*/
?>
<html>
<head>

</head>
<body>
<?php
foreach ($pasajeros as $pasajero)
{
    Van::asignarPasajero($pasajero, $vans);
    //$pasajero->imprimeDestino();
}
//Van::imprimePasajeros($vans);
?>
<canvas id="myCanvas" width="1000" height="1000" style="border:1px solid #ededed;">
    Your browser does not support the HTML5 canvas tag.
</canvas>

<script>
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");

    function dibujaGrid() {
        ctx.strokeStyle = '#ededed';
        for(var x = 100; x < 1000; x += 100) {
            ctx.beginPath();
            ctx.moveTo(x, 0);
            ctx.lineTo(x, 1000);
            ctx.stroke();

            ctx.fillStyle = '#ccc';
            ctx.fillText(x.toString(), x + 5, 10);
        }

        for(var y = 100; y < 1000; y += 100) {
            ctx.beginPath();
            ctx.moveTo(0, y);
            ctx.lineTo(1000, y);
            ctx.stroke();

            ctx.fillStyle = '#ccc';
            ctx.fillText(y.toString(), 5, y + 10);
        }
    }

    function dibujaVan(x, y, id) {
        ctx.beginPath();
        ctx.arc(x, y, 100, 0, 2 * Math.PI);
        ctx.strokeStyle = '#000';
        ctx.stroke();

        ctx.font = "50px Arial";
        ctx.strokeText("V" + id, x, y);
    }

    function dibujaPasajero(x, y, id, estado) {
        ctx.beginPath();
        ctx.arc(x, y, 10, 0, 2 * Math.PI);
        if(estado == "en_espera") ctx.fillStyle = "red";
        else if(estado == "servido") ctx.fillStyle = "green";
        ctx.fill();
        ctx.strokeStyle = '#000';
        ctx.stroke();

        ctx.font = "20px Arial";
        ctx.fillStyle = "black";
        ctx.fillText("P" + id, x, y);
    }

    dibujaGrid();
    <?php
        foreach($pasajeros as $pasajero) printf("dibujaPasajero(%d, %d, %d, '%s');\n", $pasajero->x, $pasajero->y, $pasajero->id, $pasajero->estado);
        foreach($vans as $van) printf("dibujaVan(%d, %d, %d);\n", $van->x, $van->y, $van->id);
    ?>
</script>

</body>
</html>