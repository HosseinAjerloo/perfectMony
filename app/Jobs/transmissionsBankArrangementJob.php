<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\TransmissionsBank;
use AyubIRZ\PerfectMoneyAPI\PerfectMoneyAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class transmissionsBankArrangementJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 0;
    protected $numberOFVouchers =
        [
            1 => 10,
            2 => 10,
            3 => 5,
            4 => 5,
            5 => 7,
            6 => 5,
            7 => 2,
            8 => 2,
            9 => 2,
            10 => 4,
            20 => 4,
            16 => 1,
            17 => 1,
            18 => 1,
            25 => 1

        ];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            $PM = new PerfectMoneyAPI(env('PM_ACCOUNT_ID'), env('PM_PASS'));
            foreach ($this->numberOFVouchers as $amount => $numberOFVoucher) {
                $getNewVoucherInDatabaseTable = TransmissionsBank::where('status', 'new')->where("payment_amount", $amount)->count();

                $numberOfGenerate = $numberOFVoucher - $getNewVoucherInDatabaseTable;

                if ($numberOfGenerate > 0) {

                    for ($i = 0; $i < $numberOfGenerate; $i++) {
                        $PMeVoucher = $PM->transferFund(env('ORIGIN_OF_TRANSFER'), env('PAYER_ACCOUNT'), $amount);
                        if (is_array($PMeVoucher) and isset($PMeVoucher['PAYMENT_BATCH_NUM']) and isset($PMeVoucher['Payee_Account'])) {

                            TransmissionsBank::create(
                                [
                                    'payment_amount' => $amount,
                                    'payment_batch_num' => $PMeVoucher['PAYMENT_BATCH_NUM'],
                                    'status' => 'new',
                                    'description' => 'انتقال ووچر به صورت اتوماتیک'
                                ]
                            );
                            sleep(3);
                        } else {
                            Log::emergency(json_encode($PMeVoucher));
                        }

                    }
                }

            }
        } catch (\Exception $e) {
            Log::emergency(PHP_EOL . $e->getMessage() . PHP_EOL);
            Ticket::create([
                'subject' => 'خرابی در پرفکت مانی',
                'user_id' => 1,
                'status' => 'closed'
            ]);
        }

    }
}
