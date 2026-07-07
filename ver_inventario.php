<?php
require 'conexionf.php';

$conexion = conect();
$productos = [];
if ($conexion) {
    $stmt = $conexion->query('SELECT * FROM inventario ORDER BY id DESC');
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./imgfares/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <title>Inventario guardado</title>
</head>
<body>
    <div class="w3-container">
        <header class="w3-container fcolor-d5">
            <h1>Inventario guardado</h1>
        </header>
        <div class="w3-panel w3-light-grey">
            <a href="cproductos.html" class="w3-button w3-blue">Crear producto</a>
            <a href="menu.php" class="w3-button w3-teal">Menú</a>
        </div>

        <?php if (!$conexion): ?>
            <div class="w3-panel w3-red">
                <p>No se pudo conectar a la base de datos. Verifica que MySQL esté activo.</p>
            </div>
        <?php elseif (empty($productos)): ?>
            <div class="w3-panel w3-yellow">
                <p>No hay registros guardados todavía.</p>
            </div>
        <?php else: ?>
            <table class="w3-table-all w3-card-4">
                <thead>
                    <tr class="w3-light-grey">
                        <th>ID</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Costo</th>
                        <th>% Venta</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nom_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['costo']); ?></td>
                            <td><?php echo htmlspecialchars($producto['porc_venta']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio_venta']); ?></td>
                            <td><?php echo htmlspecialchars($producto['fecha']); ?></td>
                            <td>
                                <?php if (!empty($producto['Imagen'])): ?>
                                    <img src="imgfares/<?php echo htmlspecialchars($producto['Imagen']); ?>" alt="Imagen" width="100">
                                <?php else: ?>
                                    Sin imagen
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
