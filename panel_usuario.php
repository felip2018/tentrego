<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../vista/img/favicon.png" type="image/png" sizes="20x20">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="vista/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vista/css/user_style.css">
  <script type="text/javascript" src="vista/js/bootstrap/bootstrap.min.js"></script>
  
  <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">-->
  <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed|Montserrat|Raleway" rel="stylesheet">

  <!--FUNCIONES JAVASCRIPT-->
  <script type="text/javascript" src="vista/js/modulos/user_core.js"></script>

  <script type="text/javascript" src="vista/js/modulos/user_fnc_tienda.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_carrito.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_inicio.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_mis_pedidos.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_mis_resenas.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_mis_direcciones.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_info.js"></script>
  <script type="text/javascript" src="vista/js/modulos/user_fnc_casos.js"></script>

  <!--NOTIFICACIONES PUSH-->
  <script type="text/javascript" src="vista/js/push_js/bin/push.min.js"></script>

  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '320544408486189',
        cookie     : true,
        xfbml      : true,
        version    : 'v3.0'
      });
        
      FB.AppEvents.logPageView();   
        
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "https://connect.facebook.net/es_ES/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
  </script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 menu">
        <!--<caption>Menu</caption>-->
        <div style="text-align: center;">
          <img src="vista/img/logo_click_store_2.png" alt="Logo Click Store">
        </div>
        <table>
          <tr>
            <td><a href="#inicio" onclick="location.reload()"><i class="fa fa-home"></i> Inicio</a></td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td><a href="#mi_perfil" onclick="/*verOpcionesMenu('opc_mi_perfil');*/"><i class="fa fa-user"></i> Mi Perfil</a></td> 
                </tr>
                <tr class="opciones" style="display: block;" id="opc_mi_perfil">
                  <td>
                    <table>
                      <!--<tr><td><a href="#Mis_datos_personales" onclick="loadPage('mis_datos_personales')"><i class="fa fa-database"></i> Mis datos personales</a></td></tr>-->
                      <tr><td><a href="#mis_direcciones" onclick="loadPage('mis_direcciones')"><i class="fa fa-map-marker-alt"></i> Mis direcciones</a></td></tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><a href="#mis_resenas" onclick="loadPage('mis_resenas')"><i class="fa fa-edit"></i> Mis Reseñas</a></td>
          </tr>
          <tr>
            <td><a href="#mis_pedidos" onclick="loadPage('mis_pedidos')"><i class="fa fa-list-ol"></i> Mis Pedidos</a></td>
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
            <td><a href="#tienda" onclick="loadPage('tienda')"><i class="fa fa-store"></i> Tienda</a></td>
          </tr>
          <tr>
            <td><a href="#carrito_compras" onclick="loadPage('carrito_compra')"><i class="fa fa-shopping-cart"></i> Carrito de Compras</a></td>
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
          <div class="col-9" style="padding: 10px;text-align: right;">
            <!--<img src="../../vista/img/logo_click_store_2.png" alt="Logo Click Store">-->
            <button class="btn btn-light" type="button">
              <script type="text/javascript">
                document.write(localStorage.nombre);
              </script>
            </button> 
          </div>
        </div>
        <div class="row p-2" id="vista">
          <?php
            require_once "vista/modulos/user_inicio/inicio.php";
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
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 menu-movil">
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
        <td><a href="#inicio" onclick="location.reload()"><i class="fa fa-home"></i> Inicio</a></td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td><a href="#mi_perfil"><i class="fa fa-user"></i> Mi Perfil</a></td> 
            </tr>
            <tr class="opciones" style="display: block;" id="opc_mi_perfil">
              <td>
                <table>
                  <tr><td><a href="#mis_direcciones" onclick="loadPage('mis_direcciones')"><i class="fa fa-map-marker-alt"></i> Mis direcciones</a></td></tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><a href="#mis_resenas" onclick="loadPage('mis_resenas')"><i class="fa fa-edit"></i> Mis Reseñas</a></td>
      </tr>
      <tr>
        <td><a href="#mis_pedidos" onclick="loadPage('mis_pedidos')"><i class="fa fa-list-ol"></i> Mis Pedidos</a></td>
      </tr>
      <tr>
        <td><a href="#tienda" onclick="loadPage('tienda')"><i class="fa fa-store"></i> Tienda</a></td>
      </tr>
      <tr>
        <td><a href="#carrito_compras" onclick="loadPage('carrito_compra')"><i class="fa fa-shopping-cart"></i> Carrito de Compras</a></td>
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