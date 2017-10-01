@extends('layouts.stream')

@section('content-right')

    @if (session('err_msg'))
        <div class="alert alert-danger">
            {{ session('err_msg') }}
        </div>
    @endif

<div class="panel panel-default">
    <div class="panel-heading">

        <div class="pull-left"> <strong>视频流添加</strong></div>

        <div class="pull-right">

        </div>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body">
        <form id="insert-stream-form" class="form-horizontal" method="post" action="{{ url('api/createStream') }}">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="inputUrl" class="col-sm-2 control-label">Url</label>

                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">RTMP://</span>
                        <input type="text" class="form-control" name="inputurl" id="inputUrl" placeholder="请填写RTMP地址">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputStartTime" class="col-sm-2 control-label">采集时间范围</label>
                <div class="col-sm-10">
                    <input  type="datetime" class="form-control input-time" name="inputtime" id="inputTime" placeholder="点击选择时间范围">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEndTime" class="col-sm-2 control-label">默认全局策略</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <select name="collect_global_interval_id" class="form-control">
                            @foreach($intervals as $interval)
                                <option value="{{ $interval->id }}">{{ $interval->time }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-addon">秒</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEndTime" class="col-sm-2 control-label">准确率</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength = 2  class="form-control" name="acc_expected" id="acc" placeholder="期望准确率">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEndTime" class="col-sm-2 control-label">截图主机</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <select name="server_id" class="form-control">
                            @foreach($servers as $server)
                                <option value="{{ $server->id }}">{{ $server->ip }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="pull-right mar-right-three" >
                    <button id="btn-add-stream" type="submit" class="btn btn-info">创建</button>
                </div>
            </div>



        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">

        <div class="pull-left"> <strong>截图主机</strong></div>

        <div class="pull-right">

        </div>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body">
        <form id="insert-server-form" class="form-horizontal" method="post" action="{{ url('api/createServer') }}">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="inputUrl" class="col-sm-2 control-label">IP</label>

                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control" name="ip" id="inputIP" placeholder="请填写IP地址">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="pull-right mar-right-three" >
                    <button id="btn-add-server" type="submit" class="btn btn-info">创建</button>
                </div>
            </div>



        </form>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script src="/lib/layDate/laydate/laydate.js"></script> <!-- 改成你的路径 -->

    <style>


    </style>

    <script>
        //Stream
        function DatePickCallBack(value, date){
            var startTime = value.substring(0,19);
            var endTime = value.substring(22,41);
            var dateStart = new Date(startTime);
            var dateEnd = new Date(endTime);

            console.log( startTime,'|',endTime);
        }


        //执行一个laydate实例
        //日期时间范围选择
        laydate.render({
            elem: '.input-time'
            ,type: 'datetime'
            ,range: true
            ,min: getNowTime()
            ,done: DatePickCallBack
        });


        //简单前端验证
        $('#insert-stream-form').submit(function () {
            if($('#inputUrl').val() == 0){
                Toast('请先填写RTMP地址!',3000);
                return false;
            }
            if($('#inputTime').val() == 0){
                Toast('请先选择时间范围!',3000);
                return false;
            }
            if($('#acc').val() == 0){
                Toast('请先选择准确率!',3000);
                return false;
            }
            return true;
        });

        //Server

        function isValidIP(ip)
        {
            var reg =  /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/
            return reg.test(ip);
        }

        $('#insert-server-form').submit(function () {
            var ip = $('#inputIP').val();
            if(ip == 0){
                Toast('请先填写IP地址!',3000);
                return false;
            }
            if(!isValidIP(ip)){
                Toast('请先填写有效IP地址!',3000);
                return false;
            }
            return true;
        });
    </script>
@endsection

