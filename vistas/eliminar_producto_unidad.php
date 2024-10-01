<?php
// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Aquí deberías hacer la eliminación del producto en la base de datos
// En este ejemplo, solo se mostrará un mensaje de confirmación
if ($id > 0) {
    // Código para eliminar el producto de la base de datos
    echo "Producto con ID $id eliminado exitosamente.";
    // header("Location: producto_unidad.php"); // Descomentar para redirigir
    exit;
} else {
    echo "ID de producto no válido.";
    exit;
}
?>
