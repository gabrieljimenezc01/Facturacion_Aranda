<?php
session_start();
echo "<h1>Estado de la sesión</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "<a href='index.php?page=logout'>Cerrar sesión</a>";
?>