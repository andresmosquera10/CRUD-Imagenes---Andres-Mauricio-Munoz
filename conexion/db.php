<?php
$databasePath = __DIR__ . '/crud.sqlite';

if (!file_exists($databasePath)) {
    try {
        $db = new PDO("sqlite:" . __DIR__ . '/crud.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("PRAGMA journal_mode = WAL");

        $sql = "CREATE TABLE IF NOT EXISTS imagenes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            ruta TEXT NOT NULL
        )";
        $db->exec($sql);

        echo " Base de datos y tabla 'imagenes' creadas correctamente en 'conexion/crud.sqlite'.";
    } catch (PDOException $e) {
        die("Error al crear la base de datos: " . $e->getMessage());
    }
} else {
    try {
        $db = new PDO("sqlite:" . $databasePath);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>