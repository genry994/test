function testAnimate() {
                    //пременная отступа
                    //var cont_left = $("#container").position().left;
                    $("a img").hover(function() {
        // при наведении курсора мыши
        $(this).parent().parent().css("z-index", 1);
        $(this).animate({
           height   : "150",
           width    : "150"
        }, "fast");
    }, function() {
        // hover out
        $(this).parent().parent().css("z-index", 0);
        $(this).animate({
           height   : "10",
           width    : "25"
        }, "fast");
    });
}