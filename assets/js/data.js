$(document).ready(function () {
    // --- Subida de CSV ---
    $("#cargar-csv").on("click", function () {
        $("#csv-file").click();
    });
    $("#csv-file").on("change", function () {
        if (this.files.length > 0) {
            uploadCsv(this.files[0]);
        }
    });
    function uploadCsv(file) {
        let formData = new FormData();
        formData.append("csv_file", file);
        $.ajax({
            url: "../../controller/actions.upload.php?action=uploadCsv",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $("#upload-message").text(response.message);
            },
            error: function () {
                $("#upload-message").text("Error al cargar el archivo.");
            }
        });
    }

    // --- Modales de agregar y eliminar contacto ---
    $("#open-add-modal").on("click", function () {
        $("#add-modal").fadeIn();
    });
    $("#open-delete-modal").on("click", function () {
        $("#delete-modal").fadeIn();
    });
    $("#open-filter-modal").on("click", function () {
        $("#filter-modal").fadeIn();
    });
    $(".close-modal").on("click", function () {
        $(".modal:visible").fadeOut();
    });
    $("#add-modal, #delete-modal, #filter-modal").on("click", function (e) {
        if ($(e.target).hasClass("modal") || $(e.target).hasClass("modal-overlay")) {
            $(this).fadeOut();
        }
    });
    $("#confirm-add").on("click", function () {
        alert("Contacto agregado.");
    });

    // --- Modal de filtros ---
    $('#clear-filters').on('click', function () {
        $('#buscardistrito').val('All');
        $('#buscarclacificacion').val('All');
        $('#apply-filters').trigger('click'); // Simula el click en aplicar filtros para actualizar la tabla
    });
    $('#apply-filters').on('click', function () {
        $('#filter-form').submit();
    });
    $('#filter-form').on('submit', function (e) {
        e.preventDefault();
        const distrito = $('#buscardistrito').val();
        const clasificacion = $('#buscarclacificacion').val();
        if (typeof cargarDatos === "function") cargarDatos(); // Recarga la tabla sin filtros
        console.log('Distrito:', distrito, 'Clasificación:', clasificacion);
    });
    // --- Select2 para municipio y contactos ---
    $('#select-municipio').select2({
        placeholder: 'Busca o selecciona un municipio',
        allowClear: true
    });
    $('#delete-contact').select2({
        placeholder: 'Buscar contacto',
        ajax: {
            url: '../../controller/buscarContactos.php',
            dataType: 'json',
            delay: 250,
            data: params => ({ term: params.term }),
            processResults: data => ({ results: data }),
            cache: true
        },
        minimumInputLength: 2,
        allowClear: true
    });

    // --- Vista previa y eliminación de contacto ---
    $('#delete-contact').on('select2:select', function (e) {
        const contactoId = e.params.data.id;
        fetch('detalleContacto.php?id=' + contactoId)
            .then(res => res.json())
            .then(data => {
                if (data && data.NOMBRE) {
                    const row = `
                        <tr>
                            <td>${data.NOMBRE}</td>
                            <td>${data.TELEFONO}</td>
                            <td>${data.MUNICIPIO}</td>
                            <td>${data.OCUPACION}</td>
                            <td>${data.CLASIFICACIONID}</td>
                        </tr>
                    `;
                    document.getElementById('preview-body').innerHTML = row;
                    document.getElementById('contacto-preview').style.display = 'block';
                } else {
                    document.getElementById('contacto-preview').style.display = 'none';
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener el detalle del contacto'
                });
            });
    });
    document.getElementById("close-modal").addEventListener("click", () => {
        $('#delete-contact').val(null).trigger('change');
        document.getElementById('contacto-preview').style.display = 'none';
    });
    document.getElementById("confirm-delete").addEventListener("click", function () {
        const contactoId = $('#delete-contact').val();
        if (!contactoId) {
            Swal.fire({
                icon: 'warning',
                title: 'Selecciona un contacto',
                text: 'Debes elegir a quién deseas eliminar'
            });
            return;
        }
        fetch('../../controller/delete.Contact.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: contactoId })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    $('#delete-contact').val(null).trigger('change');
                    $("#delete-modal").fadeOut();
                    document.getElementById('contacto-preview').style.display = 'none';
                    Swal.fire({
                        icon: 'success',
                        title: 'Contacto eliminado',
                        text: 'Puedes revisar el log si fue un error',
                        timer: 4000,
                        showConfirmButton: false
                    });
                    if (typeof cargarDatos === "function") cargarDatos();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo eliminar el contacto'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la conexión al servidor'
                });
            });
    });

    // --- Filtros AJAX para la tabla ---
    function cargarDatos() {
        const distrito = $('#buscardistrito').val();
        const clasificacion = $('#buscarclacificacion').val();
        $.ajax({
            url: '../../controller/filtrarContactos.php',
            method: 'POST',
            data: { distrito, clasificacion },
            dataType: 'json',
            success: function (data) {
                let html = '';
                if (data.length === 0) {
                    html = '<tr><td colspan="10">No hay resultados</td></tr>';
                } else {
                    data.forEach(function (row) {
                        html += `<tr>
                            <td>${row.NOMBRE || ''}</td>
                            <td>${row.DOMICILIO || ''}</td>
                            <td>${row.TELEFONO || ''}</td>
                            <td>${row.OCUPACION || ''}</td>
                            <td>${row.PERSONACONTACTO || ''}</td>
                            <td>${row.MUNICIPIO || ''}</td>
                            <td>${row.DISTRITO || ''}</td>
                            <td>${row.CLASIFICACIONID || ''}</td>
                            <td>${row.SECCIONELECTORAL || ''}</td>
                            <td>${row.REDESSOCIALES || ''}</td>
                        </tr>`;
                    });
                }
                $('#data-body').html(html);
            },
            error: function () {
                $('#data-body').html('<tr><td colspan="10">Error al cargar los datos</td></tr>');
            }
        });
    }

    // Llama cargarDatos al aplicar filtros y al limpiar
    $('#apply-filters').on('click', function () {
        cargarDatos();
    });
    $('#clear-filters').on('click', function () {
        $('#buscardistrito').val('All');
        $('#buscarclacificacion').val('All');
        cargarDatos();
    });
    // Carga inicial de la tabla
    cargarDatos();

    // Agregar contacto
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
        url: "../../controller/add.Contact.php?action=addContact",
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
    // --- Paginador ---
    const rowsPerPage = 5;
    const rows = $('#data-body tr');
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    function showPage(page) {
        rows.hide();
        rows.slice(page * rowsPerPage, (page + 1) * rowsPerPage).show();
    }
    for (let i = 0; i < totalPages; i++) {
        $('#paginador').append(`<button class="pagina">${i + 1}</button>`);
    }
    $('#paginador').on('click', '.pagina', function () {
        const page = $(this).text() - 1;
        showPage(page);
    });
    showPage(0);

});
