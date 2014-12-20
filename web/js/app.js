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

    function photoswipe() {
        var $pswp = $(".pswp");
        var items = [];
        var $images = $(".img-zoomable");

        $images.each(function() {
            var $el = $(this);

            items.push({
                src : $el.attr('src').replace('width=500', 'width=1024'),
                msrc : $el.attr('src'),
                w : 1024,
                h : 1024
            });
        });

        $(".img-zoomable").on('click', function() {
            var index = $images.index(this);
            var $el = $(this);

            var gallery = new PhotoSwipe(
                $pswp.get(0),
                PhotoSwipeUI_Default,
                items,
                {
                    index : index,
                    getThumbBoundsFn: function(index) {
                        var pos = $el.offset();

                        return {
                            x : pos.left,
                            y : pos.top,
                            w : $el.width()
                        };
                    }
                }
            );

            gallery.init();
            gallery.zoomTo(1, {x:gallery.viewportSize.x/2,y:gallery.viewportSize.y/2}, 200);
        });
    }

    function searchclear() {
        $('[data-action="clearinput"]').each(function() {
            var $el = $(this);
            var $target = $($el.data('target'));

            function checkShow() {
                $el.toggleClass('show', !!$target.val());
            }

            $el.on('click', function() {
                $target.val('');
                checkShow();
            });

            $target.on('keyup', checkShow);

            checkShow();
        })
    }

    loadWorkImage();
    photoswipe();
    searchclear();
})();