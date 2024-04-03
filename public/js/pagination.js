(function ($) {
    $.fn.pagination = function (options) {
        const $owner = this;

        const defaultSettings = {
            page: 1,
            count: 1,
            maxVisible: null,
            href: "javascript:void({{number}});",
            hrefVariable: "{{number}}",
            previous: "&laquo;",
            next: "&raquo;",
            paginationClass: "pagination",
            pageLinkClass: "page-link",
        }

        settings = $.extend({}, defaultSettings, options);

        if (settings.count <= 0) return this;
        if (settings.page < 1) settings.page = 1;
        if (!settings.maxVisible || isNaN(settings.maxVisible)) settings.maxVisible = settings.count;
        if (settings.maxVisible < 1 || settings.maxVisible > settings.count) settings.maxVisible = settings.count;

        this.setCount = function (count) {
            settings.count = count;
            settings.maxVisible = null;
            $owner.pagination(settings);
        }

        this.changePage = function () {
            $owner.trigger("changePage", [settings.page]);
        }

        function href(page) {
            return settings.href.replace(settings.hrefVariable, page);
        }

        return this.each(function () {
            const $container = $(this);
            let start = settings.page - Math.floor(settings.maxVisible / 2);
            start = Math.max(start, 1);
            start = Math.min(start, 1 + settings.count - settings.maxVisible);
            const end = Math.min(start + settings.maxVisible - 1, settings.count);

            $container.empty();
            $container.append('<ul class="' + settings.paginationClass + '"></ul>');
            const $pagination = $container.find("." + settings.paginationClass);

            if (settings.maxVisible < settings.count) {
                $pagination.append('<li class="previous-page button-back">' + settings.previous + '</li>');
            }

            for (let i = start; i <= end; i++) {
                const pageClass = i === settings.page ? settings.pageLinkClass + " " + "page-number-selected" : "page-number";
                $pagination.append('<li class="' + settings.pageLinkClass + '"><a class="' + pageClass + '" href="' + href(i) + '">' + i + '</a></li>');
            }

            if (settings.maxVisible < settings.count) {
                $pagination.append('<li class="next-page button-next">' + settings.next + '</li>');
            }

            $pagination.find("." + settings.pageLinkClass).not(".previous-page, .next-page").click(function (e) {
                e.preventDefault();
                settings.page = parseInt($(this).text(), 10);
                $owner.pagination(settings);
                $owner.changePage();
            });

            $pagination.find(".previous-page").click(function (e) {
                e.preventDefault();
                if (settings.page > 1) {
                    settings.page--;
                    $owner.pagination(settings);
                    $owner.changePage();
                }
            });

            $pagination.find(".next-page").click(function (e) {
                e.preventDefault();
                if (settings.page < settings.count) {
                    settings.page++;
                    $owner.pagination(settings);
                    $owner.changePage();
                }
            });
        });
    }
})
(jQuery);