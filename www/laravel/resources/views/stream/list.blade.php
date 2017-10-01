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


    <div class="panel-heading">
        <div class="pull-left">
            <strong>视频流列表</strong>&nbsp;&nbsp;
            <button type="button" class="btn btn-default btn-xs btn_refresh">
                <span class="glyphicon  glyphicon-refresh" aria-hidden="true"></span>
            </button>
        </div>


        <div class="pull-right">
            <div class="btn-toolbar" role="toolbar" aria-label="...">
                <div class="btn-group" role="group" aria-label="...">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            筛选&nbsp;&nbsp;&nbsp; <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('stream/list') }}">全部</a></li>
                            <li><a href="{{ url('stream/list?status=pre_collection') }}">刚刚添加</a></li>
                            <li><a href="{{ url('stream/list?status=collection') }}">收集中</a></li>
                            <li><a href="{{ url('stream/list?status=collection_to_manual') }}">收集完毕待处理</a></li>
                            <li><a href="{{ url('stream/list?status=manual') }}">处理中</a></li>
                            <li><a href="{{ url('stream/list?status=manual_to_online') }}">处理完毕待上线</a></li>
                            <li><a href="{{ url('stream/list?status=online') }}">上线中</a></li>
                            <li><a href="{{ url('stream/list?status=online_validate') }}">上线验证</a></li>
                            <li><a href="{{ url('stream/list?status=online_to_fix') }}">上线验证待处理</a></li>
                            <li><a href="{{ url('stream/list?status=online_fix') }}">上线验证处理中</a></li>
                            <li><a href="{{ url('stream/list?status=collection_error_img_no_up') }}">收集图片增长出错</a>
                            </li>
                            <li><a href="{{ url('stream/list?status=collection_error_pro_error') }}">收集线程执行出错</a>
                            </li>
                            <li><a href="{{ url('stream/list?status=online_error') }}">上线出错</a></li>
                            <li><a href="{{ url('stream/list?status=other_error') }}">其他出错</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>


    @foreach($servers as $server)

        <div class="panel panel-default">

            <div class="panel-heading">

                <div class="pull-left">
                    <strong>{{ $server->ip }}</strong>&nbsp;&nbsp;
                    <button type="button" class="btn btn-default btn-xs btn_option_server">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </button>
                </div>

                <div class="pull-right">
                    <div class="btn-toolbar" role="toolbar" aria-label="...">
                        @if($server->status == SERVER_STATUS_OK)
                            <span class="label label-primary">正常</span>
                        @elseif($server->status == SERVER_STATUS_ERROR_SCRIPT_RUN)
                            <span class="label label-warning">故障</span>
                        @elseif($server->status == SERVER_STATUS_ERROR_OFF_LINE)
                            <span class="label label-warning">离线</span>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body">
                <table class="table tbl_streams">
                    <tr>
                        <th></th>
                        <th>id</th>
                        <th>url</th>
                        <th>图片数量</th>
                        <th>采集/线上间隔</th>
                        <th>期望准确率</th>
                        <th>当前准确率</th>
                        <th>状态</th>
                        <th>是否禁止</th>
                        <th>操作</th>

                    </tr>
                    @foreach($server->streams as $stream)
                        <tr>
                            <td>
                                <input type="checkbox" aria-label="..." stream_id="{{ $stream->id }}">
                            </td>
                            <td>{{ $stream->id }}</td>
                            <td>{{ $stream->url }}</td>
                            <td>{{ $stream->image_num_current }}</td>

                            <td>
                                @if(in_array($stream->status,[STREAM_STATUS_ONLINE,STREAM_STATUS_ONLINE_VALIDATE,STREAM_STATUS_ONLINE_TO_FIX,STREAM_STATUS_ONLINE_FIX ]))
                                    {{ $stream->online_interval->time }}
                                @else
                                    @if($stream->collect_current_interval)
                                        {{$stream->collect_current_interval->time}}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $stream->acc_expected }}%</td>
                            <td>{{ $stream->acc_current }}%</td>
                            <td>@if($server->status == SERVER_STATUS_OK)
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
                                @else
                                    <span class="label label-warning">服务器故障</span>
                                @endif
                            </td>
                            <td>
                                @if($stream->is_forbidden)
                                    <span class="label label-warning">禁止中</span>
                                @else
                                    <span class="label label-success">未禁止</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default btn-xs dropdown-toggle" type="button"
                                            id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ url('stream/modify').'/'.$stream->id }}">修改</a></li>
                                        <li>
                                            <a href="#" class="toggle_forbidden" stream_id="{{ $stream->id }}">
                                                @if($stream->is_forbidden)
                                                    取消禁止
                                                @else
                                                    禁止
                                                @endif
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="delete_stream" stream_id="{{ $stream->id }}">
                                                删除
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>

                    @endforeach

                </table>
            </div>
        </div>

    @endforeach



@endsection

@section('script')
    <script>

        //stream 批量操作
        {{--$('#delete_streams').click(function () {--}}

        {{--var can_submit = false;--}}
        {{--var streams_id = [];--}}
        {{--$('.tbl_streams').find('input:checkbox').each(function () {--}}
        {{--if ($(this).prop('checked') == true) {--}}
        {{--can_submit = true;--}}
        {{--streams_id.push($(this).attr('stream_id'));--}}
        {{--}--}}
        {{--});--}}

        {{--if (!can_submit) {--}}

        {{--Toast('请至少选择一个流', 3000);--}}
        {{--return -1;--}}
        {{--}--}}
        {{--submit_as_form('{{ url('api/deleteStream') }}','streams_id',streams_id);--}}
        {{--})--}}


        $('.toggle_forbidden').click(function () {
            submit_as_form('{{ url('api/toggleForbidden') }}', 'stream_id', $(this).attr('stream_id'));
        })

        $('.delete_stream').click(function () {
            submit_as_form('{{ url('api/deleteStream') }}', 'stream_id', $(this).attr('stream_id'));
        })


    </script>
@endsection
