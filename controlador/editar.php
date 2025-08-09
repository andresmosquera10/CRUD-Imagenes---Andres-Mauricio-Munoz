<?php
require_once(__DIR__ . '/../conexion/db.php');

$mensaje = "";

if (!empty($_POST["btneditar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    $nombreimagen = basename($_FILES["imagen"]["name"]);
    $tipoImagen = strtolower(pathinfo($nombreimagen, PATHINFO_EXTENSION));
    $directorio = "archivos/";

    if (empty($nombreimagen)) {
        $_SESSION['mensaje'] = "<div class='alert alert-danger'>No se ha seleccionado ninguna imagen.</div>";
    }

    if (in_array($tipoImagen, ["jpg", "jpeg", "png"])) {
        $rutaAnterior = __DIR__ . "/../" . $db->query("SELECT ruta FROM imagenes WHERE id='$id'")
            ->fetch(PDO::FETCH_COLUMN);

        if (is_file($rutaAnterior)) {
            unlink($rutaAnterior);
        }

        $rutaFinalRelativa = "archivos/" . $id . "." . $tipoImagen;
        $rutaFinalFisica = __DIR__ . "/../" . $rutaFinalRelativa;

        if (move_uploaded_file($imagen, $rutaFinalFisica)) {
            $db->query("UPDATE imagenes SET nombre= '$nombreimagen', ruta='$rutaFinalRelativa' WHERE id='$id'");
            $_SESSION['mensaje'] = "<div class='alert alert-success'>Imagen actualizada correctamente: $nombreimagen</div>";
        } else {
            $_SESSION['mensaje'] = "<div class='alert alert-danger'>Error al guardar la imagen en el directorio.</div>";
        }
    } else {
        $_SESSION['mensaje'] = "<div class='alert alert-danger'>Formato de imagen no válido. Solo JPG, JPEG o PNG.</div>";
    }
}

header("Location: /CRUD_img/index.php");
exit();