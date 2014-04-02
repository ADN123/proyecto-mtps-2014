// JavaScript Document
$(document).ready(function() {
	$('#entrar').click(function entrar() {
		if (document.form1.user.value=="" || document.form1.pass.value=="") { 
			alert('por favor llene los datos');
			return false;
		}
	 
	});
});