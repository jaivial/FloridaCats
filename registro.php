<?php
mysqli_report(MYSQLI_REPORT_ERROR);
require("usaGATOS.php");
$username = $_REQUEST["username"];
$contrasenya = $_REQUEST["contra"];
$nombre = $_REQUEST["nombre"];
$apellido = $_REQUEST["apellido"];
$email = $_REQUEST["email"];

$consulta = "SELECT COUNT(*) FROM usuario WHERE username='$username' AND contrasenya='$contrasenya';";

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
        echo "User already exists!";
    } else {
        $consulta = "INSERT INTO usuario (username,contrasenya,nombre,apellido,email) VALUES ('$username','$contrasenya','$nombre','$apellido','$email');";

        echo $consulta . "<br>";

        if (!$resultado = $mysqli->query($consulta)) {
            echo "Lo sentimos. App falla<br>";
            echo "Error en $consulta <br>";
            echo "Num.error: " . $mysqli->errno . "<br>";
            echo "Error: " . $mysqli->error . "<br>";
            exit;
        } else {
            echo "Se ha grabado el registro de proveedor";
            if (!isset($_COOKIE['sesion'])) {
                setcookie('sesion', 'true', time() + (86400 * 30), '/');
            }
        }
    }
}

?>