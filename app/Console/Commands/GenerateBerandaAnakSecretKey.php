<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateBerandaAnakSecretKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beranda-anak:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate beranda anak secret key for API authentication';

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
        $new_secret = md5(str_random(5)) . '-' . str_random(59);

        config(['beranda_anak.secret' => $new_secret]);

        $fp = fopen(base_path() .'/config/beranda_anak.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('beranda_anak'), true) . ';');
        fclose($fp);

        $this->info('Your new secret key: ' . $new_secret);
    }
}
