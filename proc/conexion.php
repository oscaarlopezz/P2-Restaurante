<?php

$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbbasedatos = "db_restaurante2";

try {
    $conn = new PDO("mysql:host=$dbserver;dbname=$dbbasedatos", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}
