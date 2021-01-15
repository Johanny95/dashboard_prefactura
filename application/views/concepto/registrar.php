
<section class="content-header">
    <h1>
        Conceptos
        <small><b>Registrar</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Concepto</li>
        <li class="active">Registrar</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">
        <form id="form" method="POST">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus"></i> Registrar Concepto</h3>
                <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-right"><strong>Volver</strong></a>
            </div>
            <div class="box-body">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Proveedor</label>
                        <select name="proveedor" id="proveedor" class="select2 form-control" style="width: 100%"> </select>
                    </div>    
                    <div class="form-group">
                        <label>Nombre prevedor</label>
                        <input type="text" id="nombre_proveedor_text" class=" form-control" readonly="true" />
                    </div>
                    <div class="form-group">
                        <label>Servicio</label>
                        <select name="servicio" id="servicio" class="select2 form-control" style="width: 100%"> </select>
                    </div> 
                    <div class="form-group">
                        <label>Nombre Concepto</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Cuenta Contable</label>
                            <select  id='cta_contable' name="cta_contable" class="form-control select2" style="width: 100%" >

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 1</label>
                            <select name="medida1" id="medida1" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Precio 1</label>
                            <input type="text" name="precio1" id="precio1" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>    
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 2</label>
                            <select name="medida2" id="medida2" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Precio 2</label>
                            <input type="text" name="precio2" id="precio2" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>    
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 3</label>
                            <select name="medida3" id="medida3" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Precio 3</label>
                            <input type="text" name="precio3" id="precio3" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>    
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Creacion de OC</label>
                            <div><input id="check_oc" name="check_oc" type="checkbox" class="flat-red" checked></div>
                            
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo de pago</label>
                            <select name="tipo_pago" id="tipo_pago" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="filename">Archivo a subir (solo pdf)</label>
                            <input id="input" type="file" name="userfile" class="file-loading" >
                        </div>    
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="container-fluid">
                    <div class="col-sm-12">
                        <button type="button" id="btn_add" class="btn btn-primary btn-flat pull-right"><strong>Registrar</strong></button>        
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</section>
<script>
    jQuery(document).ready(function() {

       $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
      })

       $("#input").fileinput({
        showCaption: true,
        showPreview: false,
        language: "es",
        allowedFileExtensions: ["pdf"],
        browseClass: "btn btn-flat btn-primary",
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

        $('#nombre_proveedor_text').val($('#proveedor option:selected').text());
    });

       $('body').on('click','#btn_add',function(e){
        e.preventDefault();
        $('#btn_add').prop('disabled', true);
        var formulario              = new FormData(document.getElementById("form"));
        var servicio                = $('#servicio').val();
        var proveedor               = ( $('#proveedor').val() ? $('#proveedor').val() : '' );
        var file_data               = $('#input').prop('files')[0];
        formulario.append('proveedor'           , proveedor);
        formulario.append('servicio'            , servicio);
        formulario.append('file'                , file_data);
        $.ajax({
            url: '<?php print site_url()?>/concepto/add',
            type: 'POST',
            dataType: 'json',
            data: formulario,
            processData: false,
            contentType: false,
            cache: false,
            async: false
        }).done(function(data) {
         if (data.estado) {
            $('form')[0].reset();
            $('div.form-group').removeClass('has-success').removeClass('has-error')
            .find('.text-danger').remove();
            pf_notify('Concepto', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
            $('#organizaciones').val("");
            $('#proveedor').val("");
            $('.selectpicker').selectpicker('refresh');
            $('#check_oc').attr('checked',true);
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

       cargar_select('#proveedor','proveedor/get_proveedores_registrados');
       cargar_select('#medida1','concepto/get_medidas');
       cargar_select('#medida2','concepto/get_medidas');
       cargar_select('#medida3','concepto/get_medidas');
       cargar_select('#cta_contable','concepto/get_cuentas_contables');
       cargar_select('#tipo_pago','concepto/get_tipos_pago');


       $('body').on('change','#proveedor',function(){
        cargar_select_servicios('#servicio','proveedor/get_servicios_proveedor', $(this).val() );
    })

   });

    function cargar_select(id_elemento, url){
        $(id_elemento).select2({
            'ajax': {
                url: "<?php echo site_url('"+url+"')?>",
                type: "POST",
                dataType: 'json',
                data: function(params) {
                    return {
                        autocompletar: params.term
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
            },'width'              : '100%',
            'language'         : 'es',
            'minimumInputLength' : 0
        });
    }

    function cargar_select_servicios(id_elemento, url, id_proveedor){
     $(id_elemento).empty();
     $.post( "<?php echo site_url('"+url+"')?>", {id_proveedor : id_proveedor} , function(data) {
        $.each( data.servicios , function(index, el) {
            $(id_elemento).append('<option value="'+el.ID+'" >'+el.NOMBRE+'</option>');
        });
        $(id_elemento).select2();
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



</script>