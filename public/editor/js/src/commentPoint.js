(function(){

    let markerModule = (function() {
        let form = undefined;
        let target = undefined;
        let delete_e = undefined;
        function init(form_element, delete_element, target_element) {
            form = form_element;
            form.hide();
            target = target_element;
            delete_e = delete_element;
            bindEvents();
        }

        function bindEvents()
        {
            form.on('submit', function(e) {
                bindCreateCommentPoint(e);
            });
            target.on('click', function(e) {
                bindShowFormEvent(e);
            });
            form.find('.close-marker-btn').on('click', function(e) {
                bindCloseEvent(e);
            });

        }

        function bindShowFormEvent(e) {
            if(selectedItem === 'marker'){
                let position_x = svgEditor.getCurPos(e).x;
                let position_y = svgEditor.getCurPos(e).y;

                form.show();
                form.attr('style','transform: translate('+(position_x)+'px,'+(position_y)+'px);');
                form.find('.input-group :input[name="position_x"]').attr('value', position_x);
                form.find('.input-group :input[name="position_y"]').attr('value', position_y);

                $('#svg-work-area').append(form);

            }
        }

        function bindCreateCommentPoint(e) {
            let form = $(e.target);
            e.preventDefault();

            let url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                beforeSend: function(){},
                success: (response) => {
                    console.log('Marker created successfully');

                    let marker_template = `
                        <marker id="marker_id_${response.id}" style="transform: translate(${response.position_x}px,${response.position_y}px);" class="comment-point-marker">
                         <span style="display:block">
                         ${response.text}
                         </span>
                         <span class="text-muted small">Created by ${response.creator.name}</span>
                         </marker>
                    `;

                    $('#svg-work-area').append(marker_template);

                    form.hide();
                },
                error: function(data){
                    console.log('ERROR [marker creation failed]:'+data);
                }
            });
        }

        function bindCloseEvent(e) {
            form.hide();
        }

        return {
            init: init,
        }
    })();

    markerModule.init($('#create-marker-form'), $('.delete-marker-btn'), $('#svg-area'));

})();
