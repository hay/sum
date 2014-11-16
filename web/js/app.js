var $itemImage = $(".item-image");
var $itemImageImg = $itemImage.find("img");

// Why?
var img = new Image();

img.onload = function() {
    $itemImage.css({
        width : img.width,
        height : img.height
    });

    $itemImageImg.css({
        width : $(window).width()
    })

    $itemImage.css('margin-top', -(img.height / 3));
};

img.src = $itemImageImg.attr('src');

$(".btn-zoom").on('click', function() {
    if ($(this).hasClass('btn-zoom-zoomed')) {
        $itemImageImg.get(0).dispatchEvent(
            new CustomEvent('wheelzoom.destroy')
        );
        $(this).removeClass('btn-zoom-zoomed');
    } else {
        wheelzoom( $itemImageImg.get(0) );
        $(this).addClass('btn-zoom-zoomed');
    }
});