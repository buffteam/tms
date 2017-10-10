<div class="pagination-container">

    @if ($paginator->hasPages())
        <div class="pagination">
            <ul class="">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled"><span>上一页</span></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="prev"></a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a class="page mdui-color-theme">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}" class="page">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="next"></a></li>
                @else
                    <li class="disabled"><span>下一页</span></li>
                @endif
            </ul>
        </div>
        <input type="hidden" id="currentPage" value="{{$paginator->currentPage()}}">
    @endif
</div>
<script>
    /**
     * Created by freddy on 2017/09/14.
     */
//    var $$ = mdui.JQ;
    /**
     * 获取URL参数
     * @param name
     * @returns {*}
     */
    var getUrlParam = function (name) {
        var list = location.search.slice(1).split("&");
        var i = 0,
            l = list.length;
        if (name) {
            for (i; i < l; i++) {
                var sign1 = list[i].indexOf('=');
                if (list[i].slice(0, sign1) === name) {
                    console.timeEnd('selfSearch');
                    return decodeURIComponent(list[i].slice(sign1 + 1));
                }
            }
        }

    };
    /**
     * 获取所有查询参数
     */
    var getAllParam = function () {

        var list = location.search === "" ? [] : location.search.slice(1).split("&");
        var i = 0,
            l = list.length;
        if (l === 0) {
            return null;
        }
        var obj = {};
        for (i; i < l; i++) {
            var sign2 = list[i].indexOf('=');
            obj[list[i].slice(0, sign2)] = decodeURIComponent(list[i].slice(sign2 + 1));
        }
        return obj;
    };
    /**
     * 设置URL参数值
     * @param name
     * @param value
     * @returns {string}
     */
    var setUrlParam = function (name, value) {

        var locHref = location.href,
            url = locHref.indexOf('?') === -1 ? locHref : locHref.slice(0, locHref.search(/\?/)), //去掉查询字符串后的URL
            params = getAllParam();//查询字符串

        // 如果查询字符为空则直接在后面加上name和value
        if (params === null) {
            return url + '?' + name + '=' + value;
        }
        var flag = false,
            tmp = '?',
            first = true;
        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                if (key === name) {
                    params[key] = value;
                    flag = true;
                }
                if (first) {
                    tmp = tmp + key + '=' + params[key];
                    first = false;
                } else {
                    tmp = tmp + '&' + key + '=' + params[key];
                }


            }
        }
        // 如果需要设置的参数名称不存在URL中
        if (!flag) {
            tmp = tmp + '&' + name + '=' + value;
        }
        return url + tmp;

    };

    // 页码跳转
//    var $pagination = $$('.pagination'),
//        currentPage = $$('#currentPage').val();
//    $pagination.on('click', '.page', function (e) {
//        e.preventDefault();
//        var $this = $$(this),
//            value = $this.html();
//        location.href = setUrlParam('page', value);
//    });

    // 上一页
//    $pagination.on('click', '.prev', function (e) {
//        e.preventDefault();
//        location.href = setUrlParam('page', Number(currentPage) - 1);
//    });
//    // 下一页
//    $pagination.on('click', '.next', function (e) {
//        e.preventDefault();
//        location.href = setUrlParam('page', Number(currentPage) + 1);
//    })

</script>
