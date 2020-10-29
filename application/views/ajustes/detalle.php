<?php foreach ($ajustes as $key => $value) {
    $ajuste = $value;
}?>


<section class="content-header">
    <h1>
        Detalle
        <xsall><b>Ajuste</b></xsall>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Detalle</li>
        <li class="active">Ajuste</li>
    </ol>
</section>

<section class="content">     
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus"></i> Detalle ajuste</h3>
            <a href="<?php echo $this->agent->referrer() ?>" class="btn btn-default btn-flat pull-right"><strong>Volver</strong></a>
        </div>
        <div class="box-body">
            <div class="col-xs-3">
                <div class="form-group">
                    <label>ID Ajuste</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $ajuste->ID_AJUSTE;?>">
                </div>    
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Numero de guia</label>
                    <input type="text" class="form-control"  readonly="true" value="<?php echo $ajuste->NUMERO_GUIA ;?>">
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group">
                    <label>Periodo</label>
                    <div class="input-group date">
                        <input type="text" class="form-control"  readonly="true" value="<?php echo $ajuste->PERIODO;?>">
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
                    <iframe id="file" class="embed-responsive-item" src="<?php echo base_url().$ajuste->DOCUMENTO ?>"></iframe>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Planta</label>
                    <select name="organizaciones" id="organizaciones" class="form-control select2" style="width: 100%" disabled="true">
                        <option value="<?php echo $ajuste->ORGANIZACION?>"><?php echo $ajuste->ORGANIZACION?></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Proveedor</label>
                    <select name="proveedor" id="proveedor" class="select2 form-control" style="width: 100%" disabled="true">
                        <option value="<?php echo $ajuste->ID_PROVEEDOR ?>"><?php echo  $ajuste->RUT_PROVEEDOR.' | '.$ajuste->NOMBRE_PROVEEDOR ?></option>
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Fecha Creacion</label>
                    <input class="form-control" readonly="true" type="text" value="<?php echo $ajuste->FECHA_CREACION?>">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" class="form-control" value="<?php echo $ajuste->ESTADO ?>" readonly="true" >
                </div>
            </div>


        </div>
        <div class="box-footer">
            <div class="col-sm-6">
                <div class="form-group">
                        <label>Concepto</label>
                        <select class="form-control select2" style="width: 100%;" disabled="true">
                         <option selected="true"><?php echo $ajuste->CONCEPTO?></option>
                     </select>
                 </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Cantidad 1</label>
                    <input  type="text" class="form-control" value="<?php echo $ajuste->CANTIDAD1?>" disabled="true"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Medida 1</label>
                    <input type="text" class="form-control" readonly="true" value="<?php echo $ajuste->MEDIDA1?>" disabled="true"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Cantidad 2</label>
                    <input  type="text" class="form-control" value="<?php echo $ajuste->CANTIDAD2?>" disabled="true"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Medida 2</label>
                    <input  type="text" class="form-control" readonly="true" value="<?php echo $ajuste->MEDIDA2?>" disabled="true"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Cantidad 3</label>
                    <input  type="text" class="form-control" value="<?php echo $ajuste->CANTIDAD3?>" disabled="true"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label>Medida 3</label>
                    <input  type="text" class="form-control" readonly="true" value="<?php echo $ajuste->MEDIDA3?>" disabled="true"/>
                </div>
            </div>  

            <?php if ($ajuste->CREADOR == $this->session->usuid): ?>
                <div class="pull-right col-xs-6">
                    <button class="btn btn-block btn-danger bt_eliminar" data-id="<?php echo $ajuste->ID_AJUSTE?>">Eliminar ajuste <i class="fa fa-trash"></i></button>
                </div>
            <?php endif ?>
            
        
    </div>
</div>


<div class="modal fade in" id="modal_eliminacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Confirmación de eliminación</h4>
            </div>

            <div class="modal-body">
                <h4>Esta apunto de eliminar un registro de ajuste, ¿Desea continuar?</h4>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="bt_del_ajuste" type="button" class="btn btn-primary pull-right">Aceptar</button>
                </div>

            </div>

        </div>
    </div>
</div>




</section>

<script type="text/javascript">
    $(function(){
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
                window.history.back();
            }else{
                pf_notify('Solicitud', 'ups, Ocurrio un error, contactarse con Informática' , 'danger' ,'fa fa-ban');
            }
        },'json');
    })

 })
</script>
