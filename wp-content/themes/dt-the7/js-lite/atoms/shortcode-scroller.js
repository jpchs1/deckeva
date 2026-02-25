/* #Shortcodes scroller
================================================== */
// setting width for scroller articles
    $.fn.scrollerSlideSize = function() {

        return this.each(function() {
            var $this = $(this),
                $img = $this.find("img").eq(0),
                imgW = parseInt($img.attr("width")),
                $container = $this.parents(".slider-wrapper"),
                $containerWidth = $container.width(),
                $maxWidth = $container.attr("data-max-width"),
                sideSpace = parseInt($container.attr("data-padding-side"));



            var leftPadding = parseInt($img.parents(".wf-td").eq(0).css("paddingLeft")),
                rightPadding = parseInt($img.parents(".wf-td").eq(0).css("paddingRight")),
                addedW = 0;

            if (leftPadding > 0 && rightPadding > 0) addedW = leftPadding + rightPadding;


            //determine if max width has px or %
            if(typeof $maxWidth != "undefined"){
                var dataMaxWidth = ($containerWidth * parseFloat($maxWidth))/100 - addedW - sideSpace;
            }

            if(imgW > dataMaxWidth){
                var colmnW = dataMaxWidth;
            }else{
                var colmnW = parseInt($img.attr("width"));
                if (!$img.exists()) colmnW = 280;
            }


            $this.parents('.slider-wrapper').attr("data-width", colmnW + addedW);
            $this.css({
                width: colmnW + addedW
            });
        })
    }
    $(".slider-wrapper.description-under-image:not(.related-projects) article").scrollerSlideSize();

    //Scroller shortcode init

    var $sliderWrapper = $(".slider-wrapper.owl-carousel:not(.related-projects)");

    $sliderWrapper.each(function(){
        var $this = $(this),
            $colGap = $this.attr("data-padding-side") ? parseInt($this.attr("data-padding-side")) : 0,
            $autoPlay = ( 'true' === $this.attr("data-autoslide")) ? true : false,
            $autoPlayTimeout = $this.attr("data-delay") ? parseInt($this.attr("data-delay")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $desktopCol =  $this.attr("data-width") ? $sliderWrapper.width() / parseInt($this.attr("data-width")) : $sliderWrapper.width()/$sliderWrapper.find('article img').attr('width'),
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-018-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-018-l',
            interceptClicksTimer;

        if($this.attr("data-width")) {
            $desktopCol =  $sliderWrapper.width() / parseInt($this.attr("data-width")) ;
        }else if ($this.attr("data-max-width")) {

            $desktopCol =   $sliderWrapper.width() / parseInt($this.attr("data-max-width"));
        }else {
            $desktopCol =   $sliderWrapper.width()/$sliderWrapper.find('article img').attr('width');
        }

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopCol,
            autoHeight: false,
            margin:$colGap,
            loadedClass: 'owl-loaded',
            slideBy: 'page',
            loop:false,
            smartSpeed: 600,
            merge:true,
            autoWidth:true,
            // onInitialized: callback,
            responsive:{
                678:{
                    mergeFit:true
                },
                1000:{
                    mergeFit:false
                }
            },
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
            nav: $enableArrows,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '"></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: false,
            onInitialize: callbackHeight,
            onInitialized: callback,
            onRefreshed: callback
        }).trigger('refresh.owl.carousel');
        function callbackHeight(event) {
            var $maxWidth = parseInt($this.attr("data-max-width")),
                dataMaxWidth = ($sliderWrapper.width() * parseFloat($maxWidth))/100 - $colGap,
                imgW = parseInt($this.find('img').attr('width')),
                imgH = parseInt($this.find('img').attr('height'));
            if($maxWidth && dataMaxWidth < imgW) {
                $this.find('article').css({
                    'max-width': dataMaxWidth + 'px'
                });
                $this.find('img').css({
                    'max-width': dataMaxWidth + 'px',
                    height: dataMaxWidth * imgH / imgW
                });
            }
        }
        function callback(event) {
            var $stage = $this.find('.owl-stage'),
                stageW = $stage.width(),
                $el = $this.find('.dt-owl-item'),
                elW = 0;
            elW = ($el.width()+ parseInt($el.css("margin-right"))) * event.item.count
            if ( elW > stageW ) {
                $stage.width( elW );
            };
        }

        //add class for preventing click while dragging
        $this.on('drag.owl.carousel translate.owl.carousel', function(event) {
            $this.addClass('ts-interceptClicks');
        })
        $this.on('dragged.owl.carousel translated.owl.carousel', function(event) {
            clearTimeout( interceptClicksTimer );
            interceptClicksTimer = setTimeout(function(){
                $this.removeClass('ts-interceptClicks');
            }, 400)
        });


        $this.on('changed.owl.carousel', function(event) {
            if($(".dt-owl-item.cloned .is-loaded", $this ).parents().hasClass("layzr-bg")){
                $(".dt-owl-item.cloned .is-loaded", $this ).parents().removeClass("layzr-bg");
            }
            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();
            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();
        })

        //Stop autoplay on hover
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        });
        //run autoplay on mouseleave
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        });
        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })


        //show hide arrows on hover
        $this.on("mouseenter", function(e) {
            $this.addClass("show-arrows");
        });
        $this.on("mouseleave", function(e) {
            $this.removeClass("show-arrows");
        });

    });


    //Slideshow
    $.fn.postTypeScroller = function() {

        var $this = $(this),
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-018-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-018-l',
            paddings = $this.attr("data-padding-side") ? parseInt($this.attr("data-padding-side")) : 0,
            $sliderAutoslideEnable = ( 'true' != $this.attr("data-paused") && typeof $this.attr("data-autoslide") != "undefined" ) ? true : false,
            $sliderAutoslide = ( 'true' === $this.attr("data-paused") ) ? false : true,
            $sliderAutoslideDelay = $this.attr("data-autoslide") && parseInt($this.attr("data-autoslide")) > 999 ? parseInt($this.attr("data-autoslide")) : 5000,
            $sliderLoop = (  typeof $this.attr("data-autoslide") != "undefined" ) ? true : false,
            $sliderWidth = $this.attr("data-width") ? parseInt($this.attr("data-width")) : 800,
            $sliderHight = $this.attr("data-height") ? parseInt($this.attr("data-height")) : 400,
            imgMode = $this.attr("data-img-mode") ? $this.attr("data-img-mode") : "fill";

        $this.owlCarousel({
            rtl: $enableRtl,
            items: 1,
            autoHeight: false,
            center: false,
            margin:0,
            loadedClass: 'owl-loaded',
            slideBy: 1,
            loop:true,
            smartSpeed: 600,
            autoplay: $sliderAutoslideEnable,
            autoplayTimeout: $sliderAutoslideDelay,
            //autoplayHoverPause:true,
            nav: true,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '"></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: false
        });
        $window.on("debouncedresize", function() {

            $this.find('.dt-owl-item').each(function(i) {

                var $slide = $(this),
                    tempCSS = {};
                var img = $slide.find("img");
                img.css({
                    'opacity': 0
                })

                if(!img) {
                    return false;
                }
                var ratioS = 1;
                ratioS = $sliderHight < $sliderWidth ? $sliderHight/$sliderWidth : $sliderHight/$sliderWidth;
                if(imgMode == "fit"){
                    $slide.css({
                        height: ratioS * $slide.width()
                    });
                }else{
                    $slide.css({
                        height: ratioS * $this.width()
                    });
                }
                var baseImageWidth = parseInt(img.attr("width")),
                    baseImageHeight = parseInt(img.attr("height"));

                var containerWidth = $slide.width(),
                    containerHeight = ratioS *  $slide.width(),
                    hRatio,
                    vRatio,
                    ratio,
                    nWidth,
                    nHeight,
                    cssObj = {};
                hRatio = containerWidth / baseImageWidth;
                vRatio = containerHeight / baseImageHeight;

                if ($this.attr("data-img-mode")  == "fill") {
                    ratio = hRatio > vRatio ? hRatio : vRatio;
                } else if ($this.attr("data-img-mode")  == "fit") {
                    ratio = hRatio < vRatio ? hRatio : vRatio;
                } else {
                    ratio = hRatio > vRatio ? hRatio : vRatio;
                }

                nWidth = Math.ceil(baseImageWidth * ratio, 10);
                nHeight = Math.ceil(baseImageHeight * ratio, 10);
                cssObj.width = nWidth;
                cssObj.height = nHeight;
                cssObj.opacity = 1;
                //}
                img.css(cssObj);
            });

        });

        if(typeof $this.attr("data-autoslide") != "undefined"){
            $('<div class="psPlay"></div>').appendTo($this);
        }

        if( 'true' === $this.attr("data-paused") ){
            $(".psPlay", $this).addClass("paused");
            $this.trigger('stop.owl.autoplay');
        };
        $(".psPlay", $this).on("click", function(e){
            e.preventDefault();
            var $this = $(this);
            if( $this.hasClass("paused")){
                $this.removeClass("paused");
                $sliderAutoslideEnable = true;
                $this.trigger('play.owl.autoplay',[$sliderAutoslideDelay, 600])
            }else{
                $this.addClass("paused");
                $this.trigger('stop.owl.autoplay');
            }
        });
    };
    $(".slider-simple:not(.slider-masonry)").each(function(){
        $(this).postTypeScroller();
    });

    //Widgets
    var $widgetSlider = $("#main .slider-content, #footer .slider-content, .side-header:not(.sub-downwards) .mega-full-width > .dt-mega-menu-wrap  .slider-content, .side-header:not(.sub-downwards) .mega-auto-width > .dt-mega-menu-wrap  .slider-content");
    $.fn.widgetScroller = function() {
        return this.each(function() {
            var $this = $(this),
                $autoPlay = ( typeof $this.attr("data-autoslide") != 'undefined') ? true : false,
                $autoPlayTimeout = $this.attr("data-autoslide") ? parseInt($this.attr("data-autoslide")) : 6000,
                $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false;

            $this.owlCarousel({
                rtl: $enableRtl,
                items: 1,
                autoHeight: true,
                margin: 0,
                loadedClass: 'owl-loaded',
                slideBy: 'page',
                //loop:true,
                loop:($this.children().length > 1) ? true : false,
                smartSpeed: 600,
                autoplay: $autoPlay,
                autoplayTimeout: $autoPlayTimeout,
                autoplayHoverPause: false,
                nav: false,
                dots: true,
                dotsEach:true
            });
        })
    }

    //$widgetSlider.each(function(){
    $widgetSlider.widgetScroller().css("visibility", "visible");
    //Carousels

    var sliders = [], timer;

    $.fn.the7OwlCarousel = function(){
        var $this = $(this);

        if ( ! $this.length ) {
            return;
        }

        var $slideAll,
            $colGap = $this.attr("data-col-gap") ? parseInt($this.attr("data-col-gap")) : 0,
            $autoHeight = ( 'true' === $this.attr("data-auto-height")) ? true : false,
            $animSpeed =  $this.attr("data-speed") ? parseInt($this.attr("data-speed")) : 600,
            $autoPlay = ( 'true' === $this.attr("data-autoplay")) ? true : false,
            $autoPlayTimeout = $this.attr("data-autoplay_speed") ? parseInt($this.attr("data-autoplay_speed")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $enableDots = ( 'true' === $this.attr("data-bullet")) ? true : false,
            $desktopWideCol =  $this.attr("data-wide-col-num") ? parseInt($this.attr("data-wide-col-num")) : 3,
            $desktopCol =  $this.attr("data-col-num") ? parseInt($this.attr("data-col-num")) : 3,
            $laptopCol =  $this.attr("data-laptop-col") ? parseInt($this.attr("data-laptop-col")) : 3,
            $hTabletCol =  $this.attr("data-h-tablet-columns-num") ? parseInt($this.attr("data-h-tablet-columns-num")) : 3,
            $vTabletCol =  $this.attr("data-v-tablet-columns-num") ? parseInt($this.attr("data-v-tablet-columns-num")) : 2,
            $phoneCol =  $this.attr("data-phone-columns-num") ? parseInt($this.attr("data-phone-columns-num")) : 1,
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $slideBy =  ('1' == $this.attr("data-scroll-mode")) ? parseInt($this.attr("data-scroll-mode")) : 'page',
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-002-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-001-l',
            $dotsEach = ('1' == $this.attr("data-scroll-mode") && $enableDots) ? true : false,
            reloadAnimTimer,
            reloadLayzTimer,
            refreshCarousTimer;
        if(typeof $this.attr("data-stage-padding") != 'undefined'){
            var $stagePadding = $this.hasClass('enable-img-shadow') ? parseInt($this.attr("data-stage-padding")) + parseInt($this.attr("data-col-gap"))/2 : parseInt($this.attr("data-stage-padding"));
        }else{
            var $stagePadding = 0;
        }

        if($this.attr("data-col-gap")){
            $colGap = parseInt($this.attr("data-col-gap"));
        }else if($this.attr("data-padding-side")){
            $colGap = parseInt($this.attr("data-padding-side"));
        }else{
            $colGap = 0;
        }

        $this.on('initialize.owl.carousel', function(event) {
            $($this[0]).find('script, style').each(function(){
                var $wrapTag = $(this),
                    $wrapTagSibling = $wrapTag.siblings().first();
                if($($wrapTag).prev().length > 0) {
                    $($wrapTag).prev().addBack().wrapAll("<div class='carousel-item-wrap' />");
                }else if($($wrapTag).next().length > 0) {
                    $($wrapTag).next().addBack().wrapAll("<div class='carousel-item-wrap' />")
                }
            })

            layzrCarouselInitialisation();
        })
        /*$this.on('refreshed.owl.carousel', function(event) {
            $(".layzr-loading-on .cloned  .vc_single_image-img").layzrInitialisation();
        })*/

        var switchPoints = {};
        if ($(this).hasClass('products-carousel-shortcode') && $this.parent('.elementor-widget-container').length && elementorFrontendConfig){ // only elementor product widget
            switchPoints[0] = {
                items:$phoneCol,
                loop:($this.children().length > $phoneCol) ? true : false,
                stagePadding: 0,
            };
            switchPoints[elementorFrontendConfig.breakpoints.md] = {
                loop:($this.children().length > $hTabletCol) ? true : false,
                items:$hTabletCol,
                stagePadding: 0,
            };
            switchPoints[elementorFrontendConfig.breakpoints.lg] = {
                loop:($this.children().length > $desktopCol) ? true : false,
                items:$desktopCol
            };
        }
        else{
            switchPoints = {
                0:{
                    items:$phoneCol,
                    loop:($this.children().length > $phoneCol) ? true : false,
                    stagePadding: 0,
                },
                481:{
                    loop:($this.children().length > $vTabletCol) ? true : false,
                    items:$vTabletCol,
                    stagePadding: 0,
                },
                769:{
                    loop:($this.children().length > $hTabletCol) ? true : false,
                    items:$hTabletCol,
                    stagePadding: 0,
                },
                992:{
                    loop:($this.children().length > $laptopCol) ? true : false,
                    items:$laptopCol
                },
                1199:{
                    loop:($this.children().length > $desktopCol) ? true : false,
                    items:$desktopCol
                },
                1450:{
                    loop:($this.children().length > $desktopWideCol) ? true : false,
                    items:$desktopWideCol
                }
            };
        }

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopWideCol,
            autoHeight: $autoHeight,
            margin:$colGap,
            stagePadding: $stagePadding,
            loadedClass: 'owl-loaded',
            slideBy: $slideBy,
            loop:true,
            smartSpeed: $animSpeed,
            responsive: switchPoints,
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
            nav: $enableArrows,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '" ></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: $enableDots,
            dotsEach:$dotsEach
        });
        //Blog: layout text on image
        if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
            $this.find(".post-entry-wrapper").clickOverlayGradient();
        }

        addOnloadEvent(function(){
            if(!$this.hasClass("refreshed")){
                $this.addClass("refreshed");
                $this.trigger("refresh.owl.carousel");
            }

            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
            clearTimeout( reloadAnimTimer );
            reloadAnimTimer = setTimeout(function(){
                $(".dt-owl-item.cloned .animate-element.animation-triggered:not(.start-animation)").addClass("start-animation");
            },50);
           
            if(!dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('stop.owl.autoplay');
            }else if(dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
	        

        });
        $this.on('changed.owl.carousel', function(event) {

            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();

            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();

            var $owlItemThumbnalWrap = $(" .dt-owl-item.cloned .post-thumbnail-wrap", $this);
            if ($this.hasClass("albums-shortcode")){
                if(($this.hasClass("gradient-overlay-layout-list") || $this.hasClass("content-rollover-layout-list"))){
                    if ( $.isFunction($.fn.triggerClonedOverlayAlbumsClick) ) {
                        $(" .dt-owl-item.cloned .post-entry-content", $this).triggerClonedOverlayAlbumsClick();
                    }
                }
                else{
                    if ( $.isFunction($.fn.triggerClonedAlbumsClick) ) {
                        $owlItemThumbnalWrap.triggerClonedAlbumsClick();
                    }
                }
            }
            if($this.hasClass("gallery-shortcode")) {

                $($this).initCarouselClonedPhotoswipe();
            }

        })
        $this.on('change.owl.carousel', function(event) {
            clearTimeout( reloadLayzTimer );
            reloadLayzTimer = setTimeout(function(){
                $this.find(".dt-owl-item.active").layzrCarouselUpdate();
                $('.dt-owl-item.cloned .lazy-load', $this).parent().removeClass('layzr-bg');
            },20);
        });
        $this.on('resized.owl.carousel', function(event) {
            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
        })
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })

        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })
    };

    $('.dt-owl-carousel-call, .related-projects').each(function() {
        $(this).the7OwlCarousel();
    });

    var dtResizeTimeout;
    if(dtGlobals.isMobile && !dtGlobals.isWindowsPhone && !dtGlobals.isAndroid){
        $window.bind("orientationchange", function(event) {
            clearTimeout(dtResizeTimeout);
            dtResizeTimeout = setTimeout(function() {
                $('.dt-owl-carousel-call, .related-projects').trigger('refresh.owl.carousel');
                 $(".slider-simple:not(.slider-masonry)").trigger('refresh.owl.carousel');

            }, 200);
        });
    }


    //Elementor's carousel
    $.fn.the7ElementorOwlCarousel = function(){
        var $this = $(this);

        if ( ! $this.length ) {
            return;
        }
        //console.log(elementorFrontendConfig[environmentMode])

        var $slideAll,
            $colGap = $this.attr("data-col-gap") ? parseInt($this.attr("data-col-gap")) : 0,
            $autoHeight = ( 'true' === $this.attr("data-auto-height")) ? true : false,
            $animSpeed =  $this.attr("data-speed") ? parseInt($this.attr("data-speed")) : 600,
            $autoPlay = ( 'true' === $this.attr("data-autoplay")) ? true : false,
            $autoPlayTimeout = $this.attr("data-autoplay_speed") ? parseInt($this.attr("data-autoplay_speed")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $enableTabletArrows = ( 'true' === $this.attr("data-arrows_tablet")) ? true : false,
            $enableMobileArrows = ( 'true' === $this.attr("data-arrows_mobile")) ? true : false,
            $enableDots = ( 'true' === $this.attr("data-bullet")) ? true : false,
            $enableTabletDots = ( 'true' === $this.attr("data-bullet_tablet")) ? true : false,
            $enableMobileDots = ( 'true' === $this.attr("data-bullet_mobile")) ? true : false,
           $switchPointsMobile = (typeof elementorFrontendConfig.breakpoints.md != 'undefined') ? elementorFrontendConfig.breakpoints.md : 481,
            $switchPointsTablet = (typeof elementorFrontendConfig.breakpoints.lg != 'undefined') ? elementorFrontendConfig.breakpoints.lg : 769,
            $desktopWideCol =  $this.attr("data-wide-col-num") ? parseInt($this.attr("data-wide-col-num")) : 3,
            $desktopCol =  $this.attr("data-col-num") ? parseInt($this.attr("data-col-num")) : 3,
            $laptopCol =  $this.attr("data-laptop-col") ? parseInt($this.attr("data-laptop-col")) : 3,
            $hTabletCol =  $this.attr("data-h-tablet-columns-num") ? parseInt($this.attr("data-h-tablet-columns-num")) : 3,
            $vTabletCol =  $this.attr("data-v-tablet-columns-num") ? parseInt($this.attr("data-v-tablet-columns-num")) : 2,
            $phoneCol =  $this.attr("data-phone-columns-num") ? parseInt($this.attr("data-phone-columns-num")) : 1,
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $slideBy =  ('1' == $this.attr("data-scroll-mode")) ? parseInt($this.attr("data-scroll-mode")) : 'page',
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-002-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-001-l',
            $dotsEach = ('1' == $this.attr("data-scroll-mode") && $enableDots) ? true : false,
            reloadAnimTimer,
            reloadLayzTimer,
            refreshCarousTimer;
        if(typeof $this.attr("data-stage-padding") != 'undefined'){
            var $stagePadding = $this.hasClass('enable-img-shadow') ? parseInt($this.attr("data-stage-padding")) + parseInt($this.attr("data-col-gap"))/2 : parseInt($this.attr("data-stage-padding"));
        }else{
            var $stagePadding = 0;
        }

        if(typeof $this.attr("data-arrows_tablet") === 'undefined'){
            $enableTabletArrows = $enableArrows;
        }
        if(typeof $this.attr("data-arrows_mobile") === 'undefined'){
            $enableMobileArrows = $enableArrows;
        }

        if($this.attr("data-col-gap")){
            $colGap = parseInt($this.attr("data-col-gap"));
        }else if($this.attr("data-padding-side")){
            $colGap = parseInt($this.attr("data-padding-side"));
        }else{
            $colGap = 0;
        }

        $this.on('initialize.owl.carousel', function(event) {
            $($this[0]).find('script, style').each(function(){
                var $wrapTag = $(this),
                    $wrapTagSibling = $wrapTag.siblings().first();
                if($($wrapTag).prev().length > 0) {
                    $($wrapTag).prev().addBack().wrapAll("<div class='carousel-item-wrap' />");
                }else if($($wrapTag).next().length > 0) {
                    $($wrapTag).next().addBack().wrapAll("<div class='carousel-item-wrap' />")
                }
            })

            layzrCarouselInitialisation();
        })
        var switchPoints = {};
        switchPoints[0] = {
            items:$phoneCol,
            loop:($this.children().length > $phoneCol) ? true : false,
            stagePadding: 0,
            nav: $enableMobileArrows,
            dots: $enableMobileDots,
        };
        switchPoints[$switchPointsMobile] = {
            loop:($this.children().length > $hTabletCol) ? true : false,
            items:$hTabletCol,
            stagePadding: 0,
            nav: $enableTabletArrows,
            dots: $enableTabletDots,
        };
        switchPoints[$switchPointsTablet] = {
            loop:($this.children().length > $desktopCol) ? true : false,
            items:$desktopCol,
            nav: $enableArrows,
            dots: $enableDots,
        };
        switchPoints[1450] = {
            loop:($this.children().length > $desktopWideCol) ? true : false,
            items:$desktopWideCol,
            nav: $enableArrows,
            dots: $enableDots,
        };

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopWideCol,
            autoHeight: $autoHeight,
            margin:$colGap,
            stagePadding: $stagePadding,
            loadedClass: 'owl-loaded',
            slideBy: $slideBy,
            loop:true,
            smartSpeed: $animSpeed,
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
           // nav: $enableArrows,
            responsive: switchPoints,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '" ></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: $enableDots,
            dotsEach:$dotsEach
        });
        //Blog: layout text on image
        if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
            $this.find(".post-entry-wrapper").clickOverlayGradient();
        }

        addOnloadEvent(function(){
            if(!$this.hasClass("refreshed")){
                $this.addClass("refreshed");
                $this.trigger("refresh.owl.carousel");
            }

            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
            clearTimeout( reloadAnimTimer );
            reloadAnimTimer = setTimeout(function(){
                $(".dt-owl-item.cloned .animate-element.animation-triggered:not(.start-animation)").addClass("start-animation");
            },50);
           
            if(!dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('stop.owl.autoplay');
            }else if(dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
            

        });
        $this.on('changed.owl.carousel', function(event) {

            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();

            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();

            var $owlItemThumbnalWrap = $(" .dt-owl-item.cloned .post-thumbnail-wrap", $this);
            if ($this.hasClass("albums-shortcode")){
                if(($this.hasClass("gradient-overlay-layout-list") || $this.hasClass("content-rollover-layout-list"))){
                    if ( $.isFunction($.fn.triggerClonedOverlayAlbumsClick) ) {
                        $(" .dt-owl-item.cloned .post-entry-content", $this).triggerClonedOverlayAlbumsClick();
                    }
                }
                else{
                    if ( $.isFunction($.fn.triggerClonedAlbumsClick) ) {
                        $owlItemThumbnalWrap.triggerClonedAlbumsClick();
                    }
                }
            }
            if($this.hasClass("gallery-shortcode")) {

                $($this).initCarouselClonedPhotoswipe();
            }

        })
        $this.on('change.owl.carousel', function(event) {
            clearTimeout( reloadLayzTimer );
            reloadLayzTimer = setTimeout(function(){
                $this.find(".dt-owl-item.active").layzrCarouselUpdate();
                $('.dt-owl-item.cloned .lazy-load', $this).parent().removeClass('layzr-bg');
            },20);
        });
        $this.on('resized.owl.carousel', function(event) {
            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
        })
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })

        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })
    };
     $('.elementor-owl-carousel-call').each(function() {
        $(this).the7ElementorOwlCarousel();
    });