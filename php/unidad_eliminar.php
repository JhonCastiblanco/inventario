<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando datos ==*/
$unidad_id_del = limpiar_cadena($_GET['unidad_id_del']);

/*== Verificando unidad ==*/
$check_unidad = conexion();
$check_unidad = $check_unidad->query("SELECT * FROM unidad_producto WHERE unidad_id='$unidad_id_del'");

if ($check_unidad->rowCount() == 1) {
    $datos = $check_unidad->fetch();

    $eliminar_unidad = conexion();
    $eliminar_unidad = $eliminar_unidad->prepare("DELETE FROM unidad_producto WHERE unidad_id=:id");

    $eliminar_unidad->execute([":id" => $unidad_id_del]);

    if ($eliminar_unidad->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡UNIDAD ELIMINADA!</strong><br>
                Los datos de la unidad se eliminaron con éxito.
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo eliminar la unidad, por favor intente nuevamente.
            </div>
        ';
    }
    $eliminar_unidad = null;
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            La UNIDAD que intenta eliminar no existe.
        </div>
    ';
}
$check_unidad = null;
?>
