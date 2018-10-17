(function(){

    let drawModule = (function(){
        let svg_area = undefined;
        let editor_area = undefined;

        let itemId = null;

        function init(svgArea, editorArea)
        {
            svg_area = svgArea;
            editor_area = editorArea;
        };

        function bindEvents()
        {
            bindMouseEvents();
            bindTouchEvents();
        }

        function bindMouseEvents()
        {
  
            svg_area.on( "mousemove" , function(e){
                mouseMoveEvent(e);
            }).on( "mousedown" , function(e){
                mouseDownEvent(e);
            }).on( "mouseup" ,function(e) {
                mouseUpEvent(e);
            });

        };

        function bindTouchEvents()
        {
            svg_area.on( "touchmove" , function(e){
                touchMoveEvent(e);
            }).on( "touchstart" , function(e){
                touchDownEvent(e);
            }).on( "touchend" ,function(e) {
                touchUpEvent(e);
            });
        };

        let drawStatus = {
            isDrawing: false,
            fX: 0,
            fY: 0,
            lX:0,
            lY:0
        };

        function mouseMoveEvent(e)
        {
            if(drawStatus.isDrawing){
                let curPos = svgEditor.getCurPos(e);
                drawStatus.lX = curPos.x;
                drawStatus.lY = curPos.y;

                drawSVG.drawByString(selectedItem, itemId, drawStatus.fX, drawStatus.fY, drawStatus.lX, drawStatus.lY);
            }
            
            //Show coordinates in demo:
            str = 'X:'+svgEditor.getCurPos(e).x+'  Y:'+svgEditor.getCurPos(e).y;
            $('#current-pos').html(str);
        };

        function mouseDownEvent(e)
        {
            if (e.button === 0){ // draw only if left-mouse-button is pressed

                drawStatus.isDrawing = true;

                let curPos = svgEditor.getCurPos(e);
                drawStatus.fX = curPos.x;
                drawStatus.fY = curPos.y;

                itemId = (+ new Date()).toString(); // generate random unique id for figure
                
                let drawable = ['rectangle', 'arrow', 'line', 'ellipse'];

                if( drawable.indexOf(selectedItem) != -1 ){
                    drawSVG.createElement(itemId);
                }

            }
        };

        function mouseUpEvent(e)
        {
            if (e.button === 0){ // draw only if left-mouse-button is pressed
                drawStatus.isDrawing = false;

                let supported_for_save = ['path'];

                let element = document.getElementById(itemId);

                if( element && supported_for_save.indexOf(element.tagName) != -1)
                {
                    let d_exists = ( element.getAttribute('d') != null );

                    if(d_exists){

                        dataConstructor.storeElement(element);
                        
                        //editorDataManager.savePath(dataConstructor.getLastElement());
                        editorDataManager.savePath(element);
                    }
                }
            }

        };

        function touchMoveEvent(e)
        {
            let e_touch = e.originalEvent.touches[0];

            if(drawStatus.isDrawing){
                let curPos = svgEditor.getCurPos(e_touch);
                drawStatus.lX = curPos.x;
                drawStatus.lY = curPos.y;

                drawSVG.drawByString(selectedItem, itemId, drawStatus.fX, drawStatus.fY, drawStatus.lX, drawStatus.lY);
            }
        };

        function touchDownEvent(e)
        {
            drawStatus.isDrawing = true;

            let curPos = svgEditor.getCurPos(e.originalEvent.touches[0]);
            drawStatus.fX = curPos.x;
            drawStatus.fY = curPos.y;

            itemId = (+ new Date()).toString(); // generate random unique id for figure
            
            let drawable = ['rectangle', 'arrow', 'line', 'ellipse'];

            if( drawable.indexOf(selectedItem) != -1 ){
                drawSVG.createElement(itemId);
            }
        };

        function touchUpEvent(e)
        {
            drawStatus.isDrawing = false;

            let supported_for_save = ['path'];

            let element = document.getElementById(itemId);

            if( element && supported_for_save.indexOf(element.tagName) != -1)
            {
                let d_exists = ( element.getAttribute('d') != null );

                if(d_exists){
                    dataConstructor.storeElement(element);
                        
                    editorDataManager.savePath(dataConstructor.getLastElement());
                }
            }
        };

        return {
            init: init,
            bindEvents: bindEvents,
        };
    })();

    drawModule.init($('#svg-area'), $('#svg-editor-area'));
    drawModule.bindEvents();

})();
