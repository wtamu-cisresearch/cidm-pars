(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#add").hide();
            $("#update").show();
            $("#myModal").show();

            $("#course_code ").val($(this).data("code"));
            $("#course_name").val($(this).data("name"));
            $("#course_description").val($(this).data("description"));

            var course_id = $(this).data("course_id");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var course_code = $("#course_code ").val();
                var course_name = $("#course_name").val();
                var course_description = $("#course_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/course/' + course_id + '/' + course_code + '/' + course_name + '/' + course_description,
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
                    url: settings.root + 'wt-pars-theme/v2/course/' + course_id ,
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

        $("#add_course").on("click", function(){

            $("#update").hide();
            $("#delete").hide();
            $("#add").show();
            $("#myModal").show();

            $("#course_code ").val("");
            $("#course_name").val("");
            $("#course_description").val("");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var course_code = $("#course_code ").val();
                var course_name = $("#course_name").val();
                var course_description = $("#course_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/course/' + course_code + '/' + course_name + '/' + course_description,
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
            $("#measuresHook").text('');
            $("#myModal").hide();
        });

        $(window).on("click", function(event){
            if (event.target == document.getElementById("myModal")) {
                $("#measuresHook").text('');
                $("#myModal").hide();
            }
        });
    });
})(jQuery);