<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Transfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected  $outflow = ''; 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $outflow)
    {
        $this->outflow = $outflow;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app('log')->info('进去队列,时间:'. date('Y-m-d H:i:s',time()) . ' 数据:' . json_encode($this->outflow));
    }

    /**
     *  队列失败
     */
    public function failed(Exception $e)
    {
        app('log')->info('进去队列,时间:'. date('Y-m-d H:i:s',time()) . ' 错误信息:' . $e->getMessage());
    }    
}
