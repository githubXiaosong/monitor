@extends('layouts.stream')

@section('content-right')

    @if (session('err_msg'))
        <div class="alert alert-danger">
            {{ session('err_msg') }}
        </div>
    @endif

    @if (session('suc_msg'))
        <div class="alert alert-success">
            {{ session('suc_msg') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="pull-left">
                <strong>视频流修改</strong>&nbsp;&nbsp;
                <button type="button" class="btn btn-default btn-xs btn_refresh">
                    <span class="glyphicon  glyphicon-refresh" aria-hidden="true"></span>
                </button>
            </div>

            <div class="pull-right">

                @if($stream->status == STREAM_STATUS_PRE_COLLECTION)
                    <span class="label label-default">刚刚添加</span>
                @elseif($stream->status == STREAM_STATUS_COLLECTION)
                    <span class="label label-primary">收集图片中</span>
                @elseif($stream->status == STREAM_STATUS_COLLECTION_TO_MANUAL)
                    <span class="label label-success">收集图片完成</span>
                @elseif($stream->status == STREAM_STATUS_MANUAL)
                    <span class="label label-primary">等待上传模型</span>
                @elseif($stream->status == STREAM_STATUS_MANUAL_TO_ONLINE)
                    <span class="label label-success">等待上线</span>
                @elseif($stream->status == STREAM_STATUS_ONLINE)
                    <span class="label label-primary">线上运行中</span>
                @elseif($stream->status == STREAM_STATUS_ONLINE_VALIDATE)
                    <span class="label label-primary">线上验证中</span>
                @elseif($stream->status == STREAM_STATUS_ONLINE_TO_FIX)
                    <span class="label label-warning">线上验证待处理</span>
                @elseif($stream->status == STREAM_STATUS_ONLINE_FIX)
                    <span class="label label-primary">线上验证处理中</span>
                @elseif($stream->status == STREAM_STATUS_ERROR_OTHER)
                    <span class="label label-warning">其他错误</span>
                @elseif($stream->status == STREAM_STATUS_ERROR_IN_COLLECTION_IMG_NUM_NO_UP)
                    <span class="label label-warning">收集图片增长出错</span>
                @elseif($stream->status == STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR)
                    <span class="label label-warning">收集线程执行出错</span>
                @elseif($stream->status == STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR)
                    <span class="label label-warning">线上出错</span>
                @endif

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <form id="insert-stream-form" class="form-horizontal" method="post" action="{{ url('api/changeStream') }}">

                {{ csrf_field() }}
                {{--<input name="stream_id" value="{{ $stream->id }}" hidden>--}}


                <div class="form-group">
                    <label for="inputID" class="col-sm-2 control-label">ID</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $stream->id }}" name="stream_id"
                                   id="inputID" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputUrl" class="col-sm-2 control-label">Url</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon">RTMP://</span>
                            <input type="text" class="form-control" value="{{ $stream->url }}" name="inputurl"
                                   id="inputUrl"
                                   placeholder="请填写RTMP地址" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label for="inputStartTime" class="col-sm-2 control-label">采集时间</label>

                    <div class="col-sm-10">
                        <input type="datetime" class="form-control input-time"
                               value="{{ $stream->start.' - '.$stream->end }}" name="inputtime" id="inputTime"
                               placeholder="点击选择时间范围" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputGlobalInterval" class="col-sm-2 control-label">采集全局间隔</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <select name="collect_global_interval_id"
                                    class="form-control" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                                @foreach($intervals as $interval)
                                    <option value="{{ $interval->id }}" {{ ($stream->collect_global_interval_id==$interval->id)?'selected':''  }}>{{ $interval->time }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-addon">秒</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputAcc" class="col-sm-2 control-label">准确率</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" value="{{ $stream->acc_expected }}"
                                   onkeyup="this.value=this.value.replace(/\D/g,'')"
                                   onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength=2
                                   class="form-control" name="acc_expected" id="acc"
                                   placeholder="期望准确率" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Server" class="col-sm-2 control-label">截图主机</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <select name="collect_global_interval_id"
                                    class="form-control" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                                @foreach($servers as $server)
                                    <option value="{{ $server->id }}" {{ ($stream->server_id==$server->id)?'selected':''  }}>{{ $server->ip }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCurrentInterval" class="col-sm-2 control-label">当前采集间隔</label>

                 <div class="col-sm-10">
                        <label for="inputCurrentInterval"
                               class=" control-label">{{ $stream->collect_current_interval? $stream->collect_current_interval->time.'秒':'暂无' }}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCurrentInterval" class="col-sm-2 control-label">当前图片数量</label>

                    <div class="col-sm-10">
                        <label for="inputCurrentInterval" class=" control-label">{{ $stream->image_num_current}}
                            张</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputretry_num" class="col-sm-2 control-label">retry_num</label>

                    <div class="col-sm-10">
                        <label for="inputCurrentInterval" class=" control-label">{{ $stream->retry_num}}次</label>
                        @if(($stream->status==STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR) && ($stream->end_timestamp>time()))
                            &nbsp;&nbsp;
                            <button type="button" id="btn_repeat" class="btn btn-success btn-xs">
                                <span class="glyphicon  glyphicon-repeat" aria-hidden="true"></span>
                            </button>
                        @endif
                    </div>
                </div>


                @if( in_array($stream->status,[STREAM_STATUS_ONLINE,STREAM_STATUS_ONLINE_VALIDATE,STREAM_STATUS_ONLINE_TO_FIX,STREAM_STATUS_ONLINE_FIX ]))
                <div class="form-group">
                    <label class="col-sm-2 control-label">验证周期</label>

                    <div class="col-sm-10">
                        <label  class=" control-label">{{ $stream->validate_cycle->days }} 天</label>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">验证周期</label>

                    <div class="col-sm-10">
                        <label  class=" control-label">{{ $stream->online_interval->time }} 秒</label>

                    </div>
                </div>

                @endif

                <div class="form-group">
                    <div class="pull-right mar-right-three">
                        <button id="btn-change-stream" type="button"
                                class="btn btn-default" {{ ($stream->status==STREAM_STATUS_PRE_COLLECTION)?'':'disabled'}} >
                            修改
                        </button>

                        <button id="btn-manual-stream" type="button"
                                class="btn btn-default" {{ ($stream->status==STREAM_STATUS_COLLECTION_TO_MANUAL)?'':'disabled'}}>
                            处理
                        </button>

                        <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#modal-lg-online" {{ (in_array($stream->status,[STREAM_STATUS_MANUAL_TO_ONLINE,STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR]))?'':'disabled'}}>
                            上线
                        </button>

                        <button id="btn-offline-stream" type="button"
                                class="btn btn-default" {{ ($stream->status==STREAM_STATUS_ONLINE)?'':'disabled'}}>
                            下线
                        </button>


                    </div>
                </div>


            </form>
        </div>
    </div>

    {{--@if(in_array($stream->status,[]))--}}

    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="pull-left"><strong>添加策略</strong></div>

            <div class="pull-right">
                预计 <kbd id="kdb_image_num"></kbd> 张
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">

            {{ csrf_field() }}

            <div id="policy" style="width: 100%;height:400px; margin-bottom: 25px"></div>

            <div class="progress">
                {{ round(((($stream->end_timestamp - time()) / ($stream->end_timestamp - $stream->strat_timestamp)) * 100)) }}
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 45%">

                </div>
            </div>

            <form id="form_add_policy" method="post" action="{{ url('api/addInterval') }}">
                <input value="{{ $stream->id }}" name="stream_id" hidden>
                {{csrf_field()}}

                <table id="tbl_point" class="table">
                    <tr>
                        <th class="col-sm-1"></th>
                        <th>时间</th>
                        <th>间隔</th>
                    </tr>


                    @foreach($policies as $policy)
                        <tr>
                            <td>
                                <input type="checkbox" policy_id="{{ $policy->id }}" aria-label="...">
                            </td>
                            <td>
                                <input type="datetime" value="{{ date('Y-m-d H:i:s',$policy->timestamp)  }}"
                                       class="form-control" placeholder="点击选择时间" disabled>
                            </td>
                            <td>
                                <select class="form-control" disabled>
                                    <option>{{ $policy->interval->time }}</option>
                                </select>
                            </td>
                        </tr>

                    @endforeach

                    <tr>
                        <td></td>
                        <td>
                            <input type="datetime" id="input-time-interval1" name="datetime1"
                                   class="form-control input-time-interval" placeholder="点击选择时间">
                        </td>
                        <td>
                            <select name="interval1" class="form-control">
                                @foreach($intervals as $interval)
                                    <option value="{{ $interval->id }}">{{ $interval->time }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                </table>
                <div class="pull-right mar-right-three">
                    <button type="button" id="delete_interval_point" class="btn btn-default">删除</button>
                    <button type="button" id="add_interval_point" class="btn btn-default">添加转化点</button>
                    <button type="submit" class="btn btn-info">提交</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Large modal -->
    <div class="modal fade" id="modal-lg-online" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ url('api/onlineStream') }}" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">上线</h4>
                    </div>
                    <div class="modal-body" style="padding-left: 5%;padding-right: 5%">

                        {{csrf_field()}}

                        <input type="hidden" name="stream_id" value="{{ $stream->id }}">

                        <div class="form-group ">
                            <label class="control-label">间隔(秒)</label>
                            <select class="form-control " name="online_interval_id">
                                @foreach($intervals as $interval)
                                    <option value="{{ $interval->id }}">{{ $interval->time }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label class="control-label">验证周期(天)</label>
                            <select class="form-control" name="validate_cycle_id">
                                @foreach($validate_cycles as $validate_cycle)
                                    <option value="{{ $validate_cycle->id }}">{{ $validate_cycle->days }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消
                        </button>
                        <button type="submit" id="btn-online-stream" class="btn btn-primary">确认上线
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script src="/lib/layDate/laydate/laydate.js"></script> <!-- 改成你的路径 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/3.5.3/echarts.common.js"></script>

    <style>


    </style>

    <script>
        function DatePickCallBack(value, date) {
            var startTime = value.substring(0, 19);
            var endTime = value.substring(22, 41);
            var dateStart = new Date(startTime);
            var dateEnd = new Date(endTime);

            console.log(startTime, '|', endTime);
        }

        //执行一个laydate实例
        //日期时间范围选择
        laydate.render({
            elem: '.input-time'
            , type: 'datetime'
            , range: true
            , min: getNowTime()
            , done: DatePickCallBack
        });

        $('#btn-change-stream').click(function () {
            var url = $('#inputUrl').val();
            var time = $('#inputTime').val();
            var acc = $('#acc').val();
            if (url == 0) {
                Toast('请先填写RTMP地址!', 3000);
                return -1;
            }
            if (time == 0) {
                Toast('请先选择时间范围!', 3000);
                return -1;
            }
            if (acc == 0) {
                Toast('请先选择准确率!', 3000);
                return -1;
            }

            $('#insert-stream-form').submit();
        });

        //处理
        $('#btn-manual-stream').click(function () {
            submit_as_form('{{ url('api/manualStream') }}', 'stream_id', '{{ $stream->id }}');
        })

        //上线 以转为form提交
        {{--$('#btn-online-stream').click(function () {--}}
            {{--submit_as_form('{{ url('api/onlineStream') }}', 'stream_id', '{{ $stream->id }}');--}}
        {{--})--}}

        //下线
        $('#btn-offline-stream').click(function () {
            submit_as_form('{{ url('api/offlineStream') }}', 'stream_id', '{{ $stream->id }}');
        })

        //Echart
        var x_axis_data = []
        @foreach($intervals as $interval)
        x_axis_data.push({{ $interval->time }});
                @endforeach

                var url = '{{ $stream->url }}';

        var collect_global_interval = '{{ $stream->collect_global_interval->time }}';

        var start = '{{ $stream->start }}';
        var end = '{{ $stream->end }}';

        var myChart = echarts.init(document.getElementById('policy'));
        option = {

            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['Step Start']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                data: [start, end]
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: 'Step Start',
                    type: 'line',
                    step: 'start',
                    data: [collect_global_interval, collect_global_interval]
                }
            ]
        };

        myChart.setOption(option);


        //add point
        var name_idx = 1;

        $('#add_interval_point').click(function () {
            name_idx++;
            console.log(1);
            $("#tbl_point").append('<tr>' +
                    '<td></td>' +
                    '<td>' +
                    '<input type="datetime" id=input-time-interval' + name_idx + ' name="datetime' + name_idx + '" class="form-control"  placeholder="点击选择时间" lay-key="1">' +
                    '</td>' +
                    '<td>' +
                    '<select class="form-control" name="interval' + name_idx + '" >' +
                    '@foreach($intervals as $interval)' +
                    '<option  value="{{ $interval->id }}">{{ $interval->time }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +
                    '</tr>');

            laydate.render({
                elem: '#input-time-interval' + name_idx
                , min: '{{ $stream->start }}'
                , max: '{{ $stream->end }}'
                , type: 'datetime'
            });
        });

        laydate.render({
            elem: '#input-time-interval1'
            , min: '{{ $stream->start }}'
            , max: '{{ $stream->end }}'
            , type: 'datetime'
        });


        //批量操作
        $('#delete_interval_point').click(function () {
            var intervals_id = [];
            $('#tbl_point').find('input:checkbox').each(function () {
                if ($(this).prop('checked') == true) {
                    intervals_id.push($(this).attr('policy_id'));
                }
            });

            submit_as_form('{{ url('api/deleteInterval') }}', 'intervals_id', intervals_id);

        })

        $('#form_add_policy').submit(function (e) {
            var can_submit = true;
            $('#form_add_policy').find("input[id^='input-time-interval']").each(function () {
                if ($(this).val() == 0) {
                    can_submit = false;
                }
            });

            if (!can_submit)
                Toast('请先选择时间!', 3000);

            return can_submit;
        })

        //计算预计图片数量
        function set_image_num() {
            var arr_time_line = [];
            var arr_interval_line = [];

            arr_time_line.push({{ $stream->start_timestamp }});
            arr_interval_line.push({{ $stream->collect_global_interval->time }});
            @foreach($policies as $policy)
            arr_time_line.push({{ $policy->timestamp }});
            arr_interval_line.push({{ $policy->interval->time }})
            @endforeach
            arr_time_line.push({{ $stream->end_timestamp }});
            {{--arr_interval_line.push({{ $stream->collect_global_interval->time }});//最后这个其实不用加--}}

            var image_num = 0;
            for (var i = 0; i < (arr_time_line.length - 1); i++) {

                image_num += (arr_time_line[i + 1] - arr_time_line[i]) / arr_interval_line[i];
            }
            $('#kdb_image_num').html(image_num);
        }
        set_image_num();

        //重启流
        $('#btn_repeat').click(function () {
            submit_as_form('{{ url('api/streamReCollection') }}', 'stream_id', '{{ $stream->id }}');
        })


    </script>
@endsection

