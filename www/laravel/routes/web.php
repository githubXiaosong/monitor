<?php

function rq($key = null)
{
    return ($key == null) ? \Illuminate\Support\Facades\Request::all() : \Illuminate\Support\Facades\Request::get($key);
}
function suc($data=null){
    $ram=['status'=>0];
    if($data)
    {
        $ram['data']=$data;
        return $ram;
    }
    return $ram;
}
function err($code,$data=null){
    if($data)
        return ['status'=>$code,'data'=>$data];
    return ['status'=>$code];
}


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/test', 'TestController@test');

Route::group(['prefix' => 'stream'], function () {
    Route::get('list', 'Page\StreamController@lst')->middleware('auth');
    Route::get('add', 'Page\StreamController@add')->middleware('auth');
    Route::get('details/{stream_id}', 'Page\StreamController@details')->middleware('auth');
    Route::get('modify/{stream_id}', 'Page\StreamController@modify')->middleware('auth');
});

Route::group(['prefix' => 'api'], function () {
    Route::post('createStream', 'Service\StreamController@createStream');
    Route::post('changeStream', 'Service\StreamController@changeStream');
    Route::post('addInterval', 'Service\StreamController@addInterval');
    Route::post('deleteInterval', 'Service\StreamController@deleteInterval');
    Route::post('deleteStream', 'Service\StreamController@deleteStream');
    Route::post('toggleForbidden', 'Service\StreamController@toggleForbidden');
    Route::post('streamReCollection', 'Service\StreamController@streamReCollection');
    Route::post('manualStream', 'Service\StreamController@manualStream');
    Route::post('onlineStream', 'Service\StreamController@onlineStream');
    Route::post('offlineStream', 'Service\StreamController@offlineStream');
    Route::post('createServer', 'Service\ServerController@createServer');
    Route::post('markNotificationsAsRead', 'Service\CommonController@markNotificationsAsRead');

    Route::any('getStreamList', 'Service\StreamController@getStreamList');//todo 收集图片服务器获取流列表时调用|现在还是get方法调用 需要把api认证加上去
    Route::any('streamStatusCallBack', 'Service\StreamController@streamStatusCallBack');//todo 需要把api认证加上去
    Route::any('streamClassifyCallBack', 'Service\StreamController@streamClassifyCallBack');//todo 需要把api认证加上去
    Route::any('serverStatusCallBack', 'Service\ServerController@serverStatusCallBack');//todo 需要把api认证加上去

});

