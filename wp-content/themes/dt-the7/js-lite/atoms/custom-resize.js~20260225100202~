
	$window.on("debouncedresize", function( event ) {
		dtGlobals.resizeCounter++;

		//Photos widget
		if ( $.isFunction($.fn.calcPics) ) {
			$(".instagram-photos").calcPics();
		}
		//set correct width for header in boxed layout
		if($page.hasClass('boxed')){
			var value = $page.css("maxWidth");
			var hasPx = value.indexOf('px') >= 0;
			var hasPct = value.indexOf('%') >= 0;
			if(hasPx) {
				$mastheadHeader.addClass("width-in-pixel");
				if( typeof $phantom != 'undefined'){
					$phantom.addClass("width-in-pixel");
				}
			}
			if(hasPct){
				$(".masthead.full-width:not(.side-header)").css({
					width: $page.width()
				});
				if(typeof $phantom != 'undefined' && $phantom.find('.top-bar-bg').length > 0){
					$phantom.find('.top-bar-bg').css({
						width: $page.width()
					})
				}
				if($body.hasClass('phantom-sticky') && $('.top-bar-bg').length > 0){
					$('.top-bar-bg').css({
						width: $page.width()
					})
				}
			}

		}
		$(".content-rollover-layout-list:not(.disable-layout-hover) .dt-css-grid .post-entry-wrapper").clickOverlayGradient();

		/*Mobile header*/
		if(window.innerWidth >= dtLocal.themeSettings.mobileHeader.firstSwitchPoint){
			$page.removeClass("show-mobile-header");
			$page.addClass("closed-mobile-header");
			$body.removeClass("show-sticky-mobile-header");
			$body.removeClass("show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
			$(".mobile-sticky-header-overlay").removeClass("active");
			$(".dt-mobile-menu-icon").removeClass("active");
			$html.removeClass("menu-open");

		}

		if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){

			//Add mobile class to header to avoid conflict with floating menu
			if(!$('.masthead').hasClass("masthead-mobile")){
				$('.masthead:not(.mixed-header):not(#phantom)').addClass("masthead-mobile");
			}
			//Add class to header after mobile switch
			if(!$('.masthead').hasClass("masthead-mobile-header")){
				$('.masthead:not(.side-header):not(#phantom)').addClass("masthead-mobile-header");
				$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass("masthead-mobile-header");
			}
			if(stickyTopLine.exists()) {
				stickyTopLine.removeClass("sticky-top-line-on sticky-top-line-on");
				topLineDocked = false;
			}
			$('.mobile-header-scrollbar-wrap').css({
				'max-width': $(".dt-mobile-header ").width() - 13
			})
		}else{
			$('.masthead:not(.mixed-header):not(#phantom)').removeClass("masthead-mobile");
			//$('.masthead:not(#phantom)').removeClass("masthead-mobile-header");
			$('.masthead:not(.side-header):not(#phantom)').removeClass("masthead-mobile-header");
			$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').removeClass("masthead-mobile-header");
			if(!$('.masthead').hasClass("desktop-side-header")){
				$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass('desktop-side-header');
			}
		}

		if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")){
			//Check if top bar not empty on mobile
			if($('.left-widgets', $topBar).find(".in-top-bar-left").length > 0 || $('.top-bar .right-widgets').find(".in-top-bar-right").length > 0){
				$topBar.removeClass('top-bar-empty');
			}else{
				$topBar.addClass('top-bar-empty');
			}
		}else if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")) {
			if($('.left-widgets', $topBar).find(".in-top-bar").length > 0){
				$topBar.removeClass('top-bar-empty');
			}else{
				$topBar.addClass('top-bar-empty');
			}
		}else{
			if(!$('.mini-widgets', $topBar).find(".show-on-desktop").length > 0){
				$topBar.addClass('top-bar-empty');
			}else{
				$topBar.removeClass('top-bar-empty');
			}
		}
		if ($topBar.exists()) {
			topBarMobH = $topBar.innerHeight();
		};
		//Custom select
		$('.mini-nav select').trigger('render');
		
		//Fancy headers
		$.fancyFeaderCalc();

		//Set full height stripe
		$(".dt-default").each(function(){
			var $_this = $(this),
				$_this_min_height = $_this.attr("data-min-height");
			if($.isNumeric($_this_min_height)){
				$_this.css({
					"minHeight": $_this_min_height + "px"
				});
			}else if(!$_this_min_height){
				$_this.css({
					"minHeight": 0
				});
			}else if($_this_min_height.search( '%' ) > 0){
				$_this.css({
					"minHeight": $window.height() * (parseInt($_this_min_height)/100) + "px"
				});
			}else{
				$_this.css({
					"minHeight": $_this_min_height
				});
			};
		});
		/*Floating content*/
		
		$parentHeight = $floatContent.siblings(".project-wide-col").height();
        $floatContentHeight = $floatContent.height();
        setFloatinProjectContent();

        /*Floating sidebar*/
  //       dtGlobals.sidebarWidth = $(".sidebar").width();
		// dtGlobals.windowH = $(window).height();
		//setFloatinSidebar();
		/* Sticky footer */
		if($(".boxed").length > 0){
			var $pageBoxed = $(".boxed");
			$(".header-side-left.footer-overlap:not(.sticky-header) .boxed .footer, .left-side-line.footer-overlap .boxed .footer").css({
				right: ($window.width() - ($pageBoxed.offset().left + $pageBoxed.outerWidth()))
			})
		}
		$(".footer-overlap .footer").css({
			'opacity': 1
		});

		$(".mobile-false .footer-overlap .page-inner").css({
			'min-height': window.innerHeight - $(".footer").innerHeight(),
			'margin-bottom': $(".footer").innerHeight()
		});

        $(".mobile-false .footer-overlap .footer").css({
            'bottom': parseInt($body.css('padding-bottom')) + parseInt($body.css('margin-bottom'))
        });

	}).trigger( "debouncedresize" );

	//resize widgets in above the fold js second time
    $window[0].dispatchEvent(new CustomEvent('the7_widget_resize'));