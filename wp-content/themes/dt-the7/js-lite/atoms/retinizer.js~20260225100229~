 	//Cache variables
	var $document = $(document),
		$window = $(window),
		$html = $("html"),
		$body = $("body"),
		$page = $("#page");

	/*!- Custom resize function*/
    var dtResizeTimeout;
    if(dtGlobals.isMobile && !dtGlobals.isWindowsPhone && !dtGlobals.isAndroid){
        $window.bind("orientationchange", function() {
            resizeHandler();
        });
    }else{
        $window.on("resize", function() {
            resizeHandler();
        });
    }

    function resizeHandler(){
        clearTimeout(dtResizeTimeout);
        dtResizeTimeout = setTimeout(function() {
            $(window).trigger( "debouncedresize" );
            //resize widgets in above the fold js
            $window[0].dispatchEvent(new CustomEvent('the7_widget_resize'));
        }, 200);
    }

    $window.trigger( "debouncedresize" );

	/* #Retina images using srcset polyfill
	================================================== */
	var layzrCarousel;
    $.fn.layzrCarouselUpdate = function() {
        var $this = $(this);
        var className = "owl-thumb-lazy-load-show";
        var classSelector = "."+className;
        var isRefresh = false;
        //optimized code for performance
        //search last element after active elements
        var elem = $this.last().next().find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        //if not found search prev element before active elements
        elem = $this.first().prev().find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        //if elements before or after active does not have class, add elements to all active elements and update layzr
        elem = $this.find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        if (isRefresh)
        {
            layzrCarousel.updateSelector();
            layzrCarousel.update();
        }
    };
	function layzrCarouselInitialisation() {
        layzrCarousel = new Layzr({
            selector: ".owl-thumb-lazy-load-show",
            attr: 'data-src',
            attrSrcSet: 'data-srcset',
            retinaAttr: 'data-src-retina',
            hiddenAttr: 'data-src-hidden',
            threshold: 30,
            before: function() {
                this.setAttribute("sizes", $(this).attr('width')+"px");
                this.style.willChange = 'opacity';
            },
            callback: function() {
                //if($(this).parents(".post").first().hasClass("visible")){
                this.classList.add("is-loaded");

                var $this =  $(this);
                setTimeout(function(){
                    $this.parent().removeClass("layzr-bg");
                    $this.css("will-change",'auto');
                }, 350);
                //}
            }
        });
    };

	$(".layzr-loading-on, .vc_single_image-img").layzrInitialisation();
	

	$.fn.layzrBlogInitialisation = function(container) {
	  return this.each(function() {
	      var $this = $(this);
	      // $(".blog-shortcode.jquery-filter article").removeClass("shown");
	      // $this.addClass("shown");
	      $this.find("img").addClass("blog-thumb-lazy-load-show");

	      var layzrBlog = new Layzr({
	        container: container,
	        selector: ".blog-thumb-lazy-load-show",
	        attr: 'data-src',
	        attrSrcSet: 'data-srcset',
	        retinaAttr: 'data-src-retina',
	        hiddenAttr: 'data-src-hidden',
	        threshold: 30,
	        before: function() {
	        	this.setAttribute("sizes", this.width+"px");
	        	this.style.willChange = 'opacity';
	        	if($(this).parents(".woocom-project").length > 0){
					this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
	        	}
	        },
	        callback: function() {
	        	if($(this).parents(".post").first().hasClass("visible")){
	          		this.classList.add("is-loaded");
		         	var $this =  $(this);
		         	setTimeout(function(){
						$this.parent().removeClass("layzr-bg");
						$this.css("will-change",'auto');
					}, 350);
				}
	        }
	      });
	    });
	};
	$(".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible").layzrBlogInitialisation();

	//Rewrite vc functions for row behavior (fix issue with vc full-with row and box layout/side header)
	window.vc_rowBehaviour = function() {
	    function fullWidthRow() {
	        var $elements = $('[data-vc-full-width="true"]');
	        $.each($elements, function(key, item) {
	            var $el = $(this);
	            $el.addClass("vc_hidden");
	            if($el.parents().hasClass('vc_ie-flexbox-fixer')){
	            	var $el_full = $el.parents('.vc_ie-flexbox-fixer').next(".vc_row-full-width");
	            }else{
	            	var $el_full = $el.next(".vc_row-full-width");
	            }
	            if ($el_full.length > 0 && typeof $el_full != 'undefined') {

		            var el_margin_left = parseInt($el.css("margin-left"), 10);
		            var el_margin_right = parseInt($el.css("margin-right"), 10);
		            var offset = 0 - $el_full.offset().left - el_margin_left;
			        var width = $(window).width();

		            if ($el.parent().hasClass("vc_section")) {
			            el_margin_left = parseInt($el.parent().css("margin-left"), 10);
			            el_margin_right = parseInt($el.parent().css("margin-right"), 10);
		            }

					var windowInnerW = window.innerWidth;
					var windowW = $window.width();
					var contentW = $('#content').width();
					var $offset_fs;
					var $width_fs;
		            var $mainWfWrap = $("#main > .wf-wrap");
		            var mainWfWrapCSSWidth = parseInt($mainWfWrap.css("width"));
		            var leftPadding = parseInt($mainWfWrap.css("padding-left"));
		            var responsivenessIsOff = $body.hasClass("responsive-off");
		            var showDesktopHeader = windowInnerW > dtLocal.themeSettings.mobileHeader.firstSwitchPoint;
		            var isStikyHeader = $body.hasClass("sticky-header");
		            var isHeaderSideLeft = $body.hasClass("header-side-left");
		            var isHeaderSideRight = $body.hasClass("header-side-right");

					if ($('.boxed').length > 0) {
						var $windowWidth = $('#main').width();
					}
					else if ($('.side-header-v-stroke').length && ( $('.side-header-v-stroke').css('display') !== 'none' && showDesktopHeader && !responsivenessIsOff || responsivenessIsOff ) ){
						var $windowWidth = windowInnerW <= contentW ? contentW : (windowW - $('.side-header-v-stroke').width());
					}
					else if (!isStikyHeader && (isHeaderSideLeft || isHeaderSideRight) && showDesktopHeader && $('.side-header').css('display') !== 'none'){
						var $windowWidth = windowInnerW <= contentW ? contentW : (windowW - $('.side-header').width());
					}
					else {
						var $windowWidth = windowW <= contentW ? contentW : windowW;
					};

		            var contentPadding = $windowWidth - mainWfWrapCSSWidth;
		            $offset_fs = Math.ceil((contentPadding + 2*leftPadding) / 2 );

					if($('.sidebar-left').length > 0 || $('.sidebar-right').length > 0){
						$width_fs = $("#content").width();
						$offset_fs = 0;
					}else{
						$width_fs = $("#main").innerWidth();
					}

					var offset = 0 - $offset_fs - el_margin_left;
					var $left = ( "rtl" == jQuery(document).attr( "dir" ) ) ? "right" : "left";
					$el.css($left, offset);

		            if ($el.css({
		                position: "relative",
		                //left: offset,
		                "box-sizing": "border-box",
		                width: $width_fs
		            }),
		            !$el.data("vcStretchContent")) {
		                var padding = -1 * offset;
		                0 > padding && (padding = 0);
		                var paddingRight = $width_fs - padding - $el_full.width() + el_margin_left + el_margin_right;
		                0 > paddingRight && (paddingRight = 0),
		                $el.css({
		                    "padding-left": padding + "px",
		                    "padding-right": paddingRight + "px"
		                })
		            }
		            if ($el.data("vcStretchContent") && $el.find('.upb_row_bg').length > 0){
						var selector = $el.find('.upb_row_bg'),
							ride = selector.data('bg-override'),
							w = $width_fs;
							if(ride=='full'){
								selector.css({'min-width':w+'px'});
								selector.css($left,0);
							}
					}
		            $el.attr("data-vc-full-width-init", "true"),
		            $el.removeClass("vc_hidden");

		            //Fix dt-scroller inside fullwidth vc row
		            $el.find(".ts-wrap").each(function(){
						var scroller = $(this).data("thePhotoSlider");
						if(typeof scroller!= "undefined"){
							scroller.update();
						};
					});
			
	        	}
	        })
	    }
	   
	    function parallaxRow() {
	        var vcSkrollrOptions, callSkrollInit = !1;
	        return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(),
	        $(".vc_parallax-inner").remove(),
	        $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"),
	        $("[data-vc-parallax]").each(function() {
	            var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement, parallaxImage, youtubeId;
	            callSkrollInit = !0,
	            "on" === $(this).data("vcParallaxOFade") && $(this).children().attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom", "opacity:1;"),
	            skrollrSize = 100 * $(this).data("vcParallax"),
	            $parallaxElement = $("<div />").addClass("vc_parallax-inner").appendTo($(this)),
	            $parallaxElement.height(skrollrSize + "%"),
	            parallaxImage = $(this).data("vcParallaxImage"),
	            youtubeId = vcExtractYoutubeId(parallaxImage),
	            youtubeId ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : "undefined" != typeof parallaxImage && $parallaxElement.css("background-image", "url(" + parallaxImage + ")"),
	            skrollrSpeed = skrollrSize - 100,
	            skrollrStart = -skrollrSpeed,
	            skrollrEnd = 0,
	            $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr("data-top-bottom", "top: " + skrollrEnd + "%;")
	        }),
	        callSkrollInit && window.skrollr ? (vcSkrollrOptions = {
	            forceHeight: !1,
	            smoothScrolling: !1,
	            mobileCheck: function() {
	                return !1
	            }
	        },
	        window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions),
	        window.vcParallaxSkroll) : !1
	    }
	    function fullHeightRow() {
	        $(".vc_row-o-full-height:first").each(function() {
	            var $window, windowHeight, offsetTop, fullHeight;
	            $window = $(window),
	            windowHeight = $window.height(),
	            offsetTop = $(this).offset().top,
	            windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100),
	            $(this).css("min-height", fullHeight + "vh"))
	        })
	    }
	    function fixIeFlexbox() {
	        var ua = window.navigator.userAgent
	          , msie = ua.indexOf("MSIE ");
	        (msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) && $(".vc_row-o-full-height").each(function() {
	            "flex" === $(this).css("display") && $(this).wrap('<div class="vc_ie-flexbox-fixer"></div>')
	        })
	    }
	    var $ = window.jQuery;
	    $(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on("resize.vcRowBehaviour", fullHeightRow),
	    fullWidthRow(),
	    fullHeightRow(),
	    fixIeFlexbox(),
	    vc_initVideoBackgrounds(),
	    parallaxRow()
	};

	/*Call visual composer function for preventing full-width row conflict */
	if($('div[data-vc-stretch-content="true"]').length > 0 && $('div[data-vc-full-width-init="false"]' ).length > 0 || $('div[data-vc-full-width="true"]').length > 0 && $('div[data-vc-full-width-init="false"]' ).length > 0){
		vc_rowBehaviour();

	}

	//Blog
    $.fn.clickOverlayGradient = function () {
	    return this.each(function () {
		    var $this = $(this);
		    var $thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").innerHeight();

		    $this.data("the7OverlayLayoutContentOffset", $thisOfTop);
		    $this.css({
			    "transform": "translateY(" + $thisOfTop + "px)"
		    });

		    if (!$this.data("overlayLayoutEventsWasAdded")) {
			    $this.data("overlayLayoutEventsWasAdded", true);
			    $this.parents(".post").first()
				    .on("mouseenter tap", function () {
					    $this.css(
						    "transform", "translateY(0px)"
					    );
				    })
				    .on("mouseleave tap", function () {
					    $this.css(
						    "transform", "translateY(" + $this.data("the7OverlayLayoutContentOffset") + "px)"
					    );
				    });
		    }
	    })
    };
	addOnloadEvent(function(){
		$(".content-rollover-layout-list:not(.disable-layout-hover) .dt-css-grid .post-entry-wrapper").clickOverlayGradient();
	});

	
