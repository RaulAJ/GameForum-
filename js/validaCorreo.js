$(document).ready(function() {
    $("#validEmail").hide();
    $("#validUser").hide();

    $("#campoEmail").change(function(){
        const campo = $("#campoEmail"); // referencia jquery al campo
        campo[0].setCustomValidity(""); // limpia validaciones previas

        // validación html5, porque el campo es <input type="email" ...>
        const esCorreoValido = campo[0].checkValidity();
        if (esCorreoValido && correoValidoUCM(campo.val())) {
            // el correo es válido y acaba por @ucm.es: marcamos y limpiamos quejas
            
            // Colocamos el emoji verde (check)
            $("#validEmail").html("&#x2714;").show();

            campo[0].setCustomValidity("");
        } else {            
            // correo invalido: ponemos una marca y nos quejamos

            // Colocamos el emoji rojo (warning)
            $("#validEmail").html("&#x26a0;").show();

            campo[0].setCustomValidity(
                "El correo debe ser válido y acabar por @ucm.es, @gmail.com, @yahoo.es o @hotmail.es"
            );
        }
    });

    $("#campoUser").change(function(){
        let url = "comprobarUsuario.php?user=" + $("#campoUser").val();
        $.get(url, usuarioExiste);
    });

    function correoValidoUCM(correo) {
        return correo.endsWith("@ucm.es") 
                || correo.endsWith("@gmail.com")
                || correo.endsWith("@hotmail.es") 
                || correo.endsWith("@yahoo.es");
    }
});
