<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/17 0017
 * Time: 下午 9:18
 */
//Stream Status
define('STREAM_STATUS_PRE_COLLECTION',0);//刚刚添加
define('STREAM_STATUS_COLLECTION',100);//收集图片中
define('STREAM_STATUS_COLLECTION_TO_MANUAL',150);//收集图片完成 等待处理(打标签/训练网络)
define('STREAM_STATUS_MANUAL',200);//打标签/训练网络中 等待上传模型
define('STREAM_STATUS_MANUAL_TO_ONLINE',250);// 等待上线
define('STREAM_STATUS_ONLINE',300);//线上运行中
define('STREAM_STATUS_ONLINE_VALIDATE',301);//todo  应该随机的抽取线上的图片来保存起来然后等待验证
define('STREAM_STATUS_ONLINE_TO_FIX',350);//线上运行中 待验证
define('STREAM_STATUS_ONLINE_FIX',400);//线上运行中 验证准确率过低
define('STREAM_STATUS_ERROR_OTHER',900);//其他错误
define('STREAM_STATUS_ERROR_IN_COLLECTION_IMG_NUM_NO_UP',931);//收集图片数量未增长
define('STREAM_STATUS_ERROR_IN_COLLECTION_PROCESS_ERROR',932);//收集图片中执行进程出错
define('STREAM_STATUS_ERROR_IN_ONLINE_PROCESS_ERROR',960);//线上图片中执行进程出错

//Stream CallBack Code
#不可重复 用来唯一分区回调的是一个什么事件
define('CALLBACK_CODE_COLLECT_OK',200); //本次截图成功 返回图片数量
define('CALLBACK_CODE_COLLECT_ERROR_1',500); //本次截图失败 一般是偶尔断流了
define('CALLBACK_CODE_MANUAL_MODEL_EXISTS',230); //模型存在
define('CALLBACK_CODE_MANUAL_MODEL_NOT_EXISTS',530); //模型不存在
define('CALLBACK_CODE_ONLINE_OK',260); //本次截图成功
define('CALLBACK_CODE_ONLINE_ERROR_1',560); //本次截图失败
define('CALLBACK_CODE_ONLINE_ERROR_2',561); //getLabel 返回 -1

//Server Status
define('SERVER_STATUS_OK',200);
define('SERVER_STATUS_ERROR_SCRIPT_RUN',500);
define('SERVER_STATUS_ERROR_OFF_LINE',510);

//Server CallBack Code
define('CALLBACK_CODE_SERVER_OK',200);
define('CALLBACK_CODE_SERVER_ERROR',500);

//Notify Type
define('ARR_NOTIFY_TYPE_NOTIFY',['App\Notifications\StreamStatusChange']);
define('ARR_NOTIFY_TYPE_ERROR',['App\Notifications\ServerError','App\Notifications\StreamError']);

//Other
define('STREAM_MAX_RETRY_NUM',3);
define('SERVER_MAX_RETRY_NUM',3);


