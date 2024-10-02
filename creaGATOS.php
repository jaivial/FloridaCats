<?php
mysqli_report(MYSQLI_REPORT_ERROR);
$servidor = "localhost";
$usuario = "root";
$clave = "";

@$mysqli = new mysqli($servidor, $usuario, $clave);
if ($mysqli->connect_errno) {
  echo "Fallo conexión a Mysql: " . $mysqli->connect_errno . " " . $mysqli->connect_error;
} else {
  $consulta = "CREATE DATABASE IF NOT EXISTS gatos;";
  if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
  }
}

$basedatos = "gatos";
$mysqli->select_db($basedatos);

$consulta = "CREATE TABLE IF NOT EXISTS usuario ";
$consulta .= "(username VARCHAR(100) NOT NULL PRIMARY KEY, ";
$consulta .= "contrasenya VARCHAR(100) NOT NULL, ";
$consulta .= "nombre VARCHAR(100) NOT NULL, ";
$consulta .= "apellido VARCHAR(200) NOT NULL, ";
$consulta .= "email VARCHAR(200) NOT NULL); ";
if (!$resultado = $mysqli->query($consulta)) {
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: " . $mysqli->errno . "<br>";
  echo "Error: " . $mysqli->error . "<br>";
  exit;
}

$mysqli->select_db($basedatos);

$consulta = "CREATE TABLE IF NOT EXISTS animal (id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, nombre VARCHAR(50) NOT NULL, tipo VARCHAR(50) NOT NULL, color VARCHAR(20) NOT NULL, sexo BOOLEAN NOT NULL, precio DECIMAL(10,2) NOT NULL, foto LONGBLOB NULL, fecha_anyadido TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP); ";
if (!$resultado = $mysqli->query($consulta)) {
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: " . $mysqli->errno . "<br>";
  echo "Error: " . $mysqli->error . "<br>";
  exit;
}

$mysqli->select_db($basedatos);

$consulta = "CREATE TABLE IF NOT EXISTS carrito (
  id_animal INT(11) NOT NULL,
  username_usuario VARCHAR(50) NOT NULL,
  FOREIGN KEY (id_animal) REFERENCES animal (id),
  FOREIGN KEY (username_usuario) REFERENCES usuario(username)
);
";
if (!$resultado = $mysqli->query($consulta)) {
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: " . $mysqli->errno . "<br>";
  echo "Error: " . $mysqli->error . "<br>";
  exit;
}

$mysqli->select_db($basedatos);

$consulta = "CREATE TABLE IF NOT EXISTS compra (
  fecha DATETIME NOT NULL,
  id_animal INT(11) NOT NULL,
  username_usuario VARCHAR(100) NOT NULL,
  FOREIGN KEY (id_animal) REFERENCES animal(id),
  FOREIGN KEY (username_usuario) REFERENCES usuario(username)
);
";
if (!$resultado = $mysqli->query($consulta)) {
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: " . $mysqli->errno . "<br>";
  echo "Error: " . $mysqli->error . "<br>";
  exit;
}

$mysqli->select_db($basedatos);

$consulta = "CREATE TABLE IF NOT EXISTS compra (fecha DATETIME NOT NULL, id_animal INT(11) NOT NULL, username_usuario VARCHAR(100) NOT NULL); ";
if (!$resultado = $mysqli->query($consulta)) {
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: " . $mysqli->errno . "<br>";
  echo "Error: " . $mysqli->error . "<br>";
  exit;
}
