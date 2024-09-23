<?php

namespace App\Jobs;

use App\Services\SmsService\SatiaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsNotification implements ShouldQueue
{
    use Queueable;
    public $timeout = 0;

    public $message=null;
    public $satiaService;
    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message=$message;
        $this->satiaService=new SatiaService();

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $financeTransactionFail=\App\Models\FinanceTransaction::GetFailTransaction('2024-09-21')->chunk(100,function ($finance){
            foreach ($finance as $key=> $financeUser)
            {
                if (isset($financeUser->user->mobile))
                {
                    $this->satiaService->send($this->message, $financeUser->user->mobile, '30006928', 'New137', '140101101');

                }
            }
        });


    }
    public function tries(): int
    {
        return 2;
    }
}
