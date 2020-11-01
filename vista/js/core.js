//	ENVIAR EMAILS
function enviarEmails() 
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_emails.php",
		data:{
			action: "enviar"
		},
		success:function (response) 
		{
			console.log(response);
		}
	})
}