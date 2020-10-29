<section class="content-header">
    <h1>
        Conceptos
        <small><b>todos</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Conceptos</li>
        <li class="active">Todas</li>
    </ol>
</section>

<section class="content">   
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> Listado de Conceptos</h3>
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
                            <th>Servicio</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Cuenta Contable</th>
                            <th>F. Creación</th>
                            <th width="50px" class="no-sort text-center">Editar</th>
                            <th width="50px" class="no-sort text-center">Precios</th>
                            <th width="50px" class="no-sort text-center">Historial</th>
                            <!-- <th width="50px" class="no-sort text-center">Eliminar</th> -->
                        </thead>
                        <tbody>
                            <?php foreach ($datos as $value): ?>
                                <tr>
                                    <td><?php echo $value->ID_CONCEPTO; ?></td>
                                    <td><?php echo ucwords(mb_strtolower($value->NOMBRE_CONCEPTO)); ?></td>
                                    <td><?php echo $value->NOMBRE_SERVICIO; ?></td>
                                    <td><?php echo $value->RUT_PROVEEDOR.' | '.$value->RAZON_SOCIAL; ?></td>
                                    <td><?php echo $value->ESTADO; ?></td>
                                    <td><?php echo $value->CUENTA_CONTABLE; ?></td>
                                    <td><?php echo $value->FECHA_CREACION; ?></td>
                                    <td class="text-center">
                                        <a data-realizaroc="<?php  echo $value->REALIZAR_OC ?>" data-toggle="tooltip" data-placement="top" title="Editar caracteristicas" class="btn btn-primary btn-flat btn-sm" data-id="<?php  echo $value->ID_CONCEPTO ?>" href="<?php echo site_url('concepto/editar/'.$value->ID_CONCEPTO)?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a  data-concepto="<?php echo $value->NOMBRE_CONCEPTO?>" 
                                            data-medida1="<?php echo $value->MEDIDA1?>" 
                                            data-precio1="<?php echo $value->PRECIO1?>"
                                            data-medida2="<?php echo $value->MEDIDA2?>" 
                                            data-precio2="<?php echo $value->PRECIO2?>" 
                                            data-medida3="<?php echo $value->MEDIDA3?>" 
                                            data-precio3="<?php echo $value->PRECIO3?>"
                                            data-medida1text="<?php echo $value->MEDIDA1_TEXT?>" 
                                            data-medida2text="<?php echo $value->MEDIDA2_TEXT?>" 
                                            data-medida3text="<?php echo $value->MEDIDA3_TEXT?>" 
                                            data-id     ="<?php  echo $value->ID_CONCEPTO ?>"
                                            data-cta    ="<?php  echo $value->CUENTA_CONTABLE ?>"
                                            data-idprecio    ="<?php  echo $value->ID_PRECIO ?>"
                                            data-fechadesde    ="<?php  echo $value->FECHA_DESDE ?>"
                                            data-fechahasta    ="<?php  echo $value->FECHA_HASTA ?>"
                                            data-realizaroc    ="<?php  echo $value->REALIZAR_OC ?>"
                                            data-toggle="tooltip" data-placement="top" title="Editar precios" class="btn btn-success btn-flat btn-sm"   >
                                            <i class="fa fa-dollar"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a id="bt_historial" data-toggle="tooltip" data-placement="top" title="Historial" class="btn btn-info btn-flat btn-sm" data-id="<?php  echo $value->ID_CONCEPTO ?>" >
                                            <i class="fa fa-list"></i>
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


<div class="modal fade in" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Editar</h4>
            </div>

            <div class="modal-body">
                <form id="form-editar" method="POST">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Id concepto</label>
                            <input type="text" name="id_concepto" id="id_concepto" class="form-control" readonly="true">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Servicio</label>
                            <input type="text" name="servicio_edit" id="servicio_edit" class="form-control" readonly="true">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" autocomplete="off" class="form-control">
                        </div>    
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label>Proveedor</label>
                            <input type="text" name="proveedor_edit" id="proveedor_edit" autocomplete="off" class="form-control" readonly="true" >
                        </div>    
                    </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                            <label>Valida OC</label>
                            <div><input id="check_oc" name="check_oc" type="checkbox" class="flat-red"></div>
                            
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
                   

                </form>        

            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button id="btn_add" type="button" class="btn btn-primary pull-right">Guardar</button>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade in" id="modal_precios">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Editar Precios</h4>
            </div>

            <div class="modal-body">
                <form id="form_editar_precio" method="POST">

                 <div class="col-sm-12 div_nombre_concepto">
                    <div class="form-group">
                        <label>Concepto</label>
                        <input type="text" name="nombre_concepto" id="nombre_concepto" class="form-control" readonly="true">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group div_fecha_desde">
                        <label>Fecha desde</label>
                        <div class="input-group date">
                            <input id='fecha_desde' name='fecha_desde' type="text" class="form-control"  readonly="true" value="<?php echo date('d/m/Y');?>">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                   <div class="form-group div_fecha_hasta">
                    <label>Fecha hasta</label>
                    <div class="input-group date">
                        <input id='fecha_hasta' name='fecha_hasta' type="text" class="form-control"  readonly="true" >
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Cuenta Contable</label>
                    <select  id='cta_contable' name="cta_contable" class="form-control select2" style="width: 100%" >
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="filename">Archivo a subir (solo pdf)</label>
                    <input id="input" type="file" name="userfile" class="file-loading" >
                </div>    
            </div>
            <div class="col-sm-4 ">
                <div class="form-group">
                    <label>Tipo medida 1</label>
                    <select name="medida1" id="medida1" class="form-control select2" style="width: 100%" >
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
                    <select name="medida2" id="medida2" class="form-control select2" style="width: 100%" >
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
                    <select name="medida3" id="medida3" class="form-control select2" style="width: 100%" >
                        <option value="" selected="true">Seleccionar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Precio 3</label>
                    <input type="text" name="precio3" id="precio3" class="form-control medida" onkeypress="return isNumber(event)">
                </div>    
            </div>


        </form>        

    </div>
    <div class="modal-footer">
        <div class="col-sm-12">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button id="btn_editar_precios" type="button" class="btn btn-primary pull-right">Solicitar cambio</button>
        </div>

    </div>

</div>
</div>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_historial">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Historial de precios</h4>
    </div>
    <div class="modal-body">

        <div class="col-sm-12">
            <div class="table-responsive">
                <table id="tabla_historial" class="table table-striped table-hover dataTable" >
                    <thead class="bg-primary">
                        <tr>
                            <th>Concepto</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>cta</th>
                            <th>Creacion</th>
                            <th>Med1</th>
                            <th>Precio1</th>
                            <th>Med2</th>
                            <th>Precio2</th>
                            <th>Med3</th>
                            <th>Precio3</th>
                            <th>F.Cesde</th>
                            <th>F.Hasta</th>
                            <th>Doc</th>
                        </tr> 
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <div class="col-sm-12">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
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
            autoclose: true,
            format: "dd/mm/yyyy",
            language: "es",
            todayHighlight: true,
            startDate: "today"
        });

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




    $('.table tbody tr td .btn-primary').click(function(event){
        event.preventDefault();
        var tr   = $(this).closest('tr');
        row      = table.row(tr);
        var data = row.data();
        $('#nombre').val(data[1]);
        $('#id_concepto').val(data[0]);
        $('#rut_edit').val(data[2]);
        $('#proveedor_edit').val(data[3]);
        $('#estado_edit').val(data[4]);
        $('#fecha_creacion_edit').val(data[6]);
        $('#name').text(data[1]);
        $('input[name=id]').val(data[0]);
        var estado = ( $(this).data('realizaroc') == 'S' ? true : false );
        $('#check_oc').attr('checked' , estado);
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass   : 'iradio_flat-green'
        });

        $('#modal-default').modal('toggle');
    });

    $('.table tbody tr td .btn-success').click(function(event){
        event.preventDefault();
        var tr   = $(this).closest('tr');
        row      = table.row(tr);
        var data = row.data();
        medida1 = $(this).data('medida1');
        precio1 = $(this).data('precio1');
        medida2 = $(this).data('medida2');
        precio2 = $(this).data('precio2');
        medida3 = $(this).data('medida3');
        precio3 = $(this).data('precio3');
        medida1_text = $(this).data('medida1text');
        medida2_text = $(this).data('medida2text');
        medida3_text = $(this).data('medida3text');
        cta = $(this).data('cta');
        var fecha_desde =$(this).data('fechadesde');
        var fecha_hasta =$(this).data('fechahasta');
        $('#nombre_concepto').val( $(this).data('concepto') );

        
        $('#medida1').empty().append('<option value="'+medida1+'">'+medida1_text+'</option>');
        $('#medida2').empty().append('<option value="'+medida2+'">'+medida2_text+'</option>');
        $('#medida3').empty().append('<option value="'+medida3+'">'+medida3_text+'</option>');
        $('#precio1').val(precio1);        
        $('#precio2').val(precio2);

        $('#precio3').val(precio3);
        $('#cta_contable').val(cta);

        $('#fecha_desde').val(fecha_desde);
        if (fecha_hasta == '' ) {
         $('.div_fecha_hasta').removeClass('show').addClass('hide');
         $('.div_nombre_concepto').removeClass('col-sm-12').addClass('col-sm-6');
     }else{
       $('.div_fecha_hasta').removeClass('hide').addClass('show');
       $('.div_nombre_concepto').removeClass('col-sm-6').addClass('col-sm-12');
       $('#fecha_hasta').val(fecha_hasta).prop('disabled', true);
   }

   id_concepto = $(this).data('id'); 
   id_precio   = $(this).data('idprecio');
   $('#modal_precios').modal('toggle');
});

    

    $('body').on('click','#btn_add',function(e){
        e.preventDefault();
        $('#btn_add').prop('disabled', true);
        var formulario              = new FormData(document.getElementById("form-editar"));
        $.ajax({
            url: '<?php print site_url()?>/concepto/upd',
            type: 'POST',
            dataType: 'json',
            data: formulario,
            processData: false,
            contentType: false,
            cache: false,
            async: false
        }).done(function(data) {
           if (data.estado) {
            $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
            pf_notify('Agente', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
            // $('.selectpicker').selectpicker('refresh');
            setTimeout(function(){  location.reload(); }, 1200 );
            $('#modal-default').modal('hide');
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

    $('body').on('click','#btn_editar_precios',function(e){
        e.preventDefault();
        $('#btn_add').prop('disabled', true);
        var formulario              = new FormData(document.getElementById("form_editar_precio"));
        var file_data               = $('#input').prop('files')[0];
        formulario.append('file'                , file_data);
        formulario.append('id_concepto'         , id_concepto);
        formulario.append('id_precio'         , id_precio);
        $.ajax({
            url: '<?php print site_url()?>/concepto/editar_precio',
            type: 'POST',
            dataType: 'json',
            data: formulario,
            processData: false,
            contentType: false,
            cache: false,
            async: false
        }).done(function(data) {
         if (data.estado) {
            $('div.form-group').removeClass('has-success').removeClass('has-error').find('.text-danger').remove();
            pf_notify('Concepto', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
            setTimeout(function(){  location.reload(); }, 1200 );
            $('#modal_precios').modal('hide');
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


</script>

<script type="text/javascript">
    var arreglo_organizaciones = [];
    var arreglo_servicios = [];
    var id_concepto_historial = 0;
    $(function(){

        cargar_select('#medida1','concepto/get_medidas');
        cargar_select('#medida2','concepto/get_medidas');
        cargar_select('#medida3','concepto/get_medidas');
        cargar_select('#cta_contable','concepto/get_cuentas_contables');


        $('body').on('click','#bt_historial',function(){
            id_concepto_historial = $(this).data('id');
            tabla_historial.ajax.reload();
            $('#modal_historial').modal('show');
        });

        var tabla_historial = $('#tabla_historial').DataTable({
            "ajax": {
                "url": "<?php echo site_url('concepto/get_historial')?>",
                'type': 'POST',
                "dataSrc":"",
                "data": function ( d ) {
                    d.id_concepto = id_concepto_historial
                }
            },
            "columns":[
            {data : "id_concepto","className": "text-center"},
            {data : "id_precio","className": "text-left"},
            {data : "nombre","className": "text-left"},
            {data : "cta","className": "text-left"},
            {data : "fecha_creacion","className": "text-left"},
            {data : "medida1","className": "text-left"},
            {data : "precio1","className": "text-left"},
            {data : "medida2","className": "text-left"},
            {data : "precio2","className": "text-left"},
            {data : "medida3","className": "text-left"},
            {data : "precio3","className": "text-right"},
            {data : "fecha_desde","className": "text-left"},
            {data : "fecha_hasta","className": "text-left"},
            {data : "documento","className": "text-center"}
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
                $('td',row).eq(13).empty();
                $('td',row).eq(13).append('<button type="button" data-url="'+data.documento+'" class="btn btn-sm btn-info bt_documento"><i class="fa fa-file"></i></button>');
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
                }
            }
        });

        jQuery("#footer").ready(function(){
            jQuery("#tabla_historial_length").addClass('hidden');
            jQuery("#tabla_historial_filter").addClass('hidden');
            jQuery("#tabla_historial_info").addClass('hidden');
            jQuery("#footer-left").text(jQuery("#tabla_historial_info").text());
            jQuery("#tabla_historial_paginate").appendTo(jQuery("#footer-right"));
        });

        $('body').on('click', '.bt_documento', function (event) {
            var url = $(this).data('url');
            var tr              = $(this).closest('tr');
            var row             = tabla_historial.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child( addFramer(url) ).show();
                tr.addClass('shown');
            }     
        });

    });


function addFramer(url) {
    return '<div style="height:350px" ><iframe style="height:350px;width:100%" class="embed-responsive-item" src="<?php echo base_url() ?>'+url+'"></iframe></div>';
}

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
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

</script>