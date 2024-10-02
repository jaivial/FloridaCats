<?php
mysqli_report(MYSQLI_REPORT_ERROR);
$servidor="localhost";
$usuario="root";
$clave="";

@$mysqli = new mysqli($servidor,$usuario,$clave);
if ($mysqli->connect_errno)
{
  echo "Fallo conexión a Mysql: ".$mysqli->connect_errno." ".$mysqli->connect_error;
}
else 

$basedatos="gatos";
$mysqli->select_db($basedatos);

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Michi', 'Munchkin', 'Gris', 1, 344.55, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato1.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}


$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Whiskas', 'Munchkin', 'Gris y blanco', 0, 500, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato2.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}


$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Michi', 'ShortHair', 'Marron y blanco', 1, 700.50, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato3.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Lila', 'British', 'Gris', 1, 420.50, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato4.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Garfield Jr.', 'OrangeStray', 'Naranja', 0, 999, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato5.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Pepe', 'Munchkin', 'Negro y blanco', 1, 3450, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato6.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Lucas', 'British', 'Gris', 1, 700.50, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato7.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Toni', 'Stray', 'Gris', 1, 202, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato8.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Viqui', 'Argentina', 'Negro y blanco', 0, 5, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato9.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

$consulta="INSERT INTO animal (nombre, tipo, color, sexo, precio, foto)
VALUES ('Ramses', 'Egiptshorthair', 'Blanco', 1, 700.50, LOAD_FILE('/Applications/XAMPP/xamppfiles/htdocs/ejemplos/WEB/img/gato10.jpg'));
";
if (!$resultado=$mysqli->query($consulta))
{
  echo "Lo sentimos. App falla<br>";
  echo "Error en $consulta <br>";
  echo "Num.error: ".$mysqli->errno."<br>";
  echo "Error: ".$mysqli->error."<br>";
  exit;
}

?>