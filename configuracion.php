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
    if (isset($_POST['upload'])) {
        $nombre = $_POST['nombre'];
        $tipo = $_POST['raza'];
        $color = $_POST['color'];
        $sexo = $_POST['sexo'];

        if ($sexo === 'Macho') {
            $sexo = 1;
        } elseif ($sexo === 'Hembra') {
            $sexo = 0;
        }

        $precio = $_POST['precio'];
        $foto = file_get_contents($_FILES['imagen']['tmp_name']);

        mysqli_report(MYSQLI_REPORT_ERROR);
        require("usaGATOS.php");
        $consulta = "INSERT INTO animal (nombre, tipo, color, sexo, precio, foto) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->prepare($consulta);
        $stmt->bind_param("ssssds", $nombre, $tipo, $color, $sexo, $precio, $foto);

        if (!$stmt->execute()) {
            echo "Lo sentimos. La aplicación falló.<br>";
            echo "Error en $consulta <br>";
            echo "Num.error: " . $stmt->errno . "<br>";
            echo "Error: " . $stmt->error . "<br>";
            exit;
        } else {
            $stmt->close();
            $mysqli->close();
            header('Location: indexlogin.php');
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
if (isset($_COOKIE['usuario']) && isset($_COOKIE['password'])) {
    if ($_COOKIE['usuario'] == 'javial' && $_COOKIE['password'] == '12') {
?>
<script>
window.addEventListener('DOMContentLoaded', function() {

    var configuracionbutton = document.getElementById('configuracionbutton');
    configuracionbutton.style.display = "flex";


});
</script>
<?php
    }
}
?>

<?php
if (isset($_POST['upload'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;

    $db = mysqli_connect("localhost", "root", "", "geeksforgeeks");

    // Get all the submitted data from the form
    $sql = "INSERT INTO image (filename) VALUES ('$filename')";

    // Execute query
    mysqli_query($db, $sql);

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
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
            <img src="img/configuracion.png" alt="" class="homelogo"
                style="height:30px; margin-left: 0px; margin-right: 10px;">
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
            <h1>CONFIGURACION</h1>

        </div>
        <h1>Añade un gato</h1>

        <form method="POST" action="" enctype="multipart/form-data" class="formularioinsertar">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input class="form-control" type="text" name="nombre" value="" id="nombre" />
            </div>
            <div class="form-group">
                <label for="raza">Raza:</label>
                <input class="form-control" type="text" name="raza" value="" id="raza" />
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input class="form-control" type="text" name="color" value="" id="color" />
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" class="form-control" name="sexo">
                    <option value="Macho">Macho</option>
                    <option value="Hembra">Hembra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input class="form-control" type="text" name="precio" value="" id="precio" />
            </div>
            <div class="form-group">
                <label for="imagen">Selecciona una imagen:</label>
                <input class="form-control" type="file" name="imagen" id="imagen" />
            </div>
            <div class="form-group-submit">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
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