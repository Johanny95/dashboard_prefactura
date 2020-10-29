
<form id="form" method="POST">
    <section class="content-header">
        <h1>
            Registro de 
            <small><b>Eventos</b></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Eventos</li>
            <li class="active">Registrar</li>
        </ol>
    </section>

    <section class="content">     
        <div class="box box-primary">
            
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus"></i> Registrar Evento</h3>
                <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-right"><strong>Volver</strong></a>
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Periodo</label>
                            <div class="input-group date">
                                <input id='fecha' name='fecha' type="text" class="form-control"  readonly="true" value="<?php echo date('m/Y');?>">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Numero de guia</label>
                            <input id='numero_guia' name='numero_guia' type="text" class="form-control" onkeypress="return isNumber(event)" >
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="filename">Archivo guia referencia</label>
                            <input id="input" type="file" name="userfile" class="file-loading" >
                        </div>    
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Planta</label>
                            <select name="organizaciones" id="organizaciones" class="form-control select2" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select name="proveedor" id="proveedor" class="select2 form-control" style="width: 100%"> </select>
                        </div>
                    </div>

                </div>


            </div>
            <div class="box-footer">
                <div class="container-fluid">
                    <div class="col-sm-4 pull-left">
                        <button type="button" class="btn btn-block btn-flat btn-success" id="bt_registrar_evento" disabled="true">Guardar <i class="fa fa-save"></i></button>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <button type="button" id="btn_add_servicio" class="btn btn-primary btn-flat btn-block pull-right"><strong>Agregar servicio</strong></button>        
                    </div>
                </div>
            </div>
        </div>
        

        <div id="div_contenedor">
            
        </div>


        <div class="modal fade in" id="modal_servicio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Agregar servicio</h4>
                    </div>

                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Servicios</label>
                                <select name="servicios" id="servicios" class="form-control select2" style="width: 100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button id="btn_confirmar_add" type="button" class="btn btn-primary pull-right">Confirmar</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>



    </section>

</form>
<script>
    var  servicios = [];


    jQuery(document).ready(function() {

        // servicios.push(servicio);
        // console.log(servicios);

        $('body').on('click','#btn_add_servicio',function(){
            cargar_select_servicios('#servicios','proveedor/get_servicios_proveedor', $("#proveedor").val());
            $('#modal_servicio').modal('show');
        });

        $('body').on('click','#btn_confirmar_add',function(){
            var servicio   = {  "ID"        : $('#servicios').val(),
            "NOMBRE"    : $("#servicios option:selected").text()
        };
        add_servicio(servicio);
    })




        $('.select2').select2();
        $('.date').datepicker({
            autoclose: true,
            format: "mm/yyyy",
            language: "es",
            todayHighlight: true,
            // startDate: "today",
            viewMode: "months", 
            minViewMode: "months"
        });

        $("#input").fileinput({
            showCaption: true,
            showPreview: false,
            language: "es",
            allowedFileExtensions: ["pdf"],
            browseClass: "btn btn-flat btn-default",
            browseLabel: "Adjuntar...",
            removeClass: "btn btn-flat btn-default",
            removeLabel: "Eliminar",
            uploadClass: "btn btn-flat btn-default btn-upload hide",
            uploadLabel: "Subir",
            cancelClass: "btn btn-flat btn-default",
            cancelLabel: "Cancelar"
        });

        $('.file-preview').css('min-height', '200px');
        $('.file-preview').css('border', '1px solid #ddd');
        $('.file-preview').css('padding', '5px');
        $('.file-preview').css('margin-bottom', '10px');

        $('body').on('change','#proveedor',function(){
            $('#nombre_proveedor_text').val($(this).text());
            $('#bt_registrar_evento').attr('disabled',true);
            servicios = [];
        });

        $('body').on('click','#bt_registrar_evento',function(e){
            e.preventDefault();
            $('#btn_add').prop('disabled', true);
            var formulario              = new FormData(document.getElementById("form"));
            var file_data               = $('#input').prop('files')[0];
            formulario.append('servicios'           ,JSON.stringify(servicios) );
            // console.log(servicios);
            formulario.append('file'                , file_data);
            $.ajax({
                url: '<?php print site_url()?>/evento/registrar_evento',
                type: 'POST',
                dataType: 'json',
                data: formulario,
                processData: false,
                contentType: false,
                cache: false,
                async: false
            }).done(function(data) {
             if (data.estado) {
                $('#form')[0].reset();
                $('div.form-group').removeClass('has-success').removeClass('has-error')
                .find('.text-danger').remove();
                pf_notify('Evento', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                $('#div_contenedor').empty();
                cargar_select('#proveedor','proveedor/get_proveedores_by_org');
                $('#bt_registrar_evento').attr('disabled',true);
                servicios = [];

            }else{
                if( !(data.mensaje.validacion) ){
                    $.each(data.mensaje,function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                        .removeClass('has-success')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger')
                        .remove();
                        element.after(value);
                    });
                }else{
                    pf_notify('Concepto', data.mensaje.validacion , 'danger' ,'fa fa-ban');
                }
            }
        }) .always(function() {
            $('#btn_add').prop('disabled', false);
        });
    });

        cargar_select('#proveedor','proveedor/get_proveedores_by_org');
        cargar_select_org();

        $('body').on('change','#organizaciones',function(){
            $('#div_contenedor').empty();
            cargar_select('#proveedor','proveedor/get_proveedores_by_org');
            $('#bt_registrar_evento').attr('disabled',true);
            servicios = [];
        });

        $('body').on('change','#proveedor',function(){
            $('#div_contenedor').empty();
            servicios = [];
        });

        $('body').on('click','.btn_remove',function(){
            var id_concepto = $(this).data('id');
            var id_servicio = $(this).data('servicio');
            remove_array_concepto(id_servicio, id_concepto);
        });        

        $('body').on('click','.btn_del_service',function(){
            var id = $(this).data('id');
            remove_array_servicio(id);
            removeElement( id+"_box" );
        });

    });

function cargar_select(id_elemento, url){
    $(id_elemento).empty();
    $(id_elemento).select2({
        'ajax': {
            url: "<?php echo site_url('"+url+"')?>",
            type: "POST",
            dataType: 'json',
            data: function(params) {
                return {
                    autocompletar: params.term,
                    org_id       : $('#organizaciones').val()
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text : item.nombre,
                            id   : item.id
                        }
                    })
                };
            }
        },
        'width'              : '100%',
        'language'         : 'es',
        'minimumInputLength' : 0
    });
}

function cargar_select_servicios(id_elemento, url, id_proveedor){
 $(id_elemento).empty();
 $.post( "<?php echo site_url('"+url+"')?>", {id_proveedor : id_proveedor} , function(data) {
    $.each( data.servicios , function(index, el) {
        var validador  =  false;
        $.each(servicios, function(index, val) {
            console.log(val.ID + '   ==   '+el.ID);
            if ( val.ID == parseInt(el.ID)) {
                validador = true;
            }
        });
        if ( !validador) {
            $(id_elemento).append('<option value="'+el.ID+'" >'+el.NOMBRE+'</option>');
        }

    });
    $(id_elemento).select2();
},'json');
}

function cargar_select_org(){
    $('#organizaciones').empty();
    var usuid = "<?php echo $this->session->usuid;?>";
    $.post("<?php echo site_url('usuario/get_usuorg')?>", {usuid : usuid} , function(data) {
        $.each(data.organizaciones_usuario, function(index, val) {
            $('#organizaciones').append('<option value="'+val.ORGANIZATION_ID+'" >'+val.ORGANIZACION+'</option>');
        });
    },'json');
}

function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        //[ 0-31] 44 [48, 57]
        if (charCode > 31 && charCode != 44 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

function remove_array_servicio(elemento){
    var posicion = -1;
    $.each(servicios, function(index, val) {
       if ( val.ID == elemento) {
        posicion = index;
    }
});
    if (posicion > -1 ) {
        servicios.splice(posicion, 1);
    }
    if( servicios.length < 1 ){
        $('#bt_registrar_evento').attr('disabled',true);
    }
}

function remove_array_concepto(id_servicio, id_concepto ){

    $.each(servicios, function(index, val) {
        var i = -1;
        if ( val.ID == id_servicio ) {
            var inst = val.CONCEPTOS;
            i = inst.indexOf(id_concepto);
            if ( i > -1){
                val.CONCEPTOS.splice( i , 1);
                removeElement(id_concepto+"_row");
            }
        }
        if(val.CONCEPTOS.length < 1){
            remove_array_servicio(id_servicio);
            removeElement(id_servicio+"_box");
        }
    });
}

function removeElement(elementId) {
        // Removes an element from the document
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }

    function add_concepto( id_servicio ){

        var result = $.grep(servicios, function(e){ return e.ID == id_servicio; });
        var array   =   result[0].CONCEPTOS;

        var proveedor_id = $('#proveedor').val();

        $.post('<?php echo site_url("evento/get_conceptos_by_servicio")?>', {'id_servicio' : id_servicio , 'id_proveedor' : proveedor_id }, function(data, textStatus, xhr) {
           $.each(data, function(index, val) {
            var id = parseInt(val.ID_CONCEPTO);
            if( ! array.includes(id) ){
                add_html_concepto( val, result[0] );
                array.push(id);
                return false;
            }
        });
       },'json');
        console.log(servicios);
    }

    function add_servicio(servicio){
         var proveedor_id = $('#proveedor').val();
        $.post('<?php echo site_url("evento/get_conceptos_by_servicio")?>', {id_servicio : servicio.ID , 'id_proveedor' : proveedor_id }, function(data, textStatus, xhr) {
         if ( data.length >= 1 ){
            var str_html =  '<div id="'+servicio.ID+'_box" class="box box-primary">';
            str_html += '        <div class="box-header with-border">';
            str_html += '            <div class="container-fluid">';
            str_html += '                <div class="col-sm-6">';
            str_html += '                    <h4 id="servicio_txt"><i class="fa fa-genderless"></i>  '+servicio.NOMBRE+'</h4>';
            str_html += '                </div>';
            str_html += '                <div class="box-tools pull-right">';
            str_html += '                    <button type="button" class="btn btn-default" onclick="add_concepto('+servicio.ID+')"><i class="fa fa-plus"></i> Agregar conceptos</button>';
            str_html += '                    </button>';
            str_html += '                    <button data-id="'+servicio.ID+'" type="button" class="btn btn-box-tool btn_del_service" data-widget="remove"><i class="fa fa-times"></i></button>';
            str_html += '                </div>    ';
            str_html += '            </div>';
            str_html += '        </div>';
            str_html += '        <div class="box-body">';
            str_html += '            <div id="'+servicio.ID+'_container" class="container-fluid">';
            var array_concepto = []
            $.each( data, function(index, val) {
                array_concepto.push( parseInt(val.ID_CONCEPTO) );

                str_html += '                <div class="row" id="'+val.ID_CONCEPTO+'_row">';
                str_html += '                    <div class="col-sm-5">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Concepto</label>';
                str_html += '                            <select name="'+val.ID_CONCEPTO+'_concepto" id="'+val.ID_CONCEPTO+'_concepto" class="form-control select2" style="width: 100%;">';
                str_html += '                                   <option selected="true" value="'+val.ID_CONCEPTO+'">'+val.NOMBRE+'</option>';
                str_html += '                            </select>';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Cantidad 1</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad1" name="'+val.ID_CONCEPTO+'_cantidad1" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Medida 1</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida1" name="'+val.ID_CONCEPTO+'_medida1" type="text" class="form-control" readonly="true" value="'+val.MEDIDA1+'" />';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Cantidad 2</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad2" name="'+val.ID_CONCEPTO+'_cantidad2" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Medida 2</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida2" name="'+val.ID_CONCEPTO+'_medida2" type="text" class="form-control" readonly="true" value="'+val.MEDIDA2+'" />';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Cantidad 3</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad3" name="'+val.ID_CONCEPTO+'_cantidad3" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Medida 3</label>';
                str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida3" name="'+val.ID_CONCEPTO+'_medida3" type="text" class="form-control" readonly="true" value="'+val.MEDIDA3+'" />';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                    <div class="col-sm-1">';
                str_html += '                        <div class="form-group">';
                str_html += '                            <label>Eliminar</label>';
                str_html += '                            <button type="button" data-servicio="'+servicio.ID+'" data-id="'+val.ID_CONCEPTO+'" class="btn btn-danger form-control btn-block btn_remove"> <i class="fa fa-trash"></i> </button>';
                str_html += '                        </div>';
                str_html += '                    </div>';
                str_html += '                </div>';

            });
str_html += '            </div>';
str_html += '        </div>';
str_html += '        <div class="box-footer">';
str_html += '            <div class="container-fluid">';
str_html += '            </div>';
str_html += '        </div>';
str_html += '    </div>';

$('#div_contenedor').append(str_html);

var s = { ID        : parseInt(servicio.ID),
  CONCEPTOS : array_concepto
};

servicios.push( s );
$('#modal_servicio').modal('hide');
$('#bt_registrar_evento').attr('disabled',false);
}else{
    pf_notify('Información', 'El servicio que esta intentando agregar no tiene conceptos vigentes a la fecha de hoy' , 'info' ,'fa fa-commenting-o');
}
},'json');

}


function add_html_concepto(val , servicio){
    var str_html = "";
    str_html += '                <div class="row" id="'+val.ID_CONCEPTO+'_row">';
    str_html += '                    <div class="col-sm-5">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Concepto</label>';
    str_html += '                            <select name="'+val.ID_CONCEPTO+'_concepto" id="'+val.ID_CONCEPTO+'_concepto" class="form-control select2" style="width: 100%;">';
    str_html += '                                   <option selected="true" value="'+val.ID_CONCEPTO+'">'+val.NOMBRE+'</option>';
    str_html += '                            </select>';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Cantidad 1</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad1" name="'+val.ID_CONCEPTO+'_cantidad1" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Medida 1</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida1" name="'+val.ID_CONCEPTO+'_medida1" type="text" class="form-control" readonly="true" value="'+val.MEDIDA1+'" />';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Cantidad 2</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad2" name="'+val.ID_CONCEPTO+'_cantidad2" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Medida 2</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida2" name="'+val.ID_CONCEPTO+'_medida2" type="text" class="form-control" readonly="true" value="'+val.MEDIDA2+'" />';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Cantidad 3</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_cantidad3" name="'+val.ID_CONCEPTO+'_cantidad3" type="text" class="form-control" onkeypress="return isNumber(event)"/>';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Medida 3</label>';
    str_html += '                            <input id="'+val.ID_CONCEPTO+'_medida3" name="'+val.ID_CONCEPTO+'_medida3" type="text" class="form-control" readonly="true" value="'+val.MEDIDA3+'" />';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                    <div class="col-sm-1">';
    str_html += '                        <div class="form-group">';
    str_html += '                            <label>Eliminar</label>';
    str_html += '                            <button type="button" data-servicio="'+servicio.ID+'" data-id="'+val.ID_CONCEPTO+'" class="btn btn-danger form-control btn-block btn_remove"> <i class="fa fa-trash"></i> </button>';
    str_html += '                        </div>';
    str_html += '                    </div>';
    str_html += '                </div>';

    $("#"+servicio.ID+"_container").append(str_html);
}


</script>


