<section class="content-header">
    <h1>
        Proveedor
        <small><b>Todas</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Proveedor</li>
        <li class="active">Todas</li>
    </ol>
</section>

<section class="content">   
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> Listado de proveedores</h3>
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
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>RUT</th>
                            <th>Estado</th>
                            <th>F. Creación</th>
                            <th width="50px" class="no-sort text-center">Editar</th>
                            <th width="50px" class="no-sort text-center">Eliminar</th>
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $value): ?>
                                <tr>
                                    <td><?php echo $value->ID; ?></td>
                                    <td><?php echo ucwords(mb_strtolower($value->NOMBRE)); ?></td>
                                    <td><?php echo $value->RUT_PROVEEDOR; ?></td>
                                    <td><?php echo $value->ESTADO; ?></td>
                                    <td><?php echo $value->FECHA_CREACION; ?></td>
                                    <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Editar Agente" class="btn btn-primary btn-flat btn-xs" data-id="<?php  echo $value->ID ?>" href="<?php echo site_url('agente/editar/'.$value->ID)?>"><i class="fa fa-pencil"></i></a></td>
                                    <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Eliminar Agente" class="btn btn-danger btn-flat btn-xs" href="#"><i class="fa fa-trash"></i></a></td>
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
                <h4 class="modal-title"><i class="fa fa-question-circle margin-right-5"></i> <span>Eliminar Agente</strong></h4>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro que desea eliminar la Agente: '<span id="name"></span>' del sistema?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-flat pull-left" data-dismiss="modal"><strong>No, cancelar</strong></button>
                    <?php echo form_open(site_url('proveedor/del'), array('id' => 'form')); ?>
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
                <form id="form-editar" method="POST">
                    <div class="modal-body">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Id proveedor</label>
                                <input type="text" name="id_proveedor_edit" id="id_proveedor_edit" class="form-control" readonly="true">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">RUT</label>
                                <input type="text" name="rut_edit" id="rut_edit" class="form-control" readonly="true">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" id="nombre" autocomplete="off" class="form-control">
                            </div>    
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name='estado_edit' id='estado_edit' class="form-control">
                                        <option value='INACTIVO'>INACTIVO</option>
                                        <option value='ACTIVO'>ACTIVO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Fecha creacion [pre-factura]</label>
                                <input type="text" name="fecha_creacion_edit" id="fecha_creacion_edit" class="form-control" readonly="true">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Organizaciones</label>
                                <select id='organizaciones_edit' name='organizaciones_edit' multiple class="form-control selectpicker" data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                                </select>
                            </div>
                        </div>
                         <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Servicios</label>
                                <select id='servicios_edit' name='servicios_edit' multiple class="form-control selectpicker" data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button id="btn_add" type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
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
        row = table.row( $(this).parents('tr') );
        var data = row.data();
        id = data[0];
        $('#name').text(data[1]);
        $('#confirmation_modal').modal('toggle');
    });

    $('.table tbody tr td .btn-primary').click(function(event){
        event.preventDefault();
        var tr   = $(this).closest('tr');
        row      = table.row(tr);
        var data = row.data();
        $('#nombre').val(data[1]);
        $('#id_proveedor_edit').val(data[0]);
        $('#rut_edit').val(data[2]);
        $('#estado_edit').val(data[3]);
        $('#fecha_creacion_edit').val(data[4]);
        $('#name').text(data[1]);
        cargar_select_org(data[0]);
        cargar_select_servicios(data[0]);
        $('input[name=id]').val(data[0]);
        $('#modal-default').modal('toggle');
    });

    $('#form').submit(function(event) {
        event.preventDefault();
        var btn = $(this).find('button');
        btn.prop('disabled', true);
        $.post($(this).attr('action'), {id : id}, function(data) {
            if (data.estado) {
                pf_notify('Agente', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
            }else{
                pf_notify('Agente', 'Ups!, Error al eliminar' , 'danger' ,'fa fa-close');
            }
        }).always(function() {
            btn.prop('disabled', false);
            row.remove().draw();
            $('#confirmation_modal').modal('toggle');
        });
    });

    $('body').on('click','#btn_add',function(e){
            e.preventDefault();
            $('#btn_add').prop('disabled', true);
            var formulario              = new FormData(document.getElementById("form-editar"));
            var organizaciones          = $('#organizaciones_edit').val();
            var servicios_edit          = $('#servicios_edit').val();
            formulario.append('organizaciones_edit'      , organizaciones);
            formulario.append('servicios_edit'           , servicios_edit);
            $.ajax({
                url: '<?php print site_url()?>/proveedor/upd',
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
                    $('#modal-default').modal('hide');
                    setTimeout(function(){  location.reload(); }, 1000 );
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


</script>

<script type="text/javascript">
    var arreglo_organizaciones = [];
    var arreglo_servicios = [];
    $(function(){
        $.post("<?php echo site_url('usuario/get_organizaciones')?>", {'':''} , function(data) {
            arreglo_organizaciones = data.organizaciones;
        },'json');
         $.post("<?php echo site_url('servicio/get_servicios')?>", {'':''} , function(data) {
            arreglo_servicios = data.servicios;
        },'json');

    })

  function cargar_select_org(id_proveedor){
        $('#organizaciones_edit').empty();
        $.post("<?php echo site_url('proveedor/get_organizaciones_prov')?>", {id_proveedor : id_proveedor} , function(data) {
            $.each(arreglo_organizaciones, function(index, val) {
                var validador = false;
                $.each( data.organizaciones , function(index, el) {
                    if(val.ID == el.ORGANIZATION_ID){
                        validador = true;
                    }
                });
                if (validador) {
                    $('#organizaciones_edit').append('<option selected value="'+val.ID+'" >'+val.ORGANIZACION+'</option>');
                }else{
                    $('#organizaciones_edit').append('<option value="'+val.ID+'" >'+val.ORGANIZACION+'</option>');
                }
            });
            $('.selectpicker').selectpicker('refresh');
        },'json');
    }

    function cargar_select_servicios(id_proveedor){
        $('#servicios_edit').empty();
        $.post("<?php echo site_url('proveedor/get_servicios_proveedor')?>", {id_proveedor : id_proveedor} , function(data) {
            $.each(arreglo_servicios, function(index, val) {
                var validador = false;
                $.each( data.servicios , function(index, el) {
                    if(val.ID == el.ID){
                        validador = true;
                    }
                });
                if (validador) {
                    $('#servicios_edit').append('<option selected value="'+val.ID+'" >'+val.NOMBRE+'</option>');
                }else{
                    $('#servicios_edit').append('<option value="'+val.ID+'" >'+val.NOMBRE+'</option>');
                }
            });
            $('.selectpicker').selectpicker('refresh');
        },'json');
    }


</script>