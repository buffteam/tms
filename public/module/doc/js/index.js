/**
 * Created by linxin on 2017/8/14.
 */
// 自动保存时间
var AUTO_TIME = 30 * 1000,
    NEW_TITLE = '新建笔记';
var host = window.location.host,
    g_id = null,                // 定义一个全局id 用来存储当前操作目录的id
    $g_folder = null,
    niceScroll = null,
    mdeditor = null,            // md 编辑器
    wangeditor = null,          // wangeditor 编辑器
    timeId = null,
    cur_note = null,
    local_note = null,
    sort_type = localStorage.getItem('sort_type') || 'updated_at',  // 排序类型
    sort_order = localStorage.getItem('sort_order') || 'desc',      // 排序方式
    isCtrlS = false,            // 是否按了Ctrl-S
    cur_page = 1,               // 当前笔记列表的页码
    totalPage = null,           // 笔记列表总页码
    isSearch = false,           // 是否为搜索结果列表
    isNewest = false,           // 是否为最新笔记列表
    isRecycle = false,          // 是否为回收站列表
    isShare = false,            // 是否为分享列表
    isLoading = false;          // 是否正在加载列表

if (host == '172.28.2.228') {
    host = 'http://172.28.2.228/stip/public';
} else {
    host = 'http://' + host
}

seajs.config({
    base: "./",
    alias: {
        jquery: host + "/libs/jquery/jquery.min",
        editormd: host + "/libs/editormd/editormd",
        wangEditor: host + "/libs/wangEditor-3.0.3/wangEditor.min",
        template: host + "/libs/template/template-native",
        clipboard: host + "/libs/clipboard/clipboard.min",
        nicescroll: host + "/libs/nicescroll/jquery.nicescroll.min",
        webuploader: host + "/libs/webuploader-0.1.5/webuploader.min",
        smartMenu: host + "/libs/jquery-smartMenu/js/jquery-smartMenu"
    }
});
var deps = [
    host + "/module/doc/js/main",
    "clipboard"
];

seajs.use(deps, function (main) {
    main.init();
});