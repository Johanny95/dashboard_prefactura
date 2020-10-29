<section class="content-header">
    <h1>
        Servicio
        <small><b>Registrar</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Servicio</li>
        <li class="active">Registrar</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">
        <?php echo form_open(site_url('servicio/add')); ?>
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Registrar servicio</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" autocomplete="off" name="nombre" id="nombre" class="form-control" placeholder="EJ: Herramienta">
            </div>
        </div>
        <div class="box-footer">
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-left"><strong>Volver</strong></a>
            <button type="submit" class="btn btn-primary btn-flat pull-right"><strong>Registrar</strong></button>
        </div>
        <?php form_close(); ?>
    </div>
</section>
<script>
    jQuery(document).ready(function() {
        var btn = $('button');
        $('form').submit(function(event) {
            event.preventDefault();
            btn.prop('disabled', true);
            $.post($(this).attr('action'), $(this).serialize(), function(data) {
                if (data.estado) {
                    $('form')[0].reset();
                    $('div.form-group').removeClass('has-success').removeClass('has-error')
                    .find('.text-danger').remove();
                    pf_notify('Creación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                }else{
                   $.each(data.mensaje,function(key, value) {
                    var element = $('#' + key);
                    if (element.is('input')) {
                        element.closest('div.form-group')
                        .removeClass('has-success')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger')
                        .remove();
                        element.after(value);
                    }
                });
               }
           })
            .always(function() {
                btn.prop('disabled', false);
            });
            
        });
    });
</script>