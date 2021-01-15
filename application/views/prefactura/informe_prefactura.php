<section class="content-header">
    <h1>
        Informe prefactura
        <small><b>Listado</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Informe prefactura</li>
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
                <!-- <div id="top-left" class="col-xs-3">
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
                </div> -->
              <!--   <div class="col-xs-3 top-right">
                    <div class="form-group margin-btm-5">
                        <label>Buscar</label>
                        <input id="search_input" class="form-control">
                    </div>
                </div> -->
        <form id="form">
           <div class="col-xs-2">
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
                <div class="col-xs-2">
                    <div class="form-group">
                        <label>Valor Uf</label>
                        <input type="text" class="form-control" id="valor_uf" readonly="true" >
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-group">
                        <label for="">Organizaciones</label>
                        <select id='organizacion' name='organizacion' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                        </select>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-group">
                        <label for="">Proveedores</label>
                        <select id='proveedores' name='proveedores' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                        </select>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-group">
                        <label for="">Servicios</label>
                        <select id='servicios' name='servicios' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                        </select>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-group">
                        <label>Buscar</label>
                        <button id="bt_buscar" type="button" class="btn btn-block btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            </div>

        </div>
        <div class="box-body hide" id="box_body">
            <div class="row table-responsive no-left-right-margin">
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
                            <th>total</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot class="bg-navy">
                                <tr>
                                    <th colspan="8">Total</th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <p id="footer-left" class="col-sm-6 footer-dt"></p>
                    <div  id="div_guardar" class="col-sm-4 pull-right hide" > 
                        <button id="btn_ejecutar" type="button" class="btn btn-success btn-block"> <i class="fa fa-arrow-circle-right"></i>  Ejecutar Pre-Factura</button> 
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade in" id="modal_confirmacion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Confirmación de registro Pre-Factura</h4>
                </div>

                <div class="modal-body">
                    <h4>Esta apunto de crear una solicitud de informe de pre-factura, ¿Desea continuar?</h4>
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


    <script type="text/javascript">

        function cargar_valor_uf(periodo){
            $.post("<?php echo site_url('apertura/get_apertura_mes') ?>", {'periodo': periodo}, function(data, textStatus, xhr) {
                 $('#valor_uf').val( data.periodo[0].VALOR_UF );
                console.log( data.periodo[0].VALOR_UF );
            },'json');

        }

        $(function(){
            var usuid = <?php echo $this->session->usuid?>;
            cargar_select_org(usuid);

            cargar_select_proveedor();

            cargar_select_servicios();
            cargar_valor_uf($('#fecha').val());

            $('#bt_buscar').on('click',function(){
                $('#box_body').removeClass('hide').addClass('show');
                // $('#div_guardar').removeClass('hide').addClass('show');
                table.ajax.reload();
            });

            $('body').on('change','#organizacion',function(){
                // $('#box_body').removeClass('show').addClass('hide');
                $('#div_guardar').removeClass('show').addClass('hide');
                cargar_select_proveedor();
            });

            $('body').on('change','#proveedores',function(){
                // $('#box_body').removeClass('show').addClass('hide');
                $('#div_guardar').removeClass('show').addClass('hide');
                cargar_select_servicios();
            });

            $('body').on('change','#fecha',function(){
                // $('#box_body').removeClass('show').addClass('hide');
                $('#div_guardar').removeClass('show').addClass('hide');
                cargar_valor_uf($('#fecha').val());
            });

            $('body').on('change','#servicios',function(){
                // $('#box_body').removeClass('show').addClass('hide');
                $('#div_guardar').removeClass('show').addClass('hide');
            });

            $('#btn_ejecutar').on('click',function(){
                $('#modal_confirmacion').modal('show');
            });

            $('#btn_confirmacion').on('click',function(){
                var periodo         = $('#fecha').val();
                var organizaciones  = $('#organizacion').val();
                var proveedores     = $('#proveedores').val();
                var servicios       = $('#servicios').val();

                crear_prefactura(periodo, organizaciones, proveedores, servicios);


            });


            $('.date').datepicker({
                autoclose: true,
                format: "mm/yyyy",
                language: "es",
                todayHighlight: true,
                viewMode: "months", 
                minViewMode: "months"
            });

            var id_ajuste;
            $('body').on('click','.bt_eliminar',function(){
                id_juste = $(this).data('id');
                $('#modal_eliminacion').modal('show');
            });

            $('body').on('click','#bt_del_ajuste',function(){
                $.post("<?php echo site_url('ajustes/del')?>", {'id_ajuste' : id_juste} , function(data) {    
                    if (data.estado) {
                        pf_notify('Concepto', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                        $('.modal').modal('hide');
                        table.ajax.reload();
                    }else{
                        pf_notify('Solicitud', 'ups, Ocurrio un error, contactarse con Informática' , 'danger' ,'fa fa-ban');
                    }
                },'json');
            })

        });

        function cargar_select_org(usuid){
            $('#organizacion').empty();
            $.post("<?php echo site_url('usuario/get_usuorg')?>", {usuid : usuid} , function(data) {
                $.each( data.organizaciones_usuario , function(index, el) {
                 $('#organizacion').append('<option value="'+el.ORGANIZATION_ID+'" >'+el.ORGANIZACION+'</option>');
             });
                $('.selectpicker').selectpicker('refresh');
            },'json');
        }

        function cargar_select_proveedor(){
            var org = $('#organizacion').val();
            $('#proveedores').empty();
            $.post("<?php echo site_url('prefactura/get_proveedores_orgs')?>", {organizaciones : org} , function(data) {
                $.each( data , function(index, el) {
                 $('#proveedores').append('<option value="'+el.ID_PROVEEDOR+'" >'+el.RUT_PROVEEDOR+' | '+el.NOMBRE+'</option>');
             });
                $('.selectpicker').selectpicker('refresh');
            },'json');
        }

        function cargar_select_servicios(){
            var proveedor = $('#proveedores').val();
            console.log(proveedor);
            $('#servicios').empty();
            $.post("<?php echo site_url('prefactura/get_servicios_proveedor')?>", {proveedores : proveedor} , function(data) {
                $.each( data , function(index, el) {
                 $('#servicios').append('<option value="'+el.ID_SERVICIO+'" >'+el.NOMBRE+'</option>');
             });
                $('.selectpicker').selectpicker('refresh');
            },'json');
        }

    </script>

    <script>
        var table, id;

        jQuery(document).ready(function() {



            $('[data-toggle="tooltip"]').tooltip(); 

            $('#table tbody').on('click', '.bt_doc', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).removeClass('btn-danger').addClass('btn btn-primary');
                }
                else {
                    // Open this row
                    row.child( format( $(this).data('url') ) ).show();
                    tr.addClass('shown');
                    $(this).removeClass('btn-primary').addClass('btn btn-danger');
                }
            } );

            table = $('#table').DataTable({
                "ajax": {
                    "url": "<?php echo site_url('prefactura/get_informe_pre')?>",
                    'type': 'POST',
                    "dataSrc":"",
                    "data": function ( d ) {
                        d.periodo              = $("#fecha").val(),
                        d.organizaciones       = $("#organizacion").val(),
                        d.proveedores          = $("#proveedores").val(),
                        d.servicios            = $("#servicios").val()
                    }
                },
                "columns":[
                {data : "tipo"          ,"className": "text-center" },
                {data : "organizacion"  ,"className": "text-center" },
                {data : "proveedor"     ,"className": "text-left"   },
                {data : "servicio"      ,"className": "text-left"   },
                {data : "concepto"      ,"className": "text-left"   },
                {data : "medida1"       ,"className": "text-left"   },
                {data : "precio1"       ,"className": "text-right"  },
                {data : "cantidad1"     ,"className": "text-right"   },
                {data : "total1"        ,"className": "text-right"  ,"render": $.fn.dataTable.render.number( '.', ',', 0 )  }
                // {data : "doc","className": "text-center"},
                // {data : "url","className": "text-center"},
                // {data : "id_ajuste","className": "text-center"}
                ],
                "columnDefs": [
                {
                    "targets": [ -1 ],
                    "orderable": false,
                },
                {   
                    "targets" : 'no-sort', orderable : false 
                },
                ],
                 "createdRow": function (row,data,index){
                    $('td',row).eq(6).empty();
                    $('td',row).eq(6).append('<i class="left">$</i> '+data.precio1+' '+data.tipo_pago);

                },
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
                    .column( 8 , { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        $i ++;
                        return intVal(a.toString().replace('%','')) + intVal(b.toString().replace('%',''));
                    }, 0 );
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
               },
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



function format ( d ) {
    console.log(d)
                // `d` is the original data object for the row
                var fila= '<table cellpadding="8" cellspacing="0" border="0" style="padding-left:50px;">'
                fila+='<tr>';
                fila+='<td><iframe style="width:850px; height:600px;" frameborder="0" src="'+d+'"></iframe></td></tr></table>';
                return fila;
            }

            
        });

function number_punto(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}



function crear_prefactura(periodo,organizaciones,proveedores,servicios){


    
    var formulario              = new FormData(document.getElementById("form"));
        formulario.append('periodo'                , periodo);
        formulario.append('organizaciones'         , organizaciones);
        formulario.append('proveedores'            , proveedores);
        formulario.append('servicios'              , servicios);
        $.ajax({
                url: '<?php echo site_url("prefactura/agregar")?>',
                type: 'POST',
                dataType: 'json',
                data: formulario,
                processData: false,
                contentType: false,
                cache: false,
                async: false
        }) .done(function(data) {
            if (data.estado) {
                $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
                pf_notify('Creación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                $('#box_body').removeClass('show').addClass('hide');
                $('#div_guardar').removeClass('show').addClass('hide');
                $('#modal_confirmacion').modal('hide');
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
                    $('#modal_confirmacion').modal('hide');
                }else{
                    pf_notify('Concepto', data.mensaje.validacion , 'danger' ,'fa fa-ban');
                }
            }
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });

}



</script>

