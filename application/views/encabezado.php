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
		<link href="<?php echo base_url()?>css/alertify.core.css" rel="stylesheet" />
		<link href="<?php echo base_url()?>css/alertify.default.css" rel="stylesheet" />
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php  echo base_url() ?>/css/datatable.css">

        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>
        <script src="<?php echo base_url()?>js/jquery-ui-1.9.0.custom.js"></script>
        <script src="<?php echo base_url()?>js/jquery.dataTables.js"></script>
		<script src="<?php echo base_url()?>js/classie.js"></script>
        <script src="<?php echo base_url()?>js/kendo.all.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.tooltipster.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/jquery.leanModal.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/waypoints.min.js"></script>
		<script src="<?php echo base_url()?>js/jquery.smartWizard-2.0.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/alertify.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/funciones.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>js/validador.js" type="text/javascript"></script>

        <!-------- Graficos -->
		        
		<script src="<?php echo base_url()?>js/amcharts.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>js/serial.js" type="text/javascript"></script>  
		        
<!-- para ayuda-->
		<link href="<?php echo base_url()?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"> 		<!-- icons-->
		<script src="<?php echo base_url()?>js/bootstrap.min.js" type="text/javascript"></script>  

   


        <script type="text/javascript">

				function paginaOK(){
					//document.getElementById('loader').style.display='none';					    
					   $("#loader").fadeOut();
					   $("#ok").fadeIn();					  
					//document.getElementById('ok').style.display='block';

					}

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
				<?php echo $var?>
				
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
					if(ayudaActiva){
						$('#verAyuda').click();
					}

				});
				
				<?php echo $fun?>
				
				function cerrar() {
					classie.remove( menu1, 'active' );
					classie.remove( main, 'cbp-spmenu-push-toright' );
					classie.remove( pie, 'cbp-spmenu-push-toright' );
					classie.remove( document.body, 'oscuro' );
					classie.remove( menu1, 'cbp-spmenu-open' );
					<?php echo $call?>
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
								
								$("#contenAyuda").css("margin-top", "52px");
								$("#contenAyuda").css("margin-right", "17px");

								if (ayudaActiva) {
									$("#contenAyuda").css("margin-right", "17px");	
								} else{
									$("#contenAyuda").css("margin-right", "0px");	
								}
							}
							else {
								
								$("#contenAyuda").css("margin-top", "52px");
								if (ayudaActiva) {
									$("#contenAyuda").css("margin-right", "17px");	
								} else{
									$("#contenAyuda").css("margin-right", "0px");	
								}

								
							}
						}
						else {
							$head.attr('class', 'ha-header ha-header-subshow');
							$("#contenAyuda").css("margin-top", "150px");
							$("#contenAyuda").css("margin-right", "-13px");
							
						}
				});

				setTimeout ("paginaOK();", 200);
			});

		</script>




		
	</head>
	<body>
<!------------------------PARA QUE NO MUESTRE TODO UNA SOLA VEZ-------------->

<div id="loader" style="position:absolute; width:100%; height:100%; background-color:#ffffff; z-index:1005; text-align:center; padding-top:100px; font-size:20px; font-family:Arial; color:#000000;">

<img src="<?php echo base_url()?>css/Bootstrap/loading.gif" />
</div>
<div id="ok" style="display:none">
<!--    el contenido de la pagina siempre estara dentro del div ok     este se cierra en el archivo pie de pagina -->





        <header id="ha-header" class="ha-header ha-header-subshow">
            <div class="ha-header-perspective">
                <div class="ha-header-front" style="height: 98px;">
                </div>
                <div class="ha-header-bottom" style="height: 52px;">
                    <nav class="cl-effect-12">
                        <a id="verMenu1"><img src="<?php echo base_url()?>img/menu.png"> Men&uacute; <span>Principal</span></a>
                        <a id="verAyuda" style="float: right;margin-right: 20px;">
                        	<?php echo $nick?> <span>- <?php echo $nombre?><span> <img src="<?php echo base_url()?>img/ayuda_ico.png" alt="Ayuda"></a>
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
                		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s<?php echo $id_padre?>">
                        <h3><br/><?php echo $nombre_menu?></h3>
                        <a href="#" class="regresar" onClick="$('#verMenu<?php echo $id_padre?>').click();return false;">Regresar</a>
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
                			<a <?php echo $tipo?> title="<?php echo $descripcion_modulo[$x]?>" ><?php echo $ima." ".$modulo[$x]?></a>
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
             	<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="contenAyuda">

				<div class="sidebar-right-heading" id="tabs">
					<h3>Ayuda</h3>	

		 			<ul class="nav nav-tabs square nav-justified">
					  <li class="active"><a href="#tabs-1" data-toggle="tab"><i class="fa fa-comments"></i></a></li>
					  <li class=""><a href="#tabs-2" data-toggle="tab"><i class="fa fa-bell"></i></a></li>
					  <li class=""><a href="#tabs-3" data-toggle="tab"><i class="fa fa-tasks"></i></a></li>								 
					</ul>
					  <div id="tabs-1">
					    <p>Aqui descripcion Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
					  </div>
					  <div id="tabs-2">
					    <p>aqui pasos Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
					  </div>
					  <div id="tabs-3">
					    <p>Aqui errores Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>

					  </div>

				</div><!-- /.tab-content -->
						

					<script type="text/javascript">
						var showRight = document.getElementById( 'verAyuda' ),
							menuRight = document.getElementById( 'contenAyuda' );
						showRight.onclick = function() {
							classie.toggle( this, 'active' );
							classie.toggle( menuRight, 'cbp-spmenu-open' );
							//disableOther( 'showRight' );
							ayudaActiva=!ayudaActiva;
						};	
					var ayudaActiva=false;
					  $(function() {
					    $( "#tabs" ).tabs();
					  });
					</script>
				</nav>