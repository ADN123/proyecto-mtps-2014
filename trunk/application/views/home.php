<section>
    <h2>Datos de Sesion</h2>
</section>
    <div id="example" class="k-content">
    <div id="wrapper">

            <input class="eqSlider" value="0.5" />
        

    </div>
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
        });
    </script>

    <style>
        #wrapper {
            width: 300px;
            height: 255px;
            padding: 45px 0 0 0;
            margin: 0 auto;
            background: url('../../content/web/slider/eqBack.png') no-repeat 0 0;
            text-align: center;
        }
        #equalizer {
            display: inline-block;
            zoom: 1;
            margin: 0 12px;
            height: 122px;
        }
        .balSlider {
            width: 240px;
        }
        .balSlider .k-slider-selection {
            width: 240px;
            display: none;
        }
        .eqSlider {
            display: inline-block;
            zoom: 1;
            margin: 30px;
            height: 50px;
        }

        *+html .eqSlider {display:inline;}

    </style>