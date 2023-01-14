<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class UpdateIsEnabledBookDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:enabledbookdelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update is_enabled_book_delete';

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
        $transactions =  Transaction::where('is_enabled_to_delete',true)->update(['is_enabled_to_delete' => false]);
    }
}
