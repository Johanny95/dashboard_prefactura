<section class="content-header">
    <h1>
        Aprobación Solicitudes de cambio
        <small><b>Listado</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Aprobación</li>
        <li class="active">Todas</li>
    </ol>
</section>

<section class="content">   
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> Listado de solicitudes</h3>
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
                        <thead class="bg-navy">
                            <th>Id Solcitud</th>
                            <th>Concepto</th>
                            <th>Servicio</th>
                            <th>Proveedor</th>
                            <th>Estado Solicitud</th>
                            <th>Cuenta Contable</th>
                            <th>F. Creación</th>
                            <th width="50px" class="no-sort text-center">Aprobar</th>
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $value):?>
                                <tr>
                                    <td><?php echo $value->ID_SOLICITUD;?></td>
                                    <td><?php echo ucwords(mb_strtolower($value->NOMBRE_CONCEPTO));?></td>
                                    <td><?php echo $value->NOMBRE_SERVICIO;?></td>
                                    <td><?php echo $value->RUT_PROVEEDOR.' | '.$value->RAZON_SOCIAL;?></td>
                                    <td><?php echo $value->ESTADO_SOLICITUD;?></td>
                                    <td><?php echo $value->CUENTA_CONTABLE;?></td>
                                    <td><?php echo $value->FECHA_CREACION_SOLICITUD;?></td>
                                    <td class="text-center">
                                        <a  data-concepto   ="<?php  echo $value->NOMBRE_CONCEPTO?>" 
                                            data-medida1    ="<?php  echo $value->MEDIDA1?>" 
                                            data-precio1    ="<?php  echo $value->PRECIO1?>" 
                                            data-medida2    ="<?php  echo $value->MEDIDA2?>" 
                                            data-precio2    ="<?php  echo $value->PRECIO2?>" 
                                            data-medida3    ="<?php  echo $value->MEDIDA3?>" 
                                            data-precio3    ="<?php  echo $value->PRECIO3?>"
                                            data-medida1new    ="<?php  echo $value->MEDIDA1_CAMBIO?>" 
                                            data-precio1new    ="<?php  echo $value->PRECIO1_CAMBIO?>" 
                                            data-medida2new    ="<?php  echo $value->MEDIDA2_CAMBIO?>" 
                                            data-precio2new    ="<?php  echo $value->PRECIO2_CAMBIO?>" 
                                            data-medida3new    ="<?php  echo $value->MEDIDA3_CAMBIO?>" 
                                            data-precio3new    ="<?php  echo $value->PRECIO3_CAMBIO?>"
                                            data-concepto   ="<?php  echo $value->ID_CONCEPTO?>" 
                                            data-idprecio   = "<?php  echo $value->ID_PRECIO?>" 
                                            data-id         ="<?php  echo $value->ID_SOLICITUD?>" 
                                            data-cta        ="<?php  echo $value->CUENTA_CONTABLE?>"
                                            data-ctanew        ="<?php  echo $value->CTA_CONTABLE?>"
                                            data-fecha_desde="<?php  echo $value->FECHA_DESDE_SOLICITUD?>"
                                            data-documento="<?php  echo $value->DOCUMENTO?>"
                                            data-documentonew="<?php  echo $value->DOCUMENTO_CAMBIO?>"
                                            data-toggle="tooltip" data-placement="top" title="Editar precios" class="btn btn_accion btn-flat btn-sm bg-navy" >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>

                                    <!-- <td class="text-center"><a data-toggle="tooltip" data-placement="top" title="Eliminar Agente" class="btn btn-danger btn-flat btn-xs" href="#"><i class="fa fa-trash"></i></a></td> -->
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


<div class="modal fade in" id="modal_precios">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Aprobacion de cambio</h4>
            </div>

            <div class="modal-body">
                <form id="form_editar_precio" method="POST">

                   <div class="col-sm-6">
                    <div class="form-group">
                        <label>Concepto</label>
                        <input type="text" name="nombre_concepto" id="nombre_concepto" class="form-control" readonly="true">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fecha desde</label>
                        <div class="input-group date">
                            <input id='fecha_desde' name='fecha_desde' type="text" class="form-control"  readonly="true" value="<?php echo date('d/m/Y');?>">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="img-thumbnail">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Cuenta Contable</label>
                            <input type="text"  id='cta_contable' name="cta_contable" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Documento</label>
                            <button type="button" class="btn btn-info btn-block file"><i class="fa fa-file-o"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-12 hide div_file">
                        <div class="embed-responsive embed-responsive-16by9"><iframe id="file" class="embed-responsive-item" ></iframe></div>
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

                </div>

                <div class="img-thumbnail">
                    <div class="col-sm-12">
                        <h4>Nuevo</h4>    
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Cuenta Contable</label>
                            <input type="text"  id='cta_contable_new' name="cta_contable_new" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Documento</label>
                            <button type="button" class="btn btn-info btn-block file_new"><i class="fa fa-file-o"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-12 hide div_file_new">
                        <div class="embed-responsive embed-responsive-16by9"><iframe id="file_new" class="embed-responsive-item" ></iframe></div>
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 1</label>
                            <select name="medida1_new" id="medida1_new" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Precio 1</label>
                            <input type="text" name="precio1_new" id="precio1_new" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>    
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 2</label>
                            <select name="medida2_new" id="medida2_new" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Precio 2</label>
                            <input type="text" name="precio2_new" id="precio2_new" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-group">
                            <label>Tipo medida 3</label>
                            <select name="medida3_new" id="medida3_new" class="form-control select2" style="width: 100%">
                                <option value="" selected="true">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group"> 
                            <label>Precio 3</label>
                            <input type="text" name="precio3_new" id="precio3_new" class="form-control medida" onkeypress="return isNumber(event)">
                        </div>    
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <div class="col-sm-12">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button id="btn_aprobar" type="button" class="btn btn-primary pull-right">Aprobar</button>
                <button id="btn_rechazar" type="button" class="btn btn-danger pull-right">Rechazar</button>
            </div>

        </div>

    </div>
</div>
</div>




<div class="modal fade in" id="modal_confirmacion_aprob">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirmación aprobación</h4>
            </div>

            <div class="modal-body">
                <h4>Esta apunto de aprobar un cambio de precios o medidas, ¿Desea continuar?</h4>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn_confirmacion_aprob" type="button" class="btn btn-primary pull-right">Guardar</button>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade in" id="modal_rechazo_aprob">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirmación aprobación</h4>
            </div>

            <div class="modal-body">
                <h4>Esta apunto de rechazar un cambio de precios o medidas, ¿Desea continuar?</h4>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn_rechazo_aprobacion" type="button" class="btn btn-danger pull-right">Rechazar</button>
                </div>

            </div>

        </div>
    </div>
</div>


<script>
    var table, row, id , id_concepto, id_precio;
    var medida1, precio1, medida2, precio2, medida3, precio3 , cta;


    jQuery(document).ready(function() {

        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            language : 'es'
        });

        $('body').on('click','#btn_aprobar',function(){
            $('#modal_confirmacion_aprob').modal('show');
        });
        $('body').on('click','#btn_rechazar',function(){
            $('#modal_rechazo_aprob').modal('show');
        });

        $('body').on('click','#btn_confirmacion_aprob',function(){

            $.ajax({
                url: "<?php echo site_url('solicitud/aprobar')?>",
                type: 'POST',
                dataType: 'json',
                data: {'id': id,'id_precio':id_precio},
            }).done(function(data) {
                if (data.estado) {
                    pf_notify('Concepto', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                    $('.modal').modal('hide');
                     setTimeout(function(){  location.reload(); }, 1200 );
                }else{
                    pf_notify('Solicitud', 'ups, Ocurrio un error, contactarse con Informática' , 'danger' ,'fa fa-ban');
                }
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        });

        $('body').on('click','#btn_rechazo_aprobacion',function(){

            $.ajax({
                url: "<?php echo site_url('solicitud/rechazar')?>",
                type: 'POST',
                dataType: 'json',
                data: {'id': id,'id_precio':id_precio},
            }).done(function(data) {
                if (data.estado) {
                    pf_notify('Concepto', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                    $('.modal').modal('hide');
                    setTimeout(function(){  location.reload(); }, 1200 );
                }else{
                    pf_notify('Solicitud', 'ups, Ocurrio un error, contactarse con Informática' , 'danger' ,'fa fa-ban');
                }
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        });
        
        

        var estado_file = true;
        $("body").on('click','.file',function(){
            if (estado_file){
                $('.div_file').removeClass('hide').addClass('show');
                estado_file = false;
            }else{
                $('.div_file').removeClass('show').addClass('hide');
                estado_file = true;
            }
        });
        var estado_file_new = true;
        $("body").on('click','.file_new',function(){
            if (estado_file_new){
                $('.div_file_new').removeClass('hide').addClass('show');
                estado_file_new = false;
            }else{
                $('.div_file_new').removeClass('show').addClass('hide');
                estado_file_new = true;
            }
        });

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


    $('.table tbody tr td .btn_accion').click(function(event){
        event.preventDefault();
        var fecha_desde = $(this).data('fecha_desde');
        medida1 = $(this).data('medida1');
        precio1 = $(this).data('precio1');
        medida2 = $(this).data('medida2');
        precio2 = $(this).data('precio2');
        medida3 = $(this).data('medida3');
        precio3 = $(this).data('precio3');
        cta = $(this).data('cta');
        var medida1_new = $(this).data('medida1new');
        var precio1_new = $(this).data('precio1new');
        var medida2_new = $(this).data('medida2new');
        var precio2_new = $(this).data('precio2new');
        var medida3_new = $(this).data('medida3new');
        var precio3_new = $(this).data('precio3new');
        var cta_new     = $(this).data('ctanew');
        var documento     = $(this).data('documento');
        var documento_new = $(this).data('documentonew');
        
        $('#nombre_concepto').val( $(this).data('concepto') );
        $('#medida1').val(medida1).prop('disabled', true);
        $('#precio1').val(precio1).prop('disabled', true);
        $('#medida2').val(medida2).prop('disabled', true);
        $('#precio2').val(precio2).prop('disabled', true);
        $('#medida3').val(medida3).prop('disabled', true);
        $('#precio3').val(precio3).prop('disabled', true);
        $('#fecha_desde').val(fecha_desde).prop('disabled', true);
        $('#cta_contable').val(cta).prop('disabled', true);
        $("#file").attr("src", "<?php echo base_url()?>"+documento);
        $('#medida1_new').val(medida1_new).prop('disabled', true);
        $('#precio1_new').val(precio1_new).prop('disabled', true);
        $('#medida2_new').val(medida2_new).prop('disabled', true);
        $('#precio2_new').val(precio2_new).prop('disabled', true);
        $('#medida3_new').val(medida3_new).prop('disabled', true);
        $('#precio3_new').val(precio3_new).prop('disabled', true);
        $('#cta_contable_new').val(cta_new).prop('disabled', true);
        $("#file_new").attr("src", "<?php echo base_url()?>"+documento_new);
        
        id = $(this).data('id');
        id_precio = $(this).data('idprecio');
        $('#modal_precios').modal('toggle');
    });




</script>

<script type="text/javascript">
    var arreglo_organizaciones = [];
    var arreglo_servicios = [];
    $(function(){

        cargar_select('#medida1','concepto/get_medidas');
        cargar_select('#medida2','concepto/get_medidas');
        cargar_select('#medida3','concepto/get_medidas');
        cargar_select('#medida1_new','concepto/get_medidas');
        cargar_select('#medida2_new','concepto/get_medidas');
        cargar_select('#medida3_new','concepto/get_medidas');
        cargar_select('#cta_contable','concepto/get_cuentas_contables');

        

    });

    function cargar_select(id_elemento, url ){
        var texto = "";
        $.post("<?php echo site_url('"+url+"')?>", {autocompletar : texto} , function(data) {
            $(id_elemento).empty();
            $.each(data, function(index, val) {
                var validador = false;
                $(id_elemento).append('<option value="'+val.id+'" >'+val.nombre+'</option>');
            });
        },'json');
         // $(id_elemento).select2();
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