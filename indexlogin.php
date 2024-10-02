<?php
if (!isset($_COOKIE['usuario']) && !isset($_COOKIE['password'])) {
    header('Location: index.php');

} elseif (isset($_COOKIE['usuario']) && isset($_COOKIE['password'])) {
    $usuario = $_COOKIE['usuario'];
    $password = $_COOKIE['password'];
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitButton'])) {
        $id = $_POST['submitButton'];

        mysqli_report(MYSQLI_REPORT_ERROR);
        require("usaGATOS.php");

        $consulta = "INSERT INTO carrito (id_animal, username_usuario) VALUES ($id, '{$_COOKIE['usuario']}');";

        if (!$resultado = $mysqli->query($consulta)) {
            echo "Lo sentimos. App falla<br>";
            echo "Error en $consulta <br>";
            echo "Num.error: " . $mysqli->errno . "<br>";
            echo "Error: " . $mysqli->error . "<br>";
            exit;
        } else {
            
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
if ($resultado-> num_rows > 0) {
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

$consulta = "SELECT * FROM animal ORDER BY fecha_anyadido DESC";

if (!$resultado = $mysqli->query($consulta)) {
    echo "Lo sentimos. App falla<br>";
    echo "Error en $consulta <br>";
    echo "Num.error: " . $mysqli->errno . "<br>";
    echo "Error: " . $mysqli->error . "<br>";
    exit;
}

$images = [];
$nombre = [];
$precio = [];
$sexo = [];
$tipo = [];
$color = [];
$id = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $images[] = $fila["foto"];
        $nombre[] = $fila["nombre"];
        $precio[] = $fila["precio"];
        $sexo[] = $fila["sexo"];
        $tipo[] = $fila["tipo"];
        $color[] = $fila["color"];
        $id[] = $fila["id"];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ordenar'])) {
        $filtroOrden = $_POST['ordenar'];
        if ($filtroOrden == 'masrecientes') {
            $consulta = "SELECT * FROM animal ORDER BY fecha_anyadido DESC";
        } elseif ($filtroOrden == 'masantiguos') {
            $consulta = "SELECT * FROM animal ORDER BY fecha_anyadido ASC";
        } elseif ($filtroOrden == 'preciomayoramenor') {
            $consulta = "SELECT * FROM animal ORDER BY precio DESC";
        } elseif ($filtroOrden == 'preciomenoramayor') {
            $consulta = "SELECT * FROM animal ORDER BY precio ASC";
        } elseif ($filtroOrden == 'alfabeticodescendente') {
            $consulta = "SELECT * FROM animal ORDER BY nombre DESC";
        } elseif ($filtroOrden == 'alfabeticoascendente') {
            $consulta = "SELECT * FROM animal ORDER BY nombre ASC";
        }
    } else {
        $consulta = "SELECT * FROM animal ORDER BY fecha_anyadido DESC";
    }

    if (!$resultado = $mysqli->query($consulta)) {
        echo "Lo sentimos. App falla<br>";
        echo "Error en $consulta <br>";
        echo "Num.error: " . $mysqli->errno . "<br>";
        echo "Error: " . $mysqli->error . "<br>";
        exit;
    }

    $images = [];
    $nombre = [];
    $precio = [];
    $sexo = [];
    $tipo = [];
    $color = [];
    $id = [];

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $images[] = $fila["foto"];
            $nombre[] = $fila["nombre"];
            $precio[] = $fila["precio"];
            $sexo[] = $fila["sexo"];
            $tipo[] = $fila["tipo"];
            $color[] = $fila["color"];
            $id[] = $fila["id"];
        }
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
        var animalesDiv = document.getElementById('animales');
        
        <?php foreach ($images as $imageData) { ?>
            var animalDiv = document.createElement('div');
            animalDiv.classList.add('animal');

            animalDiv.id = 'animal';

            var fotoAnimalDiv = document.createElement('div');
            fotoAnimalDiv.classList.add('fotoanimal');
            fotoAnimalDiv.style.backgroundImage = "url('data:image/jpeg;base64,<?php echo base64_encode($imageData); ?>')";

            // Append the new div to the animalesDiv
            animalDiv.appendChild(fotoAnimalDiv);

            animalesDiv.appendChild(animalDiv);

        <?php } ?>

        <?php foreach ($nombre as $textoNombre) { ?>
            var animalDiv = document.getElementById('animal');
            var textoDiv = document.createElement('div')
            textoDiv.classList.add('textoDiv');

            var h1nombre = document.createElement('h1');
            h1nombre.classList.add('h1nombre');
            h1nombre.textContent = "<?php echo $textoNombre; ?>";
            // Append the new div to the animalesDiv
            textoDiv.appendChild(h1nombre);
            animalDiv.appendChild(textoDiv);



            animalesDiv.appendChild(animalDiv);
        <?php } ?>

        <?php foreach ($precio as $textoPrecio) { ?>
            var animalDiv = document.getElementById('animal');
            var textoDiv = document.createElement('div')
            textoDiv.classList.add('textoDiv');

            var h2precio = document.createElement('h2');
            h2precio.classList.add('h1nombre');
            h2precio.textContent = "<?php echo $textoPrecio; ?>€";
            // Append the new div to the animalesDiv
            textoDiv.appendChild(h2precio);
            animalDiv.appendChild(textoDiv);

            animalesDiv.appendChild(animalDiv);
        <?php } ?>

        <?php foreach ($tipo as $textoTipo) { ?>
            var animalDiv = document.getElementById('animal');
            var descripcionDiv = document.createElement('div')
            descripcionDiv.classList.add('descripcionDiv');
            descripcionDiv.id = 'descripcion';

            var pTipo = document.createElement('p');
            pTipo.classList.add('pTipo');
            pTipo.textContent = "<?php echo $textoTipo; ?>";
            // Append the new div to the animalesDiv
            descripcionDiv.appendChild(pTipo);
            animalDiv.appendChild(descripcionDiv);

            animalesDiv.appendChild(animalDiv);
        <?php } ?>

        <?php foreach ($sexo as $textoSexo) { ?>
            var animalDiv = document.getElementById('animal');
            var descripcionDiv = document.getElementById('descripcion');


            var pSexo = document.createElement('p');
            pSexo.classList.add('pSexo');
            pSexo.textContent = "<?php echo $textoSexo ? 'MACHO' : 'HEMBRA'; ?>";
            // Append the new div to the animalesDiv
            descripcionDiv.appendChild(pSexo);
            animalDiv.appendChild(descripcionDiv);

            animalesDiv.appendChild(animalDiv);
        <?php } ?>

        <?php foreach ($color as $textoColor) { ?>
            var animalDiv = document.getElementById('animal');
            var descripcionDiv = document.getElementById('descripcion');

            var pColor = document.createElement('p');
            pColor.classList.add('pColor');
            pColor.textContent = "<?php echo $textoColor; ?>";
            // Append the new div to the animalesDiv
            descripcionDiv.appendChild(pColor);
            animalDiv.appendChild(descripcionDiv);

            animalesDiv.appendChild(animalDiv);

        <?php } ?>


        <?php foreach ($id as $idDiv) { ?>
            var animalDiv = document.getElementById('animal');

            var formanimal = document.createElement('form');
            formanimal.method = "POST";
            formanimal.id = 'formanimal';

            var labelagregarcarrito = document.createElement('label');
            labelagregarcarrito.textContent = "AGREGAR AL CARRITO";

            var botonsubmit = document.createElement('input');
            botonsubmit.type = "submit";
            botonsubmit.id = "<?php echo $idDiv; ?>";
            botonsubmit.name = "submitButton";
            botonsubmit.value = "<?php echo $idDiv; ?>";
            botonsubmit.style.display = "none";
            labelagregarcarrito.classList.add('botonSubmit');

            
            var comprarTexto = document.createElement('p');
            comprarTexto.classList.add('comprarTexto');
            comprarTexto.textContent = "AGREGAR AL CARRITO";

            labelagregarcarrito.appendChild(botonsubmit);
            formanimal.appendChild(labelagregarcarrito);
            animalDiv.appendChild(formanimal);

            animalesDiv.appendChild(animalDiv);

        <?php } ?>

    };
</script>



<script>
    window.addEventListener('DOMContentLoaded', function () {
        var ordenarRadios = document.getElementsByName('ordenar');

        for (var i = 0; i < ordenarRadios.length; i++) {
            ordenarRadios[i].addEventListener('change', function () {
                document.forms[0].submit();
            });
        }
    });
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
    <div id='container'></div>

    <div class="container">
        <div class="header">
            <img class='floridalogo' src="img/floridalogo.png" alt="">
            <h1>FLORIDA CATS</h1>
            <div class="carrito">
            <p><?php echo $num; ?> items</p>  <p><?php echo $preciototal; ?>€</p>
                <a class='carritolink' href="carrito.php">
                    <p class='carritotexto'>Carrito</p>
                    <img src="img/carrito.png" alt="">
                </a>
            </div>
        </div>
    </div>
   
    <form action="" method="post" class="filtro">
        <div class="containerfiltro">
            <p>ORDENAR POR ANTIGUEDAD</p>
            <div class="containerdivorden">
                <div class="divOrden">
                    <input type="radio" name="ordenar" id="masrecientes" value="masrecientes">
                    <label for="masrecientes">Más recientes</label>
                </div>
                <div class="divOrden">
                    <input type="radio" name="ordenar" id="masantiguos" value="masantiguos">
                    <label for="masantiguos">Más antiguos</label>
                </div>
            </div>
        </div>
        <div class="containerfiltro">
            <p>ORDENAR POR PRECIO</p>
            <div class="containerdivorden">
                <div class="divOrden">
                    <input type="radio" name="ordenar" id="preciomayoramenor" value="preciomayoramenor">
                    <label for="preciomayoramenor">Precio de mayor a menor</label>
                </div>

                <div class="divOrden">
                    <input type="radio" name="ordenar" id="preciomenoramayor" value="preciomenoramayor">
                    <label for="preciomenoramayor">Precio de menor a mayor</label>
                </div>
            </div>
        </div>

        <div class="containerfiltro">
            <p>ORDENAR POR NOMBRE</p>
            <div class="containerdivorden">
                <div class="divOrden">
                    <input type="radio" name="ordenar" id="alfabeticodescendente" value="alfabeticodescendente">
                    <label for="alfabeticodescendente">Nombre descendente</label>
                </div>
                <div class="divOrden">
                    <input type="radio" name="ordenar" id="alfabeticoascendente" value="alfabeticoascendente">
                    <label for="alfabeticoascendente">Nombre ascendente</label>
                </div>
            </div>

        </div>
        </div>
    </form>


    <div id="animales">

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