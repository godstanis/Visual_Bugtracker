/*
    Simple object constructor for drawSVG component.
    Can be used to generate json representation of drawing objects for later saving.
*/

var dataConstructor = (function(){
    var elements = {}; // object that contains our svg elements
    var last_element_id = undefined;
    function storeElement(element){ // function to add new svg element to 'elements' object.
        var item_id = element.id;

        elements[item_id] = createObjectFromPath(element);
        last_element_id = item_id;
    };

    function removeElement(element_id){
        delete elements[element_id];
        console.log ('removed element with id:'+element_id);
    };

    function getLastElement(){
        var last_element = elements[last_element_id];
        return last_element;
    };

    /*
        Generates js object representing the given html svg path element
    */
    function createObjectFromPath(element){

        return {
            'stroke': element.getAttribute('stroke'),
            'stroke-width': element.getAttribute('stroke-width').replace('px',''),
            'd': element.getAttribute('d'),
        };
            
    };
    function generateJSON(){ //generates a JSON string of elements collection
        return JSON.stringify(elements);
    };
    function generateObject(json_string)
    {
        return JSON.parse(json_string);
    };
    /*
        Draws the on-screen elements with drawSVG using JSON
    */
    function drawElementsFromJSON(drawSVG, json_string)
    {

        var obj = this.generateObject(json_string);

        for(var id in obj)
        {
            var curObj = obj[id];

            drawSVG.createElement(id);
            element = document.getElementById(id);

            this.constructElementFromObj().path(element, curObj);

        }
    };
    function constructElementFromObj(){
        return {
            path: function(element, obj){
                element.setAttribute('d', obj['d']);
                element.setAttribute('stroke', obj['stroke']);
                element.setAttribute('stroke-width', obj['stroke-width']);
            }
        }
    };
    function clear(){ //clears element object
        elements = {};
    };

    return {
        'elements': elements,
        'storeElement': storeElement,
        'removeElement': removeElement,
        'createObjectFromPath': createObjectFromPath,
        'generateJSON': generateJSON,
        'generateObject': generateObject,
        'drawElementsFromJSON': drawElementsFromJSON,
        'constructElementFromObj': constructElementFromObj,
        'clear': clear
    };
})();

