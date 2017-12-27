(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#add").hide();
            $("#update").show();
            $("#myModal").show();

            $("#clo_code ").val($(this).data("code"));
            $("#clo_description").val($(this).data("description"));

            var clo_id = $(this).data("clo_id");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var clo_code = $("#clo_code ").val();
                var clo_description = $("#clo_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/clo/' + clo_id + '/' + clo_code + '/' + clo_description,
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
                    url: settings.root + 'wt-pars-theme/v2/admin/clo/' + clo_id,
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

            $("#clo_code ").val("");
            $("#clo_description").val("");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var clo_code = $("#clo_code ").val();
                var clo_description = $("#clo_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/clo/' + clo_code + '/' + clo_description,
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