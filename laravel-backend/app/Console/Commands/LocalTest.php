<?php

namespace App\Console\Commands;

use App\Usecases\Sale\GenerateSaleReportUsecase;
use Illuminate\Console\Command;

class LocalTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:local-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenerateSaleReportUsecase $usecase)
    {
        echo $usecase->execute();
    }
}
