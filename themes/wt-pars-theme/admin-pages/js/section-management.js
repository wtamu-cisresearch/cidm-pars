(function($){
    $(document).ready(function() {

            var _courses = [];

            $("#create-record").on("click", function(){

            $("#myModal").show();

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/admin/createsection',
                method: 'GET',
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                },
                success: function (data) {
                    var courseHook = document.getElementById("course-hook");
                    for (var i in data.course) {
                        var option = document.createElement('option'); 
                        option.dataset.course_id = data.course[i].course_id;
                        courseHook.appendChild(option).innerText = data.course[i].course_code;
                    }
                    _courses = data.course;
                    var instructorHook = document.getElementById("instructor-hook");
                    for (var i in data.instructor) {
                        var option = document.createElement('option'); 
                        instructorHook.appendChild(option).innerText = data.instructor[i].instructor;
                    }
                    var xHook = document.getElementById("x-hook");
                    for (var i in data.clo) {
                        var option = document.createElement('option');
                        option.dataset.course_id = data.clo[i].clo_id;
                        if (i % 2 == 0){
                            option.className = "shaddy";
                        }
                        xHook.appendChild(option).innerText = data.clo[i].clo_code + "\n" + data.clo[i].clo_description;
                    }
                },
                complete: function(){
                    
                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            })

            var yearHook = document.getElementById("year-hook");
            var year = new Date().getFullYear()
            for (var y = year - 5; y < year + 5; y++){
                var option = document.createElement('option');
                if(y == year){
                    option.defaultSelected = true;
                }
                yearHook.appendChild(option).innerText = y;
            }

            $("#course-hook").on("change", function(){
                for (var i = 0; i < _courses.length; i++){
                    if(_courses[i].course_id == $(this).find(':selected').data('course_id')){
                        $('#course_name').val(_courses[i].course_name);
                        $('#course_description').val(_courses[i].course_description);
                    }
                }
            });

            $("#y-snatch").on("click", function(){
                $("#x-hook").find(":selected").remove().appendTo("#y-hook");
            });

            $("#x-snatch").on("click", function(){
                $("#y-hook").find(":selected").remove().appendTo("#x-hook");
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