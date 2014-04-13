// JavaScript Document
$(document).ready(function() {
	$('#entrar').click(function entrar() {
		if (document.form1.user.value=="" || document.form1.pass.value=="") { 
			alertify.alert('Por favor ingrese un usuario y una clave.');
			return false;
		}
	 
	});
});