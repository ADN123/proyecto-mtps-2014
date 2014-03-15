<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
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
						$url=explode(",",$menu['url_modulo']);
						$img=explode(",",$menu['img_modulo']);
				?>
                		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s<?= $id_padre?>">
                        <h3><br/><?= $nombre_menu?></h3>
              	<?php
						for($x=0;$x<count($modulo);$x++) {
							if($url[$x]=="NULL")
								$tipo='href="#" class="padre" id="verMenu'.$id[$x].'"';
							else
								$tipo='href="'.base_url().'index.php/'.$url[$x].'"';
							if(isset($img[$x]) && $img[$x]!="")
								$ima='<img src="'.base_url().'img/'.$img[$x].'">';
							else
								$ima='';
				?>
                			<a <?= $tipo?> ><?= $ima." ".$modulo[$x]?></a>
				<?php		
						}
                ?>        
                        </nav>
                <?php	
                    }
                ?>
         	<script>
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
						$call.="classie.remove( menu11, 'cbp-spmenu-open' );";
						for($x=0;$x<count($id);$x++) {
							if($url[$x]=="NULL") {
								$fun.="$('#verMenu".$id[$x]."').click (function() {
									classie.toggle( this, 'active' );
									classie.toggle( main, 'cbp-spmenu-toright' );
									classie.toggle( menu11, 'cbp-spmenu-open' );
								});";
							}
						}
	
                    }
                ?>
				<?= $var?>
				<?= $fun?>
				function cerrar() {
					classie.remove( menu1, 'active' );
					classie.remove( main, 'cbp-spmenu-push-toright' );
					classie.remove( document.body, 'oscuro' );
					classie.remove( menu1, 'cbp-spmenu-open' );
					<?= $call?>
					$( window  ).scroll();
				}
			</script>
</body>
</html>