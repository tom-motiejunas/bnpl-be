<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserLoanController;
use Illuminate\Console\Command;
use Laravel\Cashier\Exceptions\IncompletePayment;

class CollectLoans extends Command
{
    public function __construct(protected UserLoanController $user_loan_controller)
    {
        parent::__construct();
    }

    protected $signature = 'app:collect-loans';

    protected $description = 'Command that collects loans from users';

    /**
     * @throws IncompletePayment
     */
    public function handle(): void
    {
        $this->user_loan_controller->collectLoans();
    }
}
