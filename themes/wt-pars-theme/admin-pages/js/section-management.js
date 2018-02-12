(function ($) {
    $(document).ready(function () {

        $("#child-view").hide();

        var _courses = [];

        $("#create-record").on("click", function () {
            $("#main-view").remove();
            $("#child-view").show();

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/admin/createsection',
                method: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', settings.nonce)
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
                        option.dataset.instructor_id = data.instructor[i].instructor_id;
                        instructorHook.appendChild(option).innerText = data.instructor[i].instructor;
                    }
                    var xHook = document.getElementById("x-hook");
                    for (var i in data.clo) {
                        var option = document.createElement('option');
                        option.dataset.clo_id = data.clo[i].clo_id;
                        if (i % 2 == 0) {
                            option.className = "shaddy";
                        }
                        xHook.appendChild(option).innerText = data.clo[i].clo_code + "\n" + data.clo[i].clo_description;
                    }
                },
                complete: function () {

                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            })

            var yearHook = document.getElementById("year-hook");
            var year = new Date().getFullYear()
            for (var y = year - 5; y < year + 5; y++) {
                var option = document.createElement('option');
                if (y == year) {
                    option.defaultSelected = true;
                }
                yearHook.appendChild(option).innerText = y;
            }

            $("#course-hook").on("change", function () {
                for (var i = 0; i < _courses.length; i++) {
                    if (_courses[i].course_id == $(this).find(":selected").data("course_id")) {
                        $("#course-name").val(_courses[i].course_name);
                        $("#course-description").val(_courses[i].course_description);
                    }
                }
            });

            $("#y-snatch").on("click", function () {
                $("#x-hook").find(":selected").remove().appendTo("#y-hook");
            });

            $("#x-snatch").on("click", function () {
                $("#y-hook").find(":selected").remove().appendTo("#x-hook");
            });

            $(".close").on("click", function () {
                $("#myModal").hide();
            });

            $('#section-number').on('focus', function(){
                $('#section-box').addClass('upper-input');
            });

            $("#section-number").on("focusout", function (){
                if (parseInt($("#section-number").val()) == $("#section-number").val()){
                    var span = document.createElement("span");
                    span.className = "section-baby";
                    span.innerText = $("#section-number").val();
                    $("#section-hook").append(span);
                }
                $("#section-number").val("");
                $('#section-box').removeClass('upper-input');
            });

            $("#submit_form").on("submit", function (event) {
                event.preventDefault();

                var course_id = $("#course-hook").find(":selected").data("course_id");
                var instructor = $("#instructor-hook").val();
                var instructor_id = $("#instructor-hook").find(":selected").data("instructor_id");
                var year_selected = $("#year-hook").val();
                var term = $("#term").val();

                console.log(course_id + " " + instructor + " " + instructor_id + " " + year_selected + " " + term);

                var clo_id = [];
                var section_number = [];

                for (var i = 0; i < $("#y-hook").find(":selected").length; i++) {
                    // console.log($("#y-hook").find(":selected")[i].dataset.clo_id);
                    clo_id.push($("#y-hook").find(":selected")[i].dataset.clo_id);
                }

                for (var i = 0; i < $(".section-baby").length; i++) {
                    // console.log($(".section-baby")[i].innerText);
                    section_number.push($(".section-baby")[i].innerText);
                }

                json_clo_id = JSON.stringify(clo_id);
                json_section_number = JSON.stringify(section_number);

                console.log(json_section_number);
                console.log(json_clo_id);
                
                $.ajax({
                    url: settings.root + "wt-pars-theme/v2/admin/alphastage/" + course_id + "/" + instructor_id + "/" + instructor + "/" + json_section_number + "/" + year_selected + "/" + term + "/" + json_clo_id,
                    method: 'POST',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', settings.nonce)
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    complete: function (xhr) {
                        
                    },
                    error: function (xhr, status, error) {
                        console.info(xhr.responseText);
                    },
                });
            });
        });
    });
})(jQuery);