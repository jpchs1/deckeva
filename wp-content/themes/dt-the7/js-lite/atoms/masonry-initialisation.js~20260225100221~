
/* #Masonry
================================================== */
	// !- Calculate columns size
	window.the7GetMasonryColumnsConfig = function ($container) {
		var $dataAttrContainer = $container.parent().hasClass("mode-masonry") ? $container.parent() : $container;
		var containerWidth = $container.width() - 1;
		var columns = {
			mobile: parseInt($dataAttrContainer.attr("data-phone-columns-num")),
			desktop: parseInt($dataAttrContainer.attr("data-desktop-columns-num")),
			tabletV: parseInt($dataAttrContainer.attr("data-v-tablet-columns-num")),
			tabletH: parseInt($dataAttrContainer.attr("data-h-tablet-columns-num"))
		};

		if (Modernizr.mq("only screen and (max-width:767px)")) {
			singleWidth = Math.floor(containerWidth / columns.mobile) + "px";
			doubleWidth = Math.floor(containerWidth / columns.mobile) * 2 + "px";
			columnsNum = columns.mobile;
		} else if (Modernizr.mq("(min-width:768px) and (max-width:991px)")) {
			singleWidth = Math.floor(containerWidth / columns.tabletV) + "px";
			doubleWidth = Math.floor(containerWidth / columns.tabletV) * 2 + "px";
			columnsNum = columns.tabletV;
		} else if (Modernizr.mq("(min-width:992px) and (max-width:1199px)")) {
			singleWidth = Math.floor(containerWidth / columns.tabletH) + "px";
			doubleWidth = Math.floor(containerWidth / columns.tabletH) * 2 + "px";
			columnsNum = columns.tabletH;
		} else {
			singleWidth = Math.floor(containerWidth / columns.desktop) + "px";
			doubleWidth = Math.floor(containerWidth / columns.desktop) * 2 + "px";
			columnsNum = columns.desktop;
		}

		return {
			singleWidth: singleWidth,
			doubleWidth: doubleWidth,
			columnsNum: columnsNum
		};
	};

	$.fn.simpleCalculateColumns = function($dataAttrContainer, columnsConfigFunction, mode) {
		var contWidth = parseInt($dataAttrContainer.attr("data-width"));
        var contNum = parseInt($dataAttrContainer.attr("data-columns"));
        var contPadding = parseInt($dataAttrContainer.attr("data-padding"));
		if (typeof mode === 'undefined' ){
            mode = 'px';
		}
        this.calculateColumns(contWidth, contNum, contPadding, null, null, null, null, mode, columnsConfigFunction);
	};

	$.fn.calculateColumns = function(minWidth, colNum, padding, switchD, switchTH, switchTV, switchP, mode, columnsConfigFunction) {
		return this.each(function() {
			var columns;
			var tempCSS = "";
			var containerWidth;
			var $container = $(this);
			var $classesContainer = $container;
			var containerID = $container.attr("data-cont-id");
			var $containerIDN = $(".cont-id-" + containerID + "");
			var containerPadding = (padding !== false) ? padding : 20;
			var singleWidth;
			var doubleWidth;
			var columnsNum;
			var normalizedMargin = -containerPadding;
			var normalizedPadding = containerPadding - 10;
			var normalizedPaddingTop = containerPadding - 5;

			if (containerPadding < 10) {
				normalizedPadding = 0;
				normalizedPaddingTop = 0;
			}
			if (containerPadding === 0) {
				normalizedMargin = 0;
			}

			if ($container.parent().hasClass("mode-masonry")) {
				$classesContainer = $classesContainer.parent();
				$containerIDN = $containerIDN.parent();
			}

			var isDescriptionUnderImage = $containerIDN.not(".bg-under-post, .content-bg-on").hasClass("description-under-image");

			if (!$("#col-style-id-" + containerID).exists()) {
				var jsStyle = document.createElement("style");
				jsStyle.id = "col-style-id-" + containerID;
				jsStyle.appendChild(document.createTextNode(""));
				document.head.appendChild(jsStyle);
			} else {
				var jsStyle = document.getElementById("col-style-id-" + containerID);
			}

			var $style = $("#col-style-id-" + containerID);

			// Add container margins to use updated container width in calculations.
			if (isDescriptionUnderImage) {
				tempCSS = " \
							.cont-id-" + containerID + " { margin: -" + normalizedPaddingTop + "px  -" + containerPadding + "px -" + normalizedPadding + "px ; } \
							.full-width-wrap .cont-id-" + containerID + " { margin: " + (-normalizedPaddingTop) + "px " + containerPadding + "px " + (-normalizedPadding) + "px ; }";
			} else {
				tempCSS = " \
							.cont-id-" + containerID + " { margin: -" + containerPadding + "px; } \
							.full-width-wrap .cont-id-" + containerID + " { margin: " + normalizedMargin + "px  " + containerPadding + "px; } \
						";
			}
			$style.html(tempCSS);

			if ($classesContainer.hasClass("resize-by-browser-width")) {
				if (typeof columnsConfigFunction === "undefined") {
					columnsConfigFunction = the7GetMasonryColumnsConfig;
				}

				columns = columnsConfigFunction.call(this, $container);

				singleWidth = columns.singleWidth;
				doubleWidth = columns.doubleWidth;
				columnsNum = columns.columnsNum;
			} else {
				containerWidth = $container.width() - 1;

				minWidth = minWidth ? minWidth : 200;
				colNum = colNum ? colNum : 6;

				for (; Math.floor(containerWidth / colNum) < minWidth;) {
					colNum--;
					if (colNum <= 1) break;
				}

				if (mode === "px") {
					singleWidth = Math.floor(containerWidth / colNum) + "px";
					doubleWidth = Math.floor(containerWidth / colNum) * 2 + "px";
					columnsNum = colNum;
				} else {
					singleWidth = Math.floor(100000 / colNum) / 1000 + "%";
					doubleWidth = Math.floor(100000 / colNum) * 2 / 1000 + "%";
				}
			}

			if (isDescriptionUnderImage) {
				if (columnsNum > 1) {
					tempCSS += " \
							.cont-id-" + containerID + "  .wf-cell { width: " + singleWidth + "; padding: " + normalizedPaddingTop + "px " + containerPadding + "px " + normalizedPadding + "px; } \
							.cont-id-" + containerID + "  .wf-cell.double-width { width: " + doubleWidth + "; } \
						";
				} else {
					tempCSS += " \
							.cont-id-" + containerID + "  .wf-cell { width: " + singleWidth + "; padding: " + normalizedPaddingTop + "px " + normalizedPadding + "px " + containerPadding + "px; } \
						";
				}
			} else {
				if (columnsNum > 1) {
					tempCSS += " \
							.cont-id-" + containerID + " .wf-cell { width: " + singleWidth + ";  padding: " + containerPadding + "px; } \
							.cont-id-" + containerID + " .wf-cell.double-width { width: " + doubleWidth + "; } \
						";
				} else {
					tempCSS += " \
							.cont-id-" + containerID + " .wf-cell { width: " + singleWidth + "; padding: " + containerPadding + "px; } \
						";
				}
			}
			$style.html(tempCSS);
			var newRuleID = jsStyle.sheet.cssRules.length;
			jsStyle.sheet.insertRule(".webkit-hack { }", newRuleID);
			jsStyle.sheet.deleteRule(newRuleID);

			$container.trigger("columnsReady");
		});
	};

	// !- Initialise slider
	$.fn.initSlider = function() {
		return this.each(function() {
		
			var $_this = $(this),
				attrW = $_this.data('width'),
				attrH = $_this.data('height');

			if ($_this.hasClass("royalReady")) {
				return;
			}

			$_this.postTypeScroller();

			$_this.addClass("royalReady");
			
		});
	};
	//disable isotope animation
	var positionFunc = Isotope.prototype._positionItem;
	Isotope.prototype._positionItem = function( item, x, y, isInstant ) {
	  // ignore isInstant, pass in true;
	  positionFunc(item, x, y, true);
	};

	$.fn.IsoLayzrInitialisation = function(container) {
        return IsoLayzrCommonInitialisation(this, container, "img[class*=iso-]", "iso-item-lazy-load");
	};

	$.fn.IsoLayzrJqInitialisation = function(container) {
		return IsoLayzrCommonInitialisation(this, container, "img", "thumb-lazy-load-show");
	};

	function IsoLayzrCommonInitialisation(elements, layzrContainer, imgSelector, imgClass) {
		var flag = true;

		return elements.each(function() {
			var $this = $(this);
			$this.find(imgSelector).addClass(imgClass);
			new Layzr({
				container: layzrContainer,
				selector: '.' + imgClass,
				attr: 'data-src',
				attrSrcSet: 'data-srcset',
				retinaAttr: 'data-src-retina',
				threshold: 30,
				before: function() {
					var ext = $(this).attr("data-src").substring($(this).attr("data-src").lastIndexOf(".")+1);
					if(ext == "png"){
						$(this).parent().addClass("layzr-bg-transparent");
					}
					$(this).one("load",function() {
						// For fixed-size images with srcset; or have to be updated on window resize.

						if($(this).parents(".woocom-project").length > 0 ){
							this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
						}else{
							this.setAttribute("sizes", this.width+"px");
						}
						this.style.willChange = 'opacity';
					});
				},
				callback: function() {
					this.classList.add("iso-layzr-loaded");
					var $this =  $(this);
					$this.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
						setTimeout(function(){
							$this.parent().removeClass("layzr-bg");
							$this.css("will-change",'auto');
						}, 200)
					});
					if($this.parents(".dt-isotope").length > 0 && flag ){
						$this.parents(".dt-isotope").isotope("layout");
						flag = false;
					}
				}
			});
		});
	};

	/* !Containers of masonry and grid content */
	
	var	$isoCollection = $(".iso-container");
	var	$gridCollection = $(".iso-grid:not(.jg-container, .iso-container), .blog.layout-grid .wf-container.description-under-image:not(.jg-container, .iso-container), .grid-masonry:not(.iso-container), .shortcode-blog-posts.iso-grid"),
		//$flexGrid = $(".blog-grid-shortcode"),
		$combinedCollection = $isoCollection.add($gridCollection),
		$isoPreloader = dtGlobals.isoPreloader = $('<div class="iso-preloader dt-posts-preload dt-posts-preload-active"><div class="dt-posts-preload-activity"></div></div>').appendTo("body").hide();
		$combinedCollection.not(".blog-grid-shortcode").addClass("dt-isotope");

	window.the7ApplyColumns = function(i, $container, columnsConfigFunction) {
		i = i || 0;

		var	$dataAttrContainer = $container.parent().hasClass("mode-masonry") ? $container.parent() : $container;
        var contPadding = parseInt($dataAttrContainer.attr("data-padding"));

		$container.addClass("cont-id-"+i).attr("data-cont-id", i);

		$container.simpleCalculateColumns($dataAttrContainer, columnsConfigFunction);
		if(contPadding > 10){
			$container.addClass("mobile-paddings");
		}

		$window.on("debouncedresize", function () {
            $container.simpleCalculateColumns($dataAttrContainer, columnsConfigFunction);

			if(contPadding > 10){
				$container.addClass("mobile-paddings");
			}
		});
	};

	if ($combinedCollection.exists()) {
		$combinedCollection.not(".custom-iso-columns").each(function(i) {
			the7ApplyColumns(i, $(this), the7GetMasonryColumnsConfig);
		});
	}

	//if(!dtGlobals.isPhone){
	// !- Responsive height hack
	$.fn.heightHack = function() {
		//if(!$(".layzr-loading-on").length > 0){

			return this.each(function() {
				var $img = $(this).not(".back-image");
				if ($img.hasClass("height-ready") || $img.parents(".testimonial-thumb").exists() || $img.parents(".post-rollover").exists() || $img.parents(".slider-masonry").exists() || $img.parents(".rollover-thumbnails").exists()) {
					return;
				}
				var	imgWidth = parseInt($img.attr('width')),
					imgHeight = parseInt($img.attr('height')),
					imgRatio = imgWidth/imgHeight;

				if($img.parents(".testimonial-vcard, .dt-format-gallery, .shortcode-blog-posts.iso-grid ").exists()) {
					$img.wrap("<div />");
				};

					if ( isNaN( imgRatio ) && $img[0] ) {
						imgRatio = $img[0].naturalWidth/$img[0].naturalHeight;
					}

					$img.parent().css({
						"padding-bottom" : 100/imgRatio+"%",
						"height" : 0,
						"display" : "block"
					});

					if($img.parents(".woocom-project").exists() && $img.parents(".woocom-project").width() > imgWidth && $img.parents(".wc-img-hover").exists() ){
						$img.parent().css({
							"padding-bottom" : (100/ ($img.parents(".woocom-project").width()/imgWidth) )/imgRatio+"%",
							"height" : 0,
							"display" : "block"
						});
					}
					if($img.parents(".dt-team-masonry-shortcode").exists()){
						if($img.parent().css('max-width') != 'none'){
							$img.parents(".team-media").addClass('apply-max-width');
						}
					}

				$img.attr("data-ratio", imgRatio).addClass("height-ready");

			});
		//}
	};


	/* !Isotope initialization */
	$.fn.IsoInitialisation = function(item, mode, trans, equalh) {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("iso-item-ready")) {
				return;
			}
			$this.isotope({
				itemSelector : item,
				layoutMode : mode,
				stagger: 30,
				resize: false,
				transitionDuration: 0,
				equalheight: equalh,
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				},
				masonry: { columnWidth: 1 },
				getSortData : {
					date : function( $elem ) {
						return $($elem).attr('data-date');
					},
					name : function( $elem ) {
						return $($elem).attr('data-name');
					}
				}
			});
			$this.addClass("iso-item-ready");

		});

	};



	/* !Masonry and grid layout */

	/* !Filter: */
	//var $container = $('.iso-container, .portfolio-grid');
	$('.iso-container, .portfolio-grid').each(function(){
		if($(this).parent().hasClass("mode-masonry")){
			var $container = null;
		}else{
			var $container = $(this);
		}

		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-categories a').on('click.presscorFilterCategories', function(e) {
			var selector = $(this).attr('data-filter');
			if ($container != null){
				$container.isotope({ filter: selector });
			}
			return false;
		});

		// !- filtering
		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-by a').on('click', function(e) {
			var sorting = $(this).attr('data-by'),
				sort = $(this).parents('.filter-extras').find('.filter-sorting > a.act').first().attr('data-sort');
			if ($container != null){
				$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
			}
			return false;
		});

		// !- sorting
		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-sorting a').on('click', function(e) {
			var sort = $(this).attr('data-sort'),
				sorting = $(this).parents('.filter-extras').find('.filter-by > a.act').first().attr('data-by');
			if ($container != null){
				$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
			}
			return false;
		});
	});
	$('.dt-css-grid .wf-cell.visible').IsoLayzrJqInitialisation();


	/* !Masonry layout */
	if ($isoCollection.exists() || $gridCollection.exists() ) {

		// Show preloader
		$isoPreloader.fadeIn(50);

		$combinedCollection.not(".blog-grid-shortcode").each(function() {
			var $this = $(this);
			var	$isoContainer = $this;
			if($this.hasClass("mode-masonry")){
				$isoContainer = $this.find(".dt-isotope");
			}
			// Hack to make sure that masonry will correctly calculate columns with responsive images height.
			$(".preload-me", $isoContainer).heightHack();
			// Slider initialization
			$(".slider-masonry", $isoContainer).initSlider();

			$isoContainer.one("columnsReady", function() {

				//Call isotope
				if($isoContainer.hasClass("iso-container")){
					$isoContainer.IsoInitialisation('.iso-item', 'masonry', 400);
				}else{
					var equalheight = true;
					if($isoContainer.parent().hasClass("gradient-overlay-layout-list") || $isoContainer.parent().hasClass("content-rollover-layout-list")){
						equalheight = false;
					}
					$isoContainer.IsoInitialisation('.wf-cell', 'fitRows', 400, equalheight);
				}

				$isoContainer.isotope('on', 'layoutComplete', function (objArray){
					//callback isotope on load ...
					for(var i = 0; i < objArray.length; i++){
						var obj = objArray[i];
						var  $container = $(this);
					   $isoContainer.trigger("IsoReady");
					}
				});
				$isoContainer.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
				/* !Call layzr on isotope layoutComplete */
				$isoContainer.one("IsoReady", function() {
					/*Init layzr*/
					var	$layzrContainer = $isoContainer;
					if($isoContainer.parent().hasClass("jquery-filter") && $isoContainer.parent().attr('data-pagination-mode') != "none"){
						$layzrContainer = $isoContainer.find(".wf-cell.visible");
					}
					$layzrContainer.IsoLayzrJqInitialisation();
					setTimeout(function () {
						$isoContainer.isotope("layout");
					}, 350);
				});
			});

			// Recalculate everything on window resize
			$isoContainer.on("columnsReady", function () {
				if($(".slider-masonry", $isoContainer).hasClass("royalReady")){
					$(".slider-masonry", $isoContainer).each(function(){
						var scroller = $(this).parents(".ts-wrap").data("thePhotoSlider");
						if(typeof scroller!= "undefined"){
							scroller.update();
						}
					});
				}
				$isoContainer.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
				$isoContainer.isotope("layout");
			});

		});

		// Hide preloader
		$isoPreloader.stop().fadeOut(300);
	}