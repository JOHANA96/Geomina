$(document).on("ready", inicio);
var dataTable;

function inicio() {

    validar_formulario();
    $("body").on("click", "#btn_añadir_laboratorio", agregarLaboratorio);
    $('#adicionar_laboratorio').on("click", "#btn_agregar_laboratorio", aceptarAgregarLaboratorio);
    $("#form_añadir_laboratorio").on("click", "#btn_mod_laboratorio", modificarLaboratorio);
    $("#modal_editar_laboratorio").on("click", "#btn_modificar_laboratorio", siModificarLaboratorio);
    $("#form_añadir_laboratorio").on("click", "#btn_elim_laboratorio", eliminarLaboratorio);
    $("#modal_elim_laboratorio").on("click", "#btn_eliminar_laboratorio", SieliminarLaboratorio);


    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/i.test(value);
    }, "Solo se admite texto");

    function validar_formulario() {
        $("#adicionar_laboratorio").validate({
            rules: {
                nombre_laboratorio: {
                    lettersonly: true,
                    required: true
                },
                descripcion_laboratorio: {
                    required: true
                },
            },
            messages: {
                nombre_laboratorio: {
                    required: " El nombre es requerido"
                },
                descripcion_laboratorio: {
                    required: "La descripción es requerida"
                },
            },
        });
        $("#modificar_laboratorio").validate({
            rules: {
                edit_nom_laboratorio: {
                    lettersonly: true,
                    required: true
                },
                edit_des_laboratorio: {
                    required: true
                },
            },
            messages: {
                edit_nom_laboratorio: {
                    required: " El nombre es requerido"
                },
                edit_des_laboratorio: {
                    required: "La descripción es requerida"
                },
            },
        });
        $("#adicionar_laboratorio :input, #modificar_laboratorio :input").on("blur", function() {
            $(this).valid();
        });
    }
}

var dato;
$.ajax({
    url: "./controladores/admin_laboratorio.php",
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

            return dato = respuesta.laboratorio;
        }

    },
})

var tabla_laboratorio = $("#datatable_laboratorio");
dataTable_laboratorio = tabla_laboratorio.DataTable({
    data: dato,
    columns: [
        { data: "id" },
        { data: "nombre" },
        { data: "descripcion" },
        {
            data: "imagen",
            render: function(data, type, row) {
                return data ?
                    '<img src="./vistas/imagenes/laboratorio/' + data + '"/>' :
                    null;
            },
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
            targets: [1, 2, 3, 4],
        },
        {
            orderable: false,
            searchable: false,
            targets: [4],

            mRender: function(data, type, row) {
                var botones;
                botones = '<div align="center"><button id="btn_mod_laboratorio" class="btn btn-warning btn_grid_form" style="display:inline-block;"><i class="fa fa-edit"></i></button>';
                botones += '<button id="btn_elim_laboratorio" class="btn btn-danger btn_grid_form" style="display:inline-block;"><i class="fa fa-remove"></i></button></div>';
                return botones;
            },
        }
    ],
});

function agregarLaboratorio() {
    $("#modal_adicionar_laboratorio").modal("show");
    $("#nombre_laboratorio").val("");
    $("#descripcion_laboratorio").val("");
    return false;
}

function aceptarAgregarLaboratorio() {
    if ($('#adicionar_laboratorio').valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#adicionar_laboratorio")[0]);
        datos.append('accion', 'add');
        $.ajax({
            url: "./controladores/admin_laboratorio.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Agregar Laboratorio",
                        text: response.ok,
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

function modificarLaboratorio() {
    row = dataTable_laboratorio.row($(this).parents("tr"));
    var datos = row.data();
    id = datos.id;
    $("#edit_nom_laboratorio").val(datos.nombre);
    $("#edit_des_laboratorio").val(datos.descripcion);
    $('#imagen').attr('src', "./vistas/imagenes/laboratorio/" + datos.imagen);
    $("#modal_editar_laboratorio").modal("show");
    return false;
}

function siModificarLaboratorio() {
    if ($("#modificar_laboratorio").valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#modificar_laboratorio")[0]);
        datos.append('accion', 'editar');
        datos.append('id', id);
        $.ajax({
            url: "./controladores/admin_laboratorio.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Editar Laboratorio",
                        text: data.ok,
                        type: "success",
                        styling: "bootstrap3"
                    });
                }
            }
        });
        $("#modal_editar_laboratorio").modal("hide");
    }
}


var id;

function eliminarLaboratorio() {
    row = dataTable_laboratorio.row($(this).parents("tr"));
    var data = row.data();
    id = data.id;
    $("#modal_elim_laboratorio").modal("show");
    return false;
}

function SieliminarLaboratorio() {
    $.ajax({
        url: "./controladores/admin_laboratorio.php",
        type: "POST",
        data: {
            accion: "eliminar",
            id: id
        }
    });
}