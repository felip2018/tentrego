<div class="col-xs-12 col-md-12">
	<h4 class="alert alert-success">Registrarse</h4>
	<div class="row">
		<div class="col-xs-12 col-md-6" style="margin: auto;">
			<form id="form_registro_usuario" style="padding: 10px;box-shadow: 0px 0px 10px #AAA;padding: 20px 10px 20px 10px;text-align: left;background: rgba(255,255,255,0.8);">
				<div class="form-group">
					<b>Nombres (*)</b>
					<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombres">
				</div>
				<div class="form-group">
					<b>Apellidos (*)</b>
					<input class="form-control" type="text" name="apellido" id="apellido" data-name="Apellidos">
				</div>
				<div class="form-group">
					<b>Telefono (*)</b>
					<input class="form-control" type="number" min="0" name="telefono" id="telefono" data-name="Telefono">
				</div>
				<div class="form-group">
					<b>E-mail (*)</b>
					<input class="form-control" type="text" name="email" id="email" data-name="Email">
				</div>
				<div class="form-group">
					<b>Contraseña (*)</b>
					<input class="form-control" type="password" name="contrasena" id="contrasena" data-name="Contraseña">
				</div>
				<div class="form-group">
					<b>Repetir Contraseña (*)</b>
					<input class="form-control" type="password" name="repetir_contrasena" id="repetir_contrasena" data-name="Repetir Contraseña">
				</div>
				<div class="form-group">
					<table style="width: 100%;text-align: center;">
						<tr>
							<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="notificaciones" id="notificaciones" value="1"></td>
							<td style="width: 90%;"><b>Me gustaria recibir notificaciones de promociones via correo electrónico.</b></td>
						</tr>
					</table>			
				</div>
				<div class="form-group">
					<table style="width: 100%;text-align: center;">
						<tr>
							<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="terminos_condiciones" id="terminos_condiciones" value="1"></td>
							<td style="width: 90%;"><b>Acepto los términos y condiciones y la Política de Privacidad y Tratamiento de Datos Personales.</b></td>
						</tr>
					</table>			
				</div>
				<hr>

				<div id="alerta_formulario" class="alert alert-danger" style="display: none;"></div>
				<button title="Registrarse" type="button" class="btn btn-primary btn-block" onclick="validar_form_registro()">Registrarse</button>
			</form>
			<br>
			<a href="terminos">Términos y condiciones</a>|<a href="politicas">Políticas de Privacidad.</a>	
		</div>
		<div class="col-xs-12 col-md-6" style="background: url('vista/img/registrarse.jpg');background-size: 100% 100%;padding: 10px;"></div>
		<!--<div class="col-xs-12 col-md-6">
			<img src="vista/img/registrarse.jpg" alt="Registrarse" width="100%" height="auto">
		</div>-->
	</div>
</div>