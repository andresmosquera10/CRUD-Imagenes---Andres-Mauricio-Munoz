<?php
require_once(__DIR__ . '/../conexion/db.php');
session_start();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];



    $rutaAnterior = $db->query("SELECT ruta FROM imagenes WHERE id='$id'")
        ->fetch(PDO::FETCH_COLUMN);

    $db->query("DELETE FROM imagenes WHERE id='$id'");

    if ($rutaAnterior && is_file(__DIR__ . "/../" . $rutaAnterior)) {
        unlink(__DIR__ . "/../" . $rutaAnterior);
    }

    $_SESSION['mensaje'] = "<div class='alert alert-success'>Imagen eliminada correctamente.</div>";
} else {
    $_SESSION['mensaje'] = "<div class='alert alert-danger'>No se seleccionó ninguna imagen para eliminar.</div>";
}

header("Location: /CRUD_img/index.php");
exit();
