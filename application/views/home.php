<style>
	#pie {
		position: absolute;
		bottom: 0px;
	}
</style>
<div style="width: 100%; height: 250px;"></div>

<!--<h1 style="text-transform: capitalize;">Bienvenid<?php if($this->session->userdata('sexo')=='M') echo 'o'; else echo 'a';?> <?=strtolower($this->session->userdata('nombre'))?></h1>
--><h1 style="text-transform: capitalize;"><?php  print_r($msj); echo " ".ucwords(utf8_encode(utf8_decode($this->session->userdata('nombre')))); ?></h1>


    
    
    