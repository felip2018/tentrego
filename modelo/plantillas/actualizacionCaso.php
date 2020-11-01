<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Actualizacion Caso</title>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <style type="text/css" media="screen">
    body{
      font-family: arial,helvetica,sans-serif;
      font-size: 12pt;
    }
    .container{
      width: 800px;
      height: auto;
      margin: auto;
      padding: 10px;
    }
    .head_message{
      width: 100%;
      height: auto;
      text-align: center;
      /*border: 1px solid blue;*/
      padding: 10px;
      box-sizing: border-box;
      background: #c0392b;
      z-index: 10;
    }
    .body_message{
      color: #000;
      padding: 10px;
      box-sizing: border-box;
      background: rgba(255,255,255,0.8);
    }
    .footer_message{
      background: #2c3e50;
      color: #FFF;
      padding: 10px;
      text-align: center;
    }
    table{
      width: 50%;
    }

  </style>
</head>
<body>
    <div class="container">
      <div class="head_message">
        <img src="http://localhost/click_store/vista/img/logo_click_store_2.png" alt="logo_click_store">
      </div>
      <div class="body_message">
        <div>
          <h3>NOTIFICACIÓN DE ESTADO</h3>
          <p>
            Hola, <b>{{cliente}}</b><br><br>
            <b>Click Store</b> te informa que su solicitud se encuentra en estado: <b>{{estado}}</b>, a continuación podrá observar la descripción de estado:
          </p>
          <p>
            "<b>{{descripcion}}</b>"
          </p>
          <p>
            Podrás observar el proceso de tu caso accediendo a tu cuenta registrada en <b>Click Store</b> sección <b>Devoluciónes / Garantías</b>.
          </p>
        </div>
      </div>
      <div class="footer_message">
        <p>Visita nuestras redes sociales</p>
  
        <a type="button" class="btn btn-primary" href="https://www.facebook.com/CLICKSTOREBogota/" target="_blank">
          Facebook
        </a>
        <a type="button" class="btn btn-danger" href="https://www.instagram.com/click._store/?hl=es" target="_blank">
          Instagram
        </a>
      </div>
    </div>
</body>
</html>