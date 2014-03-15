<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0,  minimum-scale=1.0, maximum-scale=1.0"> 
		<title>Ministerio de Trabajo y Previsi&oacute;n Social</title>
        <!--<link href="<?php echo base_url()?>css/jquery-ui-1.9.0.custom.css" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo base_url()?>css/default.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>css/component.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>css/kendo.common.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>css/kendo.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>css/kendo.dataviz.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>css/tooltipster.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>
        <!--<script src="<?php echo base_url()?>js/jquery-ui-1.9.0.custom.js"></script>-->
		<script src="<?php echo base_url()?>js/classie.js"></script>
        <script src="<?php echo base_url()?>js/kendo.all.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.tooltipster.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.leanModal.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/waypoints.min.js"></script>
        <script src="<?php echo base_url()?>js/funciones.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/validador.js" type="text/javascript"></script>
        <script type="text/javascript">
			function base_url() {
				return "<?php echo base_url()?>";
			}
            $(document).ready(function(){
				var $head = $( '#ha-header' );
				$( window  ).scroll(function() {
					if($(this).scrollTop()>=25) {
						$head.attr('class', 'ha-header ha-header-rotate');
					}
					else {
						$head.attr('class', 'ha-header ha-header-subshow');
					}
				});
			});
		</script>
	</head>
	<body>
        <header id="ha-header" class="ha-header ha-header-subshow">
            <div class="ha-header-perspective">
                <div class="ha-header-front" style="height: 65%;">
                </div>
                <div class="ha-header-bottom" style="height: 35%;">
                    <nav class="cl-effect-12">
                       
                    </nav>
                </div>
            </div>
        </header>
    	<div id="main" class="cbp-spmenu-push">
            <div class="container" id="container" style="margin-top: 220px;">
                <div class="main">