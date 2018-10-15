
$(document).ready(function() {

    let BoardModule = {
        create_board_form: undefined,
        delete_board_btn: undefined,
        init: function(create_board_form, delete_board_form){
            this.create_board_form = create_board_form;
            this.delete_board_btn = delete_board_form;
        },
        bindEvents: function(){
            $(this.create_board_form).submit(this.createBoard.bind(this));
            $(document).on("click", this.delete_board_btn, this.deleteBoard.bind(this));
        },
        createBoard: function(e){

            e.preventDefault();
            let form = $(e.target);
            let formData = new FormData(form.get(0));
            
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
                    $('#boards-block').children().last('.board-box').after(boardbox);
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
        deleteBoard: function(e){
            console.log('delete-pressed');
            e.preventDefault();

            let url = $(e.target).attr('href');

            if(url === undefined){ // if clicked on icon inside <a>
                url = $(e.target).closest('a').attr('href');
            }

            $.ajax({
                type: "GET",
                url: url,
                success: function(response){
                    console.log('success');
                    $(e.target).closest('.board-box').hide();
                }
            });
        },        
    };

    BoardModule.init( '.create-board-form', '#boards-block a.delete-board' );
    BoardModule.bindEvents();

    console.log('board module loaded');

});
