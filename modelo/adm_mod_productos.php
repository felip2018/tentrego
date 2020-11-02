<?php
	require_once "conexion.php";
	/**
	* MODELO DE PRODUCTOS
	*/
	class ProductosMod extends Conexion
	{
		#	CONSULTAR EL LISTADO DE CATEGORIAS
		public static function listaCategoriasMod()
		{
			$categorias = Conexion::conectar()->prepare("SELECT * FROM categorias WHERE estado = 'Activo' ORDER BY nombre ASC");
			$categorias -> execute();
			$listado 	=  $categorias -> fetchAll();
			return $listado;
		}

		#	CONSULTAR LISTA DE CLASIFICACION POR CATEGORIA SELECCIONADA
		public static function listaClasificacionMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare(" SELECT * 
														FROM 	clasificacion 
														WHERE 	id_categoria 	= :id_categoria
														AND 	estado 			= 'Activo'
														ORDER BY nombre ASC");
			$consulta -> bindParam(":id_categoria", $id_categoria,	PDO::PARAM_INT);
			$consulta -> execute();
			$clasificaciones = $consulta -> fetchAll();
			if (sizeof($clasificaciones) > 0) 
			{
				$resultado = json_encode(array("estado" => "ok", "data" => $clasificaciones));
			}
			else
			{
				$resultado = json_encode(array("estado" => "vacio"));
			}
			return $resultado;
		}

		#	CONSULTAR LISTA DE CLASIFICACION POR CATEGORIA SELECCIONADA
		public static function listadoClasificacionMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare(" SELECT * 
														FROM 	clasificacion 
														WHERE 	id_categoria 	= :id_categoria
														AND 	estado 			= 'Activo'
														ORDER BY nombre ASC");
			$consulta -> bindParam(":id_categoria", $id_categoria,	PDO::PARAM_INT);
			$consulta -> execute();
			$clasificaciones = $consulta -> fetchAll();
			
			return $clasificaciones;
		}

		#	CONSULTAR EL LISTADO DE MARCAS
		public static function listaMarcasMod()
		{
			$marcas = Conexion::conectar()->prepare("SELECT * 
													FROM marcas 
													WHERE estado = 'Activo' 
													ORDER BY nombre ASC");
			$marcas -> execute();
			$listado 	=  $marcas -> fetchAll();
			return $listado;
		}

		#	CONSULTAR EL LISTADO DE UNIDADES DE MEDIDA
		public static function listaUnidadesMod()
		{
			$unidades = Conexion::conectar()->prepare(" SELECT * 
														FROM unidades 
														WHERE estado = 'Activo' 
														ORDER BY id_unidad ASC");
			$unidades -> execute();
			$listado 	=  $unidades -> fetchAll();
			return $listado;
		}

		#	CONSULTAR EL LISTADO DE ATRIBUTOS REGISTRADOS
		public static function listaAtributosMod()
		{
			$atributos = Conexion::conectar()->prepare("SELECT * 
														FROM atributos 
														WHERE estado = 'Activo' 
														ORDER BY nombre ASC");
			$atributos -> execute();
			$listado =  $atributos -> fetchAll();
			return $listado;
		}

		#	CONSULTAR LISTA DE ATRIBUTOS REGISTRADOS POR PRODUCTO SELECCIONADO
		public static function listaAtributosRegistradosMod($id_producto)
		{
			$atributos = Conexion::conectar()->prepare("SELECT
														producto_atributo.id_producto,
														producto_atributo.id_atributo,
														producto_atributo.valor,
														producto_atributo.estado,
														atributos.nombre
														FROM producto_atributo 
														INNER JOIN atributos ON atributos.id_atributo = producto_atributo.id_atributo
														WHERE 		producto_atributo.id_producto = :id_producto
														AND 		producto_atributo.estado 		= 'Activo' 
														ORDER BY 	producto_atributo.id_atributo ASC");
			$atributos -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
			$atributos -> execute();
			$listado =  $atributos -> fetchAll();
			return $listado;
		}

		#	CONSULTAR LISTA DE ATRIBUTOS PENDIENTES DE ASIGNAR AL PRODUCTO SELECCIONADO
		public static function listaAtributosPendientesMod($id_producto)
		{
			$atributos = Conexion::conectar()->prepare("SELECT * 
														FROM atributos 
														WHERE id_atributo NOT IN(SELECT id_atributo
															FROM producto_atributo
															WHERE id_producto = :id_producto
															AND estado = 'Activo')
														AND estado = 'Activo' 
														ORDER BY nombre ASC");
			$atributos -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
			$atributos -> execute();
			$listado =  $atributos -> fetchAll();
			return $listado;
		}

		#	REGISTRAR PRODUCTO EN EL SISTEMA
		public static function registrarProductoMod($datosProducto)
		{
			$nombre 			= $datosProducto['nombre'];
			$id_marca 			= $datosProducto['id_marca'];
			$id_categoria 		= $datosProducto['id_categoria'];
			$id_clasificacion 	= $datosProducto['id_clasificacion'];
			$cantidad 			= $datosProducto['cantidad'];
			$id_unidad 			= $datosProducto['id_unidad'];
			$descripcion 		= $datosProducto['descripcion'];
			$costo 				= $datosProducto['costo'];
			$utilidad 			= $datosProducto['utilidad'];
			$venta 				= $datosProducto['venta'];
			$atributos 			= $datosProducto['atributos'];

			//return $datosProducto;

			#	CONSULTAMOS EL CONSECUTIVO DE LA TABLA: producto
			$consulta = Conexion::conectar()->prepare("SELECT MAX(id_producto) id_producto FROM producto");
			$consulta -> execute();
			$maximo = $consulta ->fetch();

			$id_producto 	= ($maximo['id_producto'] == null) ? 1 : $maximo['id_producto'] + 1;

			if ($_FILES['imagen']['name'] != "") 
			{
				if ($_FILES['imagen']['type'] == "image/png" ||
					$_FILES['imagen']['type'] == "image/jpg" ||
					$_FILES['imagen']['type'] == "image/jpeg") 
				{
					#	CARGAR IMAGEN AL SERVIDOR 
					$ruta = "../modulos/productos/imagenes/";
					opendir($ruta);
					$destino = $ruta.$_FILES['imagen']['name'];
					copy($_FILES['imagen']['tmp_name'],$destino);	
					$imagen = $_FILES['imagen']['name'];				
				}
			}
			else
			{
				$imagen = "";
			}

			$fecha 	= date('Y-m-d');
			$estado = "Activo";

			#	REGISTRAMOS EL PRODUCTO
			$insert = Conexion::conectar()->prepare("INSERT INTO producto(id_producto, id_categoria, id_clasificacion, id_marca, nombre, cantidad, id_unidad, imagen, descripcion, costo, utilidad, venta, fecha, estado) VALUES (:id_producto, :id_categoria, :id_clasificacion, :id_marca, :nombre, :cantidad, :id_unidad, :imagen, :descripcion, :costo, :utilidad, :venta, :fecha, :estado)");

			$insert -> bindParam(":id_producto", 		$id_producto, 		PDO::PARAM_INT);
			$insert -> bindParam(":id_categoria", 		$id_categoria, 		PDO::PARAM_INT);
			$insert -> bindParam(":id_clasificacion", 	$id_clasificacion, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_marca", 			$id_marca, 			PDO::PARAM_INT);
			$insert -> bindParam(":nombre", 			$nombre, 			PDO::PARAM_STR);
			$insert -> bindParam(":cantidad", 			$cantidad, 			PDO::PARAM_INT);
			$insert -> bindParam(":id_unidad", 			$id_unidad, 		PDO::PARAM_INT);
			$insert -> bindParam(":imagen", 			$imagen, 			PDO::PARAM_STR);
			$insert -> bindParam(":descripcion", 		$descripcion, 		PDO::PARAM_STR);
			$insert -> bindParam(":costo", 				$costo, 			PDO::PARAM_INT);
			$insert -> bindParam(":utilidad", 			$utilidad, 			PDO::PARAM_INT);
			$insert -> bindParam(":venta", 				$venta, 			PDO::PARAM_INT);
			$insert -> bindParam(":fecha", 				$fecha, 			PDO::PARAM_STR);
			$insert -> bindParam(":estado", 			$estado, 			PDO::PARAM_STR);

			

			if ($insert -> execute()) 
			{
				# 	SE HA REGISTRADO EL PRODUCTO

				if (!empty($atributos)) 
				{
					# REGISTRAR ATRIBUTOS DEL PRODUCTO
					foreach ($atributos as $attr) 
					{
						#	CONSULTA SI EL ATRIBUTO NO ESTA REGISTRADO PARA EL PRODUCTO
						$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant 
																FROM producto_atributo
																WHERE id_producto = :id_producto
																AND id_atributo = :id_atributo");
						$existe -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
						$existe -> bindParam(":id_atributo", $attr['id_atributo'], PDO::PARAM_INT);
						$existe -> execute();
						$validacion = $existe -> fetch();

						if ($validacion['cant'] == 0) 
						{
							# INSERTAMOS EL ATRIBUTO DEL PRODUCTO
							$insert = Conexion::conectar()->prepare("INSERT INTO producto_atributo(id_producto, id_atributo, valor, estado) VALUES (:id_producto, :id_atributo, :valor, :estado)");

							$insert -> bindParam(":id_producto", 	$id_producto, 			PDO::PARAM_INT);
							$insert -> bindParam(":id_atributo", 	$attr['id_atributo'], 	PDO::PARAM_INT);
							$insert -> bindParam(":valor", 			$attr['valor'], 		PDO::PARAM_STR);
							$insert -> bindParam(":estado", 		$estado, 				PDO::PARAM_STR);

							$insert -> execute();

						}

					}
				}

				$respuesta = json_encode(array("estado" => "registrado"));
			}
			else
			{
				#	NO SE HA PODIDO REGISTRAR EL PRODUCTO
				$respuesta = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
			}
			return $respuesta;
		}

		#	CONSULTAR LISTADO DE PRODUCTOS REGISTRADOS
		public static function listaProductosMod()
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.costo,
														producto.utilidad,
														producto.venta,
														producto.fecha,
														producto.estado,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														unidades.nombre unidad,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.estado estado_promocion
														FROM producto 
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN unidades ON unidades.id_unidad = unidades.id_unidad
														LEFT JOIN promociones ON promociones.id_producto = producto.id_producto
														AND promociones.estado = 'Activo'
														GROUP BY producto.id_producto
														ORDER BY nombre");
			$consulta -> execute();
			$listado = $consulta ->fetchAll();
			return $listado;
		}

		#	CONSULTAR INFORMACION REGISTRADA DE UN PRODUCTO SELECCIONADO
		public static function infoProductoMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * FROM producto WHERE id_producto = :id_producto");
			$consulta -> bindParam(":id_producto",	$id_producto, 	PDO::PARAM_INT);
			$consulta -> execute();
			$info = $consulta -> fetch();
			return $info; 
		}

		#	ACTUALIZAR INFORMACION DE PRODUCTO SELECCIONADO
		public static function actualizarProductoMod($datosProducto)
		{
			//$respuesta = json_encode($datosProducto);
			//return $respuesta;
			$id_producto 		= $datosProducto['id_producto'];
			$nombre 			= $datosProducto['nombre'];
			$id_marca 			= $datosProducto['id_marca'];
			$id_categoria 		= $datosProducto['id_categoria'];
			$id_clasificacion 	= $datosProducto['id_clasificacion'];
			$cantidad 			= $datosProducto['cantidad'];
			$id_unidad 			= $datosProducto['id_unidad'];
			$descripcion 		= $datosProducto['descripcion'];
			$costo 				= $datosProducto['costo'];
			$utilidad 			= $datosProducto['utilidad'];
			$venta 				= $datosProducto['venta'];
			$atributos 			= $datosProducto['atributos'];
			$estado 			= "Activo";

			if ($_FILES['imagen']['name'] != "") 
			{
				if ($_FILES['imagen']['type'] == "image/png" ||
					$_FILES['imagen']['type'] == "image/jpg" ||
					$_FILES['imagen']['type'] == "image/jpeg") 
				{
					#	CARGAR IMAGEN AL SERVIDOR
					$ruta = "../modulos/productos/imagenes/";
					opendir($ruta);
					$destino = $ruta.$_FILES['imagen']['name'];
					copy($_FILES['imagen']['tmp_name'],$destino);	
					$imagen = $_FILES['imagen']['name'];	

					#	ACTUALIZAR INFORMACION DE PRODUCTO JUNTO CON LA IMAGEN
					$update = Conexion::conectar()->prepare("UPDATE producto
															 SET 	nombre 				= :nombre,
																	id_marca 			= :id_marca,
																	id_categoria 		= :id_categoria,
																	id_clasificacion	= :id_clasificacion,
																	cantidad 			= :cantidad,
																	id_unidad 			= :id_unidad,
																	imagen 				= :imagen,
																	descripcion 		= :descripcion,
																	costo 				= :costo,
																	utilidad 			= :utilidad,
																	venta 				= :venta
															 WHERE 	id_producto 		= :id_producto");

					$update -> bindParam(":nombre", 			$nombre, 			PDO::PARAM_STR);
					$update -> bindParam(":id_marca", 			$id_marca, 			PDO::PARAM_INT);
					$update -> bindParam(":id_categoria", 		$id_categoria, 		PDO::PARAM_INT);
					$update -> bindParam(":id_clasificacion", 	$id_clasificacion, 	PDO::PARAM_INT);
					$update -> bindParam(":cantidad", 			$cantidad, 			PDO::PARAM_INT);
					$update -> bindParam(":id_unidad", 			$id_unidad, 		PDO::PARAM_INT);
					$update -> bindParam(":imagen", 			$imagen, 			PDO::PARAM_STR);
					$update -> bindParam(":descripcion", 		$descripcion, 		PDO::PARAM_STR);
					$update -> bindParam(":costo", 				$costo, 			PDO::PARAM_INT);
					$update -> bindParam(":utilidad", 			$utilidad, 			PDO::PARAM_INT);
					$update -> bindParam(":venta", 				$venta, 			PDO::PARAM_INT);
					$update -> bindParam(":id_producto", 		$id_producto, 		PDO::PARAM_INT);

					if ($update -> execute()) 
					{
						# SE HA ACTUALIZADO CORRECTAMENTE LA INFORMACION DEL PRODUCTO

						if (!empty($atributos)) 
						{
							# ACTUALIZAR ATRIBUTOS DEL PRODUCTO
							foreach ($atributos as $attr) 
							{
								#	CONSULTA SI EL ATRIBUTO NO ESTA REGISTRADO PARA EL PRODUCTO
								$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant 
																		FROM producto_atributo
																		WHERE id_producto = :id_producto
																		AND id_atributo = :id_atributo");
								$existe -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
								$existe -> bindParam(":id_atributo", $attr['id_atributo'], PDO::PARAM_INT);
								$existe -> execute();
								$validacion = $existe -> fetch();

								if ($validacion['cant'] == 0) 
								{
									# INSERTAMOS EL ATRIBUTO DEL PRODUCTO
									$insert = Conexion::conectar()->prepare("INSERT INTO producto_atributo(id_producto, id_atributo, valor, estado) VALUES (:id_producto, :id_atributo, :valor, :estado)");

									$insert -> bindParam(":id_producto", $id_producto, 		  PDO::PARAM_INT);
									$insert -> bindParam(":id_atributo", $attr['id_atributo'],PDO::PARAM_INT);
									$insert -> bindParam(":valor", 		 $attr['valor'], 	  PDO::PARAM_STR);
									$insert -> bindParam(":estado", 	 $estado, 			  PDO::PARAM_STR);

									$insert -> execute();

								}
								else
								{
									# ACTUALIZAMOS EL ATRIBUTO DEL PRODUCTO
									$update = Conexion::conectar()->prepare("UPDATE producto_atributo
																			SET  	valor 		= :valor,
																					estado 		= 'Activo'
																			WHERE 	id_producto = :id_producto
																			AND 	id_atributo = :id_atributo");

									$update -> bindParam(":id_producto", $id_producto, 		  PDO::PARAM_INT);
									$update -> bindParam(":id_atributo", $attr['id_atributo'],PDO::PARAM_INT);
									$update -> bindParam(":valor", 		 $attr['valor'], 	  PDO::PARAM_STR);

									$update -> execute();
								}

							}
						}

						$respuesta = json_encode(array("estado" => "actualizado"));
						return $respuesta;	
					}
					else
					{
						# HA OCURRIDO UN ERROR
						$respuesta = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
						return $respuesta;
					}

				}
				else
				{
					$respuesta = json_encode(array("estado" => "error", "data" => "Formato de imagen invalido."));
					return $respuesta;
				}
			}
			else
			{
				#	ACTUALIZAR INFORMACION DE PRODUCTO SIN LA IMAGEN
				$update = Conexion::conectar()->prepare("UPDATE producto
														 SET 	nombre 				= :nombre,
																id_marca 			= :id_marca,
																id_categoria 		= :id_categoria,
																id_clasificacion	= :id_clasificacion,
																cantidad 			= :cantidad,
																id_unidad 			= :id_unidad,
																descripcion			= :descripcion,
																costo 				= :costo,
																utilidad 			= :utilidad,
																venta 				= :venta
														 WHERE 	id_producto 		= :id_producto");

				$update -> bindParam(":nombre", 			$nombre, 			PDO::PARAM_STR);
				$update -> bindParam(":id_marca", 			$id_marca, 			PDO::PARAM_INT);
				$update -> bindParam(":id_categoria", 		$id_categoria, 		PDO::PARAM_INT);
				$update -> bindParam(":id_clasificacion", 	$id_clasificacion, 	PDO::PARAM_INT);
				$update -> bindParam(":cantidad", 			$cantidad, 			PDO::PARAM_INT);
				$update -> bindParam(":id_unidad", 			$id_unidad, 		PDO::PARAM_INT);
				$update -> bindParam(":descripcion", 		$descripcion, 		PDO::PARAM_STR);
				$update -> bindParam(":costo", 				$costo, 			PDO::PARAM_INT);
				$update -> bindParam(":utilidad", 			$utilidad, 			PDO::PARAM_INT);
				$update -> bindParam(":venta", 				$venta, 			PDO::PARAM_INT);
				$update -> bindParam(":id_producto", 		$id_producto, 		PDO::PARAM_INT);

				if ($update -> execute()) 
				{
					# SE HA ACTUALIZADO CORRECTAMENTE LA INFORMACION DEL PRODUCTO
					if (!empty($atributos)) 
					{
						# ACTUALIZAR ATRIBUTOS DEL PRODUCTO
						foreach ($atributos as $attr) 
						{
							#	CONSULTA SI EL ATRIBUTO NO ESTA REGISTRADO PARA EL PRODUCTO
							$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant 
																	FROM producto_atributo
																	WHERE id_producto = :id_producto
																	AND id_atributo = :id_atributo");
							$existe -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
							$existe -> bindParam(":id_atributo", $attr['id_atributo'], PDO::PARAM_INT);
							$existe -> execute();
							$validacion = $existe -> fetch();

							if ($validacion['cant'] == 0) 
							{
								# INSERTAMOS EL ATRIBUTO DEL PRODUCTO
								$insert = Conexion::conectar()->prepare("INSERT INTO producto_atributo(id_producto, id_atributo, valor, estado) VALUES (:id_producto, :id_atributo, :valor, :estado)");

								$insert -> bindParam(":id_producto", $id_producto, 		  PDO::PARAM_INT);
								$insert -> bindParam(":id_atributo", $attr['id_atributo'],PDO::PARAM_INT);
								$insert -> bindParam(":valor", 		 $attr['valor'], 	  PDO::PARAM_STR);
								$insert -> bindParam(":estado", 	 $estado, 			  PDO::PARAM_STR);

								$insert -> execute();

							}
							else
							{
								# ACTUALIZAMOS EL ATRIBUTO DEL PRODUCTO
								$update = Conexion::conectar()->prepare("UPDATE producto_atributo
																		SET  	valor 		= :valor,
																				estado 		= 'Activo'
																		WHERE 	id_producto = :id_producto
																		AND 	id_atributo = :id_atributo");

								$update -> bindParam(":id_producto", $id_producto, 		  PDO::PARAM_INT);
								$update -> bindParam(":id_atributo", $attr['id_atributo'],PDO::PARAM_INT);
								$update -> bindParam(":valor", 		 $attr['valor'], 	  PDO::PARAM_STR);

								$update -> execute();
							}

						}
					}

					$respuesta = json_encode(array("estado" => "actualizado"));
					return $respuesta;	
				}
				else
				{
					# HA OCURRIDO UN ERROR
					$respuesta = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
					return $respuesta;
				}

			}

		}

		#	ACTUALIZAR EL ESTADO DEL PRODUCTO SELECCIONADO
		public static function estadoProductoMod($datosProducto)
		{
			$id_producto 	= $datosProducto['id_producto'];
			$estado 		= $datosProducto['estado'];

			$update = Conexion::conectar()->prepare("	UPDATE 	producto
														SET 	estado 	= :estado
														WHERE 	id_producto = :id_producto");

			$update -> bindParam(":estado", 	$estado, 		PDO::PARAM_STR);
			$update -> bindParam(":id_producto",$id_producto, 	PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$respuesta = json_encode(array("estado" => "ok"));
			}
			else
			{
				$respuesta = json_encode(array("estado" => "ok", "data" => $update->errorInfo()));
			}
			return $respuesta;

		}

		#	SELECCIONAR PRODUCTOS POR CATEGORIA SELECCIONADA
		public static function filtroProductosMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.costo,
														producto.utilidad,
														producto.venta,
														producto.fecha,
														producto.estado,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														unidades.nombre unidad,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.estado estado_promocion
														FROM producto 
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN unidades ON unidades.id_unidad = unidades.id_unidad
														LEFT JOIN promociones ON promociones.id_producto = producto.id_producto
														AND promociones.estado = 'Activo'
														WHERE producto.id_categoria = :id_categoria
														GROUP BY producto.id_producto
														ORDER BY nombre");
			$consulta -> bindParam(":id_categoria",	$id_categoria, PDO::PARAM_INT);
			$consulta -> execute();
			$resultado = $consulta -> fetchAll();
			return $resultado;
		}

		#	INACTIVAR EL ATRIBUTO DE UN PRODUCTO
		public static function estadoAtributoMod($datosAtributo)
		{
			$id_atributo = $datosAtributo['id_atributo'];
			$id_producto = $datosAtributo['id_producto'];

			$update = Conexion::conectar()->prepare("UPDATE producto_atributo
													SET 	estado 		= 'Inactivo'
													WHERE 	id_producto	= :id_producto
													AND 	id_atributo = :id_atributo");

			$update -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
			$update -> bindParam(":id_atributo", $id_atributo, PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "ok"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}
			return $resultado;
		}

		#	CONSULTAR IMAGENES DE PRODUCTO REGISTRADAS
		public static function imagenesProductoMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM 	producto_imagenes
														WHERE 	id_producto = :id_producto
														AND 	estado IN ('Activo','Inactivo')");

			$consulta -> bindParam(":id_producto",	$id_producto,	PDO::PARAM_INT);

			$consulta -> execute();

			$imagenes = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			return $imagenes;

		}

		#	CARGAR ARCHIVO DE IMAGEN DE PRODUCTO AL SERVIDOR
		public static function subirImagenMod($id_producto)
		{
			# 	EVALUAMOS SI HAY UN ARCHIVO POR CARGAR
			if ($_FILES['imagen']['name'] != "") 
			{
				if ($_FILES['imagen']['type'] == "image/png" ||
					$_FILES['imagen']['type'] == "image/jpg" ||
					$_FILES['imagen']['type'] == "image/jpeg") 
				{
					#	CARGAR IMAGEN AL SERVIDOR 
					$ruta = "../modulos/productos/imagenes/";
					opendir($ruta);
					$destino = $ruta.$_FILES['imagen']['name'];
					copy($_FILES['imagen']['tmp_name'],$destino);	
					
					$imagen = $_FILES['imagen']['name'];	
					$fecha 	= date("Y-m-d");
					$estado = "Activo";

					#	CONSULTAMOS SI LA IMAGEN YA SE ENCUENTRA SUBIDA EN LA BASE DE DATOS
					$consulta = Conexion::conectar()->prepare("SELECT COUNT(*) cant
																FROM 	producto_imagenes
																WHERE 	imagen 		= :imagen
																AND 	id_producto = :id_producto
																AND 	estado 		IN ('Activo','Inactivo')");

					$consulta -> bindParam(":imagen",	$imagen,	PDO::PARAM_STR);
					$consulta -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

					$consulta -> execute();

					$cantidad = $consulta -> fetch(PDO::FETCH_ASSOC);

					if ($cantidad['cant'] == 0) 
					{
						# REGISTRAR LA IMAGEN
						$insert = Conexion::conectar()->prepare("INSERT INTO producto_imagenes(id_imagen, id_producto, imagen, fecha, estado) VALUES (null, :id_producto, :imagen, :fecha, :estado)");

						$insert -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
						$insert -> bindParam(":imagen", 		$imagen, 		PDO::PARAM_STR);
						$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
						$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

						if ($insert -> execute()) 
						{
							# REGISTRO EXISTOSO
							$respuesta = json_encode(array("estado" => "success"));
						}
						else
						{
							$respuesta = json_encode(array("estado" => "error","data" => $insert->errorInfo()));
						}
					}
					else
					{
						# LA IMAGEN YA ESTA CARGADA
						$respuesta = json_encode(array("estado" => "error","data" => "La imagen seleccionada ya se encuentra registrada en el sistema"));
					}

				}
				else
				{
					$respuesta = json_encode(array("estado" => "error","data" => "El formato del archivo seleccionado es invalido, formatos permitidos (.png, .jpg, .jpeg)"));		
				}
			}
			else
			{
				$respuesta = json_encode(array("estado" => "error", "data" => "Seleccione una imagen para cargar, formatos permitidos (.png, .jpg, .jpeg)"));
			}

			return $respuesta;
		}

		#	CAMBIAR ESTADO DE IMAGEN
		public static function estadoImagenMod($datosImagen)
		{
			$estado 		= $datosImagen['estado'];
			$id_producto 	= $datosImagen['id_producto'];
			$id_imagen 		= $datosImagen['id_imagen'];

			if ($estado == "Eliminar") 
			{
				# CONSULTAMOS EL ESTADO DEL REGISTRO, SI ESTA ACTIVO NO SE PUEDE ELIMINAR LA IMAGEN
				$consulta = Conexion::conectar()->prepare("SELECT 	estado,
																	imagen
															FROM 	producto_imagenes
															WHERE 	id_imagen 	= :id_imagen
															AND 	id_producto = :id_producto");

				$consulta -> bindParam(":id_imagen", 	$id_imagen, 	PDO::PARAM_INT);
				$consulta -> bindParam(":id_producto",$id_producto, 	PDO::PARAM_INT);

				$consulta -> execute();

				$validar = $consulta -> fetch(PDO::FETCH_ASSOC);

				if ($validar['estado'] == "Activo") 
				{
					# NO SE PUEDE ELIMINAR LA IMAGEN YA QUE ESTA SIENDO USADA
					$respuesta = json_encode(array("estado" => "error", "data" => "No es posible eliminar la imagen, ya que esta en uso."));
				}
				else
				{
					$filename = "../modulos/productos/imagenes/".$validar['imagen'];
					# SE PROCEDE A ELIMINAR LA IMAGEN DEL SERVIDOR
					if (is_file($filename)) 
					{
						if (unlink($filename)) 
						{
							
							$update = Conexion::conectar()->prepare("UPDATE 	producto_imagenes
																	SET			estado 		= :estado
																	WHERE		id_imagen	= :id_imagen
																	AND 		id_producto = :id_producto");

							$update -> bindParam(":estado", 	$estado, 		PDO::PARAM_STR);
							$update -> bindParam(":id_imagen", 	$id_imagen, 	PDO::PARAM_INT);
							$update -> bindParam(":id_producto",$id_producto, 	PDO::PARAM_INT);

							if ($update->execute()) 
							{
								$respuesta = json_encode(array("estado" => "success"));
							}
							else
							{
								$respuesta = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
							}
						}
						else
						{
							$respuesta = json_encode(array("estado" => "error", "data" => "No se ha podido eliminar la imagen"));
						}
					}
					else
					{
						$respuesta = json_encode(array("estado" => "error", "data" => "El archivo indicado no existe."));
					}
				}
				return $respuesta;
			}
			else
			{
				$update = Conexion::conectar()->prepare("UPDATE 	producto_imagenes
															SET		estado 		= :estado
														  WHERE		id_imagen	= :id_imagen
														  AND 		id_producto = :id_producto");

				$update -> bindParam(":estado", 	$estado, 		PDO::PARAM_STR);
				$update -> bindParam(":id_imagen", 	$id_imagen, 	PDO::PARAM_INT);
				$update -> bindParam(":id_producto",$id_producto, 	PDO::PARAM_INT);

				if ($update->execute()) 
				{
					$respuesta = json_encode(array("estado" => "success"));
				}
				else
				{
					$respuesta = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				}
				return $respuesta;
			}
		}

		#	REGISTRAR PROMOCION DE VENTA DE PRODUCTO INDICADO
		public static function crearPromocionMod($datosPromocion)
		{
			$id_producto 	= $datosPromocion['id_producto'];
			$venta 			= $datosPromocion['venta'];
			$dcto 			= $datosPromocion['dcto'];
			$precio_promo 	= $datosPromocion['precio'];
			$fecha 			= date('Y-m-d');
			$estado 		= 'Activo';

			#	CONSULTAMOS SI HAY UN REGISTRO DE PROMOCION DE ESTE PRODUCTO ACTIVO PARA ACTUALIZARLO
			$consulta = Conexion::conectar()->prepare("	SELECT 	COUNT(*) cant
														FROM 	promociones
														WHERE 	id_producto = :id_producto
														AND 	estado 		= 'Activo'");
			$consulta -> bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
			$consulta -> execute();
			$con = $consulta -> fetch(PDO::FETCH_ASSOC);

			if ($con['cant'] == 0) 
			{
				# PROCEDEMOS A REGISTRAR LA PROMOCION DE EL PRODUCTO
				$insert = Conexion::conectar()->prepare("INSERT INTO promociones(id_promocion, id_producto, venta, dcto, precio_promo, fecha, estado) VALUES (null, :id_producto, :venta, :dcto, :precio_promo, :fecha, :estado)");

				$insert -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
				$insert -> bindParam(":venta", 			$venta, 		PDO::PARAM_INT);
				$insert -> bindParam(":dcto", 			$dcto, 			PDO::PARAM_INT);
				$insert -> bindParam(":precio_promo", 	$precio_promo, 	PDO::PARAM_INT);
				$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
				$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

				if ($insert -> execute()) 
				{
					# SE HA REGISTRADO LA PROMOCION CORRECTAMENTE
					$resultado = json_encode(array("estado" => "success"));
				}
				else
				{
					# HA OCURRIDO UN ERROR
					$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
				}
				return $resultado;
			}
			else
			{
				# PROCEDEMOS A ACTUALIZAR EL REGISTRO DE LA PROMOCION
				$update = Conexion::conectar()->prepare("	UPDATE 	promociones
															SET 	venta 			= :venta,
																	dcto 			= :dcto,
																	precio_promo 	= :precio_promo
															WHERE 	id_producto 	= :id_producto
															AND 	estado 			= 'Activo'");

				$update -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
				$update -> bindParam(":venta", 			$venta, 		PDO::PARAM_INT);
				$update -> bindParam(":dcto", 			$dcto, 			PDO::PARAM_INT);
				$update -> bindParam(":precio_promo", 	$precio_promo, 	PDO::PARAM_INT);

				if ($update -> execute()) 
				{
					# SE HA REGISTRADO LA PROMOCION CORRECTAMENTE
					$resultado = json_encode(array("estado" => "success"));
				}
				else
				{
					# HA OCURRIDO UN ERROR
					$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				}
				return $resultado;
			}

		}

	}