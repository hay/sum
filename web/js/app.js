var $itemImageContainer = $('.item-image-container');
var $itemImage = $(".item-image");
var src = $itemImage.data('src');
var cWidth = $itemImageContainer.width();
var cHeight = $itemImageContainer.height();
var $img;

var img = new Image();

img.onload = function() {
    $img = $(img);
    var aspect = cHeight / cWidth;
    var newHeight = img.height * aspect;

    $img.css({
        width : cWidth,
    });

    $itemImage.css({
        width : cWidth,
        height : newHeight,
        marginTop : -(newHeight / 4)
    });

    $itemImage.append(img);

    setTimeout(function() {
        $img.addClass('item-image-loaded');
    }, 0);
};

img.src = src;

$(".btn-zoom").on('click', function() {
    if ($(this).hasClass('btn-zoom-zoomed')) {
        $img.get(0).dispatchEvent(
            new CustomEvent('wheelzoom.destroy')
        );

        $(this).removeClass('btn-zoom-zoomed');
    } else {
        wheelzoom( $img.get(0) );

        $(this).addClass('btn-zoom-zoomed');
    }
});