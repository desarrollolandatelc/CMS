import "../../vendor/slider/slider.js";


export function carousel(node) {
    var ones = $("#owl-carousel-one");
    ones.owlCarousel({
        singleItem: true,
        items: 1,
        slideSpeed: 1000,
        pagination: false,
        navigation: true,
        autoPlay: 3500,
        dots: false,
        nav: true,
        navigationText: ["<i class='icofont icofont-thin-left'></i>", "<i class='icofont icofont-thin-right'></i>"],
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    sync1.owlCarousel({
        singleItem: true,
        items: 1,
        slideSpeed: 1000,
        pagination: false,
        navigation: true,
        autoPlay: 2500,
        dots: false,
        nav: true,
        navigationText: ["<i class='icofont icofont-thin-left'></i>", "<i class='icofont icofont-thin-right'></i>"],
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });
    sync2.owlCarousel({
        items: 5,
        navigation: true,
        dots: false,
        pagination: false,
        nav: true,
        navigationText: ["<i class='icofont icofont-thin-left'></i>", "<i class='icofont icofont-thin-right'></i>"],
        responsiveRefreshRate: 100,
        afterInit: function (el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        console.log(current)
        $("#sync2")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if ($("#sync2").data("owlCarousel") !== undefined) {
            center(current)
        }
    }
    $("#sync2").on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }
        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
        }
    }

    return {
        destroy() {
            $("#sync2").off("click", ".owl-item", function (e) {
                e.preventDefault();
                var number = $(this).data("owlItem");
                sync1.trigger("owl.goTo", number);
            });
        }
    }

}
