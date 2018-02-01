(function($){
    $(document).ready(function(){

        $('#child-view').hide();

        $('.record').on('click', function(){

            var _clo = [];

            $('#main-view').hide();
            $('#child-view').show();
             
            var section_id = $(this).data('section_id');

            $('#course-code').text($(this).data('course_code'));
            $('#course-name').text($(this).data('course_name'));
            $('#section-number').text($(this).data('section_number'));
            $('#section-year').text($(this).data('section_year'));
            $('#section-term').text($(this).data('section_term'));
            $('#course-description').text($(this).data('course_description'));

            $.ajax({
                url: settings.root + 'wt-pars-theme/v2/template/clolist/' + section_id,
                method: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', settings.nonce)
                },
                success: function (data) {
                    var cloHook = document.getElementById('clo-hook');
                    for (var i in data) {
                        var option = document.createElement('option');
                        option.dataset.clo_id = data[i].clo_id;
                        option.dataset.clo_code = data[i].clo_code;
                        option.dataset.clo_description = data[i].clo_description;
                        if (i % 2 == 0) {
                            option.className = "shaddy";
                        }
                        cloHook.appendChild(option).innerText = data[i].clo_code + ' - ' + data[i].clo_description;
                    }
                },
                complete: function () {

                },
                error: function (xhr, status, error) {
                    console.info(xhr.responseText);
                },
            });

            $('#clo-hook').on('change', function(){
                $('#artifact-hook').append("<br/>");
                $('#artifact-hook').append("<div class='artifact badge badge-secondary' data-clo_id='" + $(this).find(':selected').data('clo_id') + "' data-clo_code='" + $(this).find(':selected').data('clo_code') + "' data-clo_description='" + $(this).find(':selected').data('clo_description') + "'>" + $(this).val() + "  </div>");
                $('#clo-hook').val('default');
            });

            $('#artifact-hook').on('click', '.artifact', function(){
                $('#clo-modal').show();
                $('#clo-id').val($(this).data('clo_id'));
                $('#clo-code').text($(this).data('clo_code'));
                $('#clo-description').text($(this).data('clo_description'));
            });

            $('#clo-form').on('submit', function(event){
                event.preventDefault();
                _clo.push({clo_id : $("input[name=clo-id]", this).val(), measure : $("select[name=measure]", this).val(), comments : $("textarea[name=comments]", this).val(), exemplary : $("input[name=exemplary]", this).val(), good : $("input[name=good]", this).val(), satisfactory : $("input[name=satisfactory]", this).val(), unsatisfactory : $("input[name=unsatisfactory]", this).val()});
                console.log(_clo);
                $('#clo-modal').hide();

            });

        });

        $(".close").on("click", function(){
            $("#clo-modal").hide();
            $("#measuresHook").text('');
            $("#mappingHook").text('');
        });

        $(window).on("click", function(event){
            if (event.target == document.getElementById("clo-modal")) {
                $("#clo-modal").hide();
                $("#measuresHook").text('');
                $("#mappingHook").text('');
            }
        });
        
    });
})(jQuery);