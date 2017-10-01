<?php

namespace App\Http\Controllers\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    public function markNotificationsAsRead()
    {

        $validator = Validator::make(
            rq(),
            [
                'type' => 'required|in:notify,error'
            ],
            [
            ]
        );
        if ($validator->fails())
            return back()->with('err_msg', $validator->messages());


        if (Auth::check()) {

            $rm_arr = null;

            if (rq('type') == 'notify') {
                $rm_arr = ARR_NOTIFY_TYPE_NOTIFY;

            } else if (rq('type') == 'error') {
                $rm_arr = ARR_NOTIFY_TYPE_ERROR;
            }

            foreach (Auth::user()->unreadNotifications as $notification) {
                if (in_array($notification->type, $rm_arr)) {
                    $notification->markAsRead();
                }
            }

            return back()->with('suc_msg', '操作成功');
        } else {
            return redirect('home');
        }
    }
}
