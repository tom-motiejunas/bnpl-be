<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserLoanController;
use Illuminate\Console\Command;
use Laravel\Cashier\Exceptions\IncompletePayment;

class CollectLoans extends Command
{
    protected $signature = 'app:collect-loans';

    protected $description = 'Command that collects loans from users';

    public function __construct(protected UserLoanController $user_loan_controller)
    {
        parent::__construct();
    }

    /**
     * @throws IncompletePayment
     */
    public function handle(): void
    {
        $this->user_loan_controller->collectLoans();
    }
}
