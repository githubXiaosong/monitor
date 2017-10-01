<?php

namespace App\Http\Controllers\Service;
use App\Helper\GlobalFunction;
use App\Server;
use App\Stream;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
    public function createStream(){ //todo 这边应该限制一下收集时间不能太短 而且要判断收集时间
        $validator = Validator::make(
            rq(),
            [
                'inputurl' => 'required|min:5',
                'collect_global_interval_id' => 'required|exists:intervals,id',
                'acc_expected'=>'required|digits_between:0,2',
                'inputtime' => 'required|size:41,41',
                'server_id' => 'required|exists:servers,id'
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $start_time = strtotime(substr(rq('inputtime'),0,19));//41位
        $end_time = strtotime(substr(rq('inputtime'),22));

       $id = DB::table('streams')->insertGetId(
            [
                'url' => rq('inputurl'),
                'collect_global_interval_id' => rq('collect_global_interval_id'),
                'acc_expected' => rq('acc_expected'),
                'server_id' => rq('server_id'),
                'start_timestamp' => $start_time,
                'end_timestamp' => $end_time
            ]
        );

        if ($id)
            return redirect('stream/modify/'.$id)->with('suc_msg', '创建成功 请添加策略');
        return back()->with('err_msg','创建失败 数据库出错');
    }

    public function changeStream(){

        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
                'inputurl' => 'required|min:5',
                'collect_global_interval_id' => 'required|exists:intervals,id',
                'acc_expected'=>'required|digits_between:0,2',
                'inputtime' => 'required|size:41,41'
            ],
            [
            ]
        );


        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $start_time = strtotime(substr(rq('inputtime'),0,19));//41位
        $end_time = strtotime(substr(rq('inputtime'),22));

        //这边要删除时间更新之后policy越界的

        DB::table('policies')->where('stream_id',rq('stream_id'))->where('timestamp','<',$start_time)->delete();
        DB::table('policies')->where('stream_id',rq('stream_id'))->where('timestamp','>',$end_time)->delete();

        //只有刚刚添加才可以修改
        $stream = Stream::where('id',rq('stream_id'))->first();
        if($stream->status == STREAM_STATUS_PRE_COLLECTION){
            $stream->url = rq('inputurl');
            $stream->collect_global_interval_id = rq('collect_global_interval_id');
            $stream->acc_expected = rq('acc_expected');
            $stream->start_timestamp = $start_time;
            $stream->end_timestamp = $end_time;
        }else{
            return back()->with('err_msg','修改失败 只有刚刚添加的流才可以被修改');
        }

        if ($stream->save())
            return back()->with('suc_msg', '修改成功');
        return back()->with('err_msg','修改失败 数据库出错');
    }

    public function deleteStream(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );

        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $res = DB::table('policies')->where('stream_id',rq('stream_id'))->delete();

        $res = DB::table('streams')->where('id',rq('stream_id'))->delete();
        if(!$res)
            return back()->with('err_msg','删除失败 数据库出错');
        return back()->with('suc_msg','删除成功');
    }

    public function deleteInterval(){

        $validator = Validator::make(
            rq(),
            [
                'intervals_id' => 'required|string',
                'intervals_id.*' => 'exists:intervals,id'
            ],
            [
            ]
        );

        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $res = DB::table('policies')->whereIn('id',explode(',',trim(rq('intervals_id'))))->delete();

        if($res)
            return back()->with('suc_msg','删除成功');

        return back()->with('err_msg','删除失败 数据库出错');
    }


    //todo 这边应该要添加一个限制装换时间间隔的策略
    public function addInterval()
    {
        $validator = Validator::make(
            rq(),
            [
                'interval1' => 'required|exists:intervals,id|',
                'datetime1' => 'required|size:19,19',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());


        $stream_id = rq('stream_id');
        $stream = Stream::find($stream_id);
        $start_time = $stream->start_timestamp;
        $end_time = $stream->end_timestamp;

        $insert_arr = [];
        foreach(rq() as $datetime_key=>$datetime_value){
            if(starts_with($datetime_key,'datetime')){
                $interval_key = 'interval' . explode('datetime',$datetime_key)[1];
                $interval_value = rq($interval_key);

                $datetime_value = strtotime($datetime_value);

                if(($datetime_value > $end_time) || ($datetime_value < $start_time))
                    return back()->with('err_msg','创建失败 日期越界');

                if($datetime_value && $interval_value){
                    $insert_arr[] = [
                        'interval_id' => $interval_value
                        ,'stream_id' => $stream_id
                        ,'timestamp' => $datetime_value
                    ];
                }
            }
        }

        if(DB::table('policies')->insert($insert_arr))
            return back()->with('suc_msg','插入成功');

        return back()->with('err_msg','创建失败 数据库出错');
    }


    public function toggleForbidden(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );

        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());


        $stream = DB::table('streams')->where('id',rq('stream_id'))->first();


        $res = DB::table('streams')->where('id',rq('stream_id'))->update(['is_forbidden' => ($stream->is_forbidden==1)?0:1 ]);
        //返回更新的条数 如果更新信息与原信息相同 则返回0
        if($res)
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }

    public function streamReCollection(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $time = time();
        $stream =  Stream::find(rq('stream_id'));

        if(($stream->status!=STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR) || ($stream->end_timestamp < $time )){
            return back()->with('err_msg','所操作的流状态不符');
        }

        $stream->retry_num = 0;
        $stream->status = STREAM_STATUS_COLLECTION;

        if($stream->save())
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }


    public function streamReOnline(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());


        $stream =  Stream::find(rq('stream_id'));

        if($stream->status!=STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR){
            return back()->with('err_msg','所操作的流状态不符');
        }

        $stream->retry_num = 0;
        $stream->status = STREAM_STATUS_ONLINE;

        if($stream->save())
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }

    public function manualStream(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $time = time();
        $stream =  Stream::find(rq('stream_id'));

        if(($stream->status!=STREAM_STATUS_COLLECTION_TO_MANUAL) || ($stream->end_timestamp > $time )){
            return back()->with('err_msg','所操作的流状态不符');
        }

        $stream->status = STREAM_STATUS_MANUAL;

        if($stream->save())
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }

    public function onlineStream(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
                'online_interval_id' => 'required|exists:intervals,id',
                'validate_cycle_id' => 'required|exists:validate_cycles,id',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $stream =  Stream::find(rq('stream_id'));

        if((!in_array($stream->status,[STREAM_STATUS_MANUAL_TO_ONLINE,STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR]))){
            return back()->with('err_msg','所操作的流状态不符');
        }

        $stream->online_interval_id = rq('online_interval_id');
        $stream->validate_cycle_id = rq('validate_cycle_id');
        $stream->status = STREAM_STATUS_ONLINE;

        if($stream->save())
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }

    public function offlineStream(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg',$validator->messages());

        $stream =  Stream::find(rq('stream_id'));

        if(($stream->status!= STREAM_STATUS_ONLINE)){
            return back()->with('err_msg','所操作的流状态不符');
        }

        $stream->status = STREAM_STATUS_MANUAL_TO_ONLINE;

        if($stream->save())
            return back()->with('suc_msg','操作成功');

        return back()->with('err_msg','操作失败 数据库出错');
    }


    /**
     * 非WEB调用
     */
    public function getStreamList(Request $request){

        $ip = $request->getClientIp();
        $server = Server::where('ip',$ip)->first();

        if(!$server){
            Log::error('the server'. $ip .'is not register');
            return -1;
        }


        $streams = Stream::whereIn('status',[
            STREAM_STATUS_COLLECTION,STREAM_STATUS_MANUAL,STREAM_STATUS_ONLINE
        ])->where(['is_forbidden'=>0,'server_id'=>$server->id])->with(['collect_current_interval','online_interval'])->get();

        return $streams;
    }



    /**
     * 非WEB调用
     */
    public function streamStatusCallBack(){
        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required|exists:streams,id',
                'code' => 'required',
                'img_num' => 'integer|required_if:code,' . CALLBACK_CODE_COLLECT_OK, //收集成功的时候需要一个图片数量

            ],
            [
            ]
        );
        if ($validator->fails()) {
            return -1;
        }

        $stream = Stream::find(rq('stream_id'));
        if (($stream->status != STREAM_STATUS_COLLECTION) && ($stream->status != STREAM_STATUS_MANUAL) && ($stream->status != STREAM_STATUS_ONLINE)) {
            //只有在状态为收集图片的时候才可以更新图片
            return -1;
        }

        switch ($stream->status) {

            case STREAM_STATUS_COLLECTION:
                switch (rq('code')) {
                    case CALLBACK_CODE_COLLECT_OK:
                        if ($stream->image_num_current == rq('img_num')) {
                            $stream->status = STREAM_STATUS_ERROR_IN_COLLECTION_IMG_NUM_NO_UP;
                            Log::emergency('Stream'. $stream->id .' 收集(截图)图片数量未增长');
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"收集(截图)图片数量未增长");
                        } else {
                            $stream->image_num_current = rq('img_num');
                            $stream->retry_num = 0;
                        }
                        break;
                    case CALLBACK_CODE_COLLECT_ERROR_1:
                        if ($stream->retry_num != STREAM_MAX_RETRY_NUM) {
                            $stream->retry_num = $stream->retry_num + 1;
                        } else {
                            $stream->status = STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR;
                            Log::emergency('Stream'. $stream->id .' 收集(截图)图片进程执行失败');
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status,"收集(截图)图片进程执行失败");
                        }
                        break;
                }
                break;

            case STREAM_STATUS_MANUAL:
                switch (rq('code')) {
                    case CALLBACK_CODE_MANUAL_MODEL_EXISTS:
                        $stream->status = STREAM_STATUS_MANUAL_TO_ONLINE;
                        break;
                    case CALLBACK_CODE_MANUAL_MODEL_NOT_EXISTS:

                        break;
                }
                break;

            case STREAM_STATUS_ONLINE:
                switch (rq('code')) {
                    case CALLBACK_CODE_ONLINE_OK:
                        $stream->retry_num = 0;
                        break;
                    case CALLBACK_CODE_ONLINE_ERROR_1:
                        if ($stream->retry_num != STREAM_MAX_RETRY_NUM) {
                            $stream->retry_num = $stream->retry_num + 1;
                        } else {
                            Log::emergency('Stream'. $stream->id .' 线上执行出错');
                            GlobalFunction::streamErrorNotifyAllUser($stream->id,$stream->status," 线上执行出错");
                            $stream->status = STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR;
                        }
                        break;
                }
                break;
        }

        if ($stream->save()) {
            return 1;
        }
    }

    public function streamClassifyCallBack(){
        //这一条需要较高的效率 所以用了尽量少的验证值方法

        $validator = Validator::make(
            rq(),
            [
                'stream_id' => 'required',
                'label' => 'required|integer',
                'percent' => 'required|integer|min:0|max:100'
            ],
            [
            ]
        );
        if ($validator->fails())
            return -1;

        Log::info([
            'stream_id' => rq('stream_id'),
            'label' => rq('label'),
            'percent' => rq('percent'),
            'time' => date('Y-m-d H:i:s',time())
        ]);


    }



}
