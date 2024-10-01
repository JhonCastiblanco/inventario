<?php
require_once "../inc/session_start.php";

require_once "main.php";

/*== Almacenando datos ==*/
$nombre = limpiar_cadena($_POST['producto_nombre']);
$marca = limpiar_cadena($_POST['producto_marca']);
$descripcion = limpiar_cadena($_POST['producto_descripcion']);
$precio = limpiar_cadena($_POST['producto_precio']);
$stock = limpiar_cadena($_POST['producto_stock']);
$categoria = limpiar_cadena($_POST['producto_categoria']);

$foto = $_FILES['producto_foto'];

/*== Verificando campos obligatorios ==*/
if ($nombre == "" || $marca == "" || $descripcion == "" || $precio == "" || $stock == "" || $categoria == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios.
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $marca)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La MARCA no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,255}", $descripcion)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La DESCRIPCIÓN no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[0-9.]{1,25}", $precio)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El PRECIO no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

if (verificar_datos("[0-9]{1,25}", $stock)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El STOCK no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

/*== Verificando si la categoría existe ==*/
$check_categoria = conexion();
$check_categoria = $check_categoria->prepare("SELECT categoria_id FROM categoria WHERE categoria_id = :categoria");
$check_categoria->execute([':categoria' => $categoria]);
if ($check_categoria->rowCount() == 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La CATEGORÍA seleccionada no existe.
        </div>
    ';
    exit();
}

/*== Verificando foto ==*/
if ($foto['error'] !== UPLOAD_ERR_OK) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Hubo un problema con la carga de la foto. Por favor, inténtalo de nuevo.
        </div>
    ';
    exit();
}

$foto_nombre = renombrar_fotos($foto['name']);
$foto_ruta = "../uploads/" . $foto_nombre;

/*== Verificar y crear directorio si no existe ==*/
if (!is_dir("../uploads")) {
    mkdir("../uploads", 0755, true);
}

/*== Moviendo foto al directorio de destino ==*/
if (!move_uploaded_file($foto['tmp_name'], $foto_ruta)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo mover la foto al directorio de destino. Ruta: ' . $foto_ruta . '
        </div>
    ';
    exit();
}

/*== Guardando datos ==*/
$guardar_producto = conexion();
$guardar_producto = $guardar_producto->prepare("
    INSERT INTO producto (
        producto_nombre,
        producto_marca,
        producto_descripcion,
        producto_precio,
        producto_stock,
        categoria_id,
        producto_foto,
        usuario_id
    ) VALUES (
        :nombre,
        :marca,
        :descripcion,
        :precio,
        :stock,
        :categoria,
        :foto,
        :usuario
    )
");

$marcadores = [
    ":nombre" => $nombre,
    ":marca" => $marca,
    ":descripcion" => $descripcion,
    ":precio" => $precio,
    ":stock" => $stock,
    ":categoria" => $categoria,
    ":foto" => $foto_nombre,
    ":usuario"=>$_SESSION['id']
];

try {
    $guardar_producto->execute($marcadores);

    if ($guardar_producto->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO REGISTRADO!</strong><br>
                El producto se registró con éxito.
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el producto, por favor intente nuevamente.
            </div>
        ';
    }
} catch (PDOException $e) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            Error: ' . $e->getMessage() . '
        </div>
    ';
}

$guardar_producto = null;
?>
