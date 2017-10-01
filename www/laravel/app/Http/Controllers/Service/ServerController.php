<?php

namespace App\Http\Controllers\Service;

use App\Helper\GlobalFunction;
use App\Server;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServerController extends Controller
{
    public function createServer()
    { //todo 这边应该限制一下收集时间不能太短 而且要判断收集时间
        $validator = Validator::make(
            rq(),
            [
                'ip' => 'required|unique:servers,ip|ip'
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg', $validator->messages());

//        $id = DB::table('servers')->insertGetId(
//            [
//                'ip' => rq('ip'),
//                'collect_global_interval_id' => rq('collect_global_interval_id'),
//                'acc_expected' => rq('acc_expected'),
//
//            ]
//        );
//
//        $res = Server::insert([
//            'ip' => rq('ip')
//        ]);
//

        $server = new Server();
        $server->ip = rq('ip');

        if ($server->save())
            return redirect('stream/list')->with('suc_msg', 'Server' . rq('ip') . '创建成功');
        return back()->with('err_msg', 'Server创建失败 数据库出错');
    }

    /**
     *  server 心跳
     */
    public function serverStatusCallBack(Request $request)
    {

        $ip = $request->getClientIp();

        $server = Server::where('ip', $ip)->first();
        if (!$server) {
            return -1;
        }
        $validator = Validator::make(
            rq(),
            [
                'code' => 'required|integer|in:' . CALLBACK_CODE_SERVER_OK . ',' . CALLBACK_CODE_SERVER_ERROR,
                'msg' => 'required_unless:code,'.CALLBACK_CODE_SERVER_OK
            ],
            [
            ]
        );
        if ($validator->fails())
            return -1;

        switch (rq('code')) {
            case CALLBACK_CODE_SERVER_OK:
                $server->status = SERVER_STATUS_OK;
                $server->call_live_count = 0;
                break;

            case CALLBACK_CODE_SERVER_ERROR:
                $server->status = SERVER_STATUS_ERROR_SCRIPT_RUN;
                Log::emergency(['server_id' => $server->id ,'msg' => rq('msg')]);
                GlobalFunction::serverErrorNotifyAllUser($server->id,"script run error!  error is: ".rq('msg'));
                break;
        }
        $server->save();

        return 1;
    }

}
