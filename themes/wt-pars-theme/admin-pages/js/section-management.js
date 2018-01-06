(function($){
    $(document).ready(function() {

            $("#create-record").on("click", function(){

            $("#myModal").show();

            // $("#course_code ").val($(this).data("code"));
            // $("#course_name").val($(this).data("name"));
            // $("#course_description").val($(this).data("description"));

            // var course_id = $(this).data("course_id");
            
            $("#submit_form").on("submit", function(event){
                event.preventDefault();
                var course_code = $("#course_code ").val();
                var course_name = $("#course_name").val();
                var course_description = $("#course_description").val();
                $.ajax({
                    url: settings.root + 'wt-pars-theme/v2/admin/course/' + course_id + '/' + course_code + '/' + course_name + '/' + course_description,
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

            $(".close").on("click", function(){
                $("#myModal").hide();
            });

            $(window).on("click", function(event){
                if (event.target == document.getElementById("myModal")) {
                    $("#myModal").hide();
                }
            });
        });
    });
})(jQuery);