<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../vista/img/favicon.png" type="image/png" sizes="20x20">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="../../vista/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vista/css/style.css">
  <script type="text/javascript" src="../../vista/js/bootstrap/bootstrap.min.js"></script>
  
  <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">-->
  <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed|Montserrat|Raleway" rel="stylesheet">


  <!--FUNCIONES JAVASCRIPT-->
  <script type="text/javascript" src="vista/js/core.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_inicio.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_categorias.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_marcas.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_productos.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_atributos.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_usuarios.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_pedidos.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_promociones.js"></script>
  <script type="text/javascript" src="vista/js/modulos/fnc_casos.js"></script>

</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 menu">
        <!--<caption>Menu</caption>-->
        <div style="text-align: center;">
          <img src="../../vista/img/logo_click_store_2.png" alt="Logo Click Store">
        </div>
        <table>
          <tr>
            <td><a href="#inicio" onclick="location.reload()"><i class="fa fa-home"></i> Inicio</a></td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#pedidos" onclick="verOpcionesMenu('opc_pedidos');"><i class="fa fa-history"></i> Pedidos</a></td> 
                </tr>
                <tr class="opciones" id="opc_pedidos">
                  <td>
                    <table>
                      <tr><td><a href="#pedidos" onclick="loadPage('pedidos')"><i class="fa fa-list"></i> Pedidos</a></td></tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#casos" onclick="loadPage('casos');"><i class="fa fa-book-open"></i> Devoluciónes / Garantías</a></td> 
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#configuracion" onclick="verOpcionesMenu('opc_catalogo');"><i class="fa fa-book"></i> Catalogo</a></td> 
                </tr>
                <tr class="opciones" id="opc_catalogo">
                  <td>
                    <table>
                      <tr><td><a href="#productos" onclick="loadPage('productos')"><i class="fa fa-box"></i> Productos</a></td></tr>
                      <tr><td><a href="#categorias" onclick="loadPage('categorias')"><i class="fa fa-list-alt"></i> Categorias</a></td></tr>
                      <tr><td><a href="#marcas" onclick="loadPage('marcas')"><i class="fa fa-bookmark"></i> Marcas</a></td></tr>
                      <tr><td><a href="#promociones" onclick="loadPage('promociones')"><i class="fa fa-bell"></i> Promociones</a></td></tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#registro" onclick="verOpcionesMenu('opc_registro');"><i class="fa fa-plus"></i> Registro</a></td> 
                </tr>
                <tr class="opciones" id="opc_registro">
                  <td>
                    <table>
                      <tr><td><a href="#usuarios" onclick="loadPage('usuarios')"><i class="fa fa-user"></i> Usuarios</a></td></tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#configuracion" onclick="verOpcionesMenu('opc_configuracion');"><i class="fa fa-cog"></i> Configuración</a></td> 
                </tr>
                <tr class="opciones" id="opc_configuracion">
                  <td>
                    <table>
                      <tr><td><a href="#atributos" onclick="loadPage('atributos')"><i class="fa fa-list"></i> Atributos</a></td></tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><a href="#cerrar_sesion" onclick="cerrar_sesion()"><i class="fa fa-sign-out-alt"></i> Cerrar Sesión</a></td>
          </tr>
        </table>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10" style="height: 100vh;overflow-y: scroll;">
        <div class="row header">
          <div class="col-3" style="padding: 10px;text-align: left;">
            <a class="btn-block btn_menu" href="#" title="Menu de Navegacion" onclick="mostrar_menu('ver')">
              <i class="fa fa-bars" style="display: block;"></i>
            </a>
          </div>
          <div class="col-9" style="padding: 10px;text-align: right;color:#FFF;">
            <!--<img src="../../vista/img/logo_click_store_2.png" alt="Logo Click Store">-->
            <button class="btn btn-light" type="button" onclick="info_usuario()">
              <script type="text/javascript">
                document.write(localStorage.nombre);
              </script>
            </button> 
          </div>
        </div>
        <div class="row p-2" id="vista">
          <?php
            require_once "vista/modulos/inicio/inicio.php";
          ?>
        </div>
        <div class="row" id="contact">
          <div class="col-12" style="text-align: center;padding: 10px;">
            <p>&copy 2018 Click Store. Todos los derechos reservados, el registro o el uso de este sitio constituye la aceptación de nuestros <a href="#terminos" title="Términos y condiciones" style="color:#000;" onclick="loadPage('terminos')">Términos y condiciones</a>, así como también nuestra <a href="#politicas" style="color:#000;" onclick="loadPage('politicas')">Política de privacidad</a>. | Diseñado y desarrollado por <a href="https://www.nextytech.net" title="N&T" target="_blank" style="color:#000;">Next&Tech.net</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  



  <!--MENU DE NAVEGACION MOVIL-->
  <div class="col-xs-12 col-md-3 col-lg-3 menu-movil">
    <div>
      <a href="#" title="Menu de Navegacion" onclick="mostrar_menu('ocultar')" style="color:#FFF;text-align: center;padding: 10px;">
        <i class="fa fa-times"></i>
      </a>
    </div>
    <div style="text-align: center;">
      <img src="../../vista/img/logo_click_store_2.png" alt="Logo Click Store">
    </div>
    <table>
      <tr>
        <td><a href="#inicio" onclick="loadPage('inicio')"><i class="fa fa-home"></i> Inicio</a></td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td><a href="#pedidos" onclick="verOpcionesMenu('opc_pedidos');"><i class="fa fa-history"></i> Pedidos</a></td> 
            </tr>
            <tr class="opciones" id="opc_pedidos" style="display: block;">
              <td>
                <table>
                  <tr><td><a href="#pedidos" onclick="loadPage('pedidos')"><i class="fa fa-list"></i> Pedidos</a></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td><a href="#configuracion" onclick="verOpcionesMenu('opc_catalogo');"><i class="fa fa-book"></i> Catalogo</a></td> 
            </tr>
            <tr class="opciones" id="opc_catalogo" style="display: block;">
              <td>
                <table>
                  <tr><td><a href="#productos" onclick="loadPage('productos')"><i class="fa fa-box"></i> Productos</a></td></tr>
                  <tr><td><a href="#categorias" onclick="loadPage('categorias')"><i class="fa fa-list-alt"></i> Categorias</a></td></tr>
                  <tr><td><a href="#marcas" onclick="loadPage('marcas')"><i class="fa fa-bookmark"></i> Marcas</a></td></tr>
                  <tr><td><a href="#promociones" onclick="loadPage('promociones')"><i class="fa fa-bell"></i> Promociones</a></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td><a href="#registro" onclick="verOpcionesMenu('opc_registro');"><i class="fa fa-plus"></i> Registro</a></td> 
            </tr>
            <tr class="opciones" id="opc_registro" style="display: block;">
              <td>
                <table>
                  <tr><td><a href="#usuarios" onclick="loadPage('usuarios')"><i class="fa fa-user"></i> Usuarios</a></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td><a href="#configuracion" onclick="verOpcionesMenu('opc_configuracion');"><i class="fa fa-cog"></i> Configuración</a></td> 
            </tr>
            <tr class="opciones" id="opc_configuracion">
              <td>
                <table>
                  <tr><td><a href="#atributos" onclick="loadPage('atributos')"><i class="fa fa-list"></i> Atributos</a></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><a href="#cerrar_sesion" onclick="cerrar_sesion()"><i class="fa fa-sign-out-alt"></i> Cerrar Sesión</a></td>
      </tr>
    </table>
  </div>



  <!--VENTANA MODAL-->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>
            </div>
        </div>
      </div>
  </div>

  <!--PANEL ANIMADO-->
  <div id="panel_animado">
    <div class="row">
      <div id="contenido_animado" class="col-xs-12 col-md-5"></div>
    </div>
  </div>
  
</body>
</html>