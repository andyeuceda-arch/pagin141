<?php
function conect()
{
    $nom_servidor = "localhost";
    $username = "root";
    $password = "";

    try {
        $conexion = new PDO("mysql:host=$nom_servidor;charset=UTF8", $username, $password, array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ));

        $conexion->exec("CREATE DATABASE IF NOT EXISTS sistem_fares CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci");
        $conexion->exec("USE sistem_fares");
        $conexion->exec(
            "CREATE TABLE IF NOT EXISTS inventario (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                codigo VARCHAR(50) NOT NULL,
                nom_producto VARCHAR(255) NOT NULL,
                costo DECIMAL(12,2) DEFAULT NULL,
                porc_venta VARCHAR(20) DEFAULT NULL,
                precio_venta VARCHAR(20) DEFAULT NULL,
                fecha DATE DEFAULT NULL,
                Imagen VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}

?>