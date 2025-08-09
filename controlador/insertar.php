<?php
require_once(__DIR__ . '/../conexion/db.php');

if (!empty($_POST["btnenviar"])) {

    $imagen = $_FILES["imagen"]["tmp_name"];
    $nombreimagen = basename($_FILES["imagen"]["name"]);
    $tipoImagen = strtolower(pathinfo($nombreimagen, PATHINFO_EXTENSION));
    $directorio = "archivos/";

    if (in_array($tipoImagen, ["jpg", "jpeg", "png"])) {

        $stmt = $db->prepare("INSERT INTO imagenes (nombre, ruta) VALUES (?, '')");
        $stmt->execute([$nombreimagen]);
        $idRegistro = $db->lastInsertId();

        $rutaFinal = $directorio . $idRegistro . "." . $tipoImagen;
        $db->prepare("UPDATE imagenes SET ruta = ? WHERE id = ?")->execute([$rutaFinal, $idRegistro]);

        if (move_uploaded_file($imagen, $rutaFinal)) {
            echo "<div class='alert alert-success'>Imagen subida correctamente: $nombreimagen</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al guardar la imagen al directorio.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>El archivo debe ser JPG, JPEG o PNG.</div>";
    }
}
?>