$(document).ready(function () {
    $("#login-form").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this); // Captura los datos del formulario automáticamente

        $.ajax({
            url: "controller/actions.php",
            type: "POST",
            data: formData,
            processData: false, // Evita que jQuery manipule los datos
            contentType: false, // Asegura el formato correcto
            dataType: "json",
            success: function (response) {
                console.log("Respuesta del servidor:", response); // Ver en consola
                if (response.success) {
                    alert("Redirigiendo a: " + response.redirect); // Mensaje de prueba
                    window.location.href = response.redirect;
                } else {
                    $("#error-message").text(response.message).removeClass("hidden");
                }
            },

        });
    });
});