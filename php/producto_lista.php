<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

// Campos a seleccionar en las consultas
$campos = "producto.producto_id, 
           producto.producto_nombre, 
           producto.producto_marca, 
           producto.producto_descripcion, 
           producto.producto_precio, 
           producto.producto_stock, 
           producto.producto_foto, 
           producto.categoria_id, 
           producto.usuario_id, 
           categoria.categoria_nombre, 
           usuario.usuario_nombre, 
           usuario.usuario_apellido";

// Consulta general sin filtros
if ($categoria_id <= 0) {
    $consulta_datos = "SELECT $campos 
                       FROM producto 
                       INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                       INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                       ORDER BY producto.producto_nombre ASC 
                       LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto";
} else {
    $consulta_datos = "SELECT $campos 
                       FROM producto 
                       INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                       INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                       WHERE producto.categoria_id = $categoria_id 
                       ORDER BY producto.producto_nombre ASC 
                       LIMIT $inicio, $registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto WHERE categoria_id = $categoria_id";
}

// Ejecutar las consultas
$conexion = conexion();

// Consulta de datos
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

// Consulta total
$total = $conexion->query($consulta_total);
$total = (int) $total->fetchColumn();

$Npaginas = ceil($total / $registros);

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">';
        if (is_file("./img/producto/" . $rows['producto_foto'])) {
            $tabla .= '<img src="./img/producto/' . $rows['producto_foto'] . '">';
        } else {
            $tabla .= '<img src="./img/producto.png">';
        }
        $tabla .= '</p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>' . $contador . ' - ' . $rows['producto_nombre'] . '</strong><br>
                            <strong>Marca:</strong> ' . $rows['producto_marca'] . '<br>
                            <strong>Descripción:</strong> ' . $rows['producto_descripcion'] . '<br>
                            <strong>Precio:</strong> $' . $rows['producto_precio'] . '<br>
                            <strong>Stock:</strong> ' . $rows['producto_stock'] . '<br>
                            <strong>Categoría:</strong> ' . $rows['categoria_nombre'] . '<br>
                            <strong>Registrado por:</strong> ' . $rows['usuario_nombre'] . ' ' . $rows['usuario_apellido'] . '
                        </p>
                    </div>
                    <div class="has-text-right">
                        <a href="index.php?vista=producto_unidad&product_id_up=' . $rows['producto_id'] . '" class="button is-warning is-rounded is-small">Ver</a>
                        <a href="index.php?vista=product_img&product_id_up=' . $rows['producto_id'] . '" class="button is-info is-rounded is-small">Imagen</a>
                        <a href="index.php?vista=product_update&product_id_up=' . $rows['producto_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                        <a href="' . $url . $pagina . '&product_id_del=' . $rows['producto_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                    </div>
                </div>
            </article>
            <hr>
        ';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($total >= 1) {
        $tabla .= '
            <p class="has-text-centered">
                <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </p>';
    } else {
        $tabla .= '<p class="has-text-centered">No hay registros en el sistema</p>';
    }
}

if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando productos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

$conexion = null;
echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
