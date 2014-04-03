(function($) {

    function respond() {
        var w = $(window).width();
        // remove inline display styles set by jquery.
        $("header[role=banner] *").removeAttr("style");
        closeLoginLink();
        if (w < 600) {
            setUpMobileView();
        } else {
            setUpTabletView();
        }
    }

    function setUpMobileView() {
        $("a.logolink").unbind("click");
        $("a.drop-down").remove();
        $(".navitems2 ul").children().unwrap().unwrap();
        $("a.logolink").click(function(e) {
            $('ul.global-sections ul.global-sections').toggleClass("open", 100);
            e.preventDefault();
            e.stopPropagation();
        });
        $("a.logolink").blur(function() {
            $('ul.navitems').toggleClass("open", false, 100);

        });
        $(document).click(function(e) {
            e.preventDefault();
            $('ul.global-sections ul.global-sections').toggleClass("open", false, 100);
            // Everything with an "open" class should be closed here 
        });
    }

    function setUpTabletView() {
        $("a.logolink").unbind();
        $(document).unbind("click");
        $("a.drop-down").remove();
        $(".navitems2 ul").children().unwrap().unwrap();
        var widthSum = 0;
        var spaceWidth = ($("nav.global").width() - $("a.logolink.mc-logo").width() - $("ul.utils").width()) - 125;
        console.log("a " + $("nav.global").width() + " b " + $("a.logolink.mc-logo").width() + "c " + $("ul.utils").width());
        $("ul.global-sections ul li").each(function(index) {
            widthSum += $(this).width();
            if (widthSum > spaceWidth) {
                $(this).nextAll('li').addBack().wrapAll("<li class='navitems2 ' role='menuitem'><ul class='more-items'></ul><li>");
                $('.navitems2').prepend('<a class="drop-down" href="#">More</a>');
                $("a.drop-down").click(function() {
                    $('.navitems2').toggleClass("open", 100);
                    $('.navitems').toggleClass("open", 100);
                    $(this).toggleClass("open");
                });
                return false;
            }
        });
    }

    function closeUpShop() {
        // for everything that has the open class, remove it
        $('.open').removeClass("open");
        $('[aria-hidden="false"]').attr('aria-hidden', 'true');
    }

    function siteHeaderBehavior() {
        // SEARCH
        $('header[role=banner] form[role=search] label').click(function() {
            $theSearchButton = $(this);
            if ($($theSearchButton).parent('form').hasClass("open")) {
                // $(this).parent('form').find('fieldset').attr('aria-hidden', 'true');
                //$(this).parent('form').toggleClass("open", 400);
                $(this).parent('form').removeClass("open");
                $($theSearchButton).parent('form').find('fieldset').slideUp(300,
                    function() {
                        closeUpShop();
                        $(this).parent('form').removeClass("open");
                    });
            } else {
                // $(this).parent('form').find('fieldset').attr('aria-hidden', 'false');
                //$(this).parent('form').toggleClass("open", 400);
                $('nav.main ul').slideUp(300, function() {
                    $('header[role=banner] button').removeClass("open");
                    $('header[role=banner] form[role=search] fieldset').slideDown(300,
                        function() {
                            $(this).parent('form').addClass("open");
                        });
                });
            }
        });
        $("header[role=banner] button").click(function() {
            var $theMenuButton = this;
            if ($("nav.main ul").is(":visible")) {
                //console.log(" is visible");
                $('nav.main ul').slideUp(300, function() {
                    $($theMenuButton).removeClass("open");
                });
            } else {
                console.log(" is NOT visible");
                $('header[role=banner] form[role=search] fieldset').slideUp(200,
                    function() {
                        $('nav.main ul').slideDown(300, function() {
                            $('header[role=banner] form[role=search]').removeClass("open");
                            $($theMenuButton).addClass("open");
                        });
                    });
            }
        });
    }

    function setUpLoginLink() {
        // Global nav - Login - global behavior
        $('.utils a.login-link').click(function() {
            // $('.utils ul[role="menu"]').show(1000).attr('aria-hidden', 'false');
            if ($(this).next('ul').is(":visible")) {
                closeLoginLink();
            } else {
                openLoginLink();
            }
        });
    }

    function setUpAsideReveal() {
        // visibility of arrow determined by CSS media queries
        if ($('aside[role="complimentary"].part-of-hub .responsive-disclosure').is(":visible")) {
            $('aside[role="complimentary"].part-of-hub header').click(function() {
                if ($(this).next('nav').is(":hidden")) {
                    $(this).next('nav').slideDown(300,
                        function() {
                            // open class is for the arrow display
                            $(this).parent('aside').addClass("open");
                        });
                } else {
                    $(this).next('nav').slideUp(300,
                        function() {
                            $(this).parent('aside').removeClass('open');
                        });
                }
            });
        } else {
            $("aside[role='complimentary'].part-of-hub nav").removeAttr("style");
            $('aside[role="complimentary"].part-of-hub header').unbind("click");
            $('aside[role="complimentary"].part-of-hub').removeClass('open');
        }

    }

    function closeLoginLink(e) {
        // if (!e) {
        //     e = window.event;
        // }
        //e.preventDefault();
        $('.utils ul').slideUp(100,
            function() {
                $('.utils a.login-link').removeClass("open");
                $('.utils ul[aria-hidden="false"]').attr('aria-hidden', 'true');
            });
    }

    function openLoginLink(e) {
        if (!e) {
            e = window.event;
        }
        e.preventDefault();
        $('.utils a.login-link').addClass("open");
        $('.utils ul').slideDown(100,
            function() {
                $('.utils ul[aria-hidden="true"]').attr('aria-hidden', 'false');

            });
    }
    jQuery(document).ready(function($) {
        respond();
        siteHeaderBehavior();
        setUpLoginLink();
        setUpAsideReveal();
        $(window).resize(_.debounce(function() {
            console.log("resized");
            setUpAsideReveal();
            respond();
        }, 100));
    });
    $(window).bind("load", function() {
        //nav resize code here
        respond();

    });
})(jQuery);