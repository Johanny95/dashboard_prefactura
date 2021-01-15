<?php foreach ($evento as $key => $value) {
    $eve = $value;
    // echo var_dump($eve);
}?>


<section class="content-header">
    <h1>
        Detalle
        <xsall><b>Eventos</b></xsall>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Detalle</li>
        <li class="active">Evento</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Detalle eventos</h3>
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-right"><strong>Volver</strong></a>
        </div>
        <div class="box-body">
            <div class="col-xs-3">
                <div class="form-group">
                    <label>ID evento</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $eve['id_evento'];?>">
                </div>    
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Numero de guia</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $eve['numero_guia'] ;?>">
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group">
                    <label>Periodo</label>
                    <div class="input-group date">
                        <input type="text" class="form-control"  readonly="true" value="<?php echo $eve['periodo'];?>">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="filename">Archivo guia referencia</label>
                    <button class="btn btn-info btn-block file"><i class="fa fa-save"></i> Ver documento</button>
                </div>    
            </div>
            <div class="col-sm-12 hide div_file">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="file" class="embed-responsive-item" src="<?php echo base_url().$eve['documento'] ?>"></iframe>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Planta</label>
                    <select name="organizaciones" id="organizaciones" class="form-control select2" style="width: 100%" disabled="true">
                        <option value="<?php echo $eve['organizacion']?>"><?php echo $eve['organizacion']?></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Proveedor</label>
                    <select name="proveedor" id="proveedor" class="select2 form-control" style="width: 100%" disabled="true">
                        <option value="<?php echo $eve['proveedor'] ?>"><?php echo  $eve['rut_proveedor'].' | '.$eve['nombre_proveedor'] ?></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Fecha Creacion</label>
                    <input class="form-control" readonly="true" type="text" value="<?php echo $eve['fecha_creacion']?>">
                </div>
            </div> 

            
                <div class="col-xs-3 hide" id="div_borrar">
                    <div class="form-group">
                        <label>Eliminar</label>
                        <button id="bt_eliminar" class="btn btn-danger btn-block bt_del" data-id="<?php echo $eve['id_evento']?>"><i class="fa fa-trash"></i> Eliminar</button>
                    </div>
                </div>    
            

            


        </div>
        <div class="box-footer">

        </div>
    </div>



    <?php foreach ($eve['servicios'] as $key => $servicio): ?>

     <div class="box box-primary">
        <div class="box-header with-border">
            <div class="container-fluid">
                <div class="col-sm-6">
                    <h4 id="servicio_txt"><i class="fa fa-genderless"></i>  <?php echo $servicio['nombre_servicio']?></h4>
                </div>  
            </div>
        </div>
        <div class="box-body">
            <div class="container-fluid">
                <?php $estado = 1; ?>
                <?php foreach ($servicio['conceptos'] as $key => $concepto): ?>

                    <?php if ($concepto['estado_evento'] === 'PROCESADO' || $concepto['estado_evento'] === 'APROBADO' ) : ?>
                        <?php $estado = 0  ?>
                        
                    <?php endif ?>
                    
                   <div class="row" id="">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Concepto</label>
                            <select class="form-control select2" style="width: 100%;" disabled="true">
                             <option selected="true"><?php echo $concepto['nombre_concepto']?></option>
                         </select>
                     </div>
                 </div>
                 <div class="col-sm-1">
                    <div class="form-group">
                        <label>Cantidad 1</label>
                        <input  type="text" class="form-control" value="<?php echo $concepto['cantidad1']?>" disabled="true"/>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Medida 1</label>
                        <input type="text" class="form-control" readonly="true" value="<?php echo $concepto['medida1']?>" disabled="true"/>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Cantidad 2</label>
                        <input  type="text" class="form-control" value="<?php echo $concepto['cantidad2']?>" disabled="true"/>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Medida 2</label>
                        <input  type="text" class="form-control" readonly="true" value="<?php echo $concepto['medida2']?>" disabled="true"/>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Cantidad 3</label>
                        <input  type="text" class="form-control" value="<?php echo $concepto['cantidad3']?>" disabled="true"/>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Medida 3</label>
                        <input  type="text" class="form-control" readonly="true" value="<?php echo $concepto['medida3']?>" disabled="true"/>
                    </div>
                </div>


            </div>

        <?php endforeach ?>

    </div>
</div>
<div class="box-footer">
    <div class="container-fluid">
    </div>
</div>
</div>

<?php endforeach ?>


<div class="modal  fade" id="modal_eliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="form_eliminar" action="<?php echo site_url('evento/eliminar')?>" method="get" accept-charset="utf-8">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-question-circle margin-right-5"></i> <span>Eliminar evento</strong></h4>
                    </div>
                    <div class="modal-body">
                        <p>Esta realizando la eliminacion de un evento, ¿Desea continuar?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  pull-left" data-dismiss="modal"><strong>Cancelar</strong></button>

                        <button type="button" id="bt_confirmacion_del" class="btn btn-primary pull-right"><strong>Aceptar</strong></button>    

                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<script type="text/javascript">
    $(function(){

        //
        if ('<?php echo $estado?>' === '1' &&  '<?php echo $eve["creador"] ?>' === '<?php echo $this->session->usuid?>'  ) {
            $('#div_borrar').removeClass('hide').addClass('show');
        } 




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


     $('body').on('click','.bt_del',function(){
        id = $(this).data('id');
        $('#modal_eliminar').modal('show');
    });

     $('body').on('click','#bt_confirmacion_del',function(e){

        $.post("<?php echo site_url('evento/eliminar')?>", {id_evento : id} , function(data) {
            // console.log(data);
            if (data.estado) {
                pf_notify('Eliminación', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
                $('#modal_eliminar').modal('hide');
                window.history.back();
                // setTimeout(function(){  location.reload(); }, 1000 );
            }else{
                pf_notify('Eliminación', 'Ups!, Error al eliminar' , 'danger' ,'fa fa-close');
            }
        },'json');

    });

 });
</script>
