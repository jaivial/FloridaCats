<?php
if (!isset($_COOKIE['usuario']) && !isset($_COOKIE['password'])) {
    header('Location: index.php');

} elseif (isset($_COOKIE['usuario']) && isset($_COOKIE['password'])) {
    $usuario = $_COOKIE['usuario'];
    $password = $_COOKIE['password'];
    mysqli_report(MYSQLI_REPORT_ERROR);
    require("usaGATOS.php");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['realizarcompra'])) {
        mysqli_report(MYSQLI_REPORT_ERROR);
        require("usaGATOS.php");
        $consulta = "INSERT INTO compra (fecha, id_animal, username_usuario) SELECT CURRENT_DATE, id_animal, username_usuario FROM carrito WHERE username_usuario = '{$_COOKIE['usuario']}';";
        

        if (!$resultado = $mysqli->query($consulta)) {
            echo "Lo sentimos. App falla<br>";
            echo "Error en $consulta <br>";
            echo "Num.error: " . $mysqli->errno . "<br>";
            echo "Error: " . $mysqli->error . "<br>";
            exit;
        } else {
            mysqli_report(MYSQLI_REPORT_ERROR);
            require("usaGATOS.php");
            $consulta = "DELETE FROM carrito WHERE username_usuario = '{$_COOKIE['usuario']}';";
            if (!$resultado = $mysqli->query($consulta)) {
                echo "Lo sentimos. App falla<br>";
                echo "Error en $consulta <br>";
                echo "Num.error: " . $mysqli->errno . "<br>";
                echo "Error: " . $mysqli->error . "<br>";
                exit;
        }
    }
    }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restablecer'])) {
        mysqli_report(MYSQLI_REPORT_ERROR);
        require("usaGATOS.php");
        $consulta = "DELETE FROM carrito WHERE username_usuario = '{$_COOKIE['usuario']}';";
        

        if (!$resultado = $mysqli->query($consulta)) {
            echo "Lo sentimos. App falla<br>";
            echo "Error en $consulta <br>";
            echo "Num.error: " . $mysqli->errno . "<br>";
            echo "Error: " . $mysqli->error . "<br>";
            exit;
        } 
    
    }
}
?>

<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");

$consulta = "SELECT COUNT(*) FROM carrito WHERE username_usuario = '{$_COOKIE['usuario']}';";

if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
}

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_row();
    $num = $row[0];
}
?>
<?php
if ($num == 0) {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tabla = document.getElementById('tablacarro');
            tabla.style.display = "none";
            var titulo = document.getElementById('titulo');
            titulo.style.flexDirection = "column";
            var mensajecesta = document.createElement('h1');
            mensajecesta.id = 'mensajecesta';
            mensajecesta.textContent = 'Tu cesta está vacía';
            titulo.appendChild(mensajecesta);

            var realizarcompra = document.getElementById('realizarcompra');
            realizarcompra.style.display = "none";

            var restablecer = document.getElementById('restablecer');
            restablecer.style.display = "none";

            var preciototal = document.getElementById('preciototal');
            preciototal.style.display = "none";
        });
    </script>
    <?php
}
?>



<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");

$consulta = "SELECT SUM(animal.precio) AS 'preciocarrito' FROM animal INNER JOIN carrito ON animal.id = carrito.id_animal AND username_usuario = '{$_COOKIE['usuario']}';";

if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
}

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $preciototal = $fila['preciocarrito'];
} 

if ($preciototal === NULL) {
    $preciototal = 0;
}

?>


<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");
$consulta = "SELECT animal.foto, animal.nombre, animal.tipo, animal.sexo, animal.precio, COUNT(*) AS repetitions FROM animal INNER JOIN carrito ON carrito.id_animal = animal.id AND carrito.username_usuario = '{$_COOKIE['usuario']}' GROUP BY animal.foto, animal.nombre, animal.tipo, animal.sexo, animal.precio;";

if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
} 

if ($resultado->num_rows > 0) {
    $images = [];
    $nombre = [];
    $precio = [];
    $sexo = [];
    $tipo = [];
    $color = [];
    $repetitions = [];

    while ($fila = $resultado->fetch_assoc()) {
        $images[] = $fila['foto'];
        $nombre[] = $fila['nombre'];
        $precio[] = $fila['precio'];
        $sexo[] = $fila['sexo'];
        $tipo[] = $fila['tipo'];
        $repetitions[] = $fila['repetitions'];
    }
}
?>



<script>
    window.onload = function () {
        var tablacarrito = document.getElementById('tablacarrito');

        <?php
        foreach ($images as $index => $fotos) {
            ?>
            var tr = document.createElement('tr');
            tr.id = 'trcarrito<?php echo $index; ?>';
            tablacarrito.appendChild(tr);

            var tdfoto = document.createElement('td');
            tdfoto.id = 'tdfoto<?php echo $index; ?>';
            tdfoto.style.backgroundImage = "url('data:image/jpeg;base64,<?php echo base64_encode($fotos); ?>')";
            tr.appendChild(tdfoto);
            <?php
        }
        ?>

        <?php
        foreach ($nombre as $index => $nombretexto) {
            ?>
            var tr = document.getElementById('trcarrito<?php echo $index; ?>');

            var tdnombre = document.createElement('td');
            tdnombre.id = 'tdnombre<?php echo $index; ?>';
            tr.appendChild(tdnombre);

            var nombre = document.createElement('p');
            nombre.id = 'nombre<?php echo $index; ?>';
            nombre.textContent = '<?php echo $nombretexto; ?>';
            tdnombre.appendChild(nombre);

            <?php
        }
        ?>

        <?php
        foreach ($sexo as $index => $sexotexto) {
            ?>
            var tr = document.getElementById('trcarrito<?php echo $index; ?>');

            var tdsexo = document.createElement('td');
            tdsexo.id = 'tdsexo<?php echo $index; ?>';
            tr.appendChild(tdsexo);

            var sexo = document.createElement('p');
            sexo.id = 'tipo<?php echo $index; ?>';
            if (<?php echo $sexotexto; ?> == 1) {
                sexo.textContent = 'MACHO';
            } else {
                sexo.textContent = 'HEMBRA';
            }
            tdsexo.appendChild(sexo);

            <?php
        }
        ?>
        <?php
        foreach ($repetitions as $index => $cantidad) {
            ?>
            var tr = document.getElementById('trcarrito<?php echo $index; ?>');

            var tdcantidad = document.createElement('td');
            tdcantidad.id = 'tdcantidad<?php echo $index; ?>';
            tr.appendChild(tdcantidad);

            var cantidad = document.createElement('p');
            cantidad.id = 'cantidad<?php echo $index; ?>';
            cantidad.textContent = '<?php echo $cantidad; ?>';
            tdcantidad.appendChild(cantidad);
            <?php
        }
        ?>

        <?php
        foreach ($precio as $index => $preciotexto) {
            ?>
            var tr = document.getElementById('trcarrito<?php echo $index; ?>');

            var tdprecio = document.createElement('td');
            tdprecio.id = 'tdprecio<?php echo $index; ?>';
            tr.appendChild(tdprecio);

            var precio = document.createElement('p');
            precio.id = 'precio<?php echo $index; ?>';
            precio.textContent = '<?php echo $preciotexto; ?>€';
            tdprecio.appendChild(precio);
            <?php
        }
        ?>

        <?php
        foreach ($repetitions as $index => $repetition) {
            ?>
            var repetitionValue = <?php echo $repetition; ?>;
            var precioValue = <?php echo $precio[$index]; ?>;
            var preciototal = repetitionValue * precioValue;

            var tr = document.getElementById('trcarrito<?php echo $index; ?>');

            var tdpreciototal = document.createElement('td');
            tdpreciototal.id = 'tdpreciototal<?php echo $index; ?>';

            var preciototalText = document.createElement('p');
            preciototalText.id = 'preciototaltext<?php echo $index; ?>';
            preciototalText.textContent = preciototal + '€';
            tdpreciototal.appendChild(preciototalText);

            tr.appendChild(tdpreciototal);

            <?php
        }
        ?>
    }
</script>


<?php
if(isset($_COOKIE['usuario']) && isset($_COOKIE['password'])){
 if($_COOKIE['usuario'] == 'javial' && $_COOKIE['password'] == '12') {
    ?>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
       
       var configuracionbutton = document.getElementById('configuracionbutton');
       configuracionbutton.style.display = "flex";


   });
    </script>
    <?php
 }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLORIDA CATS</title>
    <link rel="stylesheet" href="style.css">
</head>

<header class="headerindex">
    <div class="cuenta">
    <a href="configuracion.php" id="configuracionbutton" style="display: none;">
        <img src="img/configuracion.png" alt="" class="homelogo" style="height:30px; margin-left: 0px; margin-right: 10px;">
        <p>Configuracion</p>
        </a>
        <a href="indexlogin.php" style="flex-direction: row-reverse;">
            <p>Inicio</p>
            <img src="img/home.png" alt="" class="homelogo" style="height:30px; margin-left: 0px; margin-right: 10px;">
        </a>
        <a href="cuenta.php">
            <img src="img/cuentalogo.png" alt="">
            <p>Cuenta</p>
        </a>
        <a href="deletecookies.php">
            <div class="cerrarsesion">
                <p>Cerrar Sesión</p>
            </div>
        </a>
    </div>
</header>


<body id='body_index'>
    <div class="container">
        <div class="header">
            <img class='floridalogo' src="img/floridalogo.png" alt="">
            <h1>FLORIDA CATS</h1>
            <div class="carrito">
                <p>
                    <?php echo $num; ?> items
                </p>
                <p>
                    <?php echo $preciototal; ?>€
                </p>
                <a class='carritolink' href="carrito.php">
                    <p class='carritotexto'>Carrito</p>
                    <img src="img/carrito.png" alt="">
                </a>
            </div>
        </div>
    </div>

    <div class="containerinformacionsuario">
        <div class="titulo" id='titulo'>
            <h1>SU CESTA</h1>

        </div>
        <div class="tablacarrito" id="tablacarro">
            <table id="tablacarrito">
                <tr>
                    <th style="border-radius: 10px 0px 0px 10px;">Imagen</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th style="border-radius: 0px 10px 10px 0px;">Precio Total</th>
                </tr>
            </table>
        </div>
        <div class="preciototal" id="preciototal">
            <p>Sub-Total:
                <?php echo $preciototal; ?>€
            </p>
        </div>


        <form action="" method="post" id='realizarcompra'>
            <input type="submit" value="Realizar Compra" name="realizarcompra" id="realizarcompra"
                class="realizarcompra">
        </form>
        <form action="" method="post" id='restablecer'>
            <input type="submit" value="Restablecer" name="restablecer" id="realizarcompra"
                class="realizarcompra">
        </form>
    </div>

</body>


<footer>
    <div class="footercontainer">
        <div class="logocontainer">
            <img src="img/logofooter.jpg" alt="" class="imglogofooter">
            <h1>FLORIDA CATS</h1>
        </div>
        <h1>2023</h1>
        <h1>©JAIME VILLANUEVA ALCON</h1>
    </div>
</footer>



</html>