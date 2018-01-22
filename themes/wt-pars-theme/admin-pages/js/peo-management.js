(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#add").hide();
            $("#update").show();
            $("#myModal").show();

            $("#peo_code ").val($(this).data("code"));
            $("#peo_description").val($(this).data("description"));

            var peo_id = $(this).data("peo_id");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var peo_code = $("#peo_code ").val();
                var peo_description = $("#peo_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/peo/' + peo_id + '/' + peo_code + '/' + peo_description,
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
                    url: settings.root + 'wt-pars-theme/v2/admin/peo/' + peo_id,
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

            $("#peo_code ").val("");
            $("#peo_description").val("");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var peo_code = $("#peo_code ").val();
                var peo_description = $("#peo_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/peo/' + peo_code + '/' + peo_description,
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