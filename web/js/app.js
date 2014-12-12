(function() {
    function loadWorkImage() {
        var $itemImage = $(".item-image");
        var src = $itemImage.data('src');

        var img = new Image();

        img.onload = function() {
            $itemImage.attr('style', "background-image:url('" + src + "')");
            $itemImage.addClass('item-image-loaded');
        };

        img.src = src;
    }

    function navbar() {
        $(".navbar-fixed-top").autoHidingNavbar();
    }

    function readLead() {
        $("[data-action='readCompleteLead']").on('click', function(e) {
            e.preventDefault();
            $(".lead-abstract").removeClass('lead-abstract');
            $(this).remove();
        });
    }

    loadWorkImage();
    // navbar();
    readLead();
})();