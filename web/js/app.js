(function() {
    var lang = $("html").attr('lang');

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

    function fastClick() {
        FastClick.attach(document.body);
    }

    function fastQuery() {
        if ($("#fastquery").length === 0) return;

        $("#fastquery").on('click', '#show-all-works', function() {
            $(this).hide();
            $("#fastquery a").fadeIn();
        });

        var tmpl = Handlebars.compile( $("#fastquery-tmpl").html() );
        var query = $("#fastquery").attr('data-query').split(',');
        var url = 'http://tools.wmflabs.org/hay/wdskim/?prop=' + query[0] + '&item=' + query[1] + '&language=' + lang + '&withimages=on&format=json';

        $.getJSON(url, function(data) {
            if (data.items.length === 0) return;

            var items = [];

            for (var key in data.items) {
                var item = data.items[key];
                item.image = '//commons.wikimedia.org/wiki/Special:Redirect/file/' + item.image + '?width=300';
                item.image = item.image.replace("'", "\\'");
                items.push(item);
            }

            var html = tmpl({ items : items });
            var $html = $(html);
            $html.find("a:gt(3)").hide();

            $("#fastquery").html( $html );
        });
    }

    fastClick();
    loadWorkImage();
    photoswipe();
    searchclear();
    fastQuery();
})();