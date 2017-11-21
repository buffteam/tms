<script id="share-dialog" type="text/html">
    <div class="share-dialog-content">
        <div class="share-text">获取分享链接成功，复制链接进行分享!</div>
        <div class="share-input">
            <input type="text" id="share_url" value="<%= value %>">
            <span class="share-btn" data-clipboard-target="#share_url">复制链接</span>
        </div>
        <div class="share-handle">
            <a href="<%= value %>" target="_blank">查看分享</a>
            <a href="javascript:;" class="cancel-share">取消分享</a>
        </div>
    </div>
</script>
<script id="folder-tpl" type="text/html">
    <div id="move-content">
        <p>移动到：</p>
        <div class="folder-box">
        <% for(var j = 0; j < group.length; j++) { %>
            <div class="folder-group-list folder-parent-list">
                <span class="folder-group-open"></span>
                <span class="folder-group-icon"></span>
                <span><%= group[j].name %></span>
            </div>
            <ul>
                <% for(var i = 0, list = renderNav(group[j].folders); i < list.length; i++) { %>
                <li class="folder-group-child">
                    <% if(list[i].child) {%>
                        <div class="folder-child-list folder-parent-list" 
                            data-type="<%= group[j].type %>" data-fid="<%= list[i].id %>">
                            <span class="folder-group-open"></span>
                            <span class="folder-group-icon"></span>
                            <span><%= list[i].title %></span>
                        </div>
                        <ul style="display:none">
                            <% include('folder-child-tpl', {list: list[i].child, type: group[j].type})  %>
                        </ul>
                    <% } else { %>
                        <div class="folder-child-list folder-parent-list"
                            data-type="<%= group[j].type %>" data-fid="<%= list[i].id %>">
                            <span class="folder-group-icon"></span>
                            <span><%= list[i].title %></span>
                        </div>
                    <% } %>
                </li>
                <% } %>
            </ul>
        <% } %>
        </div>
    </div>
</script>
<script id="folder-child-tpl" type="text/html">
    <% for(var i = 0; i < list.length; i++) { %>
        <li class="folder-group-child">
            <% if(list[i].child) {%>
                <div class="folder-child-list folder-parent-list" data-type="<%= type %>" data-fid="<%= list[i].id %>">
                    <span class="folder-group-open"></span>
                    <span class="folder-group-icon"></span>
                    <span><%= list[i].title %></span>
                </div>
                <ul style="display:none">
                    <% include('folder-child-tpl', {list:list[i].child, type: type})  %>
                </ul>
            <% } else { %>
                <div class="folder-child-list folder-parent-list" data-type="<%= type %>" data-fid="<%= list[i].id %>">
                    <span class="folder-group-icon"></span>
                    <span><%= list[i].title %></span>
                </div>
            <% } %>
        </li>
    <% } %>
</script>
<script id="pdf-tpl" type="text/html">
    <html><head><meta charset="utf-8">
        <style>.markdown-body pre{background-color:#f7f7f7;}</style>
        </head><body><div class="markdown-body">##content##</div></body>
    </html>
</script>
<script id="folder-list-tpl" type="text/html">
    <% for(var i = 0; i < list.length; i++) { %>
        <li class="folder-item" data-id="<%= list[i].id %>">
            <p class="folder-title"><span class="icon-folder"></span><%= list[i].title %></p>
            <p class="folder-time"><%= list[i].updated_at %></p>
        </li>
    <% } %>
</script>
<script id="list-tpl" type="text/html">
    <% for(var i = 0; i < list.length; i++) { %>
    <li class="doc-item <% if(list[i].id === active) {%> active <% } %>" data-id="<%= list[i].id %>" data-fid="<%= list[i].f_id %>">
        <p class="doc-title">
            <% if(list[i].type === '1') {%><span class="icon-md"></span>
            <% }else{ %><span class="icon-note"></span>
            <% } %>
            <span class="list-title-text"><%= list[i].title %></span>
        </p>
        <p class="doc-author">
            <span>创建人：<%= list[i].author %></span>
            <% if(list[i].last_updated_name) {%>
            <span>最后修改人：<%= list[i].last_updated_name %></span>
            <% } %>
        </p>
        <p class="doc-time">
            <span><%= list[i].updated_at %></span>
        </p>
    </li>
    <% } %>
</script>
<script id="recycle-tpl" type="text/html">
    <% for(var i = 0; i < list.length; i++) { %>
    <li class="doc-item" data-id="<%= list[i].id %>" data-fid="<%= list[i].f_id %>">
        <p class="doc-title">
            <% if(list[i].type === '1') {%><span class="icon-md"></span>
            <% }else{ %><span class="icon-note"></span>
            <% } %>
            <span class="list-title-text"><%= list[i].title %></span>
        </p>
        <p class="doc-author">
            <span>创建人：<%= list[i].author %></span>
            <% if(list[i].last_updated_name) {%>
            <span>删除人：<%= list[i].last_updated_name %></span>
            <% } %>
        </p>
        <p class="doc-time">
            <span>删除时间：<%= list[i].updated_at %></span>
        </p>
    </li>
    <% } %>
</script>
<script id="add-input-tpl" type="text/html">
    <li class="child-item">
        <div class="second-menu-a" data-id="" data-pid="">
            <span class="child-menu-open"></span>
            <span class="child-menu-icon"></span>
            <span class="item-name"><input type="text"></span>
            <span class="item-count">(0)</span>
            <span class="child-menu-down" data-idx="##idx##" data-type="##type##" data-gid="##gid##"></span>
        </div>
    </li>
</script>

<script id="group-tpl" type="text/html">
    <% for(var j = 0; j < group.length; j++) { %>
        <li class="pure-menu-item nav-doc-item group-<%= j %>">
            <div class="nav-doc-a first-menu-a is-parent" data-switch="on">
                <span><%= group[j].name %></span>
            </div>
            <ul class="child-list first-child-list">
                <% idx = 1; for(var i = 0, list = renderNav(group[j].folders); i < list.length; i++) { %>
                    <li class="child-item">
                    <% if(list[i].child) {%> 
                        <div class="second-menu-a is-parent" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>" data-switch="off">
                    <% }else{ %>
                        <div class="second-menu-a" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>">
                    <% } %>
                            <span class="child-menu-open"></span>
                            <span class="child-menu-icon"></span>
                            <span class="item-name"><%= list[i].title %></span>
                            <span class="item-count g_<%= list[i].id %>">(<%= list[i].currentCount %><% if(list[i].hasOwnProperty('totalCount')) {%>/<%= list[i].totalCount %><% } %>)</span>
                            <span class="child-menu-down" data-idx="<%= idx %>" data-type="<%= group[j].type %>" data-gid="<%= group[j].id %>"></span>
                        </div>

                        <% if(list[i].child) {%>
                            <ul class="child-list">
                            <% include('nav-tpl', {list:list[i].child, idx: idx, type: group[j].type, gid: group[j].id})  %>
                            </ul>
                        <% } %>
                    </li>
                <% } %>
                <li class="child-item child-item-input">
                    <input type="text" name="add_dir<%= group[j].id %>" data-type="<%= group[j].type %>" data-gid="<%= group[j].id %>">
                </li>
                <li class="child-item add-dir">
                    <span>+</span>新建文件夹
                </li>
            </ul>
            
        </li>
    <% } %>
</script>

<script id="nav-tpl" type="text/html">
    <% idx++; for(var i = 0; i < list.length; i++) { %>
        <li class="child-item">
        <% if(list[i].child) {%> 
            <div class="second-menu-a is-parent" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>" data-switch="off">
        <% }else{ %>
            <div class="second-menu-a" data-id="<%= list[i].id %>" data-pid="<%= list[i].p_id %>">
        <% } %>
                <span class="child-menu-open"></span>
                <span class="child-menu-icon"></span>
                <span class="item-name"><%= list[i].title %></span>
                <span class="item-count g_<%= list[i].id %>">(<%= list[i].currentCount %><% if(list[i].hasOwnProperty('totalCount')) {%>/<%= list[i].totalCount %><% } %>)</span>
                <span class="child-menu-down" data-idx="<%= idx %>" data-type="<%= type %>" data-gid="<%= gid %>"></span>
            </div>

            <% if(list[i].child) {%>
                <ul class="child-list">
                <% include('nav-tpl', {list:list[i].child, idx: idx, type: type, gid: gid})  %>
                </ul>
            <% } %>
        </li>
    <% } %>
</script>

<script id="upload-tpl" type="text/html">
    <div id="uploader" class="wu-example">
        <!--用来存放文件信息-->
        <div id="thelist" class="uploader-list"></div>
        <div class="wu-example-btns">
            <div id="picker">选择文件</div>
            <button id="ctlBtn">开始上传</button>
        </div>
    </div>
</script>

<script id="attachment-tpl" type="text/html">
    <% for(var i = 0; i < list.length; i++) { %>
        <li>
            <a href="<%= list[i].url %>" download="<%= list[i].name %>"><%= list[i].name %></a>
            <span class="del-span" data-id="<%= list[i].id %>" title="删除不可恢复">删除</span>
        </li>
    <% } %>
</script>