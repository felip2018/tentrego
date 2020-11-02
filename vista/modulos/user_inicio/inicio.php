<script type="text/javascript">
	verInfoUsuario();
	conteoPedidosUsuario();	
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$(".put_share_btn").html('<div class="fb-share-button" data-href="http://clickstore.co/compartir/facebook/'+localStorage.email+'" data-layout="button" data-size="large" data-mobile-iframe="false"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.clickstore.co%2Fcompartir%2Ffacebook%2F'+localStorage.email+'&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>')
	});
</script>
<div class="col-12">
	<h4 class="alert alert-info">
		Bienvenido(a) <b><script type="text/javascript">document.write(localStorage.nombre)</script></b>
	</h4>	
</div>
<div class="col-12">
	
</div>
<div class="col-xs-12 col-md-6">
	<div class="alert alert-info informacion_usuario">
		
	</div>
</div>
<div class="col-xs-12 col-md-6">
	<div class="alert alert-info">
		Compartir
		<hr>
		<p>
			Para nosotros es importante llegar a muchas personas, por eso a través de el enlace <b>Compartir</b> te ofrecemos la oportunidad de adquirir beneficios para ti y tus amigos, solo comparte nuestra página en facebook.
		</p>
		<div class="put_share_btn">
			
		</div>
		
	</div>

	<div class="alert alert-info pedidos_usuario">
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		// 	PREVISUALIZACION DE IMAGEN
		$('#foto').change(function(e) {
			if ($("#foto").val() != "") {
		    	addImage(e); 
			}else{
				$('#foto_perfil').attr("src","vista/img/sin_imagen.png");
			}
		});

		function addImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;

		if (!file.type.match(imageType))
		return;

		var reader = new FileReader();
		reader.onload = fileOnload;
		reader.readAsDataURL(file);
		}

		function fileOnload(e) {
		var result=e.target.result;
		$('#foto_perfil').attr("src",result);
		}
	});
</script>
