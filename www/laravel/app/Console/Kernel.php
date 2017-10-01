<?php

namespace App\Console;

use App\Helper\GlobalFunction;
use App\Policy;
use App\Server;
use App\Stream;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        /**
         * 维护server状态
         * 增加 call_live_count
         */
        $schedule->call(function(){
            $servers = Server::where('status',SERVER_STATUS_OK)->get();
            foreach($servers as $server){
                if($server->call_live_count > SERVER_MAX_RETRY_NUM){
                    $server->status = SERVER_STATUS_ERROR_OFF_LINE;
                    Log::emergency('Server'. $server->ip .' off Line!!!');
                    GlobalFunction::serverErrorNotifyAllUser($server->id,"Server off Line!");
                }else{
                    $server->call_live_count = $server->call_live_count + 1;
                }
                $server->save();
            }

        })->everyMinute();

        /**
         * 维护stream状态
         */
        $schedule->call(function(){

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
                            Log::emergency('Stream'. $stream->id .' 时间比结束时间大');
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
                            Log::emergency('Stream'. $stream->id .' 时间比开始时间小');
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"时间比开始时间小");
                            $stream->status = STREAM_STATUS_ERROR_OTHER;
                        } else if ($stream->end_timestamp < $time) {
                            //时间比结束时间大
                            if ($stream->retry_num != 0) {
                                Log::emergency('Stream'. $stream->id .' 结束时retry_num不为0');
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
                            Log::emergency('Stream'. $stream->id .' 时间比结束时间小');
                            $stream->status = STREAM_STATUS_ERROR_OTHER;
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"时间比结束时间小");
                        }
                        break;
                }
                $stream->save();
            }
        })->everyMinute();

/**
 * 定时验证
 */
//        $schedule->call(function(){
//            $streams = Stream::where('status',STREAM_STATUS_ONLINE)->get();
//        })->dailyAt('08:00');



    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
