<section class="content-header">
    <h1>
        Apertura de mes
        <small><b>Registrar</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Apertura mensual</li>
        <li class="active">Registrar</li>
    </ol>
</section> 

<section class="content">     
    <div class="box box-primary">
        <form id="form" action="<?php echo site_url('apertura/add')?>" method="get" accept-charset="utf-8">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Apertura</h3>
        </div>
        <div class="box-body">
            <div class="col-sm-6"> 
                <div class="form-group">
                    <label>Periodo</label>
                    <div class="input-group ">
                        <input id='fecha' name='fecha' type="text" class="date form-control"  value="<?php echo date('m/Y');?>">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Valor UF</label>
                    <input type="text" id="valor_uf" name="valor_uf" class="form-control" maxlength="11" onkeypress="return isNumber(event)">
                </div>
            </div>
            

        </div>
        <div class="box-footer">
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-left"><strong>Volver</strong></a>
            <button type="submit" class="btn btn-primary btn-flat pull-right"><strong>Registrar</strong></button>
        </div>
        
    </form>
</div>
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
                            <th>Mes</th>
                            <th>Estado</th>
                            <th>Valor UF</th>
                            <!-- <th width="50px" class="no-sort text-center">Editar</th> -->
                            <th width="50px" class="no-sort text-center">Cerrar</th>
                            <th width="100px" class="no-sort text-center">Valor UF</th>
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $value): ?>
                                <tr>
                                    <td><?php echo $value->MES; ?>      </td>
                                    <td><?php echo $value->ESTADO; ?>   </td>
                                    <td><?php echo '$ '.$value->VALOR_UF; ?>   </td>
                                    <!-- <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-primary btn-flat btn-xs" data-id="<?php echo $value->ID;?>"><i class="fa fa-pencil"></i></a></td> -->
                                    <td class="text-center">
                                        <?php if ($value->ESTADO == 'ABIERTO' ): ?>
                                            <a data-toggle="tooltip" data-id="<?php echo $value->ID;?>" data-placement="top" title="Cierre" class="btn btn-warning btn-flat btn-xs" href="#"><i class="fa fa-close"></i></a>    
                                        <?php endif ?>
                                    </td>
                                    <td  class="text-center">
                                        <?php if ($value->ESTADO == 'ABIERTO' ): ?>
                                            <button type="button" data-periodo="<?php echo $value->MES; ?>" data-valoruf="<?php echo $value->VALOR_UF?>" id="bt_edit" class="btn btn btn-success btn-flat btn-xs bt_edit"> <i class="fa fa-dollar"></i></button>
                                        <?php endif ?>
                                    </td>
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

<div class="modal  fade" id="confirmation_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">??</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-question-circle margin-right-5"></i> <span>Cierre de mes</strong></h4>
                </div>
                <div class="modal-body">
                    <p>??Esta seguro que desea cerrar : '<span id="name"></span>' del sistema?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  pull-left" data-dismiss="modal"><strong>No, cancelar</strong></button>
                    <form  id="form_cierre" action="<?php echo site_url('apertura/cierre')?>" method="get" accept-charset="utf-8">
                        <button type="submit" class="btn btn-danger pull-right"><strong>Si, cerrar</strong></button>    
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal  fade" id="modal_edit" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="form_edit" action="<?php echo site_url('apertura/edit')?>" method="get" accept-charset="utf-8">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">??</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-question-circle margin-right-5"></i> <span>Modificar valor de UF</strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Periodo</label>
                                    <input type="text" id="periodo_edit" name="periodo_edit" class="form-control" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Valor UF</label>
                                    <input type="text" id="valor_uf_edit" name="valor_uf_edit" class="form-control" maxlength="11" onkeypress="return isNumber(event)">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn  pull-left" data-dismiss="modal"><strong>cancelar</strong></button>

                            <button type="button" id="bt_guardar_edit" class="btn btn-success pull-right"><strong>Guardar</strong></button>    

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            var table, row, id;

            jQuery(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip(); 

                $('body').on('click','.bt_edit',function(){
                    var periodo  = $(this).data('periodo');
                    var valor_ud = $(this).data('valoruf');
                    $('#periodo_edit').val(periodo);
                    $('#valor_uf_edit').val(valor_ud);
                    $('#modal_edit').modal('toggle');
                });

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
                        "sEmptyTable":     "Ning??n dato disponible en esta tabla",
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
                            "sLast":     "??ltimo",
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

            $('.table tbody tr td .btn-warning').click(function(event){

        // row = table.row( $(this).parents('tr') );
        id = $(this).data('id');
        $('#name').text(id);
        $('#confirmation_modal').modal('toggle');
    });



            $('#form_cierre').submit(function(event) {
                event.preventDefault();
                var btn = $(this).find('button');
                btn.prop('disabled', true);
                $.post($(this).attr('action'), {id : id}, function(data) {
                    if (data.estado) {
                        pf_notify('Eliminaci??n', 'Operaci??n realizada correctamente' , 'success' ,'fa fa-commenting-o');
                        setTimeout(function(){  location.reload(); }, 1000 );
                    }else{
                        pf_notify('Eliminaci??n', 'Ups!, Error al eliminar' , 'danger' ,'fa fa-close');
                    }
                }).always(function() {
                    btn.prop('disabled', false);
                // row.remove().draw();
                $('#confirmation_modal').modal('toggle');
            });
            });




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


        <script>
            jQuery(document).ready(function() {

                $('.date').datepicker({
                    autoclose: true,
                    format: "mm/yyyy",
                    language: "es",
                    todayHighlight: true,
            // startDate: "today",
            viewMode: "months", 
            minViewMode: "months"
        });

                var btn = $('button');
                $('#form').submit(function(event) {
                    event.preventDefault();
                    btn.prop('disabled', true);
                    $.post($(this).attr('action'), $(this).serialize(), function(data) {
                        if (data.estado) {
                            $('#form')[0].reset();
                            $('div.form-group').removeClass('has-success').removeClass('has-error')
                            .find('.text-danger').remove();
                            pf_notify('Creaci??n', 'Operaci??n realizada correctamente' , 'success' ,'fa fa-commenting-o');
                            setTimeout(function(){  location.reload(); }, 1000 );
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
                                    pf_notify('Error', value, 'danger' ,'fa fa-ban');
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



        <script type="text/javascript">
            $(function(){


                $('body').on('click','#bt_guardar_edit',function(e){
                    e.preventDefault();
                    $('#bt_guardar_edit').prop('disabled', true);
                    $.post( "<?php echo site_url('apertura/edit')?>", $('#form_edit').serialize(), function(data) {
                        if (data.estado) {
                            $('#form')[0].reset();
                            $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
                            pf_notify('Creaci??n', 'Operaci??n realizada correctamente' , 'success' ,'fa fa-commenting-o');
                            setTimeout(function(){  location.reload(); }, 1000 );
                            $('#modal_edit').modal('hide');
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
                                    pf_notify('Error', value, 'danger' ,'fa fa-ban');
                                }
                            });
                        }
                    })
                    .always(function() {
                        $('#bt_guardar_edit').prop('disabled', false);
                        $('#modal_edit').modal('hide');
                    });

                });

                
            })
        </script>