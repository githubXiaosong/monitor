<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <style type="text/css">
        .pointer {
            cursor: pointer;
        }

        .Huifold .item {
            position: relative
        }

        .Huifold .item h4 {
            margin: 0;
            font-weight: bold;
            position: relative;
            border-top: 1px solid #fff;
            font-size: 15px;
            line-height: 22px;
            padding: 7px 10px;
            background-color: #eee;
            cursor: pointer;
            padding-right: 30px
        }

        .Huifold .item h4 b {
            position: absolute;
            display: block;
            cursor: pointer;
            right: 10px;
            top: 7px;
            width: 16px;
            height: 16px;
            text-align: center;
            color: #666
        }

        .Huifold .item .info {
            display: none;
            padding: 10px
        }

        .mar-right-three {
            margin-right: 3%
        }
    </style>

</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Laravel
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else

                    <?php
                    $notify_count = 0;
                    $error_coutn = 0;
                    foreach (\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification) {
                        if (in_array($notification->type, ARR_NOTIFY_TYPE_NOTIFY))
                            $notify_count++;
                        else if (in_array($notification->type, ARR_NOTIFY_TYPE_ERROR))
                            $error_coutn++;
                    }
                    ?>
                    <li><a href="#" data-toggle="modal" data-target="#modal-lg-notify-notify">通知 <span
                                    class="badge">{{ $notify_count }}</span></a></li>


                    <li><a href="#" data-toggle="modal" data-target="#modal-lg-notify-error">故障 <span
                                    class="badge" style="background: orangered">{{ $error_coutn }}</span></a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

        <!-- Scripts -->
<script src="/js/app.js"></script>

<script>
    //自定义弹框
    function Toast(msg, duration) {
        duration = isNaN(duration) ? 3000 : duration;
        var m = document.createElement('div');
        m.innerHTML = msg;
        m.style.cssText = "width: 40%;min-width: 150px;opacity: 0.7;height: 50px;color: rgb(255, 255, 255);line-height: 50px;text-align: center;border-radius: 5px;position: fixed;top: 40%;left: 30%;z-index: 999999;background: rgb(0, 0, 0);font-size: 20px;";
        document.body.appendChild(m);
        setTimeout(function () {
            var d = 0.5;
            m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
            m.style.opacity = '0';
            setTimeout(function () {
                document.body.removeChild(m)
            }, d * 1000);
        }, duration);
    }

    //取得当前时间
    function getNowTime() {
        function p(s) {
            return s < 10 ? '0' + s : s;
        }

        var myDate = new Date();
        return myDate.getFullYear() + '-' + p(myDate.getMonth() + 1) + "-" + p(myDate.getDate()) + " " + p(myDate.getHours()) + ':' + p(myDate.getMinutes()) + ":" + p(myDate.getSeconds());
    }

    //以表单形式提交参数
    function submit_as_form(url, data_name, data_value) {
        var form = '<form id="tmp_for_submit_form" method="post" action=" ' + url + ' " >' +
                '<input type="hidden" name="' + data_name + '" value=" ' + data_value + ' ">' +
                '{{ csrf_field() }}' +
                '</form>';
        $('body').append(form);
        $('#tmp_for_submit_form').submit();
    }

    // 折叠筐 XiaoSong改过了Hui的东西 为了方便观察 类型只能穿3 不然报错
    jQuery.Huifold = function (obj, obj_c, speed, obj_type, Event) {

        $(obj).bind(Event, function () {
            if ($(this).next().is(":visible")) {
                $(this).next().slideUp(speed).end().removeClass("selected");
                $(this).find("b").html("+")
            }

            else {
                $(this).next().slideDown(speed).end().addClass("selected");
                $(this).find("b").html("-")
            }
        })
    }


    //刷新
    $('.btn_refresh').click(function () {
        window.location.reload();//刷新当前页面.
    })


</script>

@yield('script')


@if(Auth::check()):
<!-- Large modal notify-notify-->
<div class="modal fade" id="modal-lg-notify-notify" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('api/markNotificationsAsRead') }}">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="notify">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">通知
                        <small style="margin-left: 20px; cursor: pointer"><a>查看历史通知</a></small>
                    </h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>类型</th>
                            <th>内容</th>
                            <th>时间</th>

                        </tr>
                        @foreach(\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification)
                            @if(in_array($notification->type,ARR_NOTIFY_TYPE_NOTIFY))
                                <tr>
                                    <td> {{ $notification->type}} </td>
                                    <td> {{ json_encode($notification->data) }}</td>
                                    <td> {{$notification->created_at}}</td>
                                </tr>
                            @endif
                        @endforeach

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">保留
                    </button>
                    <button type="submit" class="btn btn-primary">已读
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Large modal notify-error-->
<div class="modal fade" id="modal-lg-notify-error" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('api/markNotificationsAsRead') }}">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="error">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">错误
                        <small style="margin-left: 20px; cursor: pointer"><a>查看历史错误</a></small>
                    </h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>类型</th>
                            <th>内容</th>
                            <th>时间</th>

                        </tr>
                        @foreach(\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $notification)
                            @if(in_array($notification->type,ARR_NOTIFY_TYPE_ERROR))
                                <tr>
                                    <td> {{ $notification->type}} </td>
                                    <td> {{ json_encode($notification->data) }}</td>
                                    <td> {{$notification->created_at}}</td>
                                </tr>
                            @endif
                        @endforeach

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">保留
                    </button>
                    <button type="submit" class="btn btn-primary">已读
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif

</body>
</html>
