
$(document).ready(function() {

    var BoardModule = {
        create_board_form: undefined,
        delete_board_form: undefined,
        init: function(create_board_form, delete_board_form){
            this.create_board_form = create_board_form;
            //this.delete_board_form = delete_board_form;
        },
        bindEvents: function(){
            this.create_board_form.submit(this.createBoard.bind(this));
            //this.delete_board_form.click(this.deleteBoard.bind(this));

        },
        createBoard: function(e){

            e.preventDefault();

            var form = $(e.target);

            var formData = new FormData(form.get(0));
            
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('.help-block').text('');
                },
                success: function(boardbox){
                    form.closest('.board-box').before(boardbox);
                    form.closest('.board-box').hide();
                },
                error: function(data){
                    var response = JSON.parse(data.responseText);

                    form.parent().addClass('has-error');

                    for(var key in response){
                        var fields = response[key];
                        
                        for(var field in fields){
                            $('.'+key).append(fields[field]);
                        }
                    }
                }
            });

        },
        deleteBoard: function(e){
            e.preventDefault();

            var url = $(e.target).attr('href');

            if(url === undefined){ // if clicked on icon inside <a>
                url = $(e.target).closest('a').attr('href');
            }

            $.ajax({
                type: "GET",
                url: url,
                success: function(response){
                    $(e.target).closest('tr').hide();
                }
            });
        },        
    };

    BoardModule.init( $('.create-board-form') , $('.issue-control-block a.delete-issue-btn') );

    BoardModule.bindEvents();

    console.log('board module loaded');

});
