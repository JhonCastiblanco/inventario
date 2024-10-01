<?php

# Conexión a la base de datos
function conexion(){
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}

# Verificar datos
function verificar_datos($filtro, $cadena){
    return !preg_match("/^".$filtro."$/", $cadena);
}

# Limpiar cadenas de texto
function limpiar_cadena($cadena){
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
    return $cadena;
}

# Función para renombrar fotos
function renombrar_fotos($nombre){
    $nombre = preg_replace('/[^a-zA-Z0-9_]/', '_', $nombre);
    $nombre .= "_" . rand(0, 100);
    return $nombre;
}

# Función paginador de tablas
function paginador_tablas($pagina, $Npaginas, $url, $botones){
    $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

    if ($pagina <= 1) {
        $tabla .= '
        <a class="pagination-previous is-disabled" disabled>Anterior</a>
        <ul class="pagination-list">';
    } else {
        $tabla .= '
        <a class="pagination-previous" href="'.$url.($pagina-1).'">Anterior</a>
        <ul class="pagination-list">
            <li><a class="pagination-link" href="'.$url.'1">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>';
    }

    $ci = 0;
    for ($i = $pagina; $i <= $Npaginas; $i++) {
        if ($ci >= $botones) {
            break;
        }
        if ($pagina == $i) {
            $tabla .= '<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
        } else {
            $tabla .= '<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
        }
        $ci++;
    }

    if ($pagina == $Npaginas) {
        $tabla .= '
        </ul>
        <a class="pagination-next is-disabled" disabled>Siguiente</a>';
    } else {
        $tabla .= '
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
        </ul>
        <a class="pagination-next" href="'.$url.($pagina+1).'">Siguiente</a>';
    }

    $tabla .= '</nav>';
    return $tabla;
}
