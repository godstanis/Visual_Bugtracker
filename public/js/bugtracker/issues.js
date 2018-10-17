
$(document).ready(function() {

    let IssueModule = {
        create_issue_form: undefined,
        delete_issue_btn: undefined,
        init: function(create_issue_form, delete_issue_btn){
            this.create_issue_form = create_issue_form;
            this.delete_issue_btn = delete_issue_btn;
        },
        bindEvents: function(){
            this.create_issue_form.submit(this.createIssue.bind(this));
            this.delete_issue_btn.click(this.deleteIssue.bind(this));

        },
        createIssue: function(e){
            e.preventDefault();

            let form = $(e.target);

            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(), // serializes the form's elements.
                beforeSend: function(){
                    $('.help-block').text('');
                },
                success: function(projectbox){
                    //form.closest('.modal').modal('toggle');
                    location.reload();
                },
                error: function(data){
                    let response = JSON.parse(data.responseText);

                    form.parent().addClass('has-error');

                    for(let key in response){
                        let fields = response[key];
                        
                        for(let field in fields){
                            $('.'+key).append(fields[field]);
                        }
                    }
                }
            });
        },
        deleteIssue: function(e){
            e.preventDefault();

            let url = $(e.target).attr('href');
            let token = $(e.target).attr('data-token');

            if(url === undefined){ // if clicked on icon inside <a>
                url = $(e.target).closest('a').attr('href');
                token = $(e.target).closest('a').attr('data-token');
            }

            $.ajax({
                type: "POST",
                url: url,
                data: {'_token':token},
                success: function(response){
                    $(e.target).closest('tr').hide();
                }
            });
        },        
    };

    IssueModule.init( $('.create-issue-form') , $('.issue-control-block a.delete-issue-btn') );

    IssueModule.bindEvents();

});
