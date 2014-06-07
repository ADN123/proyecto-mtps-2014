<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0,  minimum-scale=1.0, maximum-scale=1.0"> ygfghfjfjhfjgf
		<title>Ministerio de Trabajo y Previsi&oacute;n Social</title>
        <!--<link href="http://localhost/mtps/css/jquery-ui-1.9.0.custom.css" rel="stylesheet" type="text/css" />-->
		<link href="http://localhost/mtps/css/default.css" rel="stylesheet" type="text/css" />
		<link href="http://localhost/mtps/css/component.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/mtps/css/kendo.common.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/mtps/css/kendo.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/mtps/css/kendo.dataviz.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/mtps/css/tooltipster.css" rel="stylesheet" type="text/css" />
        <link href="http://localhost/mtps/css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="http://localhost/mtps/js/jquery-1.8.2.js"></script>
        <!--<script src="http://localhost/mtps/js/jquery-ui-1.9.0.custom.js"></script>-->
		<script src="http://localhost/mtps/js/classie.js"></script>
        <script src="http://localhost/mtps/js/kendo.all.min.js" type="text/javascript"></script>
        <script src="http://localhost/mtps/js/jquery.tooltipster.js" type="text/javascript"></script>
        <script src="http://localhost/mtps/js/jquery.leanModal.min.js" type="text/javascript"></script>
        <script src="http://localhost/mtps/js/waypoints.min.js"></script>
        <script src="http://localhost/mtps/js/funciones.js" type="text/javascript"></script>
        <script src="http://localhost/mtps/js/validador.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
				var menu = document.getElementById( 'menu-total' ),
					container = document.getElementById( 'container' ),
					main = document.getElementById( 'main' );
					menu1 = document.getElementById( 'cbp-spmenu-s1' );
				
				var $head = $( '#ha-header' );
									
				var menu1 = document.getElementById( 'cbp-spmenu-s1' ); 
				var menu58 = document.getElementById( 'cbp-spmenu-s58' ); 
				var menu65 = document.getElementById( 'cbp-spmenu-s65' ); 
				var menu70 = document.getElementById( 'cbp-spmenu-s70' ); 				
				
				$( '#verMenu1' ).click (function() {
					classie.toggle( this, 'active' );
					classie.toggle( main, 'cbp-spmenu-push-toright' );
					classie.toggle( document.body, 'oscuro' );
					classie.toggle( menu1, 'cbp-spmenu-open' );
					if(!classie.has( menu1, 'cbp-spmenu-open' )) {
						cerrar();
					}
					else {
						$head.attr('class', 'ha-header ha-header-hide');
					}
				});
				$('#verMenu58').click (function() {
					classie.toggle( this, 'active' );
					classie.toggle( main, 'cbp-spmenu-toright' );
					classie.toggle( menu58, 'cbp-spmenu-open' );
				});
				$('#verMenu70').click (function() {
					classie.toggle( this, 'active' );
					classie.toggle( main, 'cbp-spmenu-toright' );
					classie.toggle( menu70, 'cbp-spmenu-open' );
				});
				$('#verMenu65').click (function() {
					classie.toggle( this, 'active' );
					classie.toggle( main, 'cbp-spmenu-toright' );
					classie.toggle( menu65, 'cbp-spmenu-open' );
				});				
				function cerrar() {
					classie.remove( menu1, 'active' );
					classie.remove( main, 'cbp-spmenu-push-toright' );
					classie.remove( document.body, 'oscuro' );
					classie.remove( menu1, 'cbp-spmenu-open' );
					classie.remove( menu1, 'cbp-spmenu-open' );
					classie.remove( menu58, 'cbp-spmenu-open' );
					classie.remove( menu65, 'cbp-spmenu-open' );
					classie.remove( menu70, 'cbp-spmenu-open' );					
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
                        <a id="verMenu1"><img src="http://localhost/mtps/img/menu.png"> Men&uacute; <span>Principal</span></a>
                        <a style="float: right;margin-right: 20px;"><img src="http://localhost/mtps/img/usuario.png"> Nick <span>- Usuario Logueado<span></a>
                    </nav>
                </div>
            </div>
        </header>
    	<div id="main" class="cbp-spmenu-push">
            <div id="menu-total">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1"><br>
                	<h3><br/>Menú Principal</h3><br>
                 		<a href="#" class="regresar" onClick="$('#verMenu1').click();return false;">Regresar</a>
                        <a href="#" class="padre" id="verMenu58" ><img src="http://localhost/mtps/img/transporte.png"> Gestión de Transporte</a><br>
                        <a href="#" class="padre" id="verMenu70" ><img src="http://localhost/mtps/img/plan.png"> Planes Anuales de Trabajo</a><br>
				</nav>
                <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s58"><br>
                <h3><br/>Gestión de Transporte</h3><br>
                <a href="#" class="regresar" onClick="$('#verMenu58').click();return false;">Regresar</a>
              	                			<a href="http://localhost/mtps/index.php/transporte/solicitud" > Crear solicitud de Misión Oficial</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/control_solicitudes" > Control de solicitudes</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/ver_solicitudes" > Ver solicitudes</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/asignar_vehiculo_motorista" > Asignación de vehículo/motorista</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/control_salidas_entradas" > Control de salidas/entradas</a><br>
				                			<a href="#" class="padre" id="verMenu65" > Reportes y formularios</a><br>
				        
                        </nav>
                                		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s65"><br>
                        <h3><br/>Reportes y formularios</h3><br>
                        <a href="#" class="regresar" onClick="$('#verMenu65').click();return false;">Regresar</a>
              	                			<a href="http://localhost/mtps/index.php/transporte/reporte_solicitud" > Solicitud de Misión Oficial</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/reporte_salidas_entradas" > Control de salidas/entradas</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/bitacora_vehiculos" > Bitácora de vehículos</a><br>
				                			<a href="http://localhost/mtps/index.php/transporte/reporte_vehicular" > Rediminiento vehicular</a><br>
				        
                        </nav>
                                		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s70"><br>
                        <h3><br/>Planes Anuales de Trabajo</h3><br>
                        <a href="#" class="regresar" onClick="$('#verMenu70').click();return false;">Regresar</a>
              	                			<a href="http://localhost/mtps/index.php/plan/solicitud" > Pueba</a><br>
				        
                        </nav>
                            </div>
            <div class="container" id="container">
                <div class="main"><section>
    <h2>Nuevo Formulario</h2>
</section>
<form name="formu" id="formu" action="index.php" method="post">
<input type="hidden" name="estudiantes[]" value="1" /> 
    <p>
        <label for="nombre" id="lnombre">Texto</label>
        <input type="text" class="tam-4" tabindex="1" id="nombre" name="nombre"/>
    </p>
    <p>
        <label for="nombre2" id="lnombre2">Texto2</label>
        <input type="text" class="tam-3" tabindex="1" id="nombre2" name="nombre2"/>
    </p>
    <p>
        <label for="direccion" id="ldireccion">Textarea</label>
        <textarea class="tam-4" id="direccion" tabindex="2" name="direccion"/></textarea>
    </p>
    <p>
        <label for="nacimiento" id="lnacimiento">Nacimiento</label>
        <input type="text" class="nac" tabindex="3" id="nacimiento" name="nacimiento"/>
    </p>
    <p>
        <label for="select" id="lselect">Select</label>
        <select class="tam-1" tabindex="4" id="select" name="select">
            <option value="1">Valor 1</option>
            <option value="2">Valor 2</option>
        </select>
    </p>
    <p>
        <label for="precio" id="lprecio">Precio</label>
        <input type="text" class="tam-1" tabindex="5" id="precio" name="precio"/>
    </p>
    <p>
        <label for="telefono" id="ltelefono">Tel&eacute;fono</label>
        <input type="text" class="tam-2" tabindex="6" id="telefono" name="telefono"/>
    </p>
    <p>
        <label for="correo" id="lcorreo">Correo</label>
        <input type="text" class="tam-3" tabindex="7" id="correo" name="correo"/>
    </p>
    <p>
        <button type="submit" class="button tam-1 boton_validador" tabindex="8" id="guardar" name="guardar"><img src="img/guardar.png" width="12" height="12"> Guardar</button>
    </p>
</form>
<script type="text/javascript">
	$(document).ready(function(){
	   $("#nombre").validacion({
			valNombre: true
		});
		$("#nombre2").validacion({
			alf: true,
			lonMin: 15
		});
		$("#direccion").validacion({
			req: false,
			lonMin: 10
		});
		$("#nacimiento").validacion({
			valFecha: true
		});
		$("#precio").validacion({
			valPrecio: true
		});
		$("#select").validacion({
			men: "Debe seleccionar un item"
		});
		$("#telefono").validacion({
			req: false,
			valTelefono: true
		});
		$("#correo").validacion({
			valCorreo: true,
			verOk: true
		});
		$("#guardar").click(function(){
			if($("#formu").data("ok"))
				alert("Se va");			
		});
	});
</script> 				</div>
            </div>
       	</div>
	</body>
</html>
