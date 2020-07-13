$(document).on("ready", inicio);
var dataTable;

function inicio() {

    validar_formulario();
    $("body").on("click", "#btn_añadir_docente", agregarDocente);
    $('#adicionar_docente').on("click", "#btn_agregar_docente", aceptarAgregarDocente);
    $("#form_añadir_docente").on("click", "#btn_mod_docente", modificarDocente);
    $("#editar_docente").on("click", "#btn_editar_docente", siModificarDocente);
    $("#form_añadir_docente").on("click", "#btn_elim_docente", eliminarDocente);
    $("#modal_elim_docente").on("click", "#btn_eliminar_docente", SieliminarDocente);

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/i.test(value);
    }, "Solo se admite texto");


    function validar_formulario() {
        $("#adicionar_docente").validate({
            rules: {
                nombre_docente: {
                    lettersonly: true,
                    required: true
                },
                apellido_docente: {
                    lettersonly: true,
                    required: true
                },
                correo_docente: {
                    email: true,
                    required: true

                },
                correo_docente: {
                    required: true
                },
                cvlac_docente: {
                    url: true
                },
            },
            messages: {
                nombre_docente: {
                    required: "El nombre es requerido"
                },
                apellido_docente: {
                    required: "El apellido es requerido"
                },
                correo_docente: {
                    required: "El correo es requerido"
                },
                cvlac_docente: {
                    url: "Ingrese una url valida"
                },
            },
        });

        $("#editar_docente").validate({
            rules: {
                edit_nom_docente: {
                    lettersonly: true,
                    required: true
                },
                edit_apellido_docente: {
                    lettersonly: true,
                    required: true
                },
                edit_correo_docente: {
                    email: true,
                    required: true

                },
                edit_correo_docente: {
                    required: true
                },
                edit_cvlac_docente: {
                    url: true
                },
            },
            messages: {
                edit_nom_docente: {
                    required: "El nombre es requerido"
                },
                edit_apellido_docente: {
                    required: "El apellido es requerido"
                },
                edit_correo_docente: {
                    required: "El correo es requerido"
                },
                edit_cvlac_docente: {
                    url: "Ingrese una url valida"
                },
            },
        });

        $("#adicionar_docente :input, #editar_docente :input").on("blur", function() {
            $(this).valid();
        });
    }
}

var dato;
$.ajax({
    url: "./controladores/admin_docente.php",
    type: "POST",
    async: false,
    dataType: "json",
    data: {
        accion: 'datos'
    },
    success: function(respuesta) {
        if (respuesta.hasOwnProperty("ok")) {
            new PNotify({
                title: "Actualizar Datos",
                text: respuesta.ok,
                type: "success",
                styling: "bootstrap3"
            });

            return dato = respuesta.docente;
        }

    },
})

var tabla_docente = $("#datatable_docente");
dataTable_docente = tabla_docente.DataTable({
    data: dato,
    columns: [
        { data: "id" },
        { data: "nombre" },
        { data: "apellido" },
        { data: "correo" },
        { data: "cvlac" },
        { data: "categoria" },
        { data: "estado" },
        {
            data: "imagen",
            render: function(data, type, row) {
                return data ?
                    '<img src="./vistas/imagenes/docente/' + data + '"/>' :
                    null;
            },
            defaultContent: "No hay imagen",
        }
    ],
    order: [
        [1, "asc"]
    ],
    responsive: true,
    columnDefs: [{
            orderable: false,
            searchable: false,
            visible: false,
            targets: [0],
        },
        {
            orderable: true,
            searchable: true,
            targets: [1, 2, 3, 4, 5, 6, 7, 8],
        },
        {
            orderable: false,
            searchable: false,
            targets: [8],

            mRender: function(data, type, row) {
                var botones;
                botones = '<div align="center"><button id="btn_mod_docente" class="btn btn-warning btn_grid_form" style="display:inline-block;"><i class="fa fa-edit"></i></button>';
                botones += '<button id="btn_elim_docente" class="btn btn-danger btn_grid_form" style="display:inline-block;"><i class="fa fa-remove"></i></button></div>';
                return botones;
            },
        }
    ],
});

function agregarDocente() {
    $("#modal_adicionar_docente").modal("show");
    $("#nombre_docente").val("");
    $("#apellido_docente").val("");
    $("#correo_docente").val("");
    $("#cvlac_docente").val("");
    return false;
}

function aceptarAgregarDocente() {
    if ($("#adicionar_docente").valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#adicionar_docente")[0]);
        datos.append('accion', 'add');
        datos.append('categoria', $('#categoria option:selected').text());
        datos.append('estado', $('#estado option:selected').text());
        $.ajax({
            url: "./controladores/admin_docente.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Agregar Docente",
                        text: data.ok,
                        type: "success",
                        styling: "bootstrap3"
                    });
                }
            }
        });
    }
}

var row;
var id;

function modificarDocente() {
    row = dataTable_docente.row($(this).parents("tr"));
    var datos = row.data();
    id = datos.id;
    $("#edit_nom_docente").val(datos.nombre);
    $("#edit_apellido_docente").val(datos.apellido);
    $("#edit_correo_docente").val(datos.correo);
    $("#edit_cvlac_docente").val(datos.cvlac);
    $('#imagen').attr('src', "./vistas/imagenes/docente/" + datos.imagen);
    $("#modal_editar_docente").modal("show");
    return false;
}

function siModificarDocente() {
    if ($("#editar_docente").valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#editar_docente")[0]);
        datos.append('accion', 'editar');
        datos.append('categoria', $('#edit_categoria option:selected').text());
        datos.append('estado', $('#edit_estado option:selected').text());
        datos.append('id', id);
        $.ajax({
            url: "./controladores/admin_docente.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Editar Docente",
                        text: data.ok,
                        type: "success",
                        styling: "bootstrap3"
                    });
                }
            }
        });
        $("#modal_editar_docente").modal("hide");
    }
}

var id;

function eliminarDocente() {
    row = dataTable_docente.row($(this).parents("tr"));
    var data = row.data();
    id = data.id;
    $("#modal_elim_docente").modal("show");
    return false;
}


function SieliminarDocente() {
    $.ajax({
        url: "./controladores/admin_docente.php",
        type: "POST",
        data: {
            accion: "eliminar",
            id: id
        }
    });
}