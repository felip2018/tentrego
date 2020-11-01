<div class="col-xs-12 col-md-12">
	<h4 class="alert alert-success">Contactenos</h4>
	<div class="row">
		<div class="col-xs-12 col-md-7" style="background: url('vista/img/contactenos.jpg');background-size: 100% 100%;padding: 10px;">
			
		</div>
		<div class="col-xs-12 col-md-5">
			<form id="form_contacto" style="margin: auto;padding: 10px;box-shadow: 0px 0px 10px #AAA;padding: 20px 10px 20px 10px;text-align: left;background: rgba(255,255,255,0.8);">
				<div class="form-group">
					<b>Nombre Completo (*)</b>
					<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombre">
				</div>
				<div class="form-group">
					<b>Telefono (*)</b>
					<input class="form-control" type="text" name="telefono" id="telefono" data-name="Telefono">
				</div>
				<div class="form-group">
					<b>E-mail (*)</b>
					<input class="form-control" type="text" name="email" id="email" data-name="Email">
				</div>
				<div class="form-group">
					<b>Mensaje (*)</b>
					<textarea class="form-control" rows="5" name="mensaje" id="mensaje" data-name="Mensaje"></textarea>
				</div>
				<hr>
				<div id="alerta_formulario_contacto" class="alert alert-danger" style="display: none;"></div>
				<button type="button" class="btn btn-primary btn-block" onclick="enviar_form_contacto()">
					<i class="fa fa-envelope"></i> Enviar
				</button>
			</form>
		</div>
	</div>
</div>