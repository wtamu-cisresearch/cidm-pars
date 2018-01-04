(function($){
    $(document).ready(function() {

        $(".so-record").on("click", function(){

            $("#measuresHook").text('');
            $(".undercover").hide();
            $(".sunlight").show();
            $("#myModal").show();
            var copycat = document.getElementById("copycat");
            copycat.dataset.so_id = $(this).data("so_id");
            copycat.dataset.year = $(this).data("year");
            copycat.dataset.term = $(this).data("term");
            var so_id = $(this).data("so_id");
            var year = $(this).data("year");
            var term = $(this).data("term");
            console.info(so_id);

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/template/clo/' + so_id + '/' + year + '/' + term,
                method: 'GET',
                beforeSend: function(xhr){
                    xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                },
                success: function (data) {
                    for (var d in data) {
                        var sum = parseInt(data[d].exemplary) + parseInt(data[d].good) + parseInt(data[d].satisfactory) + parseInt(data[d].poor) + parseInt(data[d].unsatisfactory);
                        var tr = document.createElement('tr');
                        $("#measuresHook").append(tr);
                        var td = document.createElement('td');
                        var a = document.createElement("a");
                        a.innerText = data[d].clo_code + ' ' + data[d].clo_description;
                        a.href = "#";
                        a.dataset.clo_id = data[d].clo_id;
                        a.className = "clo_record";
                        td.appendChild(a);
                        tr.appendChild(td);
                        tr.appendChild(document.createElement('td')).innerText = data[d].course_code;
                        tr.appendChild(document.createElement('td')).innerText = data[d].section_number;
                        tr.appendChild(document.createElement('td')).innerText = data[d].exemplary + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].satisfactory + '%';
                        tr.appendChild(document.createElement('td')).innerText = data[d].unsatisfactory + '%';
                    }    
                },
                complete: function(){
                    $(".clo_record").on("click", function(){
                        var clo_id = $(this).data("clo_id");
                        console.info(clo_id);
                        console.info(year);
                        console.info(term);
                        $(".undercover").hide();
                        $(".moonlight").show();
                        $("#measuresHook").text("");
                           
                        $.ajax({
                            url: settings.root + 'wt-pars-theme/v2/template/measure/' + clo_id + '/' + year + '/' + term,
                            method: 'GET',
                            beforeSend: function(xhr){
                                xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
                            },
                            success: function (data) {
                                for (var d in data) {
                                    var sum = parseInt(data[d].exemplary) + parseInt(data[d].good) + parseInt(data[d].satisfactory) + parseInt(data[d].poor) + parseInt(data[d].unsatisfactory);
                                    var tr = document.createElement('tr');
                                    $("#measuresHook").append(tr);                                    
                                    tr.appendChild(document.createElement('td')).innerText = data[d].type; 
                                    tr.appendChild(document.createElement('td')).innerText = data[d].comment;
                                    tr.appendChild(document.createElement('td')).innerText = data[d].exemplary + '%';
                                    tr.appendChild(document.createElement('td')).innerText = data[d].satisfactory + '%';
                                    tr.appendChild(document.createElement('td')).innerText = data[d].unsatisfactory + '%';
                                }   
                            },
                            error: function (xhr, status, error) {
                                console.info(xhr.responseText);
                            },
                        });                    
                    });
                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            });
        });

        $(".close").on("click", function(){
            $("#measuresHook").text('');
            $(".undercover").hide();
            $(".sunlight").show();
            $("#myModal").hide();
        });

        $(window).on("click", function(event){
            if (event.target == document.getElementById("myModal")) {
                $("#measuresHook").text('');
                $(".undercover").hide();
                $(".sunlight").show();
                $("#myModal").hide();
            }
        });
    });
})(jQuery);