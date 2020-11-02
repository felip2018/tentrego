<?php
	require_once "../../../controlador/adm/con_productos.php";
	require_once "../../../modelo/adm/mod_productos.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'buscarClasificacion':
				# BUSCAR LISTA DE CLASIFICACION POR CATEGORIA
				$id_categoria 	= $_POST['id_categoria'];

				$producto = new ProductosCon();
				$producto -> listaClasificacionCon($id_categoria);

				break;

			case 'registrar':
				# REGISTRAR PRODUCTO EN EL SISTEMA
				$nombre 			= strtoupper($_POST['nombre']);
				$id_marca 			= $_POST['id_marca'];
				$id_categoria 		= $_POST['id_categoria'];
				$id_clasificacion 	= $_POST['id_clasificacion'];
				$cantidad 			= $_POST['cantidad'];
				$id_unidad 			= $_POST['id_unidad'];
				$costo 				= $_POST['costo'];
				$utilidad 			= $_POST['utilidad'];
				$venta 				= $_POST['venta'];
				$descripcion 		= strtoupper($_POST['descripcion']);

				$atributos = array();

				if (isset($_POST['atributos'])) 
				{
					$i = 0;
					foreach ($_POST['atributos'] as $id_atributo) 
					{
						$pos = 'attr_'.$id_atributo;
						$atributos[$i]['id_atributo'] 	= $id_atributo;
						$atributos[$i]['valor']			= strtoupper($_POST[$pos]);
						$i = $i + 1;
					}
				}

				$datosProducto = array(	"nombre"			=> $nombre,
										"id_marca"			=> $id_marca,
										"id_categoria"		=> $id_categoria,
										"id_clasificacion"	=> $id_clasificacion,
										"cantidad"			=> $cantidad,
										"id_unidad"			=> $id_unidad,
										"descripcion"		=> $descripcion,
										"costo"				=> $costo,
										"utilidad"			=> $utilidad,
										"venta"				=> $venta,
										"atributos"			=> $atributos);

				$producto = new ProductosCon();
				$producto -> registrarProductoCon($datosProducto);


				break;

			case 'actualizar':
				# ACTUALIZAR INFORMACION DE PRODUCTO SELECCIONADO
				$id_producto 		= $_POST['id_producto'];
				$nombre 			= $_POST['nombre'];
				$id_marca 			= $_POST['id_marca'];
				$id_categoria 		= $_POST['id_categoria'];
				$id_clasificacion 	= $_POST['id_clasificacion'];
				$cantidad 			= $_POST['cantidad'];
				$id_unidad 			= $_POST['id_unidad'];
				$costo 				= $_POST['costo'];
				$utilidad 			= $_POST['utilidad'];
				$venta 				= $_POST['venta'];
				$descripcion 		= strtoupper($_POST['descripcion']);

				$atributos 			= array();

				if (isset($_POST['atributos'])) 
				{
					$i = 0;
					foreach ($_POST['atributos'] as $id_atributo) 
					{
						$pos = 'attr_'.$id_atributo;
						$atributos[$i]['id_atributo'] 	= $id_atributo;
						$atributos[$i]['valor']			= strtoupper($_POST[$pos]);
						$i = $i + 1;
					}
				}

				$datosProducto 	= array("id_producto" 		=> $id_producto,
										"nombre" 			=> $nombre,
										"id_marca" 			=> $id_marca,
										"id_categoria" 		=> $id_categoria,
										"id_clasificacion" 	=> $id_clasificacion,
										"cantidad" 			=> $cantidad,
										"id_unidad" 		=> $id_unidad,
										"descripcion"		=> $descripcion,
										"costo" 			=> $costo,
										"utilidad" 			=> $utilidad,
										"venta" 			=> $venta,
										"atributos"			=> $atributos);

				$producto = new ProductosCon();
				$producto -> actualizarProductoCon($datosProducto);

				break;

			case 'estado':
				# CAMBIAR ESTADO DE PRODUCTO SELECCIONADO
				$estado 		= $_POST['estado'];
				$id_producto 	= $_POST['id_producto'];

				$datosProducto 	= array("id_producto"	=> $id_producto,
										"estado"		=> $estado);

				$producto = new ProductosCon();
				$producto -> estadoProductoCon($datosProducto);

				break;

			case 'filtro':
				# FILTRO DE PRODUCTOS POR CATEGORIA SELECCIONADA
				$id_categoria = $_POST['id_categoria'];
				$producto = new ProductosCon();
				$producto -> filtroProductosCon($id_categoria);
				break;

			case 'estado_atributo':
				# CAMBIAR ESTADO DE ATRIBUTO DE PRODUCTO
				$id_atributo = $_POST['id_atributo'];
				$id_producto = $_POST['id_producto'];

				$datosAtributo = array(	"id_atributo"	=> $id_atributo,
										"id_producto"	=> $id_producto);

				$producto = new ProductosCon();
				$producto -> estadoAtributoCon($datosAtributo);

				break;

			case 'subir_imagen':
				# CARGAR IMAGEN DE PRODUCTO AL SERVIDOR
					
				$id_producto = $_POST['id_producto'];

				$producto  = new ProductosCon();
				$producto -> subirImagenCon($id_producto);

				break;
				
			case 'estado_imagen':
				# CAMBIAR ESTADO DE IMAGEN DE LA GALERIA DE IMAGENES DE UN PRODUCTO
				$estado 		= $_POST['estado'];
				$id_producto 	= $_POST['id_producto'];
				$id_imagen 		= $_POST['id_imagen'];

				$datosImagen 	= array("estado"		=> $estado,
										"id_producto"	=> $id_producto,
										"id_imagen"		=> $id_imagen);

				$producto = new ProductosCon();
				$producto -> estadoImagenCon($datosImagen);

				break;

			case 'crear_promocion':
				# CREAR PROMOCION DE PRODUCTO SELECCIONADO
				$id_producto 	= $_POST['id_producto'];
				$venta 			= $_POST['venta'];
				$dcto 			= $_POST['dcto'];
				$precio 		= $_POST['precio'];

				$datosPromocion = array("id_producto"	=> $id_producto,
										"venta"			=> $venta,
										"dcto"			=> $dcto,
										"precio"		=> $precio);

				$producto = new ProductosCon();
				$producto -> crearPromocionCon($datosPromocion);

				break;

			default:
				print "no hay respuesta";
				break;
		}
	}
?>