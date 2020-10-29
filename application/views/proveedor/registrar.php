<section class="content-header">
    <h1>
        Proveedores
        <small><b>Registrar</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Proveedor</li>
        <li class="active">Registrar</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">
        <form id="form" method="POST">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Registrar Proveedor</h3>
        </div>
        <div class="box-body">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Proveedor</label>
                    <select name="proveedor" id="proveedor" class="select2 form-control" style="width: 100%"> </select>
                </div>    
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nombre prevedor</label>
                    <input type="text" id="nombre_proveedor_text" class=" form-control" readonly="true" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Organizaciones</label>
                    <select id='organizaciones' name='organizaciones' multiple class="form-control selectpicker" data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                    </select>
                </div>
            </div>

             <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Servicios</label>
                    <select id='servicios' name='servicios' multiple class="form-control selectpicker" data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                    </select>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-left"><strong>Volver</strong></a>
            <button type="button" id="btn_add" class="btn btn-primary btn-flat pull-right"><strong>Registrar</strong></button>
        </div>
        </form>
    </div>
</section>
<script>
    jQuery(document).ready(function() {
      
        $('body').on('change','#proveedor',function(){
            $('#nombre_proveedor_text').val($(this).text()); 
        });


        $('body').on('click','#btn_add',function(e){
            e.preventDefault();
            $('#btn_add').prop('disabled', true);
            var formulario              = new FormData(document.getElementById("form"));
            var organizaciones          = $('#organizaciones').val();
            var servicios               = $('#servicios').val();
            var proveedor               = ( $('#proveedor').val() ? $('#proveedor').val() : '' );
            formulario.append('organizaciones'      , organizaciones);
            formulario.append('proveedor'           , proveedor);
            formulario.append('servicios'           , servicios);
            $.ajax({
                url: '<?php print site_url()?>/proveedor/add',
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
                    pf_notify('Agente', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                    $('#organizaciones').val("");
                    $('.selectpicker').selectpicker('refresh');
                    $('#proveedor').val("");
                }else{
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
               }
            }) .always(function() {
                $('#btn_add').prop('disabled', false);
            });
        });

        cargar_select_org();
        cargar_select_servicio();
        cargar_select('#proveedor','proveedor/get_vendors');
    });


    function cargar_select_org(){
        $('#organizaciones').empty();
        var usuid;
        $.post("<?php echo site_url('usuario/get_organizaciones')?>", {usuid : usuid} , function(data) {
            $.each(data.organizaciones, function(index, val) {
                $('#organizaciones').append('<option value="'+val.ID+'" >'+val.ORGANIZACION+'</option>');
            });
            $('.selectpicker').selectpicker('refresh');
        },'json');
    }

       function cargar_select_servicio(){
        $('#servicios').empty();
        var usuid;
        $.post("<?php echo site_url('servicio/get_servicios')?>", {usuid : usuid} , function(data) {
            $.each(data.servicios, function(index, val) {
                $('#servicios').append('<option value="'+val.ID+'" >'+val.NOMBRE+'</option>');
            });
            $('.selectpicker').selectpicker('refresh');
        },'json');
    }


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

</script>