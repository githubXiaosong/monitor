<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $str;
    /**
     * Create a new job instance.
     *  实例化传的类
     * @return void
     */
    public function __construct($str)
    {
        //
        $this->$str = $str;
    }

    /**
     * Execute the job.
     * 执行时传的类
     * @return void
     */
    public function handle()
    {
        //
        Log::info("这个一个info级别的日志",['name'=>$this->$str]);

    }
}
