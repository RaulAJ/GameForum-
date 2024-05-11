function enviarFormulario() {
    var notaSeleccionada = document.querySelector('input[name="nota"]:checked');
    if (!notaSeleccionada) {
        document.getElementById('mensaje-advertencia').style.display = 'block';
    } else {
        document.getElementById('formValorarJuego').submit();
    }
}

var inputsNota = document.querySelectorAll('.input-nota');
var notaSeleccionada = document.getElementById('notaSeleccionada');

inputsNota.forEach(function(input) {
    input.addEventListener('change', function() {
        notaSeleccionada.value = this.value;
        document.getElementById('mensaje-advertencia').style.display = 'none';
    });

    input.addEventListener('mouseenter', function() {
        this.classList.add('animacion-numero');
    });

    input.addEventListener('mouseleave', function() {
        this.classList.remove('animacion-numero');
    });
});
