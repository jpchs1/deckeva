
/* #Mobile header
================================================== */
	if(!$body.hasClass("responsive-off")){
	
		var $mixedHeader = $(".mixed-header"),

			//Mobile header widgets
			 $firstSwitchWidgetsNearLogo = $(".masthead .near-logo-first-switch").clone(true).addClass("show-on-first-switch"),
			 $secondSwitchWidgetsNearLogo = $(".masthead .near-logo-second-switch").clone(true).addClass("show-on-second-switch"),

			 //Mobile navigation widgets
			$mobileWidgetsInMenu = $mastheadHeader.find(".in-menu-first-switch").clone(true).addClass("hide-on-desktop hide-on-second-switch show-on-first-switch"),
			$mobileWidgetsInMenuSeocndSwitch = $mastheadHeader.find(".in-menu-second-switch").clone(true).addClass("hide-on-desktop hide-on-first-switch show-on-second-switch"),

			//Mobile top bar widgets
			$mobileWidgetsInTopBar = $mastheadHeader.find(".in-top-bar").clone(true).addClass("hide-on-desktop hide-on-first-switch show-on-second-switch"),
			$mobileWidgetsInTopBarLeft = $mastheadHeader.find(".in-top-bar-left").clone(true).addClass("hide-on-desktop show-on-first-switch"),
			$mobileWidgetsInTopBarRight = $mastheadHeader.find(".in-top-bar-right").clone(true).addClass("hide-on-desktop  show-on-first-switch");

		if($mixedHeader.length > 0){
			var $mobileLogo = $mixedHeader.find(".branding > a, .branding > img").clone(true),
				$activeHeader = $mixedHeader
		}else{
			var $mobileLogo = $(".masthead:not(.mixed-header)").find(".branding > a, .branding > img").clone(true),
				$activeHeader = $mastheadHeader;
		}
		if($topBar.length > 0 && $topBar.css('display') != 'none'){
			var topBarH = $topBar.innerHeight();
		}else{
			var topBarH = 0;
		}
		var mobileToggleCaptionOn = dtLocal.themeSettings.mobileHeader.mobileToggleCaptionEnabled;
		if(mobileToggleCaptionOn != "disabled"){
			mobileToggleCaption = "<span class='menu-toggle-caption'>" + dtLocal.themeSettings.mobileHeader.mobileToggleCaption + "</span>";
		}else{
			mobileToggleCaption='';
		}

		/*Append mobile header-bar to masthead*/
		$("<div class='mobile-header-bar'><div class='mobile-navigation'></div><div class='mobile-mini-widgets'></div><div class='mobile-branding'></div></div>").appendTo(".masthead");
		/*Mobile menu toggle icon*/
		$(".mobile-header-bar .mobile-navigation").append("<a href='#' class='dt-mobile-menu-icon' aria-label='Mobile menu icon'>" + mobileToggleCaption + "<div class='lines-button '><span class='menu-line'></span><span class='menu-line'></span><span class='menu-line'></span></div></a>");
		

		/*Append mini widgets to mobile header-bar*/

		$($firstSwitchWidgetsNearLogo).appendTo(".mobile-header-bar .mobile-mini-widgets");
		$($secondSwitchWidgetsNearLogo).appendTo(".mobile-header-bar .mobile-mini-widgets");

		/*Append mini widgets to mobile top-bar*/
		$(".left-widgets", $topBar).append($mobileWidgetsInTopBar);
		$(".left-widgets", $topBar).append($mobileWidgetsInTopBarLeft);
		$(".right-widgets", $topBar).append($mobileWidgetsInTopBarRight).removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		$(".right-widgets", $topBar).append($mobileWidgetsInTopBarRight).removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch")

		/*Mobile navigation widgets*/
		$($mobileWidgetsInMenu).appendTo(".mobile-mini-widgets-in-menu");
		$($mobileWidgetsInMenuSeocndSwitch).appendTo(".mobile-mini-widgets-in-menu");
		 $mobileWidgetsInMenu.removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		 $mobileWidgetsInMenuSeocndSwitch.removeClass("select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch");

		/*Append logo to mobile header-bar*/
		$(".mobile-header-bar .mobile-branding").append($mobileLogo);

		var $mobileMenu = $(".dt-mobile-header");
		if($mobileMenu.siblings().hasClass("dt-parent-menu-clickable")){
			$mobileMenu.addClass("dt-parent-menu-clickable");
		}
		if(!$(".mobile-mini-widgets-in-menu").find(".in-menu-first-switch ").length > 0){
			$(".mobile-mini-widgets-in-menu").addClass('first-switch-no-widgets')
		}
		if(!$(".mobile-mini-widgets-in-menu").find(".in-menu-second-switch ").length > 0){
			$(".mobile-mini-widgets-in-menu").addClass('second-switch-no-widgets')
		}

		$firstSwitchWidgetsNearLogo.removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		 $secondSwitchWidgetsNearLogo.removeClass("select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch");
		 $mobileWidgetsInTopBar.removeClass('show-on-desktop select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch in-top-bar-left').addClass('hide-on-desktop hide-on-first-switch');
		 $mobileWidgetsInTopBarLeft.removeClass('show-on-desktop select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch in-top-bar').addClass('hide-on-desktop hide-on-second-switch');
		 $mobileWidgetsInTopBarRight.removeClass('show-on-desktop select-type-menu list-type-menu  select-type-menu-second-switch list-type-menu-second-switch').addClass('hide-on-desktop');
		$(".header-bar .mini-widgets > .mini-nav ").removeClass('select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch');

		$(".mini-nav.show-on-desktop:not(.show-on-first-switch):not(.show-on-second-switch)", $topBar).removeClass('select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch');
		$(".masthead .hide-on-desktop").addClass("display-none");
		
		/*Remove mega menu settings from mobile*/
		$(".mobile-main-nav ").find("li").each(function(){
			var $this = $(this),
				$this_sub = $this.find(" > .dt-mega-menu-wrap > .sub-nav");
			if($this.hasClass("new-column")){
				var $thisPrev = $this.prev().find(" > .sub-nav");
				$(" > .sub-nav > *", $this).appendTo($thisPrev)
			}
			$this_sub.unwrap();		
		}).removeClass('dt-mega-menu dt-mega-parent hide-mega-title').find(" > .sub-nav").removeClass(" hover-style-bg");


		/*!-Show Hide mobile header*/
		if($mobileMenu.length > 0 ) {
			dtGlobals.mobileMenuPoint = 50;
			var $Mobilehamburger = $(".dt-mobile-menu-icon"),
				isbtnMoved = false,
				$activeHeaderTop = $activeHeader.offset().top;
			
			/*Mobile floating menu toggle*/
			if(!$(".floating-btn").length > 0 && $(".floating-mobile-menu-icon").length > 0){
				var $hamburgerFloat = $Mobilehamburger.first().clone(true).insertBefore($Mobilehamburger).addClass("floating-btn");
				//var $hamburgerFloat = '<a href="#" class="dt-mobile-menu-icon floating-btn" aria-label="Mobile menu icon"><span class="lines"></span></a>';
				//$hamburgerFloat.insertBefore($Mobilehamburger).addClass("floating-btn");
				//$('<a href="#" class="dt-mobile-menu-icon" aria-label="Mobile menu icon"><span class="lines"></span></a>').appendTo(".masthead:not(#phantom)").addClass("floating-btn");
			}
			var $floatMobBtn = $(".floating-btn");
			
			var mobilePhantomAnimate = false;


			$window.scroll(function () {
				dtGlobals.mobileMenuPoint = $activeHeaderTop + $activeHeader.height() + 50;

				if(dtGlobals.winScrollTop > dtGlobals.mobileMenuPoint && isbtnMoved === false){
					$floatMobBtn.parents(".masthead").addClass("show-floating-icon");
					isbtnMoved = true;
				}
				else if(dtGlobals.winScrollTop <= dtGlobals.mobileMenuPoint && isbtnMoved === true) {
					$floatMobBtn.parents(".masthead").removeClass("show-floating-icon");
					isbtnMoved = false;
				}
			});
			var $Mobilehamburger = $(".dt-mobile-menu-icon");

			/*Append overlay for mobile menu*/
			if(!$(".mobile-sticky-header-overlay").length > 0){
				$body.append('<div class="mobile-sticky-header-overlay"></div>');
			}
					
			 var $mobileOverlay = $(".mobile-sticky-header-overlay");

			/*Click on mobile menu toggle*/
			$Mobilehamburger.on("click", function (e){
				e.preventDefault();
				
				var $this = $(this);

				if ($this.hasClass("active")){
					$this.removeClass("active");
					$page.removeClass("show-mobile-header").addClass("closed-mobile-header");
					$body.removeClass("show-mobile-overlay-header").addClass("closed-overlay-mobile-header");
					$this.parents("body").removeClass("show-sticky-mobile-header");
					$mobileOverlay.removeClass("active");
				}else{
					$Mobilehamburger.removeClass("active");
					$this.addClass('active');
					$page.addClass("show-mobile-header").removeClass("closed-mobile-header");
					$body.removeClass("closed-overlay-mobile-header").addClass("show-overlay-mobile-header");
					$mobileOverlay.removeClass("active");
					$this.parents("body").addClass("show-sticky-mobile-header");
					$mobileOverlay.addClass("active");
				};

			
			});
			$mobileOverlay.on("click", function (){
				if($(this).hasClass("active")){
					$Mobilehamburger.removeClass("active");
					$page.removeClass("show-mobile-header").addClass("closed-mobile-header");
					$body.removeClass("show-sticky-mobile-header").addClass("closed-overlay-mobile-header").addClass("closed-overlay-mobile-header");
					$mobileOverlay.removeClass("active");
					$page.removeClass("show-mobile-sidebar");
					
				}
			});
			$(".dt-close-mobile-menu-icon").on("click", function (){
				
				$page.removeClass("show-mobile-header");
				$page.addClass("closed-mobile-header");
				$body.removeClass("show-sticky-mobile-header");
				$body.removeClass("show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
				$mobileOverlay.removeClass("active");
				$Mobilehamburger.removeClass("active");
								
			});
			
			////!--Return with old header
			$(".dt-mobile-header").wrapInner("<div class='mobile-header-scrollbar-wrap'></div>");
		
				$mobileMenu.on('scroll', function () {
					$(".mobile-header-scrollbar-wrap").layzrInitialisation();
				})
			
			$mobileMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
			if(!$(".touchevents").length > 0){
				$mobileMenu.on("mouseenter", function(e) {
					$mobileMenu.css("overflow-y", "auto");
				});
				$mobileMenu.on("mouseleave", function(e) {
					$mobileMenu.css("overflow-y", "hidden");
				});
			}
		};
		
	}
