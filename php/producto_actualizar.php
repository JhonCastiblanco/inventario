<?php
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['producto_id']);

/*== Verificando producto ==*/
$check_producto = conexion();
$check_producto = $check_producto->query("SELECT * FROM producto WHERE producto_id='$id'");

if ($check_producto->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El producto no existe en el sistema
        </div>
    ';
    exit();
} else {
    $datos = $check_producto->fetch();
}
$check_producto = null;

/*== Almacenando datos ==*/
$nombre = trim(limpiar_cadena($_POST['producto_nombre']));
$marca = trim(limpiar_cadena($_POST['producto_marca']));
$descripcion = isset($_POST['producto_descripcion']) ? trim(limpiar_cadena($_POST['producto_descripcion'])) : '';
$precio = trim(limpiar_cadena($_POST['producto_precio']));
$stock = trim(limpiar_cadena($_POST['producto_stock']));
$categoria = trim(limpiar_cadena($_POST['producto_categoria']));

/*== Verificando campos obligatorios ==*/
if ($nombre == "" || $marca == "" || $precio == "" || $stock == "" || $categoria == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $marca)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La MARCA no coincide con el formato solicitado
        </div>
    ';
    exit();
}


if (verificar_datos("[0-9.]{1,25}", $precio)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El PRECIO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

if (verificar_datos("[0-9]{1,25}", $stock)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El STOCK no coincide con el formato solicitado
        </div>
    ';
    exit();
}

/*== Verificando nombre ==*/
if ($nombre != $datos['producto_nombre']) {
    $check_nombre = conexion();
    $check_nombre = $check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
    if ($check_nombre->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre = null;
}

/*== Verificando categoría ==*/
if ($categoria != $datos['categoria_id']) {
    $check_categoria = conexion();
    $check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if ($check_categoria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria = null;
}

/*== Actualizando datos ==*/
$actualizar_producto = conexion();
$actualizar_producto = $actualizar_producto->prepare("UPDATE producto SET producto_nombre=:nombre, producto_marca=:marca, producto_descripcion=:descripcion, producto_precio=:precio, producto_stock=:stock, categoria_id=:categoria WHERE producto_id=:id");

$marcadores = [
    ":nombre" => $nombre,
    ":marca" => $marca,
    ":descripcion" => $descripcion,
    ":precio" => $precio,
    ":stock" => $stock,
    ":categoria" => $categoria,
    ":id" => $id
];

if ($actualizar_producto->execute($marcadores)) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
            El producto se actualizó con éxito
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo actualizar el producto, por favor intente nuevamente
        </div>
    ';
}
$actualizar_producto = null;
?>
