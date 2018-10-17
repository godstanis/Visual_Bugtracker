
$(document).ready(function() {

    let ProjectsModule = (function(){
        
        let $project_box_delete = $(".delete-project-form");
        let delete_selector = ".delete-project-form";
        let $project_box_create = $(".create-project-form");
        let $projects_container = $(".projects-container");

        // Bind the events
        $projects_container.on('submit', delete_selector, deleteProject);
        $project_box_create.submit(createProject);

        

        function createProject(e){
            let form = $(e.target);
            e.preventDefault();

            let formData = new FormData(form.get(0));

            console.log(form.get(0));

            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.help-block').text('');
                },
                success: function(projectbox)
                {
                    form.closest('.project-box').before(projectbox);
                    form.trigger("reset");

                },
                error: function(response){
                    let response = JSON.parse(response.responseText);

                    form.parent().addClass('has-error');

                    for(let key in response){
                        let fields = response[key];
                        
                        for(let field in fields){
                            $('.'+key).append(fields[field]);
                        }
                    }

                }
            });

            e.preventDefault();
        };


        function deleteProject(e){
            
            e.preventDefault();

            let form = $(e.target);

            if(!confirm('Are you sure? This action will delet all project information!'))
                {
                    return false;
                }

            let form = $(e.target);
            //let formData = new FormData(form.get(0));

            $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(data)
                    {
                        //let response = JSON.parse(data);
                        console.log(data);

                        form.closest('.project-box').hide();
                    }
                });
            
        };

    })();

});