
/* #Filter
================================================== */

	/*!-categories filter*/
	window.the7ApplyGeneralFilterHandlers = function($element) {
		if (!$element.exists()) {
			return;
		}

		$element.find("> a").on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();
				arguments.callee.dtPreventD = true;

				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax");
				}
			}

			e.preventDefault();

			$this.trigger("mouseleave");

			if ($this.hasClass("act") && !$this.hasClass("show-all")) {
				e.stopImmediatePropagation();
				$this.removeClass("act");
				$this.siblings("a.show-all").trigger("click");
			} else {
				$this.siblings().removeClass("act");
				$this.addClass("act");

				if ( !arguments.callee.dtPreventD ) {
					window.location.href = $this.attr("href");
				}
			}
		});
	}

	window.the7ApplyGeneralOrderingSwitchHandlers = function($element) {
		if (!$element.exists()) {
			return;
		}

		if ($element.prev(".act").length > 0) {
			$element.addClass("left-act");
		} else if ($element.next(".act").length > 0) {
			$element.addClass("right-act");
		} else {
			$element.removeClass("right-act");
			$element.removeClass("left-act");
		}

		var $filter = $element.parents(".filter").first();
		$element.on("click", function () {
			if ($filter.hasClass("without-isotope")) {
				if ($element.hasClass("right-act")) {
					$element.prev("a")[0].click();
				} else if ($element.hasClass("left-act")) {
					$element.next("a")[0].click();
				}
			} else {
				if ($element.hasClass("right-act")) {
					$element.prev("a").trigger("click");
				} else if ($element.hasClass("left-act")) {
					$element.next("a").trigger("click");
				}
			}
		});
	}

	window.the7ApplyGeneralOrderingSwitchEffects = function ($filter) {
		if (!$filter.exists()) {
			return;
		}

		var $switch = $(".filter-switch", $filter);

		$switch.append("<span class='filter-switch-toggle'></span>");

		$switch.each(function() {
			the7ApplyGeneralOrderingSwitchHandlers($(this));
		});

		$(".filter-switch .filter-switch-toggle", $filter).on("animationend webkitAnimationEnd oanimationend MSAnimationEnd", function (e) {
			$(this).parent().removeClass("pressed");
		});

		$(".filter-extras a", $filter).on("animationend webkitAnimationEnd oanimationend MSAnimationEnd", function (e) {
			$(this).removeClass("pressed");
		});

		if (Modernizr.touch) {
			$switch.on("touchstart", function (e) {
				$(".filter-switch").removeClass("pressed")
				$(this).addClass("pressed");
			});

			$(".filter-extras a", $filter).on("touchstart", function (e) {
				$(".filter-extras").removeClass("pressed")
				$(this).parent(".filter-extras").addClass("pressed");
			});
		} else {
			$switch.on("mousedown", function (e) {
				$(".filter-switch").removeClass("pressed")
				$(this).addClass("pressed");
				setTimeout(function () {
					$(this).removeClass("pressed");
				}, 600);
			});
			$(".filter-extras a", $filter).each(function () {
				$(this).on("mousedown", function (e) {
					$(".filter-extras").removeClass("pressed")
					$(this).addClass("pressed");
					setTimeout(function () {
						$(this).removeClass("pressed");
					}, 600);
				});
			});
		}

		$(".filter-extras a", $filter).on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();

				arguments.callee.dtPreventD = true;
				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax");
				}
			}

			if ( arguments.callee.dtPreventD ) {
				e.preventDefault();
			}

			$this.siblings().removeClass("act");
			$this.addClass("act");

			$switch.each(function(){
				var $_this = $(this);
				if($_this.prev($this).hasClass('act')){
					$_this.addClass('left-act');
					$_this.removeClass('right-act');
				}else if($_this.next($this).hasClass('act')){
					$_this.addClass('right-act');
					$_this.removeClass('left-act');
				}else{
					$_this.removeClass('right-act');
					$_this.removeClass('left-act');
				}
			});
		});
	}

	$(".filter-categories").each(function() {
		the7ApplyGeneralFilterHandlers($(this));
	});

	$(".filter").each(function() {
		the7ApplyGeneralOrderingSwitchEffects($(this));
	});

		//List filter
		$(".mode-list .filter-categories > a:not(.show-all), .dt-css-grid-wrap .filter-categories > a:not(.show-all)").each(function(){
			$this = $(this),
			$dataFiltr = $this.attr("data-filter");
			$newDataFilter = $dataFiltr.substring(1, $dataFiltr.length);
			$this.attr("data-filter", $newDataFilter);
			$this.parents().removeClass('iso-filter');
		})

	window.the7ShortcodesFilterConfig = function ($container) {
		var config = {};

		if ($container.hasClass("dt-css-grid")) {
			config.filterControls = $container.parent().find(".filter-categories");
			config.pageControls = $container.parent().find(".paginator");
			config.sortControls = $container.parent().find(".filter-by");
			config.orderControls = $container.parent().find(".filter-sorting");
			config.defaultSort = $container.parent().find(".filter-by .act").attr("data-by");
			config.defaultOrder = $container.parent().find(".filter-sorting .act").attr("data-sort");
			config.paginationMode = $container.parent().attr("data-pagination-mode");
			config.pageLimit = $container.parent().attr("data-post-limit");
		} else {
			config.filterControls = $container.find(".filter-categories");
			config.pageControls = $container.find(".paginator");
			config.sortControls = $container.find(".filter-by");
			config.orderControls = $container.find(".filter-sorting");
			config.defaultSort = $container.find(".filter-by .act").attr("data-by");
			config.defaultOrder = $container.find(".filter-sorting .act").attr("data-sort");
			config.paginationMode = $container.attr("data-pagination-mode");
			config.pageLimit = $container.attr("data-post-limit");
		}

		config.useFilters = true;
		config.useSorting = true;
		config.controlsSelecter = "a";
		config.controlsSelecterChecked = "a.act";
		config.defaultFilter = "*";
		config.selectAll = "*";
		config.loadMoreButtonLabel = dtLocal.moreButtonText.loadMore;

		return config;
	}

		$.fn.shortcodesFilter = function(config) {
			var $el = $(this);

			$el.Filterade(config);
			$el.on('updateReady', function(){
				loadingEffects();
				$el.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
			})
			function lazyLoading() {
				if($el.hasClass("dt-css-grid")){
					$element = $el.parent();
				}else{
					$element = $el;
				}

				if( !$element.length || !$element.hasClass("lazy-loading-mode") ){
					return;
				}
				var $loadMoreButton = $element.find('.button-load-more');
				var buttonOffset = $loadMoreButton.offset();

				if ( buttonOffset && (($window.scrollTop() + $window.height()) > (buttonOffset.top - $window.height()*2))){
					$loadMoreButton.trigger('click');
				}
			}
			$window.on('scroll', function () {
				lazyLoading();
			});
			lazyLoading();
		}

		$('.blog-shortcode.mode-list.jquery-filter, .jquery-filter .dt-css-grid:not(.custom-pagination-handler)').each(function(){
			var $this = $(this);
			$this.shortcodesFilter(the7ShortcodesFilterConfig($this));
		});