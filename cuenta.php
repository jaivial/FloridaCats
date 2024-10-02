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

$consulta = "SELECT username, nombre, apellido, email, contrasenya FROM usuario WHERE username = '{$_COOKIE['usuario']}';";

if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
}

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $username = $fila['username'];
    $nombrepersona = $fila['nombre'];
    $apellido = $fila['apellido'];
    $email = $fila['email'];
    $contasenya = $fila['contrasenya'];
}
?>


<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");
$consulta = "SELECT compra.fecha, animal.foto, animal.nombre, animal.tipo, animal.sexo, animal.precio, COUNT(*) AS repetitions FROM animal INNER JOIN compra ON compra.id_animal = animal.id AND compra.username_usuario = '{$_COOKIE['usuario']}' GROUP BY compra.fecha, animal.foto, animal.nombre, animal.tipo, animal.sexo, animal.precio;";

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
    $fecha = [];

    while ($fila = $resultado->fetch_assoc()) {
        $images[] = $fila['foto'];
        $nombre[] = $fila['nombre'];
        $precio[] = $fila['precio'];
        $sexo[] = $fila['sexo'];
        $tipo[] = $fila['tipo'];
        $repetitions[] = $fila['repetitions'];
        $fecha[] = $fila['fecha'];
    }
}
?>
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

<script>
    window.onload = function () {
        var tablapedidos = document.getElementById('tablapedidos');

        <?php
        foreach ($images as $index => $fotos) {
            ?>
            var tr = document.createElement('tr');
            tr.id = 'trpedido<?php echo $index; ?>';
            tablapedidos.appendChild(tr);

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
            var tr = document.getElementById('trpedido<?php echo $index; ?>');

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
            var tr = document.getElementById('trpedido<?php echo $index; ?>');

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
            var tr = document.getElementById('trpedido<?php echo $index; ?>');

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
            var tr = document.getElementById('trpedido<?php echo $index; ?>');

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

            var tr = document.getElementById('trpedido<?php echo $index; ?>');

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

        <?php
        foreach ($fecha as $index => $date) {
            $formatfecha = date('d/m/Y', strtotime($date));
            ?>
            var tr = document.getElementById('trpedido<?php echo $index; ?>');

            var tdfecha = document.createElement('td');
            tdfecha.id = 'tdfecha<?php echo $index; ?>';
            tr.appendChild(tdfecha);

            var fecha = document.createElement('p');
            fecha.id = 'fecha<?php echo $index; ?>';
            fecha.textContent = '<?php echo $formatfecha; ?>';
            tdfecha.appendChild(fecha);
            <?php
        }
        ?>
    }
</script>


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
        <div class="titulo">
            <h1>SU CUENTA</h1>
        </div>
        <div class="informacionusuario">
            <p>Usuario:
                <?php
                echo $username;
                ?>
            </p>
            <p>Nombre:
                <?php
                echo $nombrepersona;
                ?>
            </p>
            <p>Apellidos:
                <?php
                echo $apellido;
                ?>
            </p>
            <p>E-mail:
                <?php
                echo $email;
                ?>
            </p>
            <p>Contraseña:
                <?php
                echo $contasenya;
                ?>
            </p>
        </div>
    </div>
    <div class="containerinformacionsuario">
        <div class="titulo">
            <h1>HISTORIAL DE PEDIDOS</h1>
        </div>
        <div class="tablapedidos">
            <table id="tablapedidos">
                <tr style="background-color: yellow; height: auto; margin: 0 0 10px 0;">
                    <th style="border-radius: 10px 0px 0px 10px;">Imagen</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th style="border-radius: 0px 10px 10px 0px;">Fecha</th>
                </tr>
            </table>

        </div>

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