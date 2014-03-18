<section>
    <h2>Datos de Sesion</h2>
</section>
    <div id="example" class="k-content">
    <div id="wrappers">
    
          <p>
		<label for="timepicker" > Hora</label>    
        <input id="timepicker"  name="hora" value="<? echo date("h:m A");?>" />
      </p>
        <p>
		<label for="km" >Kilometraje</label>    
        <input id="km"  name="km"  class="tam-1"/>
      </p>
      <p>
		<label for="combustible" > Nivel tanque(%)</label> <br />    
        <input class="eqSlider" value="50" id="combustible" name="combustible"/>
	  </p>

    </div>
    </div>
	<script>
        $(document).ready(function() {
			var templateString = "#= selectionStart # - #= selectionEnd #";
			
    		$(".eqSlider").kendoSlider({
                min: 0,
                max: 100,
                smallStep: 25,
                largeStep: 25,
                showButtons: false
            });
		  $("#timepicker").kendoTimePicker();
        });
    </script>

    <style>

        .eqSlider {
            display: inline-block;
            zoom: 1;
            margin: 30px;
            height: 50px;
			background:#FFFFFF
        }

    </style>