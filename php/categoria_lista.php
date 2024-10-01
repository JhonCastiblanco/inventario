<?php
// Calcula el índice de inicio para la consulta, basado en la página actual y el número de registros por página
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

// Inicializa una variable para almacenar el HTML de la tabla
$tabla = "";

// Verifica si se ha establecido una búsqueda
if (isset($busqueda) && $busqueda != "") {
    // Consulta para obtener los datos filtrados por la búsqueda
    $consulta_datos = "SELECT * FROM categoria 
                       WHERE categoria_descripcion LIKE '%$busqueda%' 
                       OR categoria_nombre LIKE '%$busqueda%' 
                       ORDER BY categoria_nombre ASC 
                       LIMIT $inicio, $registros";
    
    // Consulta para contar el total de registros que coinciden con la búsqueda
    $consulta_total = "SELECT COUNT(categoria_id) FROM categoria 
                       WHERE categoria_nombre LIKE '%$busqueda%' 
                       OR categoria_descripcion LIKE '%$busqueda%'";
} else {
    // Consulta para obtener todos los datos sin filtro
    $consulta_datos = "SELECT * FROM categoria 
                       ORDER BY categoria_nombre ASC 
                       LIMIT $inicio, $registros";
    
    // Consulta para contar el total de registros sin filtro
    $consulta_total = "SELECT COUNT(categoria_id) FROM categoria";
}

// Establece la conexión a la base de datos
$conexion = conexion();

// Ejecuta la consulta para obtener los datos
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll(); // Obtiene todos los resultados de la consulta

// Ejecuta la consulta para obtener el total de registros
$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn(); // Obtiene el total de registros y lo convierte a entero

// Calcula el número total de páginas
$Npaginas = ceil($total / $registros);

// Construye la tabla HTML
$tabla .= '
<div class="table-container">
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <thead>
            <tr class="has-text-centered">
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th> <!-- Nueva columna -->
                <th>Productos</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
';

// Si hay registros y la página actual está dentro del rango
if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1; // Contador para numerar los registros
    $pag_inicio = $inicio + 1; // Número de la primera página mostrada
    
    foreach ($datos as $rows) {
        $tabla .= '
            <tr class="has-text-centered">
                <td>' . $contador . '</td>
                <td>' . htmlspecialchars($rows['categoria_nombre']) . '</td>
                <td>' . htmlspecialchars($rows['categoria_descripcion']) . '</td>
                <td>
                    <a href="index.php?vista=product_category&category_id=' . urlencode($rows['categoria_id']) . '" class="button is-info is-rounded is-small">Ver productos</a>
                </td>
                <td>
                    <a href="index.php?vista=category_update&category_id_up=' . urlencode($rows['categoria_id']) . '" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="' . $url . $pagina . '&category_id_del=' . urlencode($rows['categoria_id']) . '" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $contador++;
    }
    $pag_final = $contador - 1; // Número de la última página mostrada
} else {
    // Si hay registros pero no se muestran en la página actual
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="5">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        // Si no hay registros
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="5">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$tabla .= '</tbody></table></div>';

// Muestra el rango de categorías que se están mostrando
if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando categorías <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

// Cierra la conexión a la base de datos
$conexion = null;

// Muestra la tabla construida
echo $tabla;

// Muestra el paginador si hay más de un registro y la página está dentro del rango
if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
