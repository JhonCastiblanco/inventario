<?php
// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Simulación de obtención de datos desde la base de datos
// Aquí deberías hacer una consulta a tu base de datos para obtener los detalles del producto con el ID proporcionado
$producto = null;
foreach ($productos as $prod) {
    if ($prod['id'] === $id) {
        $producto = $prod;
        break;
    }
}

// Si el producto no se encuentra, redirige o muestra un mensaje de error
if (!$producto) {
    echo "Producto no encontrado";
    exit;
}

// Si se envía el formulario, actualiza los detalles del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = $_POST['nombre'];
    $nuevas_caracteristicas = $_POST['caracteristicas'];
    $nuevo_estado = $_POST['estado'];
    $nuevas_fallas = $_POST['fallas'];

    // Aquí deberías actualizar la base de datos con los nuevos valores
    // Luego, redirigir a la página de la lista de productos o mostrar un mensaje de éxito
    echo "Producto actualizado con éxito";
    // header("Location: producto_unidad.php"); // Descomentar para redirigir
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br>

        <label for="caracteristicas">Características:</label>
        <input type="text" name="caracteristicas" id="caracteristicas" value="<?php echo htmlspecialchars($producto['caracteristicas']); ?>" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo" <?php echo $producto['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo $producto['estado'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select><br>

        <label for="fallas">Fallas:</label>
        <input type="text" name="fallas" id="fallas" value="<?php echo htmlspecialchars($producto['fallas']); ?>"><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
