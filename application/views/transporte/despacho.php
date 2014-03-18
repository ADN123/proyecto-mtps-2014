 <input id="slider" class="balSlider" value="0" />
        <div id="equalizer">
            <input class="eqSlider" value="10" />
            <input class="eqSlider" value="5" />
            <input class="eqSlider" value="0" />
            <input class="eqSlider" value="10" />
            <input class="eqSlider" value="15" />
        </div>
        
        
        
        <script>
        $(document).ready(function() {
            var slider = $("#slider").kendoSlider({
                increaseButtonTitle: "Right",
                decreaseButtonTitle: "Left",
                min: -10,
                max: 10,
                smallStep: 2,
                largeStep: 1
            }).data("kendoSlider");

            $(".eqSlider").kendoSlider({
                orientation: "vertical",
                min: -20,
                max: 20,
                smallStep: 1,
                largeStep: 20,
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
            margin-top: 75px;
            padding-right: 15px;
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
            margin: 0 12px;
            height: 122px;
        }

        *+html .eqSlider {display:inline;}

    </style>