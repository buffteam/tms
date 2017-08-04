@extends('layouts.admin')
@section('content')
    <div class="mdui-bread-crumb ">
        面包屑

    </div>
    <div class="mdui-divider" style="margin-bottom: 15px;"></div>

    <div class="mdui-row">
        <div id="noteDistribution" style="width: 600px;height:400px;"></div>
       {{-- <div class="mdui-col-md-4 mdui-center">
            <div id="noteDistribution" style="width: 600px;height:400px;"></div>
        </div>
        <div class="mdui-col-md-4 mdui-center">
            <img class="mdui-img-circle" src="{{asset('uploads/763154ba13b42043a06ba60981ca7d19.png')}}"/>
        </div>
        <div class="mdui-col-md-4 mdui-center">
            <img class="mdui-img-circle" src="{{asset('uploads/763154ba13b42043a06ba60981ca7d19.png')}}"/>
        </div>--}}
    </div>

@endsection

@section('script')
    <script src="{{asset('/libs/eChart/echarts.simple.min.js')}}"></script>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('noteDistribution'));

        // 指定图表的配置项和数据
//        var option = {
//            title : {
//                text: '笔记分布',
//                subtext: '纯属虚构',
//                x:'center'
//            },
//            tooltip : {
//                trigger: 'item',
//                formatter: "{a} <br/>{b} : {c} ({d}%)"
//            },
//            legend: {
//                orient: 'vertical',
//                left: 'left',
//                data: ['安卓端','IOS端','4G手表','C++/C语言','效率工具','产品设计']
//            },
//            series : [
//                {
//                    name: '笔记分布',
//                    type: 'pie',
//                    radius : '65%',
//                    center: ['50%', '60%'],
//                    data:[
//                        {value:1, name:'安卓端'},
//                        {value:2, name:'IOS端'},
//                        {value:3, name:'2G手表'},
//                        {value:4, name:'4G手表'},
//                        {value:5, name:'C++/C语言'},
//                        {value:6, name:'效率工具'},
//                        {value:7, name:'产品设计'}
//                    ],
//                    itemStyle: {
//                        emphasis: {
//                            shadowBlur: 10,
//                            shadowOffsetX: 0,
//                            shadowColor: 'rgba(0, 0, 0, 0.5)'
//                        }
//                    }
//                }
//            ]
//        };
        var option = {
            title : {
                text: '笔记分布',
                subtext: '各端笔记笔记数量分布',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: ['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        {value:335, name:'直接访问'},
                        {value:310, name:'邮件营销'},
                        {value:234, name:'联盟广告'},
                        {value:135, name:'视频广告'},
                        {value:1548, name:'搜索引擎'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@endsection