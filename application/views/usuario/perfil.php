
<section class="content-header">
	<h1>Perfil<small>Ver</small></h1>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-dashboard"></i> Perfil</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Rut</label>
						<input type="text" class="form-control" disabled value="<?php echo $this->session->rut?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" class="form-control" disabled value="<?php echo $this->session->nombre?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Oficina</label>
						<input type="text" class="form-control" disabled value="<?php echo $this->session->oficina_nombre?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Departamento</label>
						<input type="text" class="form-control" disabled value="<?php echo $this->session->departamento?>">
					</div>
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