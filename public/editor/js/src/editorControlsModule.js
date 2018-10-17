(function(){
    let editorControlsModule = (function(){

        let svg_area = undefined;
        let editor_area = undefined;
        let svg_elements = undefined;

        function init(svgArea, editorArea, svgElements)
        {
            svg_area = svgArea;
            editor_area = editorArea;
            svg_elements = svgElements;
        };

        function bindEvents()
        {
            bindMouseEvents();
            bindTouchEvents();
            bindDeleteEvent();
            bindWheelEvents();
            bindZoomButtonsEvents();
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

        function bindWheelEvents()
        {
            editor_area.on('mousewheel', function(e){
                mouseWheelZoomEvent(e);
            });
        };

        function bindDeleteEvent()
        {
            $(document).on('click', svg_elements,function(e){

                deleteElementEvent(e);
            });
        };

        function bindZoomButtonsEvents()
        {
            $('.zoom-svg-in').click(function(e){
                zoomInClickEvent(e);
            });

            $('.zoom-svg-out').click(function(e){
                zoomOutClickEvent(e);
            });
        };

        let dragStatus = {
            isDragging: false,
            editorX: 0,
            editorY: 0,
            fX: 0,
            fY: 0,
            lX: 0,
            lY: 0
        };

        function mouseMoveEvent(e)
        {
            if(dragStatus.isDragging)
            {
                dragStatus.lX = e.clientX - dragStatus.fX;
                dragStatus.lY = e.clientY - dragStatus.fY;
                svgEditor.drag(dragStatus.editorX, dragStatus.editorY, dragStatus.lX, dragStatus.lY);
            }
        };

        function mouseDownEvent(e)
        {
            let actionIsDrag = (e.button === 1) || (selectedItem == "drag");

            if( actionIsDrag ){
                dragStatus.isDragging = true;
            }

            dragStatus.editorX = svgEditor.curX();
            dragStatus.editorY = svgEditor.curY();

            dragStatus.fX = e.clientX;
            dragStatus.fY = e.clientY;
        };

        function mouseUpEvent(e)
        {
            dragStatus.isDragging = false;
        };

        function mouseWheelZoomEvent(e)
        {
            let scaleSize = e.deltaY * 0.1;
            svgEditor.scale( svgEditor.coordScale() + scaleSize );
        };

        function touchMoveEvent(e)
        {
            let e_touch = e.originalEvent.touches[0];

            if(dragStatus.isDragging)
            {
                dragStatus.lX = e_touch.clientX - dragStatus.fX;
                dragStatus.lY = e_touch.clientY - dragStatus.fY;

                svgEditor.drag(dragStatus.editorX, dragStatus.editorY, dragStatus.lX, dragStatus.lY);
            }
        };

        function touchDownEvent(e)
        {
            let e_touch = e.originalEvent.touches[0];

            let actionIsDrag = (selectedItem == "drag");
            if( actionIsDrag ){
                dragStatus.isDragging = true;
            }
            dragStatus.editorX = svgEditor.curX();
            dragStatus.editorY = svgEditor.curY();

            dragStatus.fX = e_touch.clientX;
            dragStatus.fY = e_touch.clientY;
        };

        function touchUpEvent(e)
        {
            dragStatus.isDragging = false;
        };

        function zoomInClickEvent(e){
            svgEditor.scale( svgEditor.coordScale() + 0.1 );   
        };

        function zoomOutClickEvent(e){
            svgEditor.scale( svgEditor.coordScale() - 0.1);
        };

        function deleteElementEvent(e)
        {
            if(selectedItem == 'eraser'){

                let deletable = ['path']; // deletable object tags

                if(deletable.indexOf(e.target.tagName) != -1 && confirm('Are you sure?'))
                {

                    editorDataManager.deletePath(e.target.id)
                    
                }
            }
        };

        return {
            init: init,
            bindEvents: bindEvents,
        };
    })();

    editorControlsModule.init($('#svg-area'), $('#svg-editor-area'), $('.svg-element'));
    editorControlsModule.bindEvents();

})();
