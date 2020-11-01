<?php
	require_once "../../controlador/con_mis_direcciones.php";
	require_once "../../modelo/mod_mis_direcciones.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'buscarCiudades':
				# BUSCAR CIUDADES PARA REGISTRO DE DIRECCION
				$id_dpto = $_POST['id_dpto'];

				$mis_direcciones = new MisDireccionesCon();
				$ciudades = $mis_direcciones -> listadoCiudadesCon($id_dpto);

				echo "<option value=''>-Seleccione</option>";

				foreach ($ciudades as $ciudad) 
				{
					echo "<option value='".$ciudad['id_ciudad']."'>".$ciudad['nombre']."</option>";					
				}

				break;

			case 'registrarDireccion':
				# REGISTRAR DIRECCION DE USUARIO
				$email 		= $_POST['email'];
				$direccion 	= strtoupper($_POST['direccion']);
				$barrio 	= strtoupper($_POST['barrio']);
				$indicaciones = strtoupper($_POST['indicaciones']);
				$id_dpto 	= $_POST['id_dpto'];
				$id_ciudad 	= $_POST['id_ciudad'];
				$telefono 	= $_POST['telefono'];

				$datosDireccion = array("email"		=> $email,
										"direccion"	=> $direccion,
										"barrio"	=> $barrio,
										"indicaciones" => $indicaciones,
										"id_dpto"	=> $id_dpto,
										"id_ciudad"	=> $id_ciudad,
										"telefono"	=> $telefono);

				$mis_direcciones = new MisDireccionesCon();
				$mis_direcciones -> registrarDireccionCon($datosDireccion);

				break;

			case 'actualizarDireccion':
				# ACTUALIZAR DIRECCION DE USUARIO
				$id_direccion 	= $_POST['id_direccion'];
				$email 			= $_POST['email'];
				$direccion 		= strtoupper($_POST['direccion']);
				$barrio 		= strtoupper($_POST['barrio']);
				$indicaciones 	= strtoupper($_POST['indicaciones']);
				$id_dpto 		= $_POST['id_dpto'];
				$id_ciudad 		= $_POST['id_ciudad'];
				$telefono 		= $_POST['telefono'];

				$datosDireccion = array("id_direccion" 	=> $id_direccion,
										"email"			=> $email,
										"direccion"		=> $direccion,
										"barrio"		=> $barrio,
										"indicaciones" 	=> $indicaciones,
										"id_dpto"		=> $id_dpto,
										"id_ciudad"		=> $id_ciudad,
										"telefono"		=> $telefono);

				$mis_direcciones = new MisDireccionesCon();
				$mis_direcciones -> actualizarDireccionCon($datosDireccion);
				break;

			case 'estadoDireccion':
				# ESTADO DE DIRECCION
				$estado 		= $_POST['estado'];
				$id_direccion 	= $_POST['id_direccion'];

				$datosDireccion = array("estado"		=> $estado,
										"id_direccion" 	=> $id_direccion);

				$mis_direcciones = new MisDireccionesCon();
				$mis_direcciones -> estadoDireccionCon($datosDireccion);

				break;
			
			default:
				print json_encode(array("estado" => "No hay respuesta"));
				break;
		}
	}
?>