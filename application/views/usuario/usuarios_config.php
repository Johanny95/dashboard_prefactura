
<section class="content-header">
	<h1>Configuración <small>usuarios</small></h1>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-user"></i> Usuarios - Roles</h3>
		</div>
		<div class="box-body">

			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
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
					<div class="col-sm-5">
						<div class="form-group">
							<label>Buscar</label>
							<div class="input-group">
								<input id='search_filter' type="text" class="form-control" placeholder="Ej: S.N.S">
								<span class="input-group-addon"><i class="fa fa-search"></i></span>
							</div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table id='tabla_usurol' class="table table-responsive table-bordered">
						<thead class="bg-navy" >
							<tr>
								<th>Usuid</th>
								<th>Nombre</th>
								<th>Rut</th>
								<th>Depto</th>
								<th>Estado</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody id='tbodyDocs' >

						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div class="box-footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4 pull-right">
						<a href="<?php echo $this->agent->referrer()?>" class="btn btn-default btn-flat btn-block"><i class="fa fa-reply"></i> Volver</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>





<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edición de usuario-rol</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form id="formEdit" method="POST">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Id Usuario</label>
								<input type="text" class="form-control" id='idusuario_edit' name='idusuario_edit' required="true" readonly="true">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Nombre usuario</label>
								<input type="text" class="form-control" id="usunom_edit" name='usunom_edit' required="true" readonly="true">
							</div>
						</div>
						<div class="col-sm-6 div_oficina">
							<div class="form-group">
								<label for="">Roles</label>
								<select id='roles_edit' name='roles_edit' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
								</select>
							</div>
						</div>
						<div class="col-sm-6 div_oficina">
							<div class="form-group">
								<label for="">Organizaciones</label>
								<select id='organizaciones_edit' name='organizaciones_edit' class="form-control selectpicker" multiple data-actions-box="true" data-selected-text-format="count" style="width: 100%">
								</select>
							</div>
						</div>
						<!--SE AGREGA 02-10-2019-->
						<div class="col-sm-6">
							<div class="form-group">
								<label>Estado usuario</label>
								<input id="texto_activo_edit" value="Activo" class="form-control" readonly="true" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default bg-gray" data-dismiss="modal">Cerrar</button>
				<a type="button" id='btnEdit' class="btn btn-primary bg-navy"><i class="fa pull-left fa-check"></i>Guardar cambios</a>
			</div>
		</div>
	</div>
</div>








<script type="text/javascript">
	
	var arreglo_organizaciones 	= [];
	var arreglo_roles		    = [];

	$(function(){

		cargar_select('#roles' 		,'usuarios/get_roles');
		cargar_select('#usuarios' 	,'usuarios/get_usuario');

		$('body').on('click','.bt_editar',function(e){
			e.preventDefault();
			var usuid 	= $(this).data('usuid');
			var usunom 	= $(this).data('usunom');
			var rolid 	= $(this).data('rolid');
			var rolname = $(this).data('rolname');
			var estado  = $(this).data('estado');
			$('#texto_activo_edit').val(estado);
			$('#idusuario_edit').val( usuid );
			$('#usunom_edit').val(usunom);
			$('#rolid_edit').val(rolid);
			$('#rolname_edit').val(rolname);
			$("#activo_edit").prop( "checked", (estado == 'ACTIVO' ? true : false ) );
			
			cargar_select_org(usuid);
			cargar_select_rol(usuid);
				
			$('.div_oficina').removeClass('hidden').addClass('show');
			$('#modal_edit').modal('show');
		})


		$.post("<?php echo site_url('usuario/get_organizaciones')?>", {'':''} , function(data) {
			arreglo_organizaciones = data.organizaciones;
			// console.log(arreglo_organizaciones);
		},'json');

		$.post("<?php echo site_url('usuario/get_roles')?>", {'':''} , function(data) {
			arreglo_roles = data.roles;
			// console.log(arreglo_roles);
		},'json');


		
		

	})


	function cargar_select(id_elemento, url){
		$(id_elemento).select2({
			'ajax': {
				url: "<?php echo site_url('"+url+"')?>",
				type: "POST",
				dataType: 'json',
				data: function(params) {
					return {
						autocompletar: params.term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function (item) {
							return {
								text : item.nombre,
								id   : item.id
							}
						})
					};
				}
			},'width' 			   : '100%',
			'language' 		   : 'es',
			'minimumInputLength' : 0
		});
	}

	function cargar_select_org(usuid){
		$('#organizaciones_edit').empty();
		$.post("<?php echo site_url('usuario/get_usuorg')?>", {usuid : usuid} , function(data) {
			$.each(arreglo_organizaciones, function(index, val) {
				var validador = false;
				$.each( data.organizaciones_usuario , function(index, el) {
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

	function cargar_select_rol(usuid){
		$('#roles_edit').empty();
		$.post("<?php echo site_url('usuario/get_roluser')?>", {usuid : usuid} , function(data) {
			console.log(data);
			$.each(arreglo_roles, function(index, val) {
				var validador = false;
				$.each( data.roles_usuario , function(index, el) {
					if(val.ROLID == el.ROLID){
						validador = true;
					}
				});
				if (validador) {
					$('#roles_edit').append('<option selected value="'+val.ROLID+'" >'+val.NOMBRE+'</option>');
				}else{
					$('#roles_edit').append('<option value="'+val.ROLID+'" >'+val.NOMBRE+'</option>');
				}
			});
			$('.selectpicker').selectpicker('refresh');
		},'json');
	}



</script>


<script type="text/javascript">
	var t;
	$(function(){

		t = $('#tabla_usurol').DataTable({
			"ajax": {
				"url": "<?php echo site_url() ;?>/tabla_usurol/get_usuarios",
				'type': 'POST',
				"dataSrc":"",
				"data": function ( d ) {
					d.search_filter = $('#search_filter').val();
				}
			},
			"paging"     : true,
			"ordering"   : true,
			"info"       : true,
			"autoWidth"  : false,
			"iDisplayLength": 10, 
			"processing " : true,
			"columnDefs" : [
			{ targets    : "no-sort"     	, orderable: false  },
			{ className  : "dt-nowrap"   	, "targets": [0,1]	},
			{ className  : "text-center"  	, "targets": [0,1,4,5]},
			{ "width": "10%"  , "targets": 0 },
			{ "width": "30%"  , "targets": 1 },
			{ "width": "15%"  , "targets": 2 },
			{ "width": "15%"  , "targets": 3 },
			{ "width": "20%"  , "targets": 4 },
			{ "width": "10%"  , "targets": 5 },
			{ targets: 'no-sort', orderable: false }
			], 
			"createdRow": function ( row, data, index ) {

				var estado = ( data[5].ESTADO == 'ACTIVO' ? 'label-success' : 'label-danger');
				$('td',row).eq(4).empty();
				$('td',row).eq(4).append("<strong><span class='label center-block "+estado+"'>"+data[5].ESTADO+"</span>");

				$('td',row).eq(5).empty();
				$('td',row).eq(5).append('<button type="button" class="bt_editar btn btn-sm bg-teal" data-usuid="'+data[5].USUID+'" data-usunom="'+data[5].USUNOM+'" data-rolid="'+data[5].ROLID+'" data-rolname="'+data[5].NOMBRE_ROL+'" data-estado="'+data[5].ESTADO+'" ><i class="fa fa-edit"></i></button>');
			},
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "Busqueda no encontrada",
				"info": "Página _PAGE_ de _PAGES_",
				"infoEmpty": "Busqueda",
				"infoFiltered": "(entre _MAX_ registro totales)",
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
			jQuery("#tabla_usurol_length").addClass('hidden');
			jQuery("#tabla_usurol_filter").addClass('hidden');
			jQuery("#tabla_usurol_info").addClass('hidden');
			jQuery("#footer-left").text(jQuery("#tabla_usurol_info").text());
			jQuery("#tabla_usurol_paginate").appendTo(jQuery("#footer-right"));
		});

		$('#search_filter').keyup(function(){
			t.ajax.reload();
		});

		$('#show_record').change(function() {
			t.page.len($('#show_record').val()).draw();
			jQuery("#footer-left").text(jQuery("#tabla_usurol_info").text());
		});

		$('#search_filter').change(function(event) {
			t.ajax.reload();
		});

		$('#roles_filter').change(function(event){
			var buscar = $(this).val();
			t.column(3).search(buscar).draw();
		});

		$('body').on('click','#activo_edit',function(){
			var estado = ($(this).is(':checked') ? 'Activo': 'Deshabilitado');
			$('#texto_activo_edit').val(estado);
		})



		/*update de rol asociacion*/
		$('body').on('click','#btnEdit',function(e){
			e.preventDefault();
			$('#btnEdit').prop('disabled', true);
			var formulario 		 		= new FormData(document.getElementById("formEdit"));
			var organizaciones_edit   	= $('#organizaciones_edit').val();
			var roles_edit   			= $('#roles_edit').val();
			formulario.append('organizaciones_edit' 	 ,organizaciones_edit);
			formulario.append('roles_edit' ,roles_edit);
			$.ajax({
				url: '<?php print site_url()?>/usuario/upd_rol_usuario',
				type: 'POST',
				dataType: 'json',
				data: formulario,
				processData: false,
				contentType: false,
				cache: false,
				async: false
			}).done(function(data) {
				if(data.status){
					pf_notify('Correcto','Usuario actualizado correctamente.','success');						
					// $('#form_rol_usuario')[0].reset();
					$('#btnEdit').prop('disabled', false);
					t.ajax.reload();
					$('#modal_edit').modal('hide');
				}else{
					pf_notify('Error', data.mesaje, 'danger');
					$('#btnEdit').prop('disabled', false);
				}
			})
		});


	});


</script>