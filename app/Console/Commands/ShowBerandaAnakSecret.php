<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowBerandaAnakSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beranda-anak:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Beranda Anak secret key';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Current Secret Key: ' . config('beranda_anak.secret'));
    }
}
