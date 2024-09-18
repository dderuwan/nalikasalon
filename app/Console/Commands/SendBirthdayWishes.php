<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EmployeeController;

class SendBirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:wishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday wishes to employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new EmployeeController(); // Replace with the controller you defined the function in
        $controller->sendBirthdayWishes();

        $this->info('Birthday wishes sent successfully!');
    }
}
