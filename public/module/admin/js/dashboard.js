/**
 * Created by linxin on 2017/8/4.
 */
var host = window.location.host;
// 设置 ajax 请求地址前缀
switch(host){
    case 'stip.omwteam.com':
        host = 'http://stip.omwteam.com';
        break;
    case '172.28.2.228':
        host = 'http://172.28.2.228/stip/public';
        break;
    case '127.0.0.1:8000':
        host = 'http://127.0.0.1:8000';
        break;
}

var main = {
    init: function () {
        main.initPie();
        main.initBar();
        main.initCount();
    },
    initPie: function(){
        $.get(host + '/static/getNotesClass', function(res){
            var title = [], value = [];
            for(var i = 0; i < res.data.length; i++){
                title.push(res.data[i].title);
                value.push({value: res.data[i].value, name: res.data[i].title});
            }
            // 基于准备好的dom，初始化echarts实例
            var myChart1 = echarts.init($('#noteDistribution')[0]);

            // 指定图表的配置项和数据
            var option1 = {
                title: {
                    text: '笔记分布情况',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: title
                },
                series: [
                    {
                        name: '笔记分布',
                        type: 'pie',
                        radius: '65%',
                        center: ['50%', '60%'],
                        data: value,
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
            myChart1.setOption(option1);
        })
    },
    initBar: function () {
        var myChart2 = echarts.init($('#noteTopList')[0]);
        var option2 = {
            title: {
                text: '笔记排行榜前七',
                x: 'center'
            },
            color: ['#3398DB'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : ['vue', 'react', 'angular', 'html5', 'css', 'jquery', 'zepto'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'笔记数量',
                    type:'bar',
                    barWidth: '60%',
                    data:[71, 60, 50, 40, 30, 20, 10]
                }
            ]
        };
        myChart2.setOption(option2);
    },
    initCount: function () {
        $.get(host+ '/static/getNumCount', function (res) {
            var $userTotal = $('#userTotal'),
                $notesTotal = $('#notesTotal'),
                $recycleCount = $('#recycleCount'),
                data = res.data;
            $userTotal.animateNumber({
                number: data.userTotal,
                numberStep: function(now) {
                    $userTotal.text(Math.floor(now));
                }
            }, 1000);
            $notesTotal.animateNumber({
                number: data.notesTotal,
                numberStep: function(now) {
                    $notesTotal.text(Math.floor(now));
                }
            }, 1000);
            $recycleCount.animateNumber({
                number: data.recycleCount,
                numberStep: function(now) {
                    $recycleCount.text(Math.floor(now));
                }
            }, 1000);
            // $notesTotal.text(data.notesTotal);
            // $recycleCount.text(data.recycleCount);

        })
    }
};
main.init();