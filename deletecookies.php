<?php
setcookie("usuario","__",time()-1000,"/");
setcookie("password","__",time()-1000,"/");
// setcookie("inserta","__",time()-1000,"/");
header("Location: index.php");
?>
