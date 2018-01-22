(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#add").hide();
            $("#update").show();
            $("#myModal").show();

            $("#so_code ").val($(this).data("code"));
            $("#so_description").val($(this).data("description"));

            var so_id = $(this).data("so_id");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var so_code = $("#so_code ").val();
                var so_description = $("#so_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/so/' + so_id + '/' + so_code + '/' + so_description,
                    method: 'PUT',
                    beforeSend: function(xhr){
                        xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                    },
                    success: function (responce) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.info(xhr.responseText);
                    },
                })
            });

            $("#delete").on("click", function(event){
                event.preventDefault();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/so/' + so_id,
                    method: 'DELETE',
                    beforeSend: function(xhr){
                        xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                    },
                    success: function (responce) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.info(xhr.responseText);
                    },
                })
            });
        });

        $("#add_record").on("click", function(){

            $("#update").hide();
            $("#delete").hide();
            $("#add").show();
            $("#myModal").show();

            $("#so_code ").val("");
            $("#so_description").val("");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var so_code = $("#so_code ").val();
                var so_description = $("#so_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/so/' + so_code + '/' + so_description,
                    method: 'POST',
                    beforeSend: function(xhr){
                        xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                    },
                    success: function (responce) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.info(xhr.responseText);
                    },
                })
            }); 
        });

        $(".close").on("click", function(){
            $("#myModal").hide();
        });

        $(window).on("click", function(event){
            if (event.target == document.getElementById("myModal")) {
                $("#myModal").hide();
            }
        });
    });
})(jQuery);