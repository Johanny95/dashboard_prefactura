
<form id="form" method="POST">
    <section class="content-header">
        <h1>
            Registro de 
            <small><b>Asjutes</b></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Ajustes</li>
            <li class="active">Registrar</li>
        </ol>
    </section>

    <section class="content">     
        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus"></i> Registrar Ajuste</h3>
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Servicios</label>
                            <select name="servicios" id="servicios" class="form-control select2" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Concepto</label>
                            <select name="concepto" id="concepto" class="form-control select2" style="width: 100%;">
                                <option selected="true" value=""></option>
                            </select>

                        </div>
                    </div>
                    <div id="div_contenedor" class="hide">
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>Cantidad 1</label>
                                <input class="form-control" type="text" name="cantidad1" id="cantidad1" value=""  onkeypress="return isNumber(event)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>Medida 1</label>
                                <input class="form-control" type="text" name="medida1" id="medida1" value="" readonly="true">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>Cantidad 1</label>
                                <input class="form-control" type="text" name="cantidad2" id="cantidad2" value=""  onkeypress="return isNumber(event)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>medida 2</label>
                                <input class="form-control" type="text" name="medida2" id="medida2" value="" readonly="true">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>Cantidad 1</label>
                                <input class="form-control" type="text" name="cantidad3" id="cantidad3" value=""  onkeypress="return isNumber(event)">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-groupm">
                                <label>Medida 3</label>
                                <input class="form-control" type="text" name="medida3" id="medida3" value="" readonly="true" >
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <div class="container-fluid">
                    <div class="col-sm-4 pull-left">
                        <button type="button" class="btn btn-block btn-flat btn-success" id="bt_add_ajuste" disabled="true">Guardar <i class="fa fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>


    </section>

</form>
<script>
    var  servicios = [];


    jQuery(document).ready(function() {


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
            
        });

        $('body').on('click','#bt_add_ajuste',function(e){
            e.preventDefault();
            $('#btn_add').prop('disabled', true);
            var formulario              = new FormData(document.getElementById("form"));
            var file_data               = $('#input').prop('files')[0];
            formulario.append('file'                , file_data);
            $.ajax({
                url: '<?php print site_url()?>/ajuste/registrar_ajuste',
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
                
                cargar_select('#proveedor','proveedor/get_proveedores_by_org');
                $('#bt_add_ajuste').attr('disabled',true);
                cargar_select_servicios('#servicios', 'proveedor/get_servicios_proveedor', $("#proveedor").val());
                $('#div_contenedor').addClass('hide').removeClass('show');
                $('#concepto').empty();
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
                    pf_notify('ajuste', data.mensaje.validacion , 'danger' ,'fa fa-ban');
                }
            }
        }) .always(function() {
            $('#btn_add').prop('disabled', false);
        });
    });

        cargar_select('#proveedor','proveedor/get_proveedores_by_org');
        cargar_select_org();

        $('body').on('change','#organizaciones',function(){
            $('#div_contenedor').addClass('hide').removeClass('show');
            $('#concepto').empty();
            $('#servicios').empty();
            cargar_select('#proveedor','proveedor/get_proveedores_by_org');
            $('#bt_add_ajuste').attr('disabled',true);
        });

        $('body').on('change','#proveedor',function(){
            $('#div_contenedor').addClass('hide').removeClass('show');
            $('#concepto').empty();
            cargar_select_servicios('#servicios', 'proveedor/get_servicios_proveedor', $("#proveedor").val());
            $('#bt_add_ajuste').attr('disabled',true);
        });

        $('body').on('change','#servicios',function(){
            $('#div_contenedor').addClass('hide').removeClass('show');
            $('#concepto').empty();
            cargar_concepto($('#servicios').val());
            $('#bt_add_ajuste').attr('disabled',true);
        });

        $('body').on('change','#concepto',function(){
            var id_concepto = $(this).val();
            var elemento = $.grep(conceptos, function(e){ return e.ID_CONCEPTO == id_concepto; })[0];
            
            $('#medida1').val(elemento.MEDIDA1);
            $('#medida2').val(elemento.MEDIDA2);
            $('#medida3').val(elemento.MEDIDA3);
            $('#div_contenedor').removeClass('hide').addClass('show');
            $('#bt_add_ajuste').attr('disabled',false);

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
 $(id_elemento).append('<option >Seleccionar</option>');
 $.post( "<?php echo site_url('"+url+"')?>", {id_proveedor : id_proveedor} , function(data) {
    $.each( data.servicios , function(index, el) {
        var validador  =  false;
        $.each(servicios, function(index, val) {
            // console.log(val.ID + '   ==   '+el.ID);
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

var conceptos = [];
function cargar_concepto(id_servicio){
    $('#concepto').empty();
    var proveedor_id  = $('#proveedor').val();
    $.post('<?php echo site_url("evento/get_conceptos_by_servicio")?>', {'id_servicio' : id_servicio, 'id_proveedor' : proveedor_id}, function(data, textStatus, xhr) {
        conceptos = data;
        $('#concepto').append('<option value="">Seleccionar</option>');
        $.each(conceptos, function(index, val) {
         $('#concepto').append('<option value="'+val.ID_CONCEPTO+'">'+val.NOMBRE+'</option>');
     }); 

        console.log(conceptos);
    },'json');

}






</script>


