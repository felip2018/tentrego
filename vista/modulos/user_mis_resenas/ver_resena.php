<?php
	setlocale(LC_TIME, 'spanish');
	require_once "../../../controlador/user_con_mis_resenas.php";
	require_once "../../../modelo/user_mod_mis_resenas.php";

	if (isset($_POST['id_resena'])) 
	{
		$id_resena = $_POST['id_resena'];

		$mis_resenas = new MisResenasCon();
		$info = $mis_resenas -> infoResenaCon($id_resena);

?>
<style type="text/css" media="screen">

#form label {
  font-size: 25px;
}

input[type="radio"] {
  display: none;
}

label {
  color: grey;
  font-size: 15pt;
}

.clasificacion {
  direction: rtl;
  unicode-bidi: bidi-override;
  text-align: center;
}

label:hover,
label:hover ~ label {
  color: orange;
}

input[type="radio"]:checked ~ label {
  color: orange;
  font-size: 15pt;
}
</style>
<script type="text/javascript">
	var id = "radio"+<?php echo $info['calificacion'];?>;
	$("#"+id).prop("checked",true);
	//console.log("id -> #"+id);
</script>
<form id="form_resena_producto">
	<input type="hidden" name="id_resena" id="id_resena" value="<?php echo $info['id_resena'];?>">
	<b>Calificación del producto</b>
  	
  	<p class="clasificacion">
	    <input id="radio5" type="radio" name="estrellas" value="5"><label for="radio5">★</label>
	    <input id="radio4" type="radio" name="estrellas" value="4"><label for="radio4">★</label>
	    <input id="radio3" type="radio" name="estrellas" value="3"><label for="radio3">★</label>
	    <input id="radio2" type="radio" name="estrellas" value="2"><label for="radio2">★</label>
	    <input id="radio1" type="radio" name="estrellas" value="1"><label for="radio1">★</label>
  	</p>
	
	<b>Escribir reseña</b>

	<textarea class="form-control" rows="5" name="resena" id="resena"><?php echo $info['comentarios'];?></textarea>
	
	<div class="alert alert-danger alert_resena" style="display:none;"></div>
	
	<button type="button" class="btn btn-primary btn-block" onclick="actualizar_resena('<?php echo $info['id_pedido'];?>','<?php echo $info['id_producto'];?>','<?php echo $info['email'];?>')">
		<i class="fa fa-save"></i> Salvar reseña
	</button>

	</form>
<?php

	}
	else
	{
		echo "Vista no disponible!";
	}
?>