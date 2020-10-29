<section class="content-header">
    <h1>
        Servicios
        <small><b>Listado</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Servicios</li>
        <li class="active">Listado</li>
    </ol>
</section>

<section class="content">   
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> Listado de registros</h3>
        </div>
        <div class="box-header with-border">
            <div class="row">
                <div id="top-left" class="col-xs-6">
                    <div class="form-group margin-btm-5">
                        <label>Mostrar</label>
                        <select id="show_record" class="form-control">
                            <option value="10">10 registros</option>
                            <option value="25">25 registros</option>
                            <option value="50">50 registros</option>
                            <option value="100">100 registros</option>
                            <option value="-1">Todos los registros</option>
                        </select>
                    </div>
                </div>
                <div id="top-right" class="col-xs-6">
                    <div class="form-group margin-btm-5">
                        <label>Buscar</label>
                        <input id="search_input" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row table-responsive no-left-right-margin">
                <div class="col-xs-12"> 
                    <table id="table" class="table table-bordered table-striped table-hover" style="width: 100%">
                        <thead>
                            <th>Nombre</th>
                            <th width="50px" class="no-sort text-center">Editar</th>
                            <th width="50px" class="no-sort text-center">Eliminar</th>
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $value): ?>
                                <tr>
                                    <td><?php echo ucwords(mb_strtolower($value->NOMBRE)); ?></td>
                                    <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-primary btn-flat btn-xs" href="<?php echo site_url('condicion/editar/'.$value->ID)?>"><i class="fa fa-pencil"></i></a></td>
                                    <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-flat btn-xs" href="#"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <p id="footer-left" class="col-sm-6 footer-dt"></p>
                <div id="footer-right" class="col-sm-6"></div>
            </div>
        </div>
    </div>
</section>

<div class="modal modal-danger fade" id="confirmation_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-question-circle margin-right-5"></i> <span>Eliminar</strong></h4>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro que desea eliminar : '<span id="name"></span>' del sistema?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-flat pull-left" data-dismiss="modal"><strong>No, cancelar</strong></button>
                    <?php echo form_open(site_url('servicio/del'), array('id' => 'form')); ?>
                    <button type="submit" class="btn btn-outline btn-flat pull-right"><strong>Si, eliminar</strong></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <?php echo form_open(site_url('servicio/edi'), array('id' => 'form-editar'), array('id' => '')); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

  <script>
    var table, row, id;

    jQuery(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip(); 

        table = $("#table").DataTable({
            "order": [0, 'asc'],
            "columnDefs": [
            { targets: 'no-sort', orderable: false }
            ], 
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,

            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }, 
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });

    jQuery("#footer").ready(function(){
        jQuery("#table_length").addClass('hidden');
        jQuery("#table_filter").addClass('hidden');
        jQuery("#table_info").addClass('hidden');
        jQuery("#footer-left").text(jQuery("#table_info").text());
        jQuery("#table_paginate").appendTo(jQuery("#footer-right"));
    });

    $('#search_input').keyup(function(){
        table.search($(this).val()).draw() ;
    })

    $('#show_record').click(function() {
        table.page.len($('#show_record').val()).draw();
        jQuery("#footer-left").text(jQuery("#table_inc_info").text());
    });

    jQuery("#table").on("page.dt", function(){
        var info = table.page.info();
        jQuery("#footer-left").text("Mostrando registros del "+(info.start+1)+" al "+info.end+" de un total de "+info.recordsTotal+" registros");
    });

    $('.table tbody tr td .btn-danger').click(function(event){
        $('#name').text($(this).parent().siblings().text());
        row = table.row( $(this).parents('tr') );
        id = $(this).parent().parent().children().eq(1).find('a').attr('href').split('/').pop().replace('.html', '');
        $('#confirmation_modal').modal('toggle');
    });

    $('.table tbody tr td .btn-primary').click(function(event){
        event.preventDefault();
        var tr   = $(this).closest('tr');
        row      = table.row(tr);
        var data = row.data();
        $('#nombre').val(data[0]) 
        $('#name').text($(this).parent().siblings().text());
        $('input[name=id]').val($(this).parent().parent().children().eq(1).find('a').attr('href').split('/').pop().replace('.html', ''));
        $('#modal-default').modal('toggle');
    });

    $('#form').submit(function(event) {
        event.preventDefault();
        var btn = $(this).find('button');
        btn.prop('disabled', true);
        $.post($(this).attr('action'), {id : id}, function(data) {
            if (data.estado) {
                pf_notify('Eliminación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
            }else{
                pf_notify('Eliminación', 'Ups!, Error al eliminar' , 'danger' ,'fa fa-close');
            }
        })
        .always(function() {
            btn.prop('disabled', false);
            row.remove().draw();
            $('#confirmation_modal').modal('toggle');
        });
    });

    $('#form-editar').submit(function(event) {
        event.preventDefault();
        var btn = $(this).find('button');
        btn.prop('disabled', true);
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
            if (data.estado) {
                table.cell(row, 0).data($('#nombre').val()).draw();
                $('form')[0].reset();
                $('div.form-group').removeClass('has-success').removeClass('has-error')
                .find('.text-danger').remove();
                pf_notify('Edición', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
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
            $('#modal-default').modal('toggle');
        });
    });
</script>