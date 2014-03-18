
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/fd-slider/fd-slider.css?v=2">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/fd-slider/fd-slider-tooltip.css">
<script type="text/javascript" src="<?php echo base_url()?>css/fd-slider/fd-slider.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/prettify.js"></script>
<script src="<?php echo base_url()?>js/gauge.js"></script>



    <div id="wrappers" style="width:75%">

  <form id="opts" class="opts">
  
      <p>
		<label for="timepicker" > Hora</label>    
        <input id="timepicker"  name="hora" value="<? echo date("h:m A");?>" />
      </p>
        <p>
		<label for="km" >Kilometraje</label>    
        <input id="km"  name="km"  class="tam-1"/>
      </p>
        <p>
    <input type="hidden" name="animationSpeed" min="1" max="128" step="1" value="32" >
	<label>Tanque</label><input  type="text" name="currval" min="0" max="100" step="1" value="50" >
    </p>
 <div id="preview" >
  	<canvas width=220 height=70 id="canvas-preview"></canvas>
  	<div id="preview-textfield"></div>
</div>
  </form>



    </div>
	<script>
        $(document).ready(function() {

			
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
    

    <script>
  prettyPrint();
  function update() {
    var opts = {};
    $('.opts input[min], .opts .color').each(function() {
      var val = $(this).hasClass("color") ? this.value : parseFloat(this.value);
      if($(this).hasClass("color")){
        val = "#" + val;
      }
      if(this.name.indexOf("lineWidth") != -1 ||
        this.name.indexOf("angle") != -1 ||
        this.name.indexOf("pointer.length") != -1){
        val /= 100;
      }else if(this.name.indexOf("pointer.strokeWidth") != -1){
        val /= 1000;
      }
      $('#opt-' + this.name.replace(".", "-")).text(val);
      if(this.name.indexOf(".") != -1){
      	var elems = this.name.split(".");
      	var tmp_opts = opts;
      	for(var i=0; i<elems.length - 1; i++){
      		if(!(elems[i] in tmp_opts)){
      			tmp_opts[elems[i]] = {};
      		}
      		tmp_opts = tmp_opts[elems[i]];
      	}
      	tmp_opts[elems[elems.length - 1]] = val;
      }else if($(this).hasClass("color")){
        // color picker is removing # from color values
      	opts[this.name] = "#" + this.value
        $('#opt-' + this.name.replace(".", "-")).text("#" + this.value);
      }else{
      	opts[this.name] = val;
      }
      if(this.name == "currval"){
      	// update current demo gauge
      	demoGauge.set(parseInt(this.value));
      	AnimationUpdater.run();
      }
    });
 
    demoGauge.animationSpeed = opts.animationSpeed;
    opts.generateGradient = true;
    demoGauge.setOptions(opts);
    demoGauge.ctx.clearRect(0, 0, demoGauge.ctx.canvas.width, demoGauge.ctx.canvas.height);
    demoGauge.render();
 
  }
  function initGauge(){

    demoGauge = new Gauge(document.getElementById("canvas-preview"));
    demoGauge.setTextField(document.getElementById("preview-textfield"));
    demoGauge.maxValue = 100;
    demoGauge.set(50);
  };
 
  $(function() {
    var params = {};
    var hash = /^#\?(.*)/.exec(location.hash);
   
    if (hash) {
      $('#share').prop('checked', true);
      $.each(hash[1].split(/&/), function(i, pair) {
        var kv = pair.split(/=/);
        params[kv[0]] = kv[kv.length-1];
      });
    }
    $('.opts input[min], #opts .color').each(function() {
      var val = params[this.name];
      if (val !== undefined) this.value = val;
      this.onchange = update;
    });
 
 
    initGauge();
    update();
    
  });
</script>
    
    
    