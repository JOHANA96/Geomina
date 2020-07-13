
$(document).on("ready", inicio); 
var dataTable;

function inicio(){
 
validar_formulario();
$("body").on("click", "#btn_añadir_curso", agregarCurso);
$('#adicionar_curso').on("click", "#btn_agregar_curso", aceptarAgregarCurso);  
$("#form_añadir_curso").on("click", "#btn_mod_curso", modificarCurso);  
$("#editar_curso").on("click", "#btn_modificar_curso", siModificarDocente); 
$("#form_añadir_curso").on("click", "#btn_elim_curso", eliminarCurso);  
$("#modal_elim_curso").on("click", "#btn_eliminar_curso", SieliminarCurso);  


jQuery.validator.addMethod("lettersonly", function(value, element) {
//return this.optional(element) || /^[a-z\s]+$/i.test(value);
return this.optional(element) || /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/i.test(value);
}, "Solo se admite texto");

function validar_formulario(){
  $("#adicionar_curso").validate(
     {
         rules:
         {
             nombre_curso:
             {
                 lettersonly: true,
                 required: true
             },
            descripcion_curso:
             {
                 required: true
             },
             tiempo_curso:
             {
                 required: true
             },
             costo_curso:
             {
                 required: true
             },
             contenido_curso:
             {
                  required: true
             },
             contacto_curso:
                {
                    email: true,
                    required: true
                    
                },
         },
         messages:
         {
             nombre_curso:
             {
                 required: "El nombre es requerido"
             },
             descripcion_curso:
             {
                 required: "La descripción es requerido"
             },
            tiempo_curso:
             {
                 required: "El tiempo es requerido"
             },
            costo_curso:
             {
                 required: "El costo es requerido"
             },
             contenido_curso:
             {
                 required: "El contenido es requrido"
             },
             contacto_curso:
             {
                 required: "El correo es requerido"
             },
             
         },
     });

     $("#editar_curso").validate(
     {
         rules:
         {
            edit_nom_curso:
             {
                 lettersonly: true,
                 required: true
             },
            edit_descripcion_curso:
             {
                 required: true
             },
             edit_td_curso:
             {
                 required: true
             },
             edit_costo_curso:
             {
                 required: true
             },
             edit_contenido_curso:
             {
                  required: true
             },
             edit_contacto_curso:
                {
                    email: true,
                    required: true
                    
                },
         },
         messages:
         {
             edit_nom_curso:
             {
                 required: "El nombre es requerido"
             },
             edit_descripcion_curso:
             {
                 required: "La descripción es requerido"
             },
            edit_td_curso:
             {
                 required: "El tiempo es requerido"
             },
            edit_costo_curso:
             {
                 required: "El costo es requerido"
             },
             edit_contenido_curso:
             {
                 required: "El contenido es requrido"
             },
             edit_contacto_curso:
             {
                 required: "El correo es requerido"
             },
             
         },
     });
$("#adicionar_curso :input, #editar_curso :input").on("blur", function () {
 $(this).valid();
});  
}
}

var dato;
$.ajax({
 url: "./controladores/admin_curso.php",
 type: "POST",
 async: false,
 dataType: "json",
 data: {
     accion: 'datos'
     },
  success: function(respuesta) {
     if(respuesta.hasOwnProperty("ok")){
         new PNotify(
             {
                 title: "Actualizar Datos",
                 text: respuesta.ok,
                 type: "success",
                 styling: "bootstrap3"
             });

             return dato=respuesta.curso;
     }  

 },    
})

var tabla_curso= $("#datatable_curso");
dataTable_curso = tabla_curso.DataTable({
                    data : dato,
            columns : [
                 { data : "id"},
                 { data : "nombre"},
                 { data : "descripcion"},
                 { data : "tiempo_duracion"},
                 { data : "costo"},
                 { data : "contenido"},
                 { data : "contacto"},
                 { data : "nombre_imagen",
                   render: function(data, type, row) {
                     return data ?
                     '<img src="./vistas/imagenes/curso/'+data+'"/>':
                     null;
                 },  
             }
              ],
         order: [
             [1, "asc"]
         ],
         responsive: true,
         columnDefs: [
             {
                 orderable: false,
                 searchable: false,
                 visible: false,
                 targets: [0,],
             },
             {
                 orderable: true,
                 searchable: true,
                 targets: [ 1,2, 3, 4, 5, 6, 7, 8],
             },
           { 
                 orderable: false,
                 searchable: false,
                 targets: [8],

                 mRender: function (data, type, row) {
                     var botones;
                     botones = '<div align="center"><button id="btn_mod_curso" class="btn btn-warning btn_grid_form" style="display:inline-block;"><i class="fa fa-edit"></i></button>';
                     botones += '<button id="btn_elim_curso" class="btn btn-danger btn_grid_form" style="display:inline-block;"><i class="fa fa-remove"></i></button></div>';
                     return botones;
             },
         }],
     });
     
function agregarCurso(){
 $("#modal_adicionar_curso").modal("show");
 $("#nombre_curso").val("");
 $("#descripcion_curso").val("");
 $("#tiempo_curso").val("");
 $("#costo_curso").val("");
 $("#contenido_curso").val("");
$("#contacto_curso").val("");
  return false;
}

function aceptarAgregarCurso(){ 
 if ($("#adicionar_curso").valid() == false) {
     return false;
 }
 else {
  var datos = new FormData($("#adicionar_curso")[0]); 
  datos.append('accion', 'add') ;       
 $.ajax({
     url: "./controladores/admin_curso.php",
     type: "POST",
     data:  datos,
     contentType: false,
     processData:false,
          success: function(response) {
             if(response.hasOwnProperty('ok')){
                 new PNotify(
                     {
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
function modificarCurso(){ 
 row = dataTable_curso.row($(this).parents("tr"));
 var datos = row.data();
 id=datos.id;
$("#edit_nom_curso").val(datos.nombre);
$("#edit_descripcion_curso").val(datos.descripcion);
$("#edit_td_curso").val(datos.tiempo_duracion);
$("#edit_costo_curso").val(datos.costo);
$("#edit_contenido_curso").val(datos.contenido);
$("#edit_contacto_curso").val(datos.contacto);
$('#imagen').attr('src', "./vistas/imagenes/curso/"+datos.nombre_imagen);
$("#modal_editar_curso").modal("show"); 
 return false;
}

function siModificarDocente() {
     if ($("#editar_curso").valid() == false) {
        return false;
    }
    else {
     var datos = new FormData($("#editar_curso")[0]); 
     datos.append('accion', 'editar') ;        
     datos.append('id', id);
    $.ajax({
        url: "./controladores/admin_curso.php",
        type: "POST",
        data:  datos,
        contentType: false,
        processData:false,
             success: function(response) {
                if(response.hasOwnProperty('ok')){
                    new PNotify(
                        {
                            title: "Editar Curso",
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
function eliminarCurso(){
    row = dataTable_curso.row($(this).parents("tr"));
    var data = row.data();
    id = data.id;
    $("#modal_elim_curso").modal("show");
    return false;
}


function SieliminarCurso() {
    $.ajax({
        url: "./controladores/admin_curso.php",
        type: "POST",
        data: {
           accion: "eliminar",
           id: id 
        }
    });
}