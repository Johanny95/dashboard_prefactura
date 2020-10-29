<section class="content">
	
	<div class="box box-info">
		<div class="box-header">
			<i class="fa fa-clock-o"></i>
			<h3 class="box-title">Mantenedor de datos generales por organización y periodo</h3>
			<div class="note pull-right" style="margin-right: 5px;margin-top: 15px">
				<span class="pull-left margin-right-5">
					<small class="label bg-aqua pull-right"> <i class="fa fa-info padding-top-3"></i></small> 
				</span>
				<strong> Nota: </strong> Para visualizar organizaciones debe seleccionar un periodo.
			</div>

		</div>
		<div class="box-body">
			
			<!-- fecha mes y año -->
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Periodo a ingresar</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" id="datepicker" maxlength="5">
						</div>
						<!-- /.input group -->
					</div>
				</div>
				<div class="col-sm-6">
					<h3 id="mes_seleccionado" class="pull-right"></h3>

					<div class="form-group">
						<label>Leyendas</label>
						<div>
							<button class="btn btn-sm bg-primary"></button> No registrados<br/>
							<button class="btn btn-sm bg-green"></button> Registrados		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div id="contenedor">

			

		</div>
	</div>

</section>

<script type="text/javascript">
	$(function () {

		//Date picker
		$('#datepicker').datepicker({
			format: 'mm-yyyy',
			minViewMode: "months",
			autoclose: true,
			language: "es",
			todayHighlight: true
		}).datepicker('setDate' , new Date());

		$('#datepicker').on('change',function(){
			cargar_oficinas(this.value);
			$('#mes_seleccionado').empty().append(this.value);
		})

		cargar_oficinas($('#datepicker').val());
		$('#mes_seleccionado').empty().append($('#datepicker').val());

		$("body").on('click','.bt_guardar',function (e) {
			e.preventDefault();
			var id_org = $(this).data('id');
			this.disabled   = true;
			var action 		= $('#'+id_org).attr('action');
			var formulario  = $('#'+id_org).serializeArray();
			formulario.push({name: "id_oficina"	, value: id_org      						});
			formulario.push({name: "oficina" 	, value: this.getAttribute('data-oficina')  });
			formulario.push({name: "periodo"	, value: $('#datepicker').val()				});
			guardar_hora_salida(action, formulario);
			this.disabled   = false;
		});

		$('body').on('click','.bt-eliminar',function(e){
			e.preventDefault();
			eliminar_hora_salida($('#datepicker').val(), $(this).data('id'));
		})

	});
	//funciones de carga, formato y guardar-

	//function que guarda las modificaciones indepemdiente si es nuevo el registro o se modifica.
	function guardar_hora_salida(action, formulario){
		var periodo = $('#datepicker').val();
		$.ajax({
			url: action, 
			type: "POST",
			data: formulario,
			dataType: "json",
			success: function(data){
				if (data.estado) {
	                $('div.form-group').removeClass('has-success').removeClass('has-error')
	                .find('.text-danger').remove();
	                pf_notify('Registro', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
	                cargar_oficinas(periodo);
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
	                    pf_notify('Registro', data.mensaje.validacion , 'danger' ,'fa fa-ban');
	                }
	            }
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		})
	}
	//function para eliminar hora de salida
	function eliminar_hora_salida(periodo,id_oficina){
		$.ajax({
			url: '<?php echo site_url('mantenedor_datos/elimnar_registro')?>', 
			type: "POST",
			data: {'periodo' : periodo , 'id_oficina' : id_oficina},
			dataType: "json",
			success: function(data){
				if (data.estado) {
	                $('div.form-group').removeClass('has-success').removeClass('has-error')
	                .find('.text-danger').remove();
	                pf_notify('Evento', 'Operación realizada correctamente' , 'success' ,'fa fa-commenting-o');
	                cargar_oficinas(periodo);
	                $('#div_contenedor').addClass('hide').removeClass('show');
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
	                    pf_notify('Registro', data.mensaje.validacion , 'danger' ,'fa fa-ban');
	                }
	            }
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		})
	}


	//proceso que carga las oficinas para
	function cargar_oficinas(periodo){
		$.ajax({
			url: "<?php echo site_url('mantenedor_datos/get_datos_org')?>", 
			type: "POST",
			data: { 'periodo' : periodo},
			dataType: "json",
			success: function(data){
				$('#contenedor').empty();

				$.each(data.datos,function(index, el) {
					var estado_box = (el.KILOS_PRODUCCION ? 'box-success'  : 'box-primary');
					var estado_btn = (el.KILOS_PRODUCCION ? 'btn-success'  : 'btn-primary' );

					var kg_produccion 		= (el.KILOS_PRODUCCION  	? el.KILOS_PRODUCCION : '' );
					var mts2_superficie 	= (el.MTS2_SUPERFICIE  	? el.MTS2_SUPERFICIE : '' );
					var mts_jardines 		= (el.MTS2_JARDINES  	? el.MTS2_JARDINES : '' );
					var dias_servicios 		= (el.DIAS_SERVICIOS  	? el.DIAS_SERVICIOS : '' );
					var dotacion 			= (el.DOTACION  	? el.DOTACION : '' );
					var valor_uf 			= (el.VALOR_UF  	? el.VALOR_UF : '' );
					

					var action     = (el.KILOS_PRODUCCION ? '<?php print site_url('mantenedor_datos/editar')?>' 
						: '<?php print site_url('mantenedor_datos/ingresar')?>')
					var box = '<div class="col-md-3">';
					box+= '<div class="box '+estado_box+'">';
					box+= '<div class="box-header with-border">';
					box+= '<h3 class="box-title"><strong>'+el.ORGANIZACION+'</strong></h3>';
					if(el.KILOS_PRODUCCION){
						box+= '<button type="button" data-id="'+el.ORGANIZACION_ID+'" class="bt-eliminar btn btn-danger pull-right"><i class="fa fa-trash-o"></i></button>';		
					}
					box+= '</div>';
					box+= '<div class="box-body">';

						//se define el input para hacer el ingreso de los horarios
						box+= '<form action="'+action+'" id="'+el.ORGANIZACION_ID+'">';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Kg Producción</label> ';
						box+= '			<input type="text" id="kilos_produccion'+el.ORGANIZACION_ID+'" value="'+kg_produccion+'" name="kilos_produccion'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)" > ';
						box+= '		</div>	 ';
						box+= '	</div> ';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Metros Superfice</label> ';
						box+= '			<input type="text" id="mts2_superficie'+el.ORGANIZACION_ID+'" value="'+mts2_superficie+'" name="mts2_superficie'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)"> ';
						box+= '		</div>	 ';
						box+= '	</div> ';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Metros Jardines</label> ';
						box+= '			<input type="text" id="mts2_jardines'+el.ORGANIZACION_ID+'" value="'+mts_jardines+'" name="mts2_jardines'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)"> ';
						box+= '		</div>	 ';
						box+= '	</div> ';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Dias Servicios</label> ';
						box+= '			<input type="text" id="dias_servicios'+el.ORGANIZACION_ID+'" value="'+dias_servicios+'" name="dias_servicios'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)"> ';
						box+= '		</div>	 ';
						box+= '	</div> ';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Dotacion</label> ';
						box+= '			<input type="text" id="dotacion'+el.ORGANIZACION_ID+'" value="'+dotacion+'" name="dotacion'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)" > ';
						box+= '		</div>	 ';
						box+= '	</div> ';
						box+= '	<div class="col-sm-12"> ';
						box+= '		<div class="form-group"> ';
						box+= '			<label>Valor UF</label> ';
						box+= '			<input type="text" id="valor_uf'+el.ORGANIZACION_ID+'" value="'+valor_uf+'" name="valor_uf'+el.ORGANIZACION_ID+'" class="form-control" onkeypress="return isNumber(event)"> ';
						box+= '		</div>	 ';
						box+= '	</div> ';

						box+= '<input type="button" data-id="'+el.ORGANIZACION_ID+'" data-oficina="'+el.ORGANIZACION+'" class="btn bt_guardar '+estado_btn+' btn-block" value="Guardar">';
						box+= '</div>';
						box+= '</form>';
						box+= '</div>';
						box+= '</div>';
						$('#contenedor').append(box);
					});
				// formato_timepicker();
			},
			error: function (request, status, error) {
				// console.log(request.responseText);
			}
		});	
	}

	// function formato_timepicker(){
	// 	//Timepicker
	// 	$('.timepicker').timepicker({
	// 		showInputs: false,
	// 		minuteStep: 1,
	// 		format: 'hh:mm',
	// 		showMeridian: false
	// 	})
	// }

	

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








