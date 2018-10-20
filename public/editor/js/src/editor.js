(function(){

    /*
        Loaded image centering
    */
    $('#centerImage').click(function(){
        svgEditor.center();
    });

    /*
        JSON conversion functions showcase
    */
    $('#generateFromJson').click(function(){

        json_string = $('#json_input').val();

        dataConstructor.drawElementsFromJSON(drawSVG, json_string);
        
    });

    $('#generateJson').click(function(){

        generated_json = dataConstructor.generateJSON();
        $('#json_input').val(generated_json);
        $('#generate_json_block').click();

    });

    /*
        Stroke width slider event
    */
    $('#stroke-width-range').on("input", function() {
        let strokeRange = $('#stroke-width-range').val();
        $('#stroke-width-output').text(strokeRange);
        drawSVG.setWidth(strokeRange+'px');
    });


})();
