<?php

namespace App\Console\Commands;

use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DisabledReportPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportpublic:disabled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Desactiva el reporte publico por la fecha asignada en la tabla business';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('--------Disabled Report Public START-----------');
        Log::info('Get Data Business start');
        $business = Business::getBusiness();
        Log::info('Get Data Business end');
        Log::info('checking if public reporting is enabled ');
        if (!$business->show_report_public &&  !$business->show_report_yearly) {
            Log::info('public reporting is disabled ');
            Log::info('--------Disabled Report Public END-----------');
            return;
        }
        Log::info('public reporting is enabled');
        Log::info('checking if the date expired');
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $dateCloseShowReport = Carbon::parse($business->date_close_show);
        //dd($dateCloseShowReport);
        if (!$now->ne($dateCloseShowReport)) {
            Log::info('Date not expired');
            Log::info('--------Disabled Report Public END-----------');
            return;
        }
        Log::info('Date expired');
        Log::info('Disabling public report');
        $business->disabledReportPublic();
        Log::info('Disabled public report');
        Log::info('--------Disabled Report Public END-----------');
    }
}
