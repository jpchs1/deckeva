
/* #Floating menu
================================================== */
	dtGlobals.desktopProcessed = false;
	dtGlobals.mobileProcessed = false;

	var stickyMobileHeaderExists = $(".sticky-mobile-header").exists();


	if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
		$('.masthead:not(.side-header):not(#phantom)').addClass("masthead-mobile-header");
		$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass("masthead-mobile-header").addClass('desktop-side-header');
	}
	if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")){
		//Check if top bar not empty on mobile
		if($('.left-widgets', $topBar).find(".in-top-bar-left").length > 0 || $('.right-widgets', $topBar).find(".in-top-bar-right").length > 0){
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
	}

	/*
	// Mobile sticky header
	// variables $mastheadHeader, $mainSlider are defined in header.js atom
	*/
	var floatingNavigationBelowSliderExists = $(".floating-navigation-below-slider").exists();

	if($('.sticky-mobile-header').exists() && !$body.hasClass("responsive-off")){

		var $stickyMobileHeader =  $(".masthead:not(.side-header):not(#phantom), body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"),
			$mobileHeader = $stickyMobileHeader.find(".mobile-header-bar");
			$stickyMobileLogo = $stickyMobileHeader.find(".mobile-branding"),
			mobileLogoURL = $(".mobile-branding a").attr("href");

		// Logo for mobile sticky floating header: first switch point
		if(!$(".sticky-mobile-logo-first-switch").exists()) {
			if (dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html) {
				if (mobileLogoURL == undefined) {
					console.log($(dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html))
					$(dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html).addClass("sticky-mobile-logo-first-switch").prependTo($stickyMobileLogo)
				}
				else {
					$('<a class="sticky-mobile-logo-first-switch" href="'+mobileLogoURL+'">' + dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html +' </a>').prependTo($stickyMobileLogo);
				};
			};
		};


		// Logo for mobile sticky floating header: second switch point
		if(!$(".sticky-mobile-logo-second-switch").exists()) {
			if (dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html) {
				if (mobileLogoURL == undefined) {
					$(dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html).addClass("sticky-mobile-logo-second-switch").prependTo($stickyMobileLogo)
				}
				else {
					$('<a class="sticky-mobile-logo-second-switch" href="'+mobileLogoURL+'">' + dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html +' </a>').prependTo($stickyMobileLogo);
				};
			};
		};


		var mobileTopBarH = 0,
			mobileAdminBarH = 0,
			sliderH = $mainSlider.height(),
			mobileHeaderH = 0,
			mobileMenuH = 0,
			mobileMenuT = 0,
			mobileHeaderDocked = false;

		if (!bodyTransparent) {
			$("<div class='mobile-header-space'></div>").insertBefore($stickyMobileHeader);
			var $MobileHeaderSpace = $(".mobile-header-space");
		}
		if($(".no-cssgridlegacy.no-cssgrid").length > 0  && floatingNavigationBelowSliderExists){
			if (bodyTransparent) {
				$stickyMobileHeader.css({
					"top":  sliderH
				});
				$MobileHeaderSpace.css({
					"top":  sliderH
				});
			}else{
				$MobileHeaderSpace.insertAfter($mainSlider);
				$stickyMobileHeader.insertAfter($mainSlider);
			}
		}

		dtGlobals.resetMobileSizes = function (sliderHeihgt) {
			if (window.innerWidth > dtLocal.themeSettings.mobileHeader.firstSwitchPoint) {
				if($(".is-safari").length > 0){
					$stickyMobileHeader.css({
						"width": "",
						"max-width": ""
					});
				}

				$stickyMobileHeader.removeClass('sticky-mobile-off sticky-mobile-on');
				mobileHeaderDocked = false;
				return false;
			};

			// Admin bar height
			if ($("#wpadminbar").exists() && !Modernizr.mq('only screen and (max-width:600px)')) {
				mobileAdminBarH = $("#wpadminbar").height();
			} else {
				mobileAdminBarH = 0;
			};
	
			// Top-bar height
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" ) && !$topBar.hasClass( "hide-top-bar" )) {
				mobileTopBarH = $topBar.innerHeight();
			}
			else {
				mobileTopBarH = 0;
			};
			// Full & sticky part header height
			if (window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint) {
				mobileHeaderH = dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight + mobileTopBarH;
				mobileMenuH = dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight;
			}
			else {
				mobileHeaderH = dtLocal.themeSettings.mobileHeader.secondSwitchPointHeight + mobileTopBarH;
				mobileMenuH = dtLocal.themeSettings.mobileHeader.secondSwitchPointHeight;
			};
			
			// Sticky menu position
			if (!floatingNavigationBelowSliderExists) {
				mobileMenuT = mobileTopBarH;
			}
			else if (floatingNavigationBelowSliderExists && !bodyTransparent) {
				mobileMenuT = sliderHeihgt;
			}
			else if (floatingNavigationBelowSliderExists && bodyTransparent) {
				mobileMenuT = sliderHeihgt - mobileHeaderH + mobileTopBarH;
			}
			else {
				$mobileHeader.offset().top;
			}
			if ($stickyMobileHeader.hasClass('sticky-mobile-on')){
				$stickyMobileHeader.css({
					"top":  mobileAdminBarH - mobileTopBarH
				});
			}
	
			if (!bodyTransparent) {
				$MobileHeaderSpace.css({
					"height": mobileHeaderH
				});
				$MobileHeaderSpace.css({
					"top":  sliderHeihgt
				});
			};
			if($(".is-safari").length > 0){
				$stickyMobileHeader.css({
					"width":  document.documentElement.clientWidth,
					"max-width":  document.documentElement.clientWidth
				});
			}

		};
		dtGlobals.resetMobileSizes($mainSlider.height());
		$window.on("resize debouncedresize", function() {
			dtGlobals.resetMobileSizes($mainSlider.height());
		});

		// Main loop: listening for the scroll event
		$window.on("scroll", function() {
			// Stop execution when on mobile devices
			if (window.innerWidth > dtLocal.themeSettings.mobileHeader.firstSwitchPoint) {
				return false;
			}

			var posScrollTop = dtGlobals.winScrollTop;

			// Making header sticky (rewrite relative to $stickyHeader position)

			if ((posScrollTop > mobileMenuT) && (!mobileHeaderDocked) && $(document).height() > $(window).height()) {
				$stickyMobileHeader.removeClass('sticky-mobile-off').addClass('sticky-mobile-on');
				if(headerBelowSliderExists && stickyMobileHeaderExists){	
					$stickyMobileHeader.addClass("fixed-mobile-header");
				};
				$stickyMobileHeader.css({
					"top":  mobileAdminBarH - mobileTopBarH
				});
				mobileHeaderDocked = true;
			}
			else if ((posScrollTop <= mobileMenuT) && (mobileHeaderDocked)) {
				$stickyMobileHeader.removeClass('sticky-mobile-on').addClass('sticky-mobile-off');
				if(headerBelowSliderExists && stickyMobileHeaderExists){	
					$stickyMobileHeader.removeClass("fixed-mobile-header");
				};				
				$stickyMobileHeader.css({
					"top": 0
				});
				if($(".no-cssgridlegacy.no-cssgrid").length > 0  && floatingNavigationBelowSliderExists){
					if (bodyTransparent) {
						$stickyMobileHeader.css({
							"top":  sliderH
						});
					}else{
						$stickyMobileHeader.css({
							"top":  sliderH
						});
					}
				}
				mobileHeaderDocked = false;
			};
		});
	};


	/* Set variable for floating menu */

	if ((dtGlobals.isMobile && window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint)  && !dtGlobals.isiPad && !$body.hasClass("responsive-off")){
		if(dtLocal.themeSettings.floatingHeader.showMenu && $(".phantom-sticky").exists() && bodyTransparent) {
			$mastheadHeader.addClass('fixed-masthead');
		}

		dtLocal.themeSettings.floatingHeader.showMenu = false;
	} 

	var bodyTransparent = $body.hasClass("transparent"),
		phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderExists = $(".side-header").exists();


	/* Floating navigation -> Style -> Sticky */

	if(dtLocal.themeSettings.floatingHeader.showMenu && phantomStickyExists) {
		var logoURL = $(".branding a", $mastheadHeader).attr("href"),
			$stickyHeader = $mastheadHeader,
			$stickyMenu = $stickyHeader.find(".header-bar"),
			$branding = $stickyHeader.find(".branding"),
			$logo = $branding.find("img");

		// Using same or different logo?
		if ($branding.find("a.same-logo").length > 0) {
		}
		else {
			if(!$(".sticky-logo").exists()) {
				if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
					if (logoURL == undefined) {
						$(dtLocal.themeSettings.floatingHeader.logo.html).addClass("sticky-logo").prependTo($branding);
					}
					else {
						$('<a class="sticky-logo" href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>').prependTo($branding);
					};
				};
			};
		};

		var topBarH = 0,
			FtopBarH = 0,
			adminBarH = 0,
			stickyHeaderH = 0,
			stickyMenuH = 0,
			stickyMenuT = 0,
			headerDocked = false,
			headerTransition = "";

		// Appending empty div for sticky header placeholder

		if (!bodyTransparent) {
			$("<div class='header-space'></div>").insertAfter($stickyHeader);
			var $headerSpace = $(".header-space");
		};

		// Adding initial classes
		$stickyHeader.addClass('sticky-off fixed-masthead');

		var mobileReset = false;
		dtGlobals.resetSizes = function (sliderHeihgt) {
			// Stop execution when on mobile devices
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				if (!mobileReset) {
					mobileReset = true;
					$stickyHeader.removeClass('sticky-off sticky-on');
					if (!bodyTransparent) {
						$headerSpace.removeClass('sticky-space-off sticky-space-on');
					}
					$stickyHeader.css({
						"top":  "",
						"transform" : ""
					});
					headerDocked = false,
					headerTransition = "";
					if($(".is-safari").length > 0){
						$stickyHeader.css({
							"width":  "",
							"max-width":  ""
						});
					}
				}
				return false;
			}
			else if (mobileReset) {
				mobileReset = false;
			}
			
			if(!headerDocked && headerTransition === "") {
				$stickyHeader.addClass('sticky-off');
				if (!bodyTransparent) {
					$headerSpace.addClass('sticky-space-off');
				}	
			}

			// Admin bar height
			if ($("#wpadminbar").exists()) {
				adminBarH = $("#wpadminbar").height();
			}
			else {
				adminBarH = 0;
			};
	
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
				topBarH = $topBar.innerHeight();
			}else {
				topBarH = 0;
			};

			// Full header height
			stickyHeaderH = dtLocal.themeSettings.desktopHeader.height + topBarH;
			
			// Sticky part height 
			stickyMenuH = dtLocal.themeSettings.desktopHeader.height;
			
			// Sticky menu position
			if (!floatingNavigationBelowSliderExists) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = 0;
				}else{
					stickyMenuT = topBarH;
				}
			}
			else if (floatingNavigationBelowSliderExists && !bodyTransparent) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = sliderHeihgt - topBarH;
				}else{
					stickyMenuT = sliderHeihgt;
				}
			}
			else if (floatingNavigationBelowSliderExists && bodyTransparent) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = sliderHeihgt - stickyMenuH - topBarH;
				}else{
					stickyMenuT = sliderHeihgt - stickyMenuH;
				}
			}
			else {
				$stickyMenu.offset().top;
			}
	
			if (!bodyTransparent) {
				$headerSpace.css({
					"height": stickyHeaderH
				});
			};
			// $stickyMenu
			// .css({
			// 	height : stickyMenuH
			// });


			if($(".is-safari").length > 0){
				if ($page.hasClass("boxed")) {
					$stickyHeader.css({
						"width":  $page.width(),
						"max-width":  $page.width()
					});
				}else{
					$stickyHeader.css({
						"width":  document.documentElement.clientWidth,
						"max-width":  document.documentElement.clientWidth
					});
				}
			}
		};

		dtGlobals.resetSizes($mainSlider.height());
		$window.on(" debouncedresize", function() {
			dtGlobals.resetSizes($mainSlider.height());
		});
		function showStickyMenu(){
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				return false;
			}
			var posScrollTop = dtGlobals.winScrollTop;

			// Making header sticky (rewrite relative to $stickyHeader position)
			if ((posScrollTop > (stickyMenuT + 1)) && (!headerDocked && !dtGlobals.isHovering)) {
				$stickyHeader.removeClass("sticky-off").addClass("sticky-on");
				if (!bodyTransparent) {
					$headerSpace.removeClass("sticky-space-off").addClass("sticky-space-on");
				}

				if($body.hasClass("floating-top-bar")){
					$stickyHeader.css({
						"top":  adminBarH
					});
				}else{
					$stickyHeader.css({
						"top":  adminBarH - topBarH
					});
				}
				headerDocked = true;

				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					$stickyHeader.css({
						"transform" : "translateY(0)"
					});
					if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){
						var $mastheadHeaderStyle = $stickyHeader.attr("style");
						$stickyHeader.attr("style", $mastheadHeaderStyle + "; top:" + topBarH + "px !important;");
					}
				};
			}
			else if ((posScrollTop <= (stickyMenuT + 1)) && (headerDocked)) {
				$stickyHeader.removeClass("sticky-on").addClass("sticky-off");
				if (!bodyTransparent) {
					$headerSpace.removeClass("sticky-space-on").addClass("sticky-space-off");
				}
				$stickyHeader.css({
					"top": 0
				});
				headerDocked = false;
			
				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					$stickyHeader.css({
						"transform" : "translateY(-100%)"
					});
					if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){
						var $mastheadHeaderStyle = $stickyHeader.attr("style");
						$stickyHeader.not('.sticky-on').attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
					}
				};
			};

			// Transition
			if ((posScrollTop > (stickyMenuT + 1)) && (posScrollTop <= ((stickyMenuT + 1) + stickyMenuH - dtLocal.themeSettings.floatingHeader.height))) {
				headerTransition = "changing";
				$stickyMenu
				.css({
					"transition" : "none",
					height : stickyMenuT + stickyMenuH - posScrollTop,
				});
			}
			else if (posScrollTop > ((stickyMenuT + 1) + dtLocal.themeSettings.floatingHeader.height) && headerTransition !== "end") {
				headerTransition = "end";
				$stickyMenu
				.css({
					height : dtLocal.themeSettings.floatingHeader.height,
					"transition" : "all 0.3s ease" 
				});
			}
			else if (posScrollTop <= (stickyMenuT + 1) && headerTransition !== "start") {
				headerTransition = "start";
				$stickyMenu
				.css({
					height : stickyMenuH,
					"transition" : "all 0.1s ease"
				});
			};
		}
		showStickyMenu()
		// Scroll
		$window.on("scroll", function() {
			// Stop execution when on mobile devices
			showStickyMenu();
		});		
	};

	//Sticky top line
	if(stickyTopLine.exists()) {

		var stickyTopLineH = 0,
			adminBarH = 0,
			topBarH = 0,
			topLineDocked = false;
		stickyTopLine.addClass("sticky-top-line-off");

		if (!$('.top-line-space').exists() && !bodyTransparent) {
			$("<div class='top-line-space'></div>").insertBefore(stickyTopLine);
		}
		var logoURL = $(".branding a", stickyTopLine).attr("href"),
			$branding = stickyTopLine.find(".branding"),
			$logo = $branding.find("img");

		// Using same or different logo?
		if ($branding.find("a.same-logo").length > 0) {
		}
		else {
			if(!$(".sticky-logo").exists()) {
				if (dtLocal.themeSettings.topLine.floatingTopLine.logo.html && dtLocal.themeSettings.topLine.floatingTopLine.logo.showLogo) {
					if (logoURL == undefined) {
						$(dtLocal.themeSettings.topLine.floatingTopLine.logo.html).addClass("sticky-logo").prependTo($branding);
					}
					else {
						$('<a class="sticky-logo" href="'+logoURL+'">' + dtLocal.themeSettings.topLine.floatingTopLine.logo.html +' </a>').prependTo($branding);
					};
				};
			};
		};

	
		var mobileReset = false;
		dtGlobals.resetTopLineSizes = function (sliderHeihgt) {
			// Stop execution when on mobile devices
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				if (!mobileReset) {
					mobileReset = true;
					stickyTopLine.removeClass('sticky-top-line-on');
					
					stickyTopLine.css({
						"top":  ""
					});
					topLineDocked = false;
				}
				return false;
			}
			else if (mobileReset) {
				mobileReset = false;
			}
			

			// Admin bar height
			if ($("#wpadminbar").exists()) {
				adminBarH = $("#wpadminbar").height();
			}
			else {
				adminBarH = 0;
			};
	
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
				topBarH = $topBar.innerHeight();
			}else {
				topBarH = 0;
			};
			stickyTopLineH = stickyTopLine.find('.header-bar').height() + topBarH;

			$('.top-line-space').css({
				height: stickyTopLineH
			});

			if($(".is-safari").length > 0){
				if($page.hasClass("boxed")){
					stickyTopLine.css({
						"width": dtLocal.themeSettings.boxedWidth,
						"max-width": dtLocal.themeSettings.boxedWidth
					})
				}else{
					stickyTopLine.css({
						"width":  document.documentElement.clientWidth,
						"max-width":  document.documentElement.clientWidth
					});
				}
			}
		};

		dtGlobals.resetTopLineSizes($mainSlider.height());
		$window.on("resize debouncedresize", function() {
			dtGlobals.resetTopLineSizes($mainSlider.height());
		});

		$window.on("scroll", function() {
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				return false;
			}
			// When sticky navigation should be shown
			var posScrollTop = dtGlobals.winScrollTop, //window scroll top position
				stickyTopLineH = stickyTopLine.height(),
				showstickyTopLineAfter = posScrollTop > stickyTopLineH;
				if (showstickyTopLineAfter && !topLineDocked){
					stickyTopLine.removeClass("sticky-top-line-off").addClass("sticky-top-line-on");
					if(stickyTopLine.hasClass("mixed-floating-top-bar")){
						stickyTopLine.css({
							"top":  adminBarH
						});
					}else{
						stickyTopLine.css({
							"top":  adminBarH - topBarH
						});
					}
					topLineDocked = true;
				}
				else if(!showstickyTopLineAfter && topLineDocked){
					stickyTopLine.removeClass("sticky-top-line-on").addClass("sticky-top-line-off");
					stickyTopLine.css({
						"top": adminBarH
					});
					topLineDocked = false;
				}
		});
	}

	/* Floating navigation -> Style -> fade, Slide */

	if(dtLocal.themeSettings.floatingHeader.showMenu) {

		if (dtLocal.themeSettings.floatingHeader.showMenu && !phantomStickyExists ) {

			var phantomFadeExists = $(".phantom-fade").exists(),
				phantomSlideExists = $(".phantom-slide").exists(),
				splitHeaderExists = $(".split-header").exists();

			if( phantomFadeExists || phantomSlideExists) {


				var $headerMenu = $(".masthead:not(#phantom) .main-nav").clone(true).removeAttr('id'),
					logoURL = $(".branding a", $mastheadHeader).attr("href"),
					$topbarFloating = $body.hasClass("floating-top-bar") ? $(".masthead:not(#phantom) .top-bar").clone(true) : "",
					isMoved = false;

				if (splitHeaderExists) {
					var headerClass = $mastheadHeader.attr("class");
					var $headerTopLine = $(".side-header-h-stroke, .split-header"),
						$phantom = $('<div id="phantom" class="'+headerClass+'"><div class="ph-wrap"></div></div>').appendTo("body"),
						$menuBox = $phantom.find(".ph-wrap"),
						$widgetBox = $phantom.find(".widget-box"),
						$widget = $headerMenu.find(".mini-widgets"),
						$phantomLogo = $headerTopLine.find(".branding");
					

					/*Phantom logo*/

					if($(".phantom-custom-logo-on").length > 0){

						if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
							if (logoURL == undefined){
								$(dtLocal.themeSettings.floatingHeader.logo.html).prependTo($phantomLogo)
							}
							else {
								$('<a class="phantom-top-line-logo" href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>').prependTo($phantomLogo);
							};
						};

						
					};
					//Generate floating content on load
					var $headerMenu = $(".split-header .header-bar").clone(true);
					$headerMenu.appendTo($menuBox).find('.main-nav').removeAttr('id');
					if($body.hasClass("floating-top-bar")){
						$topbarFloating.insertBefore($menuBox);
					}
				}
				else {
					var headerClass = $mastheadHeader.attr("class"),
						$phantom = $('<div id="phantom" class="'+headerClass+'"><div class="ph-wrap"><div class="logo-box"></div><div class="menu-box"></div><div class="widget-box"></div></div></div>').appendTo("body"),
						$menuBox = $phantom.find(".menu-box"),
						$widgetBox = $phantom.find(".widget-box");

					if ($(".classic-header").length > 0) {
						var $widget = $(".header-bar .navigation .mini-widgets").clone(true);
					}
					else if (splitHeaderExists) {}
					else {
						var $widget = $(".header-bar .mini-widgets").clone(true);
					};
					//Generate floating content on load
					$headerMenu.appendTo($menuBox);
					$widget.appendTo($widgetBox);
					if($body.hasClass("floating-top-bar")){
						$topbarFloating.prependTo($phantom);
					}

					/*Phantom logo*/
					if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
						$phantom.find(".ph-wrap").addClass("with-logo");

						if(logoURL == undefined){
							$phantom.find(".logo-box").html('<a href="'+dtLocal.themeSettings.floatingHeader.logo.url+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>');
						}
						else {
							$phantom.find(".logo-box").html('<a href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>');
						};
					};

					
				};
				var $floatingMenu =  $("#phantom");
				
				if ($page.hasClass("boxed")) {
					$phantom.addClass("boxed").find(".ph-wrap").addClass("boxed");
				}

				/* Hide floating on load */
				var phantomShowTimer;
				$floatingMenu.removeClass('show-phantom').addClass('hide-phantom').css("visibility", "hidden");
				addOnloadEvent(function(){
					clearTimeout( phantomShowTimer );
        			phantomShowTimer = setTimeout(function(){
						$floatingMenu.css("visibility", "");
					},150);
				})
				$menuBox.layzrInitialisation();

				var phantomAnimate = false;

				var phantomTimeoutShow,
					phantomTimeoutHide;	
				var tempScrTop = dtGlobals.winScrollTop,
					sliderH = $mainSlider.height(),
					headerH = $mastheadHeader.height();

				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					var showFloatingAfter = tempScrTop <= sliderH;

				}
				else if (floatingNavigationBelowSliderExists) {
					var showFloatingAfter = tempScrTop <= (sliderH + headerH);
				}
				else {
					var showFloatingAfter = tempScrTop <= dtLocal.themeSettings.floatingHeader.showAfter;
				};
				$window.on("scroll", function() {

					// Stop execution when on mobile devices
					if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
						return false;
					}
					
					var tempScrTop = dtGlobals.winScrollTop,
						sliderH = $mainSlider.height(),
						headerH = $mastheadHeader.height();

					if (floatingNavigationBelowSliderExists && bodyTransparent) {
						var showFloatingAfter = tempScrTop > sliderH && isMoved === false,
							hideFloatingAfter = tempScrTop <= sliderH && isMoved === true;

					}
					else if (floatingNavigationBelowSliderExists) {
						var showFloatingAfter = tempScrTop > (sliderH + headerH) && isMoved === false,
							hideFloatingAfter = tempScrTop <= (sliderH + headerH) && isMoved === true;
					}
					else {
						var showFloatingAfter = tempScrTop > dtLocal.themeSettings.floatingHeader.showAfter && isMoved === false,
							hideFloatingAfter = tempScrTop <= dtLocal.themeSettings.floatingHeader.showAfter && isMoved === true;
					};

					if (showFloatingAfter) {
						if(!$html.hasClass("menu-open")){	

							if( !dtGlobals.isHovering && !phantomAnimate ) {
								phantomAnimate = true;
								$floatingMenu.removeClass("hide-phantom").addClass("show-phantom");
								isMoved = true;
							};
						}
					}
					else if (hideFloatingAfter) {

						if(phantomAnimate) {
							if(!$html.hasClass("menu-open")){	
								phantomAnimate = false;
								$floatingMenu.removeClass("show-phantom").addClass("hide-phantom");
				
								isMoved = false;
							}
						}

					};
					
				});
			};
		};
	};
	var loaderShowTimer;
	addOnloadEvent(function(){
		clearTimeout( loaderShowTimer );
		loaderShowTimer = setTimeout(function(){
			var load = document.getElementById("load");
			if (load !== null && !load.classList.contains('loader-removed')) {
				
				load.className += " loader-removed";
			}
		},150);
	});