<section class="content-header">
    <h1>
        Eventos
        <small><b>Listado</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Eventos</li>
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
                <div id="top-left" class="col-xs-3">
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
                <div id="top-right" class="col-xs-3">
                    <div class="form-group margin-btm-5">
                        <label>Buscar</label>
                        <input id="search_input" class="form-control">
                    </div>
                </div>
                <div class="col-xs-3">
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
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="">Organizaciones</label>
                        <select id='organizacion' name='organizacion' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row table-responsive no-left-right-margin">
                <div class="col-xs-12"> 
                    <table id="table" class="table table-bordered table-striped table-hover" style="width: 100%">
                        <thead>
                            <th>Id evento</th>
                            <th>Periodo</th>
                            <th>Proveedor</th>
                            <!-- <th>Estado</th> -->
                            <th>Fecha Creacion</th>
                            <th class="no-sort text-center">Documento</th>
                            <th class="no-sort text-center">Visualizar</th>
                            <!-- <th width="50px" class="no-sort text-center">Editar</th>
                                <th width="50px" class="no-sort text-center">Eliminar</th> -->
                            </thead>
                            <tbody>

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


    <script type="text/javascript">
        $(function(){
            var usuid = <?php echo $this->session->usuid?>;
            cargar_select_org(usuid);

            $('body').on('change','#organizacion',function(){
                table.ajax.reload();
            });
            $('body').on('change','#fecha',function(){
                table.ajax.reload();
            });

            $('.date').datepicker({
                autoclose: true,
                format: "mm/yyyy",
                language: "es",
                todayHighlight: true,
                viewMode: "months", 
                minViewMode: "months"
            });

        });


        function cargar_select_org(usuid){
            $('#organizacion').empty();
            $.post("<?php echo site_url('usuario/get_usuorg')?>", {usuid : usuid} , function(data) {
                $.each( data.organizaciones_usuario , function(index, el) {
                   $('#organizacion').append('<option selected value="'+el.ORGANIZATION_ID+'" >'+el.ORGANIZACION+'</option>');
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
            function format ( d ) {
                console.log(d)
                // `d` is the original data object for the row
                var fila= '<table cellpadding="8" cellspacing="0" border="0" style="padding-left:50px;">'
                fila+='<tr>';
                fila+='<td><iframe style="width:850px; height:600px;" frameborder="0" src="'+d+'"></iframe></td></tr></table>';
                return fila;
            }

            table = $('#table').DataTable({
                "ajax": {
                    "url": "<?php echo site_url('eventos/get_eventos')?>",
                    'type': 'POST',
                    "dataSrc":"",
                    "data": function ( d ) {
                        d.periodo = $("#fecha").val(),
                        d.org     = $("#organizacion").val()
                    }
                },
                "columns":[
                {data : "id_evento","className": "text-center"},
                {data : "periodo","className": "text-left"},
                {data : "proveedor","className": "text-left"},
                // {data : "estado","className": "text-left"},
                {data : "fecha_creacion","className": "text-left"},
                {data : "doc","className": "text-center"},
                {data : "url","className": "text-center"}
                ],
                "columnDefs": [
                {
                    "targets": [ -1 ],
                    "orderable": false,
                },
                {   
                    "targets" : 'no-sort', orderable : false 
                }
                ],
                "createdRow": function (row,data,index){
                    $('td',row).eq(4).empty();
                    $('td',row).eq(4).append('<button type="button" class="btn btn-info bt_doc" data-url="'+data.doc+'"><i class="fa fa-save"></i></button>');
                    $('td',row).eq(5).empty();
                    $('td',row).eq(5).append('<a data-id="'+data.id_evento+'" href="'+data.url+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>');
                },
                "paging": true, 
                "info": true,
                "autoWidth": true, 
                "bPaginate":true,
                "sPaginationType":"full_numbers",
                "bLengthChange": true,
                "bInfo" : true,
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

</script>

