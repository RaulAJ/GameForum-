<?php

function buildFormularioValorarJuego($id)
{
    $carruselNotas = '<fieldset><legend>Nota</legend>';
    // Generar opciones del carrusel con las notas del 0 al 10
    for ($i = 0; $i <= 10; $i++) {
        // Crea los inputs de cada nota
        $carruselNotas .= "<input type='radio' id='nota_$i' name='nota' value='$i'";
        // Crea las etiquetas de cada nota
        $carruselNotas .= "><label for='nota_$i'>$i</label>";
    }
    $carruselNotas .= "</fieldset>";

    return <<<EOS
    <form id="formValorarJuego" action="procesarValorarJuego.php" method="POST">
        $carruselNotas
        <input type="hidden" id="id" name="id" value="$id">
        <input type="hidden" id="notaSeleccionada" name="notaSeleccionada" value="">
        <button type="submit" onclick="setNotaSeleccionada()">Enviar</button>
    </form>
    <script>
        function setNotaSeleccionada() {
            var notaSeleccionada = document.querySelector('input[name=nota]:checked').value;
            document.getElementById('notaSeleccionada').value = notaSeleccionada;
        }
    </script>
    EOS;
}