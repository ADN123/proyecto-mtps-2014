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
        <link href="<?php echo base_url()?>css/smart_wizard.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>
        <!--<script src="<?php echo base_url()?>js/jquery-ui-1.9.0.custom.js"></script>-->
		<script src="<?php echo base_url()?>js/classie.js"></script>
        <script src="<?php echo base_url()?>js/kendo.all.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.tooltipster.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.leanModal.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/waypoints.min.js"></script>
		<script src="<?php echo base_url()?>js/jquery.smartWizard-2.0.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/funciones.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/validador.js" type="text/javascript"></script>
        <script type="text/javascript">
			function base_url() {
				return "<?php echo base_url()?>";
			}
            $(document).ready(function(){
				var menu = document.getElementById( 'menu-total' ),
					container = document.getElementById( 'container' ),
					main = document.getElementById( 'main' );
					pie = document.getElementById( 'pie' );
					menu1 = document.getElementById( 'cbp-spmenu-s1' );
				
				var $head = $( '#ha-header' );
				
				<?php
					$var="";
					$fun="";
					$call="";
                    foreach($menus as $menu) {
						if($menu['id_padre']=="")
							$id_padre="1";
						else
							$id_padre=$menu['id_padre'];
							
						$id=explode(",",$menu['id_modulo']);
						$url=explode(",",$menu['url_modulo']);
						
						$var.="var menu".$id_padre." = document.getElementById( 'cbp-spmenu-s".$id_padre."' ); ";
						$call.="classie.remove( menu".$id_padre.", 'cbp-spmenu-open' );";
						for($x=0;$x<count($id);$x++) {
							if($url[$x]=="NULL") {
								$fun.="$('#verMenu".$id[$x]."').click (function() {
									classie.toggle( this, 'active' );
									classie.toggle( main, 'cbp-spmenu-toright' );
									classie.toggle( pie, 'cbp-spmenu-toright' );
									classie.toggle( menu".$id[$x].", 'cbp-spmenu-open' );
								});";
							}
						}
	
                    }
                ?>					
				<?= $var?>
				
				$( '#verMenu1' ).click (function() {
					classie.toggle( this, 'active' );
					classie.toggle( main, 'cbp-spmenu-push-toright' );
					classie.toggle( pie, 'cbp-spmenu-push-toright' );
					classie.toggle( document.body, 'oscuro' );
					classie.toggle( menu1, 'cbp-spmenu-open' );
					if(!classie.has( menu1, 'cbp-spmenu-open' )) {
						cerrar();
					}
					else {
						$head.attr('class', 'ha-header ha-header-hide');
					}
				});
				
				<?= $fun?>
				
				function cerrar() {
					classie.remove( menu1, 'active' );
					classie.remove( main, 'cbp-spmenu-push-toright' );
					classie.remove( pie, 'cbp-spmenu-push-toright' );
					classie.remove( document.body, 'oscuro' );
					classie.remove( menu1, 'cbp-spmenu-open' );
					<?= $call?>
					$( window  ).scroll();
				}
				
				var bodyClickFn = function( el ) {
					cerrar();
					el.removeEventListener( 'click', bodyClickFn );
				};
				
				function hasParent( e, id ) {
					if (!e) return false;
					var el = e.target||e.srcElement||e||false;
					while (el && el.id != id) {
						el = el.parentNode||false;
					}
					return (el!==false);
				}
				
				document.addEventListener( 'click', function( ev ) {
					if(self.open && !hasParent(ev.target, verMenu1.id) && !hasParent(ev.target, menu.id)  && !hasParent(ev.target, container.id)) {
						bodyClickFn( this );
					}
				});
				
				$( window  ).scroll(function() {
					if(!classie.has( menu1, 'cbp-spmenu-open' )) 
						if($(this).scrollTop()>=25) {
							$head.attr('class', 'ha-header ha-header-rotate');
							if($(this).scrollTop()>=300 ) {
								/*$head.attr('class', 'ha-header ha-header-box');*/
							}
							else {
							}
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
                        <a id="verMenu1"><img src="<?php echo base_url()?>img/menu.png"> Men&uacute; <span>Principal</span></a>
                        <a style="float: right;margin-right: 20px;"><img src="<?php echo base_url()?>img/usuario.png"> <?php echo $nick?> <span>- <?php echo $nombre?><span></a>
                    </nav>
                </div>
            </div>
        </header>
    	<div id="main" class="cbp-spmenu-push">
            <div id="menu-total">
				<?php
                    foreach($menus as $menu) {
						if($menu['nombre_padre']=="")
							$nombre_menu="Menú Principal";
						else
							$nombre_menu=$menu['nombre_padre'];
						if($menu['id_padre']=="")
							$id_padre="1";
						else
							$id_padre=$menu['id_padre'];
							
						$id=explode(",",$menu['id_modulo']);
						$modulo=explode(",",$menu['nombre_modulo']);
						$descripcion_modulo=explode(",",$menu['descripcion_modulo']);
						$url=explode(",",$menu['url_modulo']);
						$img=explode(",",$menu['img_modulo']);
				?>
                		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s<?= $id_padre?>">
                        <h3><br/><?= $nombre_menu?></h3>
                        <a href="#" class="regresar" onClick="$('#verMenu<?= $id_padre?>').click();return false;">Regresar</a>
              	<?php
						for($x=0;$x<count($modulo);$x++) {
							if($url[$x]=="NULL")
								$tipo='href="#" class="padre" id="verMenu'.$id[$x].'" onClick="return false;"';
							else
								$tipo='href="'.base_url().'index.php/'.$url[$x].'"';
							if(isset($img[$x]) && $img[$x]!="")
								$ima='<img src="'.base_url().'img/'.$img[$x].'">';
							else
								$ima='';
				?>
                			<a <?= $tipo?> title="<?= $descripcion_modulo[$x]?>" ><?= $ima." ".$modulo[$x]?></a>
				<?php		
						}
                ?>        
                        </nav>
                <?php	
                    }
                ?>
            </div>
            <div class="container" id="container">
                <div class="main">