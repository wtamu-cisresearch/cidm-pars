(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#myModal").show();

            var section_id = $(this).data("section_id");
            console.info(section_id);

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/viewresults/' + section_id,
                method: 'GET',
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                },
                success: function (data) {
        
                    $('#_year').text(data[0].year);
                    $('#_term').text(data[0].term);
                    $('#_course').text(data[0].course_code);
                    $('#_number').text(data[0].number);
                    $('#_course_description').text(data[0].course_description);
                    $('#_instructor').text(data[0].instructor);
                    $('#_a').text(data[0].a);
                    $('#_b').text(data[0].b);
                    $('#_c').text(data[0].c);
                    $('#_d').text(data[0].d);
                    $('#_f').text(data[0].f);
                    $('#_x').text(data[0].x);
                    $('#_total').text( parseInt(data[0].a) + parseInt(data[0].b) + parseInt(data[0].c) + parseInt(data[0].d) + parseInt(data[0].f) + parseInt(data[0].x));
                    
                    var tracker = [];

                    for (var d in data) {
                        if(!tracker.includes(data[d].clo_description)){
                            var tr = document.createElement('tr');
                            $("#mappingHook").append(tr);
                            var so = data[d].so_code + ' - ' + data[d].so_description;
                            var clo = data[d].clo_code + ' - ' + data[d].clo_description
                            tr.appendChild(document.createElement('td')).innerText = so;
                            tr.appendChild(document.createElement('td')).innerText = clo;
                        }
                        tracker.push(data[d].clo_description);
                    }

                    for (var d in data) {
                        var sum = parseInt(data[d].exemplary) + parseInt(data[d].good) + parseInt(data[d].satisfactory) + parseInt(data[d].poor) + parseInt(data[d].unsatisfactory);
                        var tr = document.createElement('tr');
                        $("#measuresHook").append(tr);
                        tr.appendChild(document.createElement('td')).innerText = data[d].so_code;
                        tr.appendChild(document.createElement('td')).innerText = data[d].clo_code;
                        tr.appendChild(document.createElement('td')).innerText = data[d].type;
                        tr.appendChild(document.createElement('td')).innerText = data[d].comment;
                        tr.appendChild(document.createElement('td')).innerText = data[d].exemplary + ' (' + Math.round((data[d].exemplary / sum) * 100) + '%)';
                        tr.appendChild(document.createElement('td')).innerText = data[d].good + ' (' + Math.round((data[d].good / sum) * 100) + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].satisfactory + ' (' + Math.round((data[d].satisfactory / sum) * 100) + '%)';
                        tr.appendChild(document.createElement('td')).innerText = data[d].poor + ' (' + Math.round((data[d].poor / sum) * 100) + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].unsatisfactory + ' (' + Math.round((data[d].unsatisfactory / sum) * 100) + '%)';
                    }
            
                    $('#_modification').text(data[0].modification);
                    $('#_reflection').text(data[0].reflection);
                    $('#_feedback').text(data[0].feedback);
                    $('#_proposed_action').text(data[0].proposed_action);
        
                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            })
            
        });

        $(".close").on("click", function(){
            $("#myModal").hide();
            $("#measuresHook").text('');
            $("#mappingHook").text('');
        });

        $(window).on("click", function(event){
            if (event.target == document.getElementById("myModal")) {
                $("#myModal").hide();
                $("#measuresHook").text('');
                $("#mappingHook").text('');
            }
        });
    });
})(jQuery);
