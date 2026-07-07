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
    <link rel="icon" href="./imgfares/FAVICON.jpg" type="image/jpg" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/diseñocssf.css"> 
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="./JScript/acciones_script.JS" defer></script>
    <title>Inventario-Fares</title>
</head>

<body>
    <header id="titulo1" class="fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    <?php include './nav.php'; ?>
    
    <section class="fcolor-l1 seccion-form">
        <div class="s-encabezado">
            <h2>Inventario</h2>
        </div>
    
    <form class="fcolor-l5" action="guardar.php" method="post" enctype="multipart/form-data" autocomplete="off">
        <div id="codnom">
        <label class="codnom1">Codigo: <input type="text" name="codigo" id="codigo" pattern="[0-9]{3,}"
        placeholder="ingresar solo numeros" size="12" autofocus required> </label>
        <label class="codnom1">Producto: <input type="text" class="campof" name="nproducto" id="nproducto"
        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$" placeholder="ingresar solo letras" size="50" 
        required> </label>    
        </div>
        
        <div id="cospor">
            <label class="codnom1">Costo: <input type="text" class="campof" name="costop" id="costop"
            pattern="[0-9]+([,/.][0-9]+)?"> </label>
            <label class="codnom1">Porcentaje de Venta: <input type="text" class="campof" name="porcentajev"
            id="porcentajev" maxlength="3" size="4"> </label>
        </div>
        
        <div id="prefecha">
        <label class="codnom1">Precio de venta: <input type="text" class="campof" name="pventa" id="pventa" readonly> </label>
        <label class="codnom1">Fecha: <input type="date" class="campof" name="fecha_creacion" id="fecha_creacion" > </label>
        </div>

        <div id="csimagen" >
            <img src="" width="200px" alt="Imagen del Producto...">
        </div>

        <div id="botonimg">
        <input type="file" class="campof" name="simagen" id="simagen">
        </div>
        <input type="submit" name="cguardar" id="cguardar" value="Guardar">
    </form>
    </section>

    <section class="w3-container w3-margin-top">
        <h2>Productos guardados</h2>
        <?php if (!$conexion): ?>
            <div class="w3-panel w3-red">
                <p>No se pudo conectar a la base de datos.</p>
            </div>
        <?php elseif (empty($productos)): ?>
            <div class="w3-panel w3-yellow">
                <p>No hay productos guardados.</p>
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
    </section>
    <footer class="fcolor-d5">
        <p>Derechos Recervados &copy; 2004-2023 </p>
    </footer>
</body>
</html>