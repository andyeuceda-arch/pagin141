<?php
require 'conexionf.php';
//Declarar variables
$v_ccodigo = ""; //Recogerá el código
$v_nproducto = ""; //Recogerá el nombre del producto
$v_costop = ""; //Se almacenará el costo
$v_porcentajev = ""; //Aquí se almacenará el porcentaje de venta
$v_pventa = ""; //Recogerá el precio de venta
$v_fecha_creacion = ""; //Recogerá la fecha
$v_simagen = ""; //Se utilizará para recoger la imagen

//Función para escapar los datos
function filtrofares($dat_fares)
{
    $datos = trim($dat_fares); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes "\\"
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}

function guardaimagen()
{
    if (isset($_POST['cguardar'])) {
        $vcodigo = ""; //Declarar variable
        if (!empty($_POST["codigo"])) { //Si el campo código es distinto de vacío entonces
            //Almacenar en la variable $vcodigo el valor del código
            //que ingresó el usuario ya filtrado
            $vcodigo = filtrofares($_POST["codigo"]);
        }

        //Almacenar el nombre de la imagen en la variable $archivo
        $archivo = $_FILES['simagen']['name'];
        //Si archivo tiene información y es diferente de vacío entonces
        if (isset($archivo) && $archivo != "") {
            $tipo = $_FILES['simagen']['type']; // Obtener el tipo de archivo
            $temp = $_FILES['simagen']['tmp_name']; // Obtener el nombre temporal del archivo

            // Si la imagen seleccionada no es del tipo correcto, devolver null
            if (!(strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                return null; // Retornar null
            } else {
                // Almacenar la extensión del archivo en la variable $extension
                $extension = pathinfo($_FILES['simagen']['name'], PATHINFO_EXTENSION);
                // Concatenar en $nuevonombre el código + punto + extensión
                $nuevonombre = $vcodigo . "." . $extension;

                // Subir el archivo conservando el tamaño y tipo
                if (move_uploaded_file($temp, "imgfares/" . $nuevonombre)) {
                    // Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod("imgfares/" . $nuevonombre, 0777);
                    return $nuevonombre; // Retornar el nombre de la imagen
                } else { // Si la imagen no se guardó
                    return null; // Retornar null a la función
                }
            }
        }
    }
   
}

// Verificar si los datos fueron enviados desde el método _post
if (isset($_POST["cguardar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["codigo"])) { // Si el código no está vacío entonces
        // Almacenar en la variable $v_ccodigo el valor del código que ingresó el usuario ya filtrado
        $v_ccodigo = filtrofares($_POST["codigo"]);
    }

    if (!empty($_POST["nproducto"])) {
        $v_nproducto = filtrofares($_POST["nproducto"]);
    }

    if (!empty($_POST["costop"])) {
        $v_costop = filtrofares($_POST["costop"]);
    }

    if (!empty($_POST["porcentajev"])) {
        $v_porcentajev = filtrofares($_POST["porcentajev"]);
    }

    if (!empty($_POST["pventa"])) {
        $v_pventa = filtrofares($_POST["pventa"]);
    }

    if (!empty($_POST["fecha_creacion"])) {
    $v_fecha_creacion = filtrofares($_POST["fecha_creacion"]);
    }
    $v_simagen = guardaimagen(); // Ejecutar función guardaimagen() y almacenar el resultado en $v_simagen
    $conexion = conect(); // Conectar con la base de datos

    if ($conexion) {
        try {
            $sql = "INSERT INTO inventario (codigo, nom_producto, costo, porc_venta, precio_venta, fecha, Imagen)
                    VALUES (:codigo, :nom_producto, :costo, :porc_venta, :precio_venta, :fecha, :Imagen)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':codigo' => $v_ccodigo,
                ':nom_producto' => $v_nproducto,
                ':costo' => $v_costop,
                ':porc_venta' => $v_porcentajev,
                ':precio_venta' => $v_pventa,
                ':fecha' => $v_fecha_creacion,
                ':Imagen' => $v_simagen,
            ]);
            $conexion = null; // Cerrar la conexión
            header("Location: cproductos.html"); // Redirigir a cproductos.html
            exit;
        } catch (PDOException $e) {
            echo "Error al guardar: " . $e->getMessage();
        }
    } else {
        echo "No se pudo conectar a la base de datos. Verifique el servidor MySQL y la configuración.";
    }
}
