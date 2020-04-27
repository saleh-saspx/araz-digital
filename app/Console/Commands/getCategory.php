<?php

namespace App\Console\Commands;

use App\Classes\Category;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class getCategory extends Command
{
    protected $page = 1;
    protected $pageLimit = 1;
    protected $url = [];
    protected $baseUrl = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:category';

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
        $url = $this->ask('category url : ', 'https://arzdigital.com/category/news/');
        $this->pageLimit = $this->ask('pagetion limit : ', '2');
        $this->baseUrl = $url;
        $this->getUrlPage();
        $callTime = time();
        $cache = Cache::store('file')->put($callTime, json_encode($this->url));
        \App\Cache::query()->insert(['key' => $callTime, 'value' => 'category', 'expiration' => 0]);
        $this->error('page Count : ' . count($this->url));
        return (new Category());
    }

    public function getUrlPage()
    {
        $client = new Client();
        $response = $client->request('get', $this->baseUrl . 'page/' . $this->page);
        if ($response && $this->page <= $this->pageLimit) {
            $this->info($this->baseUrl . 'page/' . $this->page . ' - Add');
            $this->url = array_merge($this->url, [$this->baseUrl . 'page/' . $this->page]);
            $this->page++;
            $this->info('get next page check');
            $this->getUrlPage();
        } else {
            $this->error('Url invalid');
        }
    }
}
