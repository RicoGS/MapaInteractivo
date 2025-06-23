$(document).ready(function () {
  // =========================
  // Utilidades
  // =========================
  const showFeedback = (selector, message, isSuccess = true) => {
    const el = $(selector);
    el.removeClass("feedback-success feedback-error").hide();
    el
      .addClass(isSuccess ? "feedback-success" : "feedback-error")
      .text(message)
      .fadeIn();
  };

  const limpiarFormulario = (formSelector) => {
    $(`${formSelector} input, ${formSelector} select`).val("");
  };

  const cerrarModales = () => {
    $(".modal").fadeOut();
  };

  // =========================
  // Modal: Agregar contacto
  // =========================
  $("#open-add-modal").on("click", function () {
    $("#add-modal").fadeIn();
  });

  $("#confirm-add").on("click", function () {
    let contactData = {
      name: $("#add-name").val(),
      phone: $("#add-phone").val(),
      municipio: $("#select-municipio").val(),
      persona: $("#add-persona").val(),
      domicilio: $("#add-domicilio").val(),
      distrito: $("#add-distrito").val(),
      redes: $("#add-redes").val(),
      ocupacion: $("#add-ocupacion").val(),
      seccion: $("#add-seccion").val(),
      clasificacion: $("#add-clasificacion").val()
    };

    // Validación de campos
    for (let key in contactData) {
      if (!contactData[key]) {
        alert("Todos los campos son obligatorios.");
        return;
      }
    }

    $("#confirm-add").prop("disabled", true);

    $.ajax({
      url: "../../controller/actions.add.php?action=addContact",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(contactData),
      dataType: "json",
      success: function (response) {
        console.log("Respuesta del servidor:", response);
        if (response.success) {
          showFeedback("#add-feedback", "Contacto agregado correctamente.", true);
          limpiarFormulario("#add-modal");
          setTimeout(() => location.reload(), 1500);
        } else {
          showFeedback("#add-feedback", response.message || "Error al agregar el contacto.", false);
        }
        $("#confirm-add").prop("disabled", false);
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        showFeedback("#add-feedback", "Error de conexión con el servidor.", false);
        $("#confirm-add").prop("disabled", false);
      }
    });
  });

  // =========================
  // Modal: Eliminar contacto
  // =========================
  $("#open-delete-modal").on("click", function () {
    $("#delete-modal").fadeIn();
  });

  $("#confirm-delete").on("click", function () {
    const contactId = $("#delete-id").val();

    if (!contactId) {
      alert("Por favor, ingresa un ID.");
      return;
    }

    $.ajax({
      url: "../../controller/actions.php?action=deleteContact",
      type: "POST",
      data: { id: contactId },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          showFeedback("#add-feedback", "Contacto eliminado correctamente.", true);
          setTimeout(() => location.reload(), 1500);
        } else {
          showFeedback("#add-feedback", "Ocurrió un error al eliminar.", false);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error al eliminar:", status, error);
        showFeedback("#add-feedback", "Error de conexión con el servidor.", false);
      }
    });

    cerrarModales();
  });

  // =========================
  // Cerrar modales (común)
  // =========================
  $(".close-modal").on("click", cerrarModales);
});
