<?php
require_once "../inc/session_start.php";
require_once "main.php";

// Recoger datos del formulario
$producto_id = limpiar_cadena($_POST['producto_id']);
$estado = limpiar_cadena($_POST['estado_producto']);
$fallas = limpiar_cadena($_POST['fallas']);

// Verificar campos obligatorios
if ($producto_id == "" || $estado == "" || $fallas == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios.
        </div>
    ';
    exit();
}

// Verificar el estado
$estados_validos = ['Disponible', 'En mantenimiento', 'En proyecto'];
if (!in_array($estado, $estados_validos)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El ESTADO no es válido.
        </div>
    ';
    exit();
}

// Verificar integridad de los datos
if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,255}", $fallas)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La descripción de FALLAS no coincide con el formato solicitado.
        </div>
    ';
    exit();
}

// Verificar si el producto existe
$check_producto = conexion();
$check_producto = $check_producto->prepare("SELECT producto_id FROM producto WHERE producto_id = :producto_id");
$check_producto->execute([':producto_id' => $producto_id]);
if ($check_producto->rowCount() == 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El PRODUCTO seleccionado no existe.
        </div>
    ';
    exit();
}

// Guardar los datos en la base de datos
$guardar_unidad = conexion();
$guardar_unidad = $guardar_unidad->prepare("
    INSERT INTO unidad_producto (
        producto_id,
        estado,
        fallas
    ) VALUES (
        :producto_id,
        :estado,
        :fallas
    )
");

$marcadores = [
    ":producto_id" => $producto_id,
    ":estado" => $estado,
    ":fallas" => $fallas
];

try {
    $guardar_unidad->execute($marcadores);

    if ($guardar_unidad->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡UNIDAD REGISTRADA!</strong><br>
                La unidad se registró con éxito.
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar la unidad, por favor intente nuevamente.
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

$guardar_unidad = null;
?>
