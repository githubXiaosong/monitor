<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7 0007
 * Time: 下午 7:15
 */

namespace App\Http\Controllers;

use App\Helper\GlobalFunction;
use App\Policy;
use App\Server;
use App\Stream;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Notifications\Test;


use App\User;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {

        $servers = Server::where('status', SERVER_STATUS_OK)->get();

        $streams = [];

        foreach ($servers as $server) {

            $items = Stream::whereIn('status', [
                STREAM_STATUS_PRE_COLLECTION,
                STREAM_STATUS_COLLECTION,
                STREAM_STATUS_MANUAL
            ])->where(['is_forbidden' => 0, 'server_id' => $server->id])->get();

            foreach ($items as $item)
                $streams[] = $item;

        }


        $time = time();
        foreach ($streams as $stream) {

            switch ($stream->status) {
                case STREAM_STATUS_PRE_COLLECTION:
                    if ($stream->end_timestamp < $time) {
                        //时间比结束时间大 error
                        GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"时间比结束时间大");
                        $stream->status = STREAM_STATUS_ERROR_OTHER;
                    } else if (($stream->start_timestamp < $time)) {
                        //时间比开始时间大
                        GlobalFunction::streamStatusChangeNotifyAllUser($stream->id,$stream->status,STREAM_STATUS_COLLECTION);
                        $stream->status = STREAM_STATUS_COLLECTION;
                        $stream->collect_current_interval_id = $stream->collect_global_interval_id;
                    }

                    print(1);
                    break;
                case STREAM_STATUS_COLLECTION:
                    if ($stream->start_timestamp > $time) {
                        //时间比开始时间小 error
                        GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"时间比开始时间小");
                        $stream->status = STREAM_STATUS_ERROR_OTHER;
                    } else if ($stream->end_timestamp < $time) {
                        //时间比结束时间大
                        if ($stream->retry_num != 0) {
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"结束时retry_num不为0");
                            $stream->status = STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR;
                        } else {
                            GlobalFunction::streamStatusChangeNotifyAllUser($stream->id,$stream->status,STREAM_STATUS_COLLECTION_TO_MANUAL);
                            $stream->status = STREAM_STATUS_COLLECTION_TO_MANUAL;
                        }
                        $stream->collect_current_interval_id = null;
                    } else {
                        //根据制定的策略设定collect_current_interval_id
                        $policy = Policy::where('stream_id', $stream->id)
                            ->where('timestamp', '<', $time)
                            ->orderBy('timestamp', 'desc')
                            ->first();
                        if ($policy) {
                            $stream->collect_current_interval_id = $policy->interval_id;
                        }
                        print(2);
                    }
                    break;
                case STREAM_STATUS_MANUAL:
                    if ($stream->end_time > $time) {
                        //时间比结束时间小 error
                        $stream->status = STREAM_STATUS_ERROR_OTHER;
                        GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"时间比结束时间小");
                    }
                    break;
            }
            $stream->save();
        }

    }

//        foreach ($user->unreadNotifications as $notification) {
//            if ($notification->type == 'App\Notifications\StreamStatusChange')
//                echo $notification->type;
//        }
//        $user->notify(new Test(NOTIFY_TYPE_ERROR,"这是通知标题", '这是通知内容'));

//        GlobalFunction::streamErrorNotifyAllUser(1,STREAM_STATUS_ONLINE,"测试错误");
//        GlobalFunction::serverErrorNotifyAllUser(3,"错误");
//        GlobalFunction::streamStatusChangeNotifyAllUser('1',STREAM_STATUS_COLLECTION,STREAM_STATUS_COLLECTION_TO_MANUAL);


//        $user = User::find(1);
//        foreach ($user->notifications as $notification) {
//            echo $notification->data['title'];
//        }

//        $user->notify(new Test("这是通知标题",'这是通知内容'));

//        Notification::send($user,new Test());
//        Notification::send($user,new Test());

//        $s= new \App\Helper\RongLianYun\SendTemplateSMS();
//        $result = $s->sendTemplateSMS('13081114886',["xiaosong"],"1");
//        if($result->statusCode == 000000)

//        Mail::to($user)->send(new Test("你好 我是小松 ！"));


//if (Auth::check())
//{
//$user = Auth::user();
//}

}
