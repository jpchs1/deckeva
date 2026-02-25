
/* #Header
================================================== */

	var $topBar = $(".top-bar"),
		$mastheadHeader = $(".masthead"),
		$overlayHeader = $(".overlay-navigation"),
		$stickyHeader = $(".sticky-header"),
		stickyTopLine = $(".sticky-top-line"),
		$mainSlider = $("#main-slideshow, .photo-scroller"),
		$leftHeader = $(".header-side-left").length > 0,
		$rightHeader = $(".header-side-right").length > 0,
		$main = $("#main, #main-slideshow, .photo-scroller, .page-title, .fancy-header, .footer"),
		$topHeader = $(".floating-logo.side-header-menu-icon .branding, .side-header-h-stroke, #phantom"),
		$sideHeader = $(".side-header"),
		$onePage = $(".page-template-template-microsite").length > 0,
		dtScrollTimeout,
		bodyTransparent = $body.hasClass("transparent"),
		headerBelowSliderExists = $(".floating-navigation-below-slider").exists();
		if($(".side-header-v-stroke").length > 0){			
			var $sideHeaderW = $sideHeader.width() - $(".side-header-v-stroke").width(),
				$delay = 200;
		}else{
			var $sideHeaderW = $sideHeader.width(),
				$delay = 0;
		}

	$.closeSideHeader = function(){
		$page.removeClass("show-header");
		$page.addClass("closed-header");
		$(".sticky-header-overlay").removeClass("active");
		
	}
	$.closeMobileHeader = function(){
		$page.removeClass("show-mobile-header");
		$page.addClass("closed-mobile-header");
		$body.removeClass("show-sticky-mobile-header show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
		$(".mobile-sticky-header-overlay, .dt-mobile-menu-icon, .menu-toggle, .menu-close-toggle").removeClass("active");
		
	}


	/*!-Show Hide side header*/
	if($stickyHeader.length > 0 || $overlayHeader.length > 0 ) {
		$('<div class="lines-button x"><span class="menu-line"></span><span class="menu-line"></span><span class="menu-line"></span></div>').appendTo(".menu-toggle");
		var ToggleCaptionOn = dtLocal.themeSettings.ToggleCaptionEnabled;
		if(ToggleCaptionOn != "disabled"){
			ToggleCaption = "<span class='menu-toggle-caption'>" + dtLocal.themeSettings.ToggleCaption + "</span>";
		}else{
			ToggleCaption='';
		}
		if($stickyHeader.length > 0) {
			$body.append('<div class="sticky-header-overlay"></div>');
		};
		/*hiding side header*/

		var $hamburger = $(".menu-toggle"),
			$hamburgerClose = $(".menu-close-toggle"),
			$menuToggle = $(".menu-toggle:not(.active), .menu-close-toggle:not(.active)"),
			$overlay = $(".sticky-header-overlay");

		$hamburger.on("click", function (){
			if(!$(".header-under-side-line").length > 0){
				var $this = $(".side-header .menu-toggle");
			}else{
				var $this = $(".menu-toggle");
			}
			if ($this.hasClass("active")){
				$this.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
				$(".hide-overlay").removeClass("active");
			}
			else{
				$menuToggle.removeClass("active");
				$this.addClass('active').css({left:"",right:""});
				$page.addClass("show-header").removeClass("closed-header");
				$hamburgerClose.addClass("active");
				$overlay.addClass("active");
				$(".hide-overlay").addClass("active");
				
			};
		});
		$hamburgerClose.on("click", function (){
			// if(!$(".header-under-side-line").length > 0){
			// 	var $this = $(".side-header .menu-close-toggle");
			// }else{
				var $this = $(this);
			//}
			if ($this.hasClass("active")){
				$this.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
				$(".hide-overlay").removeClass("active");
			}
			else{
			 	$menuToggle.removeClass("active");
			 	$this.addClass('active').css({left:"",right:""});
			 	$page.addClass("show-header").removeClass("closed-header");
				
			 	$overlay.addClass("active");
			 	$(".hide-overlay").addClass("active");
				
			 };
		});
		$overlay.on("click", function (){
			if($(this).hasClass("active")){
				$menuToggle.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
			}
		});
		$(".hide-overlay").on("click", function (){
			if($(this).hasClass("active")){
				$menuToggle.removeClass("active");
				$page.removeClass("show-header");
				$page.addClass("closed-header");
				$overlay.removeClass("active");
				
			}
		});
	};

	/* !- Right-side header + boxed layout */
	function ofX() {

		var $windowW = $window.width(),
			$boxedHeaderPos = ($windowW - $page.innerWidth())/2,
			$sideHeaderToggleExist = $(".side-header-menu-icon").length > 0;

		if(($windowW - $page.innerWidth())/2 > 0){
			var $boxedHeaderPos = ($windowW - $page.innerWidth())/2;
		}else {
			var $boxedHeaderPos = "";
		}

		if ($body.hasClass("header-side-right") && $page.hasClass("boxed")) {
			if(!$stickyHeader.length > 0){
				$sideHeader.css({
					right: $boxedHeaderPos
				});
			};
		}
		if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
			$mastheadHeader.insertAfter($mainSlider);
			var $mastheadHeaderStyle = $mastheadHeader.attr("style");
			$mastheadHeader.not('.sticky-on').attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
		}
		if($(".floating-menu-icon-right").length > 0 && $page.hasClass("boxed")){
			$menuToggle.css({
				right: $boxedHeaderPos
			});
			$(".branding").css({
				left: $boxedHeaderPos
			});
		}
	
		if ($page.hasClass("boxed")) {
			
			if($sideHeaderToggleExist && !$(".floating-menu-icon-right").length > 0){
				
				$(".floating-logo .branding").css({
					right: $boxedHeaderPos
				});
				$menuToggle.css({
					left: $boxedHeaderPos
				});
			}
		};
		if($overlayHeader.length > 0 && $sideHeaderToggleExist  && $page.hasClass("boxed")){
			$menuToggle.css({
				right: $boxedHeaderPos
			});
			$(".floating-logo .branding").css({
				left: $boxedHeaderPos
			});

		};
	};

	ofX();
	$window.on("resize", function() {
		ofX();
	});
	
		if(headerBelowSliderExists && $body.hasClass("footer-overlap")){
			$mastheadHeader.insertAfter($mainSlider)
		}
		if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
			$mastheadHeader.insertAfter($mainSlider);
			var $mastheadHeaderStyle = $mastheadHeader.attr("style")
			$mastheadHeader.attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
		}

	/*Default scroll for mobile*/
	if($(".mixed-header").length > 0){
		var $activeHeader = $(".mixed-header");
	}else{
		var $activeHeader = $mastheadHeader;
	}

	/*Side header scrollbar for desctop*/
	$(".side-header .header-bar").wrap("<div class='header-scrollbar-wrap'></div>");
	if($sideHeader.length > 0 && !dtGlobals.isMobile){
		$(".header-scrollbar-wrap").mCustomScrollbar({
			scrollInertia:150,
			callbacks:{
		        whileScrolling:function(){
					$(".header-scrollbar-wrap").layzrInitialisation();
		        }
		    }
		});
		$(".sub-downwards .main-nav").find('.slider-content').widgetScroller().css("visibility", "visible");

	};
	if($sideHeader.length > 0){
		if(!$(".mCSB_container").length > 0){
			$(".side-header .header-scrollbar-wrap .header-bar").wrap("<div class='mCSB_container'></div>");
		}
	}
	
	