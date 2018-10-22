<div class="zoom-panel">
    <i class="sprite sprite-zoom-in zoom-btn zoom-svg-in" title="Zoom-in"></i>
    <i class="sprite sprite-zoom-out zoom-btn zoom-svg-out" title="Zoom-out"></i>

    <i id="centerImage" class="sprite sprite-center" title="Center Image"></i>
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
            <label for="marker-radio">
                <input id="marker-radio" type="radio" value="marker" name="item" >
                <i class="sprite sprite-marker" title="Marker"></i>
            </label>
        </div>
        <div class="buttons-separator"></div> <!-- separator -->
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
    </div>

    <div>
        <label for="stroke-width-range"><b>@lang('editor.stroke_width'):</b></label>
        <input id="stroke-width-range" type="range" min="1" max="32" step="1" value="4">
        <span style="display:inline-block;width:20px;" id="stroke-width-output">4</span>px
    </div>
    <input class="jscolor {width:243, height:150, position:'bottom',
    borderColor:'#474D57', insetColor:'#32363D', backgroundColor:'#666', borderRadius:'0', zIndex:11000}" value="00FF00" name="strokeColor" readonly="true">

</div>

<div id="svg-editor-area">
    <div id="svg-work-area">
        @include('bugtracker.editor.partials.components.marker-form')
        <div id="svg-image-couple">
            <svg id="svg-area" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" shape-rendering="auto">
                <!-- PathsRender react.js component container -->
            </svg>
            <div id="bg-element">
                <img id="bg-element-image" src="{{ $current_board->sourceImageUrl() }}" alt="Board source image">
            </div>
        </div>
        <div id="markers-container">
            <!-- MarkersRender react.js component container -->
        </div>
    </div>
</div>
