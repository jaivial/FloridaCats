<?php
setcookie("usuario", "__", time() - 1000, "/");
setcookie("password", "__", time() - 1000, "/");
// setcookie("inserta","__",time()-1000,"/");

mysqli_report(MYSQLI_REPORT_ERROR);
require("creaGATOS.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['password'])) {
    $username = $_POST["usuario"];
    $contrasenya = $_POST["password"];

    $consulta = "SELECT COUNT(*) FROM usuario WHERE username='$username' AND contrasenya='$contrasenya';";
    if (!$resultado = $mysqli->query($consulta)) {
        echo "Lo sentimos. App falla<br>";
        echo "Error en $consulta <br>";
        echo "Num.error: " . $mysqli->errno . "<br>";
        echo "Error: " . $mysqli->error . "<br>";
        exit;
    }
    $row = $resultado->fetch_row();
    $count = $row[0];

    if ($count > 0) {
        if (!isset($_COOKIE['usuario']) && !isset($_COOKIE['password'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['password'])) {
                $usuario = $_POST['usuario'];
                setcookie('usuario', $usuario, time() + (86400 * 30), '/');
                $password = $_POST['password'];
                setcookie('password', $password, time() + (86400 * 30), '/');
                header('Location: indexlogin.php');
            }
        }
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
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <div class='login' id='login'>
        <div class='head'>
            <h1 class='company'> Florida Cats </h1>
            <p id='login_mensaje' style="display: none" class='login_mensaje'>Usuario no encontrado. <br> Regístrate si
                no tienes una cuenta de usuario.</p>
        </div>
        <div class='form'>
            <form method="post" action="">
                <label for="username">Usuario:</label>
                <input type="text" placeholder='Username' class='text' id='username' name='usuario' required><br>
                <label for="password">Contraseña:</label>
                <input type="password" placeholder='••••••••••••••' class='password' name='password' id='password'
                    required><br>
                <input type="submit" name="enviar" id='do-login' value="Login" class='btn-login' />
            </form>
        </div>
    </div>

    <div class='registro' id='registro' style="display:none">
        <div class='head'>
            <h1 class='titulo'>REGISTRO</h1>
            <p id='mensaje_registro' style="display:none" class='mensaje_registro'>El usuario ya existe. <br> Inicia
                sesión si ya tienes una cuenta.</p>
        </div>
        <div class='form'>
            <form method="post" action="" class='form'>

                <label for="username">USERNAME:</label>
                <input type="text" name="username" id="username" required />

                <label for="contra">CONTRASEÑA:</label>
                <input type="password" name="contra" id="contra" required />

                <label for="nombre">NOMBRE:</label>
                <input type="text" name="nombre" id="nombre" required />

                <label for="apellido">APELLIDO:</label>
                <input type="text" name="apellido" id="apellido" required />

                <label for="email">EMAIL:</label>
                <input type="text" name="email" id="email" required />

                <input type="submit" name="enviar" id='do-login' value="Registro" class='btn-login' />
                <input type="reset" name="borrar" id="borrar" value="Restablecer" class='btn-login' />

            </form>
        </div>
    </div>
    <div class="registro_exito" id='registro_exito' style="display: none">
        <h1>¡Registro completado con éxito!<br><br>Inicia sesión con los datos registrados.</h1>
    </div>


</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario']) && isset($_POST['password'])) {
    $username = $_POST["usuario"];
    $contrasenya = $_POST["password"];

    $consulta = "SELECT COUNT(*) FROM usuario WHERE username='$username' AND contrasenya='$contrasenya';";
    if (!$resultado = $mysqli->query($consulta)) {
        echo "Lo sentimos. App falla<br>";
        echo "Error en $consulta <br>";
        echo "Num.error: " . $mysqli->errno . "<br>";
        echo "Error: " . $mysqli->error . "<br>";
        exit;
    }
    $row = $resultado->fetch_row();
    $count = $row[0];

    if ($count == 0) {
?>
        <script>
            var login_mensaje = document.getElementById('login_mensaje');
            login_mensaje.style.display = "flex";
            var registro_popup = document.getElementById('registro');
            registro_popup.style.display = "flex";
        </script>
<?php
    }
}
?>

<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['contra']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email'])) {
    $username = $_POST["username"];
    $contrasenya = $_POST["contra"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];

    $consulta = "SELECT COUNT(*) FROM usuario WHERE username='$username' OR email='$email';";

    if (!$resultado = $mysqli->query($consulta)) {
        echo "Lo sentimos. App falla<br>";
        echo "Error en $consulta <br>";
        echo "Num.error: " . $mysqli->errno . "<br>";
        echo "Error: " . $mysqli->error . "<br>";
        exit;
    }
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_row();
        $count = $row[0];

        if ($count > 0) {
?>
            <script>
                var registro_popup = document.getElementById('registro');
                registro_popup.style.display = "flex";
                var mensaje_error = document.getElementById('mensaje_registro');
                mensaje_error.style.display = "block";
            </script>
            <?php
        } else {
            $consulta = "INSERT INTO usuario (username,contrasenya,nombre,apellido,email) VALUES ('$username','$contrasenya','$nombre','$apellido','$email');";


            if (!$resultado = $mysqli->query($consulta)) {
                echo "Lo sentimos. App falla<br>";
                echo "Error en $consulta <br>";
                echo "Num.error: " . $mysqli->errno . "<br>";
                echo "Error: " . $mysqli->error . "<br>";
                exit;
            } else {
            ?>
                <script>
                    var registro_exito = document.getElementById('registro_exito');
                    registro_exito.style.display = "flex";
                </script>
<?php
            }
        }
    }
}
?>