<?php

namespace App\Http\Controllers\Page;

use App\Interval;
use App\Policy;
use App\Server;
use App\Stream;
use App\Validate_cycle;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

//test
class StreamController extends Controller
{
    public function lst()
    {
        $status_code = null;
        if (rq('status')) {
            switch (rq('status')) {
                case 'pre_collection':
                    $status_code = STREAM_STATUS_PRE_COLLECTION;
                    break;
                case 'collection':
                    $status_code = STREAM_STATUS_COLLECTION;
                    break;
                case 'collection_to_manual':
                    $status_code = STREAM_STATUS_COLLECTION_TO_MANUAL;
                    break;
                case 'manual':
                    $status_code = STREAM_STATUS_MANUAL;
                    break;
                case 'manual_to_online':
                    $status_code = STREAM_STATUS_MANUAL_TO_ONLINE;
                    break;
                case 'online':
                    $status_code = STREAM_STATUS_ONLINE;
                    break;
                case 'online_validate':
                    $status_code = STREAM_STATUS_ONLINE_VALIDATE;
                    break;
                case 'online_to_fix':
                    $status_code = STREAM_STATUS_ONLINE_TO_FIX;
                    break;
                case 'online_fix':
                    $status_code = STREAM_STATUS_ONLINE_FIX;
                    break;
                case 'other_error':
                    $status_code = STREAM_STATUS_ERROR_OTHER;
                    break;
                case 'collection_error_img_no_up':
                    $status_code = STREAM_STATUS_ERROR_IN_COLLECTION_IMG_NUM_NO_UP;
                    break;
                case 'collection_error_pro_error':
                    $status_code = STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR;
                    break;
                case 'online_error':
                    $status_code = STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR;
                    break;
                default:
                    break;
            }
        }

        $servers = Server::get();

        foreach ($servers as $server) {
            $streams_getter = Stream::where('server_id' , $server->id);
            if (!is_null($status_code)) {
                $streams_getter = $streams_getter->where('status',$status_code);
            }
            $streams = $streams_getter->get();
            foreach ($streams as $stream) {
                $stream->collect_current_interval = (new Interval())->find($stream->collect_current_interval_id);
                $stream->online_interval = (new Interval())->find($stream->online_interval_id);
            }
            $server->streams = $streams;
        }
        return view('stream.list')->with(['servers' => $servers]);
    }

    public function add()
    {
        $intervals = (new Interval())->get();
        $servers = (new Server())->get();
        return view('stream.add')->with([
            'intervals' => $intervals,
            'servers' => $servers
        ]);
    }

    public function details($stream_id)
    {
        $stream = Stream::find($stream_id);
        if (!$stream)
            return back();
        $intervals = (new Interval())->get();

        return view('stream.modify')->with(['stream' => $stream, 'intervals' => $intervals]);
    }

    public function modify($stream_id)
    {
        $stream = Stream::where('id', $stream_id)->with(['collect_current_interval', 'collect_global_interval','validate_cycle','online_interval'])->first();

        $policies = Policy::where('stream_id', $stream_id)->with('interval')->orderBy('timestamp')->get();

        if (!$stream)
            return back();

        $stream->start = date('Y-m-d H:i:s', $stream->start_timestamp);
        $stream->end = date('Y-m-d H:i:s', $stream->end_timestamp);
        $intervals = (new Interval())->get();
        $servers = (new Server())->get();
        $validate_cycles = (new Validate_cycle())->get();

        return view('stream.modify')->with([
            'stream' => $stream,
            'intervals' => $intervals,
            'policies' => $policies,
            'servers' => $servers,
            'validate_cycles' => $validate_cycles
        ]);
    }

}
