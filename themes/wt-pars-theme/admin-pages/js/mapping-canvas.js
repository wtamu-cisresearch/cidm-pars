(function($){ 
    $(document).ready(function() {

        $('.box-clo').on('click', function(){
            $(this).clone().appendTo($(this).parent().removeClass('box'));
            //$(this).parent().remove();
        });
        // Credit for dragging technique: Taufik Nurrohman - http://jsfiddle.net/tovic/mkUJf/
        $('#wpbody').on('mousedown', '.box', function() {
            $(this).addClass('draggable').parents().on('mousemove', function(e) {
                $('.draggable').offset({
                    top: e.pageY - $('.draggable').outerHeight() / 2,
                    left: e.pageX - $('.draggable').outerWidth() / 2
                }).on('mouseup', function() {
                    $(this).removeClass('draggable');
                });
            });
            e.preventDefault();
        }).on('mouseup', function() {
            $('.draggable').removeClass('draggable');
        });   
    });
})(jQuery);