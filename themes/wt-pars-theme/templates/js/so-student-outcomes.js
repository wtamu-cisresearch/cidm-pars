(function($){
    $(document).ready(function() {

        $(".record").on("click", function(){

            $("#myModal").show();

            var so_id = $(this).data("so_id");
            var year = $(this).data("year");
            var term = $(this).data("term");
            console.info(so_id);

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/studentoutcomes/' + so_id + '/' + year + '/' + term,
                method: 'GET',
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                },
                success: function (data) {
                    for (var d in data) {
                        var sum = parseInt(data[d].exemplary) + parseInt(data[d].good) + parseInt(data[d].satisfactory) + parseInt(data[d].poor) + parseInt(data[d].unsatisfactory);
                        var tr = document.createElement('tr');
                        $("#measuresHook").append(tr);
                        tr.appendChild(document.createElement('td')).innerText = data[d].clo_code + ' ' + data[d].clo_description;
                        tr.appendChild(document.createElement('td')).innerText = data[d].course_code;
                        tr.appendChild(document.createElement('td')).innerText = data[d].section_number;
                        tr.appendChild(document.createElement('td')).innerText = data[d].exemplary + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].satisfactory + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].unsatisfactory + '%';
                    }    

                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            })
            
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