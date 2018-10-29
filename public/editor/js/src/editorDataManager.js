let editorDataManager = (function(){

    function savePath(element)
    {
        //console.log(element);
        let path_json = dataConstructor.createObjectFromPath(element);
        
        $.ajax({
            type: "POST",
            url: editor_page_data.create_path_link,
            data: {
                path_data:path_json['d'],
                stroke_width:path_json['stroke-width'],
                stroke_color:path_json['stroke'],
            },
            success: function(data){
                //console.log(data);
                //data = JSON.parse(data);
                cheangeElementId(element, data.path_slug);
            }
        });

        
    }

    function cheangeElementId(element, id){
        element.setAttribute('id', id);
    }

    function deletePath(path_id)
    {

        $.ajax({
            type: "POST",
            url: editor_page_data.delete_path_link,
            data: {path_slug:path_id},
            success: function(data){
                console.log ('element deleted success');
                deleteElement(path_id)
            },
            error: function(data){
                alert ('You are not allowed to delete others elements!');
            },
        });

    }

    function deleteElement(path_id){
        drawSVG.deleteObject(path_id);
        dataConstructor.removeElement(path_id);
    }

    return {
        savePath: savePath,
        deletePath: deletePath,
    };

})();