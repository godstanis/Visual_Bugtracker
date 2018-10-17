
let svgEditor = (function(){
    console.log('Editor initialized');
    let workAreaElement= ""; // element, affected by scaling/translating
    let backgroundElement= "";
    let svgElement= "";
    let coordScale= 1;
    let maxScale= 2;
    let minScale= 0.3;
    let curX = 0;
    let curY = 0;

    function init(workAreaId, svgElementId, backgroundElementId){ 
        workAreaElement = document.getElementById(workAreaId);
        svgElement = document.getElementById(svgElementId);
        backgroundElement = document.getElementById(backgroundElementId);

    };

    function getCurX(){
        return curX;
    };

    function getCurY(){
        return curY;
    };

    function getScale(){
        return coordScale;
    };

    function center(){
        let windowCenterX = window.innerWidth / 2;
        let windowCenterY = window.innerHeight / 2;

        let svgRect = svgElement.getBoundingClientRect();

        let currentSvgCenterX = (svgRect.width / 2) / coordScale;
        let currentSvgCenterY = (svgRect.height / 2) / coordScale;

        curX = windowCenterX - currentSvgCenterX;
        curY = windowCenterY - currentSvgCenterY;

        updateTransform();

    };
    function drag(f_editor_X, f_editor_Y, difX, difY){
        curX = f_editor_X+difX;
        curY = f_editor_Y+difY;

        updateTransform();
    };
    function scale(in_scale){

        let scale = parseFloat(in_scale.toFixed(2));

        if (( minScale <= in_scale ) && ( in_scale <= maxScale )){
            coordScale = in_scale
            updateTransform();
            return true;
        }

        return false;
    };
    function updateTransform()
    {
        let translate = "translate(" + curX + "px," + curY + "px)";
        let scale = "scale("+coordScale+")";

        workAreaElement.style.transform = translate+scale;
    };
    function setPosition(left, top){
        /*
        workAreaElement.style.left = left+'px';
        workAreaElement.style.top = top+'px';
        */
        workAreaElement.style.transform = "translate(" + left + "px," + top + "px)";
    };
    function setScale(in_scale)
    {
        workAreaElement.style.transform = "scale("+in_scale+")";
    };
    // initialize image and adjust editor elements sizing
    function initImage( image_path )
    {

        let bgImg = backgroundElement.getElementsByTagName('img')[0];

        function initImgSizing(){
            
            let imageWidth = bgImg.offsetWidth;
            let imageHeight = bgImg.offsetHeight;

            svgElement.style['width'] = imageWidth+'px';
            svgElement.style['height'] = imageHeight+'px';

        }

        function setImage(image_element, image_path){
            image_element.setAttribute('src', image_path);
        }

        scale(minScale);

        setImage(bgImg, image_path);

        bgImg.onload = function(){
            initImgSizing();
            updateTransform();
            center();
        };
    };
    function getOffset(element){ //Service method, providing current information about <svg> relative position
        let box = element.getBoundingClientRect();
        return {
            top: box.top + pageYOffset,
            left: box.left + pageXOffset
        };
    };
    function getCurPos(e, scale){ //Returns current mouse position in relative <svg> coordinates
        if(scale === undefined){
            scale = coordScale;
        }
        let svg = workAreaElement;
        let x = e.pageX - getOffset(svg).left;
        let y = e.pageY - getOffset(svg).top;
        return {
            x: Math.round(x*1/scale),
            y: Math.round(y*1/scale)
        }
    };

    return {
        init: init,
        center: center,
        drag: drag,
        scale: scale,
        initImage: initImage,
        getOffset: getOffset,
        getCurPos: getCurPos,
        curX: getCurX,
        curY: getCurY,
        coordScale: getScale,
    };

})();
