
$(document).ready(function() {

    var ProjectsModule = (function(){
        
        var $project_box_delete = $(".delete-project-form");
        var delete_selector = ".delete-project-form";
        var $project_box_create = $(".create-project-form");
        var $projects_container = $(".projects-container");

        // Bind the events
        $projects_container.on('submit', delete_selector, deleteProject);
        $project_box_create.submit(createProject);

        

        function createProject(e){
            var form = $(e.target);
            e.preventDefault();

            var formData = new FormData(form.get(0));

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
                    var response = JSON.parse(response.responseText);

                    form.parent().addClass('has-error');

                    for(var key in response){
                        var fields = response[key];
                        
                        for(var field in fields){
                            $('.'+key).append(fields[field]);
                        }
                    }

                }
            });

            e.preventDefault();
        };


        function deleteProject(e){
            
            e.preventDefault();

            var form = $(e.target);

            if(!confirm('Are you sure? This action will delet all project information!'))
                {
                    return false;
                }

            var form = $(e.target);
            //var formData = new FormData(form.get(0));

            $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(data)
                    {
                        //var response = JSON.parse(data);
                        console.log(data);

                        form.closest('.project-box').hide();
                    }
                });
            
        };

    })();

});