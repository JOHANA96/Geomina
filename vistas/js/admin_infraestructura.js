$(document).on("ready", inicio);
var dataTable;

function inicio() {

    validar_formulario();
    $("body").on("click", "#btn_añadir_infraestructura", agregarInfraestructura);
    $('#adicionar_infraestructura').on("click", "#btn_agregar_infraestructura", aceptarAgregarInfraestructura);
    $("#form_añadir_infraestructura").on("click", "#btn_mod_infraestructura", modificarInfraestructura);
    $("#modal_editar_infraestructura").on("click", "#btn_modificar_infraestructura", siModificarInfraestructura);
    $("#form_añadir_infraestructura").on("click", "#btn_elim_infraestructura", eliminarInfraestructura);
    $("#modal_elim_infraestructura").on("click", "#btn_eliminar_infraestructura", sieliminarInfraestructura);


    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/i.test(value);
    }, "Solo se admite texto");

    function validar_formulario() {
        $("#adicionar_infraestructura").validate({
            rules: {
                titulo_infraestructura: {
                    lettersonly: true,
                    required: true
                }
            },
            messages: {
                titulo_infraestructura: {
                    required: " El titulo es requerido"
                }
            },
        });
        $("#modificar_infraestructura").validate({
            rules: {
                edit_tit_infraestructura: {
                    lettersonly: true,
                    required: true
                }
            },
            messages: {
                edit_tit_infraestructura: {
                    required: " El titulo es requerido"
                }
            },
        });
        $("#adicionar_infraestructura :input, #modificar_infraestructura :input").on("blur", function() {
            $(this).valid();
        });
    }
}

var dato;
$.ajax({
    url: "./controladores/admin_infraestructura.php",
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

            return dato = respuesta.infraestructura;
        }

    },
})

var tabla_infraestructura = $("#datatable_infraestructura");
dataTable_infraestructura = tabla_infraestructura.DataTable({
    data: dato,
    columns: [
        { data: "id" },
        { data: "titulo" },
        { data: "descripcion" },
        {
            data: "imagen",
            render: function(data, type, row) {
                return data ?
                    '<img src="./vistas/imagenes/infraestructura/' + data + '"/>' :
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
                botones = '<div align="center"><button id="btn_mod_infraestructura" class="btn btn-warning btn_grid_form" style="display:inline-block;"><i class="fa fa-edit"></i></button>';
                botones += '<button id="btn_elim_infraestructura" class="btn btn-danger btn_grid_form" style="display:inline-block;"><i class="fa fa-remove"></i></button></div>';
                return botones;
            },
        }
    ],
});

function agregarInfraestructura() {
    $("#modal_adicionar_infraestructura").modal("show");
    $("#titulo_infraestructura").val("");
    $("#descripcion_infraestructura").val("");
    return false;
}

function aceptarAgregarInfraestructura() {
    if ($('#adicionar_infraestructura').valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#adicionar_infraestructura")[0]);
        datos.append('accion', 'add');
        $.ajax({
            url: "./controladores/admin_infraestructura.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Agregar infraestructura",
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

function modificarInfraestructura() {
    row = dataTable_infraestructura.row($(this).parents("tr"));
    var datos = row.data();
    id = datos.id;
    $("#edit_tit_infraestructura").val(datos.titulo);
    $("#edit_des_infraestructura").val(datos.descripcion);
    $('#imagen').attr('src', "./vistas/imagenes/infraestructura/" + datos.imagen);
    $("#modal_editar_infraestructura").modal("show");
    return false;
}

function siModificarInfraestructura() {
    if ($("#modificar_infraestructura").valid() == false) {
        return false;
    } else {
        var datos = new FormData($("#modificar_infraestructura")[0]);
        datos.append('accion', 'editar');
        datos.append('id', id);
        $.ajax({
            url: "./controladores/admin_infraestructura.php",
            type: "POST",
            data: datos,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.hasOwnProperty('ok')) {
                    new PNotify({
                        title: "Editar Infraestructura",
                        text: data.ok,
                        type: "success",
                        styling: "bootstrap3"
                    });
                }
            }
        });
    }
}

var id;

function eliminarInfraestructura() {
    row = dataTable_infraestructura.row($(this).parents("tr"));
    var dato = row.data();
    id = dato.id;
    $("#modal_elim_infraestructura").modal("show");
    return false;

}

function sieliminarInfraestructura() {
    $.ajax({
        url: "./controladores/admin_infraestructura.php",
        type: "POST",
        data: {
            accion: "eliminar",
            id: id
        }
    });
}