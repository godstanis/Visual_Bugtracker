<div class="zoom-panel">
    <i class="sprite sprite-zoom-in zoom-btn zoom-svg-in" title="Zoom-in"></i>
    <i class="sprite sprite-zoom-out zoom-btn zoom-svg-out" title="Zoom-out"></i>
</div>

<div class="json-management-panel" style="display:none">
    <button id="generateJson">Generate JSON</button>

    <div id="generate_json_block">
        <button>Generate from JSON</button>

        <div id="json_input_block">
            <textarea name="json_input" id="json_input" cols="30" rows="10"></textarea>
            <button id="generateFromJson">Generate</button>
        </div>
    </div>
</div>

<div class="control-panel">

    <div class="radio-tab" id="select-item-form">
        <div class="radio-figure">
            <label for="rectangle-radio">
                <input id="rectangle-radio" type="radio" value="rectangle" name="item" checked>
                <i class="sprite sprite-rectangle" title="Rectangle"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="arrow-radio">
                <input id="arrow-radio" type="radio" value="arrow" name="item">
                <i class="sprite sprite-arrow" title="Arrow"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="line-radio">
                <input id="line-radio" type="radio" value="line" name="item">
                <i class="sprite sprite-line" title="Line"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="ellipse-radio">
                <input id="ellipse-radio" type="radio" value="ellipse" name="item">
                <i class="sprite sprite-ellipse" title="Ellipse"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="eraser-radio">
                <input id="eraser-radio" type="radio" value="eraser" name="item">
                <i class="sprite sprite-eraser" title="Eraser"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="drag-radio">
                <input id="drag-radio" type="radio" value="drag" name="item" >
                <i class="sprite sprite-drag" title="Drag (Mouse wheel)"></i>
            </label>
        </div>
        <div class="radio-figure">
            <label for="marker-radio">
                <input id="marker-radio" type="radio" value="marker" name="item" >
                <i class="sprite sprite-marker" title="Marker"></i>
            </label>
        </div>
    </div>
    
    <div class="buttons-separator"></div>
    
    <div class="functional-btns">
       
            <i id="centerImage" class="sprite sprite-center" title="Center Image"></i>
       
    </div>
    <div>
        <label for="stroke-width-range"><b>STROKE WIDTH</b> </label>
        <input id="stroke-width-range" type="range" min="1" max="32" step="1" value="4">
        <span style="display:inline-block;width:20px;font-size:150%" id="stroke-width-output">4</span>
    </div>
    <input class="jscolor {width:243, height:150, position:'bottom',
    borderColor:'#474D57', insetColor:'#32363D', backgroundColor:'#666', borderRadius:'0', zIndex:11000}" value="00FF00" name="strokeColor" readonly="true">
    
</div>

<div id="svg-editor-area">
    <div id="svg-work-area">
        <div id="svg-image-couple">
            <svg id="svg-area" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" shape-rendering="auto">
            </svg>
            <div id="bg-element">
                <img id="bg-element-image" src="" alt="">
            </div>
        </div>
    </div>
</div>
