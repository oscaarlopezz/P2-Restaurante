
<?php
session_start();
include_once("./conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php?sesion=nosesion');
    exit();
} else {
    $id = $_SESSION['id_user'];
    $sqlMesa = "SELECT nombre FROM tbl_camareros WHERE id_user = :id";
    $stmt1 = $conn->prepare($sqlMesa);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();
    $nom = $stmt1->fetchColumn();
    if (empty($nom)) {
        $sqlMesa = "SELECT user as nombre FROM tbl_admin WHERE id = :id";
        $stmt2 = $conn->prepare($sqlMesa);
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt2->execute();
        $nom = $stmt2->fetchColumn();
        if (empty($nom)) {
            echo "Error";
        }else{
            try {
                $sql = "DELETE FROM tbl_camareros WHERE `tbl_camareros`.`id_user` = :id";
                $stmt3 = $conn->prepare($sql);
                $stmt3->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                $stmt3->execute();
                echo "actualizado con exitos";
            }catch(PDOException $e) {
               echo $e->getMessage();
               echo "FAIL";
            }
        }
    }else {
        echo "Un camarero no puede modificar camareros porfavor salga";
    }
}