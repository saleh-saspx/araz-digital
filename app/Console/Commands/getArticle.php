<?php

namespace App\Console\Commands;

use App\Classes\Article;
use App\Classes\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class getArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('Start Crawler Articles');
        return (new Article());
    }
}
