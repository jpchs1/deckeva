 
/* #Filter for posts shortcode
================================================== */
    var DTMasonryControls = (function () {
        function DTMasonryControls(config) {
            var defaults = {
                paginatorContainer: null,
                postLimit: 1,
                curPage: 1,
                items: [],
            filter: null,
                onPaginate: function () {
                }
            };

            this.config = $.extend(defaults, config);
        }

        DTMasonryControls.prototype.setCurPage = function (curPage) {
            this.config.curPage = parseInt(curPage);
        };

        DTMasonryControls.prototype.getCurPage = function () {
            return this.config.curPage;
        };

        DTMasonryControls.prototype.reset = function (items) {
            this.config.items = items;
            this.setCurPage(1);
            this.appendControls();
            this._filterByCurPage();
        };

        DTMasonryControls.prototype.appendControls = function () {
        };

        DTMasonryControls.prototype._filterByCurPage = function () {
            this.showItem(this.config.items);
        };

        DTMasonryControls.prototype.hideItem = function (item) {
            item.removeClass('visible').addClass('hidden').hide();
        };

        DTMasonryControls.prototype.showItem = function (item) {
            item.addClass('visible').removeClass('hidden').show();
        };

        DTMasonryControls.prototype.applyLoadingEffects = function () {
            this.lazyLoadImages();
            loadingEffects();
        };

        DTMasonryControls.prototype.lazyLoadImages = function () {
            if (this.config.items) {
                this.config.items.filter('.visible').IsoLayzrJqInitialisation();
            }
        };

        DTMasonryControls.prototype.layoutItems = function () {
            this._filterByCurPage();

            if (this.config.filter && typeof this.config.filter.layoutItems === "function") {
                this.config.filter.layoutItems();
            }
        };

        return DTMasonryControls;
    }());

    var DTMasonryPaginationControls = (function () {
        function DTMasonryPaginationControls(config) {
            DTMasonryControls.call(this, config);

            var defaults = {
                previousButtonClass: '',
                previousButtonLabel: '',
                pagerClass: '',
                nextButtonClass: '',
                nextButtonLabel: '',
                activeClass: 'act',
                pagesToShow: 5
            };

            this.config = $.extend(defaults, this.config);

            this.appendControls();

            $('a.act', this.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
        }

        DTMasonryPaginationControls.prototype = new DTMasonryControls();

        DTMasonryPaginationControls.prototype.addEvents = function () {
            var self = this;
            $('a', this.config.paginatorContainer).not('.dots').on('click.dtPostsPaginationFilter', {self: this}, function(event, onSetup) {
                self.config.onPaginate.call(this, event, onSetup);
            });
            $('a.dots', this.config.paginatorContainer).on('click.dtPostsPaginationDots', {self: this}, function(event) {
                event.preventDefault();
                event.data.self.config.paginatorContainer.find('div:hidden a').unwrap();
                event.data.self.config.paginatorContainer.find('a.dots').remove();
            });
        };

        DTMasonryPaginationControls.prototype.appendControls = function () {
            var pageControls = this.config.paginatorContainer;
            var pageCount = Math.ceil(this.config.items.length / this.config.postLimit);
            var activePage = this.config.curPage;

            pageControls.empty();

            if (pageCount <= 1) {
                pageControls.addClass("hidden");
                return;
            } else {
                pageControls.removeClass("hidden");
            }

            var i, _i;

            if (activePage !== 1) {
                pageControls.prepend('<a href="#" class="' + this.config.previousButtonClass + '" data-page-num="' + (activePage - 1) + '">' + this.config.previousButtonLabel + '</a>');
            }

            var pagesToShow = this.config.pagesToShow | 5;
            var pagesToShowMinus1 = pagesToShow - 1;
            var pagesBefore = Math.floor(pagesToShowMinus1 / 2);
            var pagesAfter = Math.ceil(pagesToShowMinus1 / 2);
            var startPage = Math.max(activePage - pagesBefore, 1);
            var endPage = activePage + pagesAfter;

            if (startPage <= pagesBefore) {
                endPage = startPage + pagesToShowMinus1;
            }

            if (endPage > pageCount) {
                startPage = Math.max(pageCount - pagesToShowMinus1, 1);
                endPage = pageCount;
            }

            var dots = '<a href="javascript:void(0);" class="dots">…</a>';
            var leftPagesPack = $('<div style="display: none;"></div>');
            var rightPagesPack = $('<div style="display: none;"></div>');

            for (i = _i = 1; 1 <= pageCount ? _i <= pageCount : _i >= pageCount; i = 1 <= pageCount ? ++_i : --_i) {
                if (i < startPage && i != 1) {
                    leftPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                    continue;
                }

                if (i == startPage && leftPagesPack.children().length) {
                    pageControls.append(leftPagesPack).append($(dots));
                }

                if (i > endPage && i != pageCount) {
                    rightPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                    continue;
                }

                if (i == pageCount && rightPagesPack.children().length) {
                    pageControls.append(rightPagesPack).append($(dots));
                }

                pageControls.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
            }

            if (activePage < pageCount) {
                pageControls.append('<a href="#" class="' + this.config.nextButtonClass + '" data-page-num="' + (activePage + 1) + '">' + this.config.nextButtonLabel + '</a>');
            }
            pageControls.find('a[data-page-num="' + activePage + '"]').addClass(this.config.activeClass);

            this.addEvents();
        };

        DTMasonryPaginationControls.prototype._filterByCurPage = function () {
            var self = this;
            this.config.items.get().map(function (item, index) {
                if (self._showOnCurPage(index + 1)) {
                    self.showItem($(item));
                } else {
                    self.hideItem($(item));
                }
            });
        };

        DTMasonryPaginationControls.prototype._showOnCurPage = function (index) {
            return this.config.postLimit <= 0 || ( this.config.postLimit * (this.getCurPage() - 1) < index && index <= this.config.postLimit * this.getCurPage() );
        };

        DTMasonryPaginationControls.prototype._setAsActive = function (item) {
            item.addClass('act').siblings().removeClass('act');
        };

        return DTMasonryPaginationControls;
    }());

    var DTMasonryLoadMoreControls = (function () {
        function DTMasonryLoadMoreControls(config) {
            DTMasonryControls.call(this, config);

            this.appendControls();
            this.addEvents();
            this.layoutItems();
            this.applyLoadingEffects();
        }

        DTMasonryLoadMoreControls.prototype = new DTMasonryControls();

        DTMasonryLoadMoreControls.prototype.addEvents = function () {
            $('a', this.config.paginatorContainer).on('click.dtPostsPaginationFilter', {self: this}, this.config.onPaginate);
        };

        DTMasonryLoadMoreControls.prototype.appendControls = function () {
            var pageControls = this.config.paginatorContainer;
            var maxPages = Math.ceil(this.config.items.length / this.config.postLimit);

            if (this.config.curPage < maxPages) {
                pageControls.removeClass("hidden");
            } else {
                pageControls.addClass("hidden");
            }
        };

        DTMasonryLoadMoreControls.prototype._filterByCurPage = function () {
            var self = this;
            var postsToShow = self.getCurPage() * self.config.postLimit;

            this.config.items.get().map(function (item, index) {
                if (index < postsToShow) {
                    self.showItem($(item));
                } else {
                    self.hideItem($(item));
                }
            });
        };

        return DTMasonryLoadMoreControls;
    }());

    var DTIsotopeFilter = (function () {
        function DTIsotopeFilter(config) {
            var defaults = {
                onCategoryFilter: function () {
                },
                onOrderFilter: function () {
                },
                onOrderByFilter: function () {
                },
                categoryContainer: null,
                orderContainer: null,
                orderByContainer: null,
                postsContainer: null,
                order: 'desc',
                orderBy: 'date',
                curCategory: '*'
            };
            this.config = $.extend(defaults, config);

            this.addEvents();
        }

        DTIsotopeFilter.prototype.addEvents = function () {
            var self = this;
            this.config.categoryContainer && $('a', this.config.categoryContainer).on('click.dtPostsCategoryFilter', {self: this}, function(event) {
                self.config.onCategoryFilter.call(this, event);
            });
            this.config.orderContainer && $('a', this.config.orderContainer).on('click.dtPostsOrderFilter', {self: this}, function(event) {
                self.config.onOrderFilter.call(this, event);
            });
            this.config.orderByContainer && $('a', this.config.orderByContainer).on('click.dtPostsOrderByFilter', {self: this}, function(event) {
                self.config.onOrderByFilter.call(this, event);
            });
        };

        DTIsotopeFilter.prototype.setOrder = function (order) {
            this.config.order = order;
        };

        DTIsotopeFilter.prototype.setOrderBy = function (orderBy) {
            this.config.orderBy = orderBy;
        };

        DTIsotopeFilter.prototype.setCurCategory = function (curCategory) {
            this.config.curCategory = curCategory;
        };

        DTIsotopeFilter.prototype.getFilteredItems = function () {
            return $(this.config.postsContainer.isotope('getFilteredItemElements'));
        };

        DTIsotopeFilter.prototype.getItems = function () {
            return $(this.config.postsContainer.isotope('getItemElements'));
        };

        DTIsotopeFilter.prototype.layoutItems = function () {
            this.layout();
            this.config.postsContainer.trigger("updateReady");
        };

        DTIsotopeFilter.prototype.layout = function () {
            this.config.postsContainer.isotope('layout');
        };

        DTIsotopeFilter.prototype.scrollToTopOfContainer = function (onComplite, bindTo) {
            var scrollTo = this.config.postsContainer.parent();
            var phantomStickyExists = $(".phantom-sticky").exists(),
                sideHeaderHStrokeExists = $(".sticky-top-line").exists();
                if(phantomStickyExists || sideHeaderHStrokeExists){
                    var $phantom = $(".masthead");
                }else{
                    var $phantom = $("#phantom");
                }
            $("html, body").animate({
                scrollTop: scrollTo.offset().top - $phantom.height() - 50
            }, 400, onComplite ? onComplite.bind(bindTo | this) : undefined);
        };

        DTIsotopeFilter.prototype._filterPosts = function () {
            this.config.postsContainer && this.config.postsContainer.isotope({
                filter: this.config.curCategory,
                sortAscending: 'asc' == this.config.order,
                sortBy: this.config.orderBy
            });
        };

        DTIsotopeFilter.prototype._setAsActive = function (item) {
            item.addClass('act').siblings().removeClass('act');
        };

        return DTIsotopeFilter;
    }());

    var DTJGridFilter = (function () {
        function DTJGridFilter(config) {
            DTIsotopeFilter.call(this, config);

            var defaults = {
                showOnCurPage: function() {}
            };
            this.config = $.extend(defaults, this.config);
            this.items = this.config.postsContainer.find('.wf-cell');
            this.filteredItems = this.items;
        }

        DTJGridFilter.prototype = new DTIsotopeFilter();

        DTJGridFilter.prototype.getFilteredItems = function () {
            return this.filteredItems;
        };

        DTJGridFilter.prototype.getItems = function () {
            return this.items;
        };

        DTJGridFilter.prototype.layout = function () {
            var self = this;

            // category filter emulation
            self.items.css("display", "none");
            var itemsCount = 0;
            var visibleItems = [];
            self.filteredItems.each(function() {
                if ( self.config.showOnCurPage( ++itemsCount ) ) {
                    $(this).css("display", "block");
                    visibleItems.push( this );
                }
            });

            visibleItems = $(visibleItems);
            self.config.postsContainer.data('visibleItems', visibleItems);
            self.config.postsContainer.collage({ images: visibleItems });
        };

        DTJGridFilter.prototype._filterPosts = function() {
            var self = this;
            self.filteredItems = self.items.filter(self.config.curCategory);
        };

        return DTJGridFilter;
    }());

    var DTJQueryFilter = (function() {
        function DTJQueryFilter(config) {
            DTIsotopeFilter.call(this, config);

            this.items = this.config.postsContainer.find('.wf-cell');
            this.filteredItems = this.items;
        }

        DTJQueryFilter.prototype = new DTIsotopeFilter();

        DTJQueryFilter.prototype.getFilteredItems = function () {
            return this.filteredItems;
        };

        DTJQueryFilter.prototype.getItems = function () {
            return this.items;
        };

        DTJQueryFilter.prototype.layout = function () {};

         DTJQueryFilter.prototype._filterPosts = function() {
             this.items.hide();
             this.filteredItems = this._sortItems(this.items.filter(this.config.curCategory));
             this.filteredItems.detach().prependTo(this.config.postsContainer);
             this.filteredItems.show();
        };

        DTJQueryFilter.prototype._sortItems = function(items) {
            var activeSort = this.config.orderBy;
            var activeOrder = this.config.order;
            var $nodes = $([]);
            $nodes.$nodesCache = $([]);

            items.each(function() {
                var $this = $(this);
                $nodes.push({
                    node: this,
                    $node: $this,
                    name: $this.attr("data-name"),
                    date: new Date($this.attr("data-date"))
                });
            });

            if (activeSort === "date" && activeOrder ==="desc") {
                $nodes.sort(function(a, b){return b.date - a.date});
            }
            else if (activeSort === "date" && activeOrder ==="asc") {
                $nodes.sort(function(a, b){return a.date - b.date});
            }
            else if (activeSort === "name" && activeOrder ==="desc") {
                $nodes.sort(function(a, b){
                    var x = a.name.toLowerCase();
                    var y = b.name.toLowerCase();
                    if (x > y) {return -1;}
                    if (x < y) {return 1;}
                    return 0;
                });
            }
            else if (activeSort === "name" && activeOrder ==="asc") {
                $nodes.sort(function(a, b){
                    var x = a.name.toLowerCase();
                    var y = b.name.toLowerCase();
                    if (x < y) {return -1;}
                    if (x > y) {return 1;}
                    return 0;
                });
            }

            $nodes.each(function() {
                $nodes.$nodesCache.push(this.node);
            });

            return $nodes.$nodesCache;
        };

        return DTJQueryFilter;
    }());

    $('.dt-shortcode.with-isotope').each(function () {
        var $this = $(this);
        var $container = $this.find('.iso-grid, .iso-container');
        var isIsotopeContainer = $container.hasClass('dt-isotope');
        var filterConfig = {
            postsContainer: $container,
            categoryContainer: $this.find('.filter-categories'),
            curCategory: $this.find('.filter-categories a.act').attr('data-filter'),
        };

        if (isIsotopeContainer) {
            var order = $this.find('.filter-extras .filter-sorting a.act').attr('data-sort');
            if (!order) {
                order = $this.find('.filter-categories').attr('data-default-order');
            }

            var orderBy = $this.find('.filter-extras .filter-by a.act').attr('data-by');
            if (!orderBy) {
                orderBy = $this.find('.filter-categories').attr('data-default-orderby');
            }

            // Masonry short code.
            $.extend(filterConfig, {
                order: order,
                orderBy: orderBy,
                orderByContainer: $this.find('.filter-extras .filter-by'),
                orderContainer: $this.find('.filter-extras .filter-sorting'),
                onCategoryFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setCurCategory(item.attr('data-filter'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                },
                onOrderFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setOrder(item.attr('data-sort'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                },
                onOrderByFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setOrderBy(item.attr('data-by'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                }
            });
            var isoFilter = new DTIsotopeFilter(filterConfig);
            var paginator = new DTMasonryPaginationControls({
                previousButtonClass: 'nav-prev',
                previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
                nextButtonClass: 'nav-next',
                nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
                postLimit: $container.attr('data-posts-per-page'),
                curPage: 1,
                pagesToShow: ($container.hasClass('show-all-pages') ? 999 : 5),
                items: isoFilter.getFilteredItems(),
                paginatorContainer: $this.find('.paginator'),
                onPaginate: function (event, onSetup) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self._setAsActive(item);
                    self.setCurPage(item.attr('data-page-num'));
                    self._filterByCurPage();
                    isoFilter.layout();

                    if (!onSetup) {
                        self.appendControls();
                        isoFilter.scrollToTopOfContainer();
                    }
                }
            });
        } else {
            // JGrid short code.
            var isoFilter = new DTJGridFilter(filterConfig);
            var paginator = new DTMasonryPaginationControls({
                previousButtonClass: 'nav-prev',
                previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
                nextButtonClass: 'nav-next',
                nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
                postLimit: $container.attr('data-posts-per-page'),
                curPage: 1,
                pagesToShow: ($container.hasClass('show-all-pages') ? 999 : 5),
                items: isoFilter.getFilteredItems(),
                paginatorContainer: $this.find('.paginator'),
            });
            isoFilter.config.onCategoryFilter = function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setCurCategory(item.attr('data-filter'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layout();
                lazyLoading();
                loadingEffects();
            };
            isoFilter.config.showOnCurPage = function (index) {
                return paginator._showOnCurPage(index);
            };
            paginator.config.onPaginate = function (event, onSetup) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self._setAsActive(item);
                self.setCurPage(item.attr('data-page-num'));
                self._filterByCurPage();
                isoFilter.layout();

                if (!onSetup) {
                    self.appendControls();
                    isoFilter.scrollToTopOfContainer();
                }
            };

            // Trigger pagination after setup once again after providing proper callback.
            $('a.act', paginator.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
        }
    });

    window.the7ApplyMasonryJsFiltering = function($element) {
        var $container = $element.find('.iso-grid, .iso-container');
        var $paginator = $element.find(".paginator");
        var isLazyLoading = $element.hasClass("lazy-loading-mode");

        var order = $element.find('.filter-extras .filter-sorting a.act').attr('data-sort');
        if (!order) {
            order = $element.find('.filter-categories').attr('data-default-order');
        }

        var orderBy = $element.find('.filter-extras .filter-by a.act').attr('data-by');
        if (!orderBy) {
            orderBy = $element.find('.filter-categories').attr('data-default-orderby');
        }

        if ($element.is(".content-rollover-layout-list:not(.disable-layout-hover)")) {
            $container.on("updateReady", function() {
                $(this).find(".wf-cell.visible .post-entry-wrapper").clickOverlayGradient();
            });
        }

        var filterConfig = {
            order: order,
            orderBy: orderBy,
            curCategory: $element.find('.filter-categories a.act').attr('data-filter'),
            postsContainer: $container,
            categoryContainer: $element.find('.filter-categories'),
            orderByContainer: $element.find('.filter-extras .filter-by'),
            orderContainer: $element.find('.filter-extras .filter-sorting'),
            onCategoryFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setCurCategory(item.attr('data-filter'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            },
            onOrderFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setOrder(item.attr('data-sort'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            },
            onOrderByFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setOrderBy(item.attr('data-by'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            }
        };

        var isoFilter = new DTIsotopeFilter(filterConfig);

        switch ($element.attr('data-pagination-mode')) {
            case 'load-more':
                var paginator = new DTMasonryLoadMoreControls({
                    postLimit: $element.attr("data-post-limit"),
                    curPage: 1,
                    items: isoFilter.getFilteredItems(),
                    filter: isoFilter,
                    paginatorContainer: $paginator,
                    onPaginate: function (event) {
                        var self = event.data.self;

                        event.preventDefault();
                        self.setCurPage(self.getCurPage() + 1);
                        self.layoutItems();
                        self.applyLoadingEffects();
                        self.appendControls();
                    }
                });
                break;
            case 'pages':
                var previousButtonLabel = "<i class=\"dt-icon-the7-arrow-0-42\" aria-hidden=\"true\"></i>";
                var nextButtonLabel = "<i class=\"dt-icon-the7-arrow-0-41\" aria-hidden=\"true\"></i>";
                var pagerClass = "page";

                // It's ugly but simple enough.
                if ($element.is("[class*='the7_elements-']")) {
                    previousButtonLabel = "<i class=\"dt-icon-the7-arrow-35-1\" aria-hidden=\"true\"></i>";
                    nextButtonLabel = "<i class=\"dt-icon-the7-arrow-35-2\" aria-hidden=\"true\"></i>";
                    pagerClass = "page-numbers filter-item";
                }

                var paginator = new DTMasonryPaginationControls({
                    previousButtonClass: 'nav-prev',
                    previousButtonLabel: previousButtonLabel,
                    nextButtonClass: 'nav-next',
                    nextButtonLabel: nextButtonLabel,
                    pagerClass: pagerClass,
                    postLimit: $element.attr('data-post-limit'),
                    curPage: 1,
                    pagesToShow: ($element.hasClass('show-all-pages') ? 999 : 5),
                    items: isoFilter.getFilteredItems(),
                    filter: isoFilter,
                    paginatorContainer: $paginator,
                    onPaginate: function (event, onSetup) {
                        var item = $(this);
                        var self = event.data.self;

                        event.preventDefault();
                        self._setAsActive(item);
                        self.setCurPage(item.attr('data-page-num'));
                        self.layoutItems();

                        if (!onSetup) {
                            self.appendControls();
                            isoFilter.scrollToTopOfContainer();
                        }

                        self.applyLoadingEffects();
                    }
                });
                break;
            default:
                // Dummy pagination.
                var paginator = new DTMasonryControls();
        }

        function lazyLoading() {
            var $button = $paginator.find(".button-load-more");
            var buttonOffset = $button.offset();

            if ( $paginator.hasClass("hidden") ) {
                removeLazyLoadingPagination();
            }

            if (buttonOffset && $window.scrollTop() > (buttonOffset.top - $window.height()) / 2) {
                $button.trigger("click");
            }
        }

        function removeLazyLoadingPagination() {
            $window.off("scroll", lazyLoading);
        }

        function applyLazyLoadingPagination() {
            if (isLazyLoading) {
                removeLazyLoadingPagination();
                $window.on("scroll", lazyLoading);
                lazyLoading();
            }
        }

        applyLazyLoadingPagination();
    };

    $('.mode-masonry.jquery-filter, .mode-grid.jquery-filter:not(.dt-css-grid-wrap)').one("IsoReady", function() {
        the7ApplyMasonryJsFiltering($(this));
    });

    if(typeof owlCarouselOrigin != 'undefined'){
        $.fn.owlCarousel = owlCarouselOrigin;
    }
