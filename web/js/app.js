(function() {
    function loadWorkImage() {
        var $itemImage = $(".item-image");
        var src = $itemImage.data('src');

        var img = new Image();

        img.onload = function() {
            $itemImage.css('background-image', 'url(' + src + ')');
            $itemImage.addClass('item-image-loaded');
        };

        img.src = src;
    }

    function readLead() {
        $("[data-action='readCompleteLead']").on('click', function(e) {
            e.preventDefault();
            $(".lead-abstract").removeClass('lead-abstract');
            $(this).remove();
        });
    }

    loadWorkImage();
    readLead();
})();