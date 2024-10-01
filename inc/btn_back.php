<?php
// Archivo: btn_back.php

// Descripción:
// Este archivo incluye un botón de retroceso que permite al usuario regresar a la página anterior
// en el historial de navegación. El botón está diseñado con el estilo de Bulma CSS y tiene un script
// JavaScript asociado para manejar el comportamiento de retroceso.
?>

<!-- HTML -->
<p class="has-text-right pt-4 pb-4">
    <!--
        Este es el botón de retroceso:
        - `href="#"`: El enlace no lleva a ninguna parte, solo activa el script JavaScript.
        - `button`: Clase de Bulma que aplica el estilo de botón.
        - `is-link`: Clase de Bulma que aplica un color de botón basado en el esquema de enlace.
        - `is-rounded`: Clase de Bulma que aplica bordes redondeados al botón.
        - `btn-back`: Clase personalizada para el botón utilizada en el script JavaScript.
    -->
    <a href="#" class="button is-link is-rounded btn-back"><- Regresar atrás</a>
</p>

<!-- JavaScript -->
<script type="text/javascript">
    // Selecciona el botón de retroceso del DOM
    let btn_back = document.querySelector(".btn-back");

    // Añade un manejador de eventos para el clic en el botón
    btn_back.addEventListener('click', function(e){
        // Previene el comportamiento predeterminado del enlace (navegar a `href`)
        e.preventDefault();
        // Regresa a la página anterior en el historial del navegador
        window.history.back();
    });
</script>
