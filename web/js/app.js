(function() {
    function loadWorkImage() {
        var $itemImage = $(".item-image");
        if (!$itemImage.length) return;

        var src = $itemImage.data('src');

        var img = new Image();

        img.onload = function() {
            $itemImage.attr('style', "background-image:url('" + src + "')");
            $itemImage.addClass('item-image-loaded');
        };

        img.src = src;
    }

    loadWorkImage();
})();