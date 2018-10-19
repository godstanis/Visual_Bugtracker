(function(){
   
    let board_id = editor_page_data.board_id;

    console.log ('board_'+board_id);

    Echo.private('board_'+board_id).listen('.userCreatedCommentPoint', function(message){
        console.log ('someone created comment:');
        console.log(message);

    });

    Echo.private('board_'+board_id).listen('.userDeletedCommentPoint', function(message){
        console.log ('someone deleted comment:');
        console.log(message);

    });

    Echo.private('board_'+board_id).listen('.userCreatedPath', function(message){
        console.log ('someone created path:');
        console.log(message);

        let path_json = message.path_json;
        let itemId = path_json.path_slug;
        
        drawSVG.createElement(itemId);
        element = document.getElementById(itemId);
        dataConstructor.constructElementFromObj().path(element, path_json);
        
    });

    Echo.private('board_'+board_id).listen('.userDeletedPath', function(message){
        console.log ('someone deleted path:');
        console.log(message);

        let path_json = message.path_json;
        let itemId = path_json.path_slug;

        drawSVG.deleteObject(itemId);
        dataConstructor.removeElement(itemId);
        
    });


    
})();