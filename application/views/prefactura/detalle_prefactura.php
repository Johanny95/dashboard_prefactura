<?php foreach ($prefactura as $key => $value) {
    $cabecera = $value;
}?>


<section class="content-header">
    <h1>
        Detalle
        <xsall><b>Pre-Factura</b></xsall>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Detalle</li>
        <li class="active">Pre-Factura</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Detalle Pre-Factura</h3>
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-right"><strong>Volver</strong></a>
        </div>
        <div class="box-body">
            <div class="col-xs-3">
                <div class="form-group">
                    <label>ID evento</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $cabecera->ID_PREFACTURA;?>">
                </div>    
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Numero de guia</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $cabecera->ESTADO ;?>">
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group">
                    <label>Periodo</label>
                    <div class="input-group date">
                        <input id="periodo" type="text" class="form-control"  readonly="true" value="<?php echo $cabecera->PERIODO;?>">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>  
                    </div>
                </div>
            </div>
          
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Solicitante</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $cabecera->SOLICITANTE ;?>">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Fecha Creacion</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $cabecera->FECHA_CREACION ;?>">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Fecha Aprobación</label>
                    <input class="form-control" readonly="true" type="text" value="<?php echo $cabecera->FECHA_APROBACION ?>">
                </div>
            </div>
        
            

        </div>
        <div class="box-footer">
            
           <div class=" table-responsive no-left-right-margin">
                <div class="col-xs-12"> 
                    <table id="table" class="table table-bordered table-hover" style="width: 100%">
                        <thead class="bg-navy">
                            <th>Tipo</th>
                            <th>Organizacion</th>
                            <th>Proveedor</th>
                            <th>Servicio</th>
                            <th>Concepto</th>
                            <th>Medida</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total prefactura</th>
                            </thead>
                            <tbody>
                                    <?php foreach ($detalle as $key => $el): ?>
                                        <tr >
                                            <td> <?php echo $el->TIPO ?></td>
                                            <td> <?php echo $el->ORGANIZACION ?> </td>
                                            <td> <?php echo $el->RUT_PROVEEDOR.' | '.$el->RAZON_SOCIAL ?> </td>
                                            <td> <?php echo $el->SERVICIO ?> </td>
                                            <td> <?php echo $el->CONCEPTO ?> </td>
                                            <td> <?php echo $el->MEDIDA1 ?> </td>
                                            <td> <?php echo $el->PRECIO1 ?> </td>
                                            <td> <?php echo $el->CANTIDAD1 ?> </td>
                                            <td> <?php echo round($el->TOTAL1) ?> </td>
                                        </tr>
                
                                    <?php endforeach ?>
                            </tbody>
                            <tfoot class="bg-navy">
                                <tr>
                                    <th colspan="8">Total prefactura</th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div> 

                <?php if ( $cabecera->ESTADO  ==  'APROBADO' ) :?>
                <div class="container-fluid">
                    <h4> Detalle de orden de compra </h4>
                </div>
                <div class=" table-responsive no-left-right-margin">
                <div class="col-xs-12"> 
                    <table id="tabla_oc" class="table table-bordered table-hover" style="width: 100%">
                        <thead class="bg-navy">
                            <th>Código orden compra</th>
                            <th>Estado</th>
                            <th>Proveedor</th>
                            </thead>
                            <tbody>
                                    <?php foreach ($detalle_oc as $key => $el): ?>
                                        <tr >
                                            <td> <?php echo $el->NUMERO_OC ?></td>
                                            <td> <?php echo $el->ESTADO_APROBACION ?> </td>

                                            <td> <?php echo $el->RUT_PROVEEDOR.' | '.$el->RAZON_SOCIAL ?> </td>
                                            
                                        </tr>
                
                                    <?php endforeach ?>
                            </tbody>
                            <tfoot>
                            </tfoot>

                        </table>
                    </div>
                </div> 
                <?php endif ?>

            <div class="container-fluid row">

                <?php if ( $cabecera->ESTADO  ==  'INGRESADO' ) :?>
                    <div class="col-sm-6">
                        <button id="bt_rechazar" type="button" data-id="<?php echo $cabecera->ID_PREFACTURA ?>" class="btn btn-block btn-danger"><i class="fa fa-ban"></i> Rechazar</button>
                    </div>
                      <div class="col-sm-6">
                        <button id="bt_aprobar" type="button" data-id="<?php echo $cabecera->ID_PREFACTURA ?>" class="btn btn-block btn-success"><i class="fa fa-check"></i> Aprobar</button>
                    </div>
                                    
                <?php endif ?>

            </div>

        </div>
    </div>


    <div class="modal fade in" id="modal_aprobacion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirmación de aporbacion Pre-Factura</h4>
                </div>

                <div class="modal-body">
                    <h4>Esta apunto de aprobar una prefactura, esto genera ordenes de compra automaticas para los proveedores contenidos en este informe, ¿Desea continuar?</h4>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button id="btn_confirmacion" type="button" class="btn btn-primary pull-right">Aceptar</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade in" id="modal_rechazo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirmación de rechazo Pre-Factura</h4>
                </div>

                <div class="modal-body">
                    <h4>Esta apunto de rechazar la prefactura, ¿Desea continuar?</h4>
                    <p>Los registros de eventos volveran al estado de registrados y quedaran disponibles para la ejecución de otro informe de pre-factua.</p>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button id="btn_rechazar" type="button" class="btn btn-primary pull-right">Aceptar</button>
                    </div>

                </div>

            </div>
        </div>
    </div>


  




</section>

<script type="text/javascript">
    var table, id;
    $(function(){
            
        $('#bt_rechazar').on('click',function(){
            id =  $(this).data('id');
            $('#modal_rechazo').modal('show');
        });

        $('#bt_aprobar').on('click',function(){
            id =  $(this).data('id');
            $('#modal_aprobacion').modal('show');
        });

         $('#btn_rechazar').on('click',function(){
            var periodo = $('#periodo').val();
            $.ajax({
                url: '<?php echo site_url("prefactura/rechazar")?>',
                type: 'POST',
                dataType: 'json',
                data: {'id_prefactura': id , 'periodo' : periodo},
            })
            .done(function(data) {
                if (data.estado) {
                    $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
                    pf_notify('Creación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                    $('#modal_rechazo').modal('hide');
                     window.history.back();
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
                        $('#modal_rechazo').modal('hide');
                    }else{
                        pf_notify('Concepto', data.mensaje.validacion , 'danger' ,'fa fa-ban');
                    }
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
                
        });



        $('#btn_confirmacion').on('click',function(){
            var periodo = $('#periodo').val();
            $.ajax({
                url: '<?php echo site_url("prefactura/aprobar")?>',
                type: 'POST',
                dataType: 'json',
                data: {'id_prefactura': id , 'periodo' : periodo},
            })
            .done(function(data) {
                if (data.estado) {
                    $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
                    pf_notify('Creación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                    $('#modal_rechazo').modal('hide');
                     window.history.back();
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
                        $('#modal_rechazo').modal('hide');
                    }else{
                        pf_notify('Concepto', data.mensaje.validacion , 'danger' ,'fa fa-ban');
                    }
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
                
        });


        table = $('#table').DataTable({
                // "ajax": {
                //     "url": "<?php echo site_url()?>",
                //     'type': 'POST',
                //     "dataSrc":"",
                //     "data": function ( d ) {
                //         d.periodo              = $("#fecha").val(),
                //         d.organizaciones       = $("#organizacion").val(),
                //         d.proveedores          = $("#proveedores").val(),
                //         d.servicios            = $("#servicios").val()
                //     }
                // },
                // "columns":[
                // {data : "tipo"          ,"className": "text-center" },
                // {data : "organizacion"  ,"className": "text-center" },
                // {data : "proveedor"     ,"className": "text-left"   },
                // {data : "servicio"      ,"className": "text-left"   },
                // {data : "concepto"      ,"className": "text-left"   },
                // {data : "medida1"       ,"className": "text-left"   },
                // {data : "precio1"       ,"className": "text-right" , "render": $.fn.dataTable.render.number( '.', ',', 0 ,'$ ' )  },
                // {data : "cantidad1"     ,"className": "text-right"   },
                // {data : "total1"        ,"className": "text-right"  ,"render": $.fn.dataTable.render.number( '.', ',', 0 )  }
                // ],
               "columnDefs": [
                    { "className": "text-right" , targets:[6,7,8]},
                    {"render": $.fn.dataTable.render.number( '.', ',', 0 ) , targets:[6,7,8] } 
                ],
                "footerCallback": function ( row, data, start, end, display ) {

                    var api = this.api(), data;
                    var $i = 0;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };
                    suma = api
                    .column( 8 , { page: 'current'} ).data().reduce( function (a, b) {
                        $i ++;
                        console.log('A.'+a.toString().replace('%',''));
                        console.log('B.'+b.toString().replace('%',''));
                        return intVal(a.toString().replace('%','')) + intVal(b.toString().replace('%',''));
                    }, 0 );
                    //console.log(suma);

                    $( api.column(8).footer()).html( '<p class="pull-left">$</p> '+ number_punto(suma) );

                    if(data.length == 0 ){
                        $('#div_guardar').removeClass('show').addClass('hide');
                    }else{
                        $('#div_guardar').removeClass('hide').addClass('show');
                    }

                },  
                "paging": false,
                "rowsGroup" : [0,1,2,3,4,5],
                "iDisplayLength": -1,
                "order": [[ 0, "desc" ]],
                "info": false,
                "autoWidth": true, 
                "bPaginate":false,
                "sPaginationType":"full_numbers",
                "bLengthChange": false,
                "bInfo" : false,
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
               }
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
            

   });

    function number_punto(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}








</script>


