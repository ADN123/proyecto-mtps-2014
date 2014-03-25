/*
 *  Plugin para validacion de campos
 *  Creada por Leonel Peña
 *  leoneladonispm@hotmail.com
 *  Febrero 27 de 2014
 */
(function($){ 
	$.fn.validacion = function(options) {
		var	$objeto = $(this), /*Objeto que se quiere validar*/
			$obj = $objeto, /*Objeto al que se le aplica el diseño de validacion*/
			$form = $objeto.parents('form'), /*Form al que pertenece el objeto*/
			$self = this,
			to = "", /*String donde se almacena el mensaje segun la validacion que se esta ejecutando*/
            settings = {}; /*Objeto que contiene las configuraciones*/
		
		/*Variables que sirven para saber que todas la validaciones estan correctas, 1 por cada funcion de validacion*/
		var	reqRes = true,
			alfRes = true,
			numRes = true,
			mayRes = true,
			menRes = true,
			mayLRes = true,
			menLRes = true,
			pattRes = true;
		
		var finalRes = true; /*Variable que contiene el resultado final de la validacion*/
		
		$objeto.addClass("validar"); /*Se agrega un identificador al objeto*/
		$form.data("ok",false); /*Se agrega un identificador al formulario para saber si todos los campos son correctos*/
		
		settings = $.extend({
			req: true, /*true si el campo es requido, false si no lo es*/
            alf: false, /*true si el campo es alfabetico, false si no lo es*/
            num: false, /*true si el campo es numerico real, false si no lo es*/
			ent: false,	/*true si el campo es numerico entero, false si no lo es*/		
            numMin: null, /*Numero minino que se requiere en el obejto, null si no se va a utilizar*/
			numMax: null, /*Numero maximo que se requiere en el obejto, null si no se va a utilizar*/
			lonMin: null, /*Longitud minina de caracteres que se requiere en el obejto, null si no se va a utilizar*/
			lonMax: null, /*Longitud maxima de caracteres que se requiere en el obejto, null si no se va a utilizar*/
			patt: null,  /*Expresion regular que se requiere en el obejto, null si no se va a utilizar*/
			men: null, /*Mensaje que se quiere mostrar cuando no cumple con las validaciones, null si no se va a utilizar*/
			valNombre: false, /*true si lo que se quiere validar es un nombre, sino false */
			valTelefono: false, /*true si lo que se quiere validar es un telefono, sino false */
			valFecha: false, /*true si lo que se quiere validar es una fecha, sino false */
			valCorreo: false, /*true si lo que se quiere validar es un correro, sino false */
			valPrecio: false, /*true si lo que se quiere validar es un precio, sino false */
			verOk: false /*true si se desea aplicar el diseño cuando cumple la validacion, false si no se desea a utilizar*/
        }, options);
		
/*------------------------------------------------------------------------------------------------------------------------		
---------FUNCIONES PARA VALIDAR-------------------------------------------------------------------------------------------		
------------------------------------------------------------------------------------------------------------------------*/		
		
		/*Funcion para validar que el valor del objeto no sea vacio*/
		this.req = function() { 
			if(settings.req) {
				if($objeto.val()=="") {
					if(settings.men==null || settings.men=="")
						to="No debe quedar vacío";
					else
						to=settings.men;
					reqRes = false;	
					$self.err();
				}
				else {
					reqRes = true;
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que el valor del objeto sea alfabetico*/
		this.alf = function(){
			if(settings.alf) {
				var pattLoc = /^([a-z|\' '|ñ|á-ú]*)$/i;
				if(!pattLoc.test($objeto.val()) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="")
						to="Debe escribir sólo letras";
					else
						to=settings.men;
					alfRes = false;
					$self.err();			
				}
				else {
					alfRes = true;	
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que el valor del objeto sea numerico*/
		this.num = function(){
			if(settings.num || settings.ent) {;
				var enteros = /^[0-9]*$/i;
				var reales = /^[0-9]*([.]?[0-9]{1,2})?$/i;
				var pattLoc;
				if(settings.num)
					pattLoc=reales;
				else
					pattLoc=enteros;
				if(!pattLoc.test($objeto.val()) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="")
						to="Debe escribir sólo números"
					else
						to=settings.men;
					numRes = false;	
					$self.err();
				}
				else {
					numRes = true;	
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que el valor del objeto sea mayor que un numero dado*/
		this.may = function(){
			if(settings.numMin!=null) {
				if(Number($objeto.val()) <= Number(settings.numMin) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="") 
						to="Debe ser mayor que "+settings.numMin;
					else
						to=settings.men;
					mayRes = false;	
					$self.err();
				}
				else {
					mayRes = true;
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que el valor del objeto sea mayor que un numero dado*/
		this.men = function(){
			if(settings.numMax!=null) {
				if(Number($objeto.val()) >= Number(settings.numMax) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="") 
						to="Debe ser menor que "+settings.numMax;
					else
						to=settings.men;
					menRes = false;
					$self.err();
				}
				else {
					menRes = true;
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que la longitud del objeto sea mayor que un numero dado*/
		this.mayL = function(){
			if(settings.lonMin!=null) {
				if(Number($objeto.val().length) <= Number(settings.lonMin) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="") 
						to="Debe contener al menos "+settings.lonMin+" caracteres";
					else
						to=settings.men;
					mayLRes = false;	
					$self.err();
				}
				else {
					mayLRes = true;
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que la longitud del objeto sea menor que un numero dado*/
		this.menL = function(){
			if(settings.lonMax!=null) {
				if(Number($objeto.val().length) >= Number(settings.lonMax) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="") 
						to="No debe contener más de "+settings.lonMax+" caracteres";
					else
						to=settings.men;
					menLRes = false;	
					$self.err();
				}
				else {
					menLRes = true;
					$self.cor();
				}
			}
		}
		
		/*Funcion para validar que el valor del objeto sea una expresion regular*/
		this.expReg = function(){
			if(settings.patt!=null) {
				var pattLoc = settings.patt;
				if(!pattLoc.test($objeto.val()) && $objeto.val()!="") {
					if(settings.men==null || settings.men=="")
						to="Debe estar con el formato correcto";
					else
						to=settings.men;
					pattRes = false;
					$self.err();			
				}
				else {
					pattRes = true;	
					$self.cor();
				}
			}
		}
		
/*------------------------------------------------------------------------------------------------------------------------		
---------FUNCIONES PARA MOSTRAR EL RESULTADO DE LA VALIDACION-------------------------------------------------------------		
------------------------------------------------------------------------------------------------------------------------*/		
		
		/*Funcion que sirve para mostrar el mensaje del resultado de la validacion*/
		this.res = function(resultado) {
			var mensaje="";
			if(resultado) {
				if(settings.verOk) {
					mensaje="<span class='mensaje-tooltip'><img src='"+base_url()+"img/ok.png' width='12' width='12'/> Ok!</span><br/>";
					$obj.tooltipster('enable');
				}
				else {
					mensaje="";
					$obj.tooltipster('disable');
				}
			}
			else {
				mensaje="<span class='mensaje-tooltip'><img src='"+base_url()+"img/error.png' width='12' width='12'/> "+to+"</span><br/>";
				$obj.tooltipster('enable');
			}
			$obj.tooltipster('content', $(mensaje));
			finalRes = resultado;
		};
		
		/*Funcion que aplica el diseño de error en la validacion*/
		this.err = function() {
			$obj.stop()
				.animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
				.animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
				.animate({ left: "0px" }, 100)
				.removeClass('correct').removeClass('correct2').addClass('required');
			$self.res(false);
		};
		
		/*Funcion que aplica el diseño de correcto en la validacion*/
		this.cor = function() {
			/*Aqui se verifica que todas las variables tengan true*/
			if(reqRes && alfRes && numRes && mayRes && menRes && mayLRes && menLRes && pattRes) { 
				if(settings.verOk)
					$obj.stop().removeClass('required').addClass("correct2");
				else
					$obj.stop().removeClass('required').addClass("correct");
				$self.res(true);
			}
		}
		
/*------------------------------------------------------------------------------------------------------------------------		
---------INICIALIZADORES DE VALIDACIONES ESPECIFICAS----------------------------------------------------------------------		
------------------------------------------------------------------------------------------------------------------------*/		
		
		/*Constructor para valida nombres*/
		if(settings.valNombre) {
			settings.alf=true;
			settings.lonMin=15;
		}
		
		/*Constructor que valida telefonos*/
		if(settings.valTelefono) {
			settings.men="Debe estar con el formato correcto (<i>9999-9999</i>)";
			settings.patt=/^[2|6|7]{1}[0-9]{3}-[0-9]{4}$/i;
		}
		
		/*Constructor que valida fechas*/
		if(settings.valFecha) {
			settings.men="Debe estar con el formato correcto (<i>dd/mm/aaaa</i>)";
			settings.patt=/^([0][1-9]|[12][0-9]|3[01])(\/|-)([0][1-9]|[1][0-2])\2(\d{4})$/i;
		}
		
		/*Constructor que valida correos*/
		if(settings.valCorreo) {
			settings.men="Debe estar con el formato correcto (<i>micorreo@ejemplo.com</i>)";
			settings.patt=/(^(\w+([\.]\w+)*[\@]{1}\w+([\.]\w+)?[\.]{1}\w{2,3})|^)$/i;
		}
		
		/*Constructor que valida precios*/
		if(settings.valPrecio) {
			settings.num=true;
			settings.numMin=0;
		}	
			
		/*Pregunta si el objeto es requerido, si lo es añade un "*" en el label del objeto*/
		if(settings.req) {
			var label="#l"+$objeto.attr("id");
			$(label).append(' <span class="obligatorio">*</span>');
		}
		
/*------------------------------------------------------------------------------------------------------------------------		
---------SELECCION DE EVENTO DISPARADOR DE LAS VALIDACIONES---------------------------------------------------------------		
------------------------------------------------------------------------------------------------------------------------*/		
		
		/*Verificacion de que tipo de evento va a disparar la validacion*/		
		if($objeto[0].tagName=="INPUT" || $objeto[0].tagName=="TEXTAREA") {
			if($objeto.data("role")=="datepicker" || $objeto.data("role")=="timepicker") {
				$obj=$objeto.parent();
			}
			$objeto.blur(function(){ 
				$self.req();
				$self.alf();
				$self.num();
				$self.may();
				$self.men();
				$self.mayL();
				$self.menL();
				$self.expReg();
			});
		}
		else { 
			/*Cuando es de tipo SELECT*/
			$obj=$objeto.siblings('span');
			$objeto.change(function(){ 
				$self.req();
				$self.alf();
				$self.num();
				$self.may();
				$self.men();
				$self.mayL();
				$self.menL();
				$self.expReg();
			});
		}
		
/*------------------------------------------------------------------------------------------------------------------------		
--------VERIFICACION DE TODOS LOS OBEJTOS QUE SE ESTAN VALIDANDO----------------------------------------------------------		
------------------------------------------------------------------------------------------------------------------------*/		
		
		$obj.tooltipster(); /*Agrega al objeto la clase tooltip*/
		$boton=$form.find('.boton_validador');
		$boton.click(function(){
			$self.req();
			$self.alf();
			$self.num();
			$self.may();
			$self.men();
			$self.mayL();
			$self.menL();
			$self.expReg();
			$objeto.data("ok",finalRes);
			
			$camposValidar=$form.find(".validar");
				$form.data("ok",true);
			
			/*Verifica cada uno de los elementos que se estan validando, 
			si alguno resulta false el envio del formulario al que pertenece se denegado*/
			$camposValidar.each(function (index) {
				if(!($(this).data("ok"))) {
					$form.data("ok",false);
				}
			});
			
			$form.submit(function() {
				if(($form.data("ok")))
					return true;
				else
					return false;
			});
		});
	};
	$.fn.destruirValidacion = function(options) {
		var	$objeto = $(this), /*Objeto que se quiere validar*/
			$obj = $objeto, /*Objeto al que se le aplica el diseño de validacion*/
			$form = $objeto.parents('form'), /*Form al que pertenece el objeto*/
			$self = this
			
		$objeto.removeClass("validar"); /*Se quita el identificador al objeto*/
		$objeto.removeClass("tooltipster"); /*Se quita el identificador al objeto*/
		$objeto.removeData("ok");
		$objeto.off('change');
		$objeto.off('blur');
		
		var label="#l"+$objeto.attr("id");
		var span=$(label).find('span');
		span.remove();
		
	};
})(jQuery); 