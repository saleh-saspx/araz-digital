<?php


namespace App\Classes;


use App\Cache;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Monolog\Logger;


class Category
{
    protected $cache = null;
    protected $postList = array();

    public function __construct()
    {
        $this->cache = Cache::query()->where('value', 'category')->where('expiration', 0)->get();
        $this->handle();
    }

    public function logger($text, $name = 'Category')
    {
        $log = new Logger($name);
        return $log->info('Status', ['get : ' . $text]);
    }

    public function handle()
    {
        if ($this->cache != null) {
            foreach ($this->cache as $builder) {
                $data = \Illuminate\Support\Facades\Cache::get($builder->key);
                $urls = json_decode($data);
                foreach ($urls as $url) {
                    $this->getCategory($url);
                }
                Cache::query()->where('key', $builder->key)->delete();
                \Illuminate\Support\Facades\Cache::forget($builder->key);
            }
            $keys = 'Article-' . time();
            $cache = \Illuminate\Support\Facades\Cache::store('file')->put($keys, json_encode($this->postList));
            \App\Cache::query()->insert(['key' => $keys, 'value' => 'article', 'expiration' => 0]);
        }
        dump($this->postList, 'Articles Url Added');
    }

    protected function getCategory($url)
    {
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);
        $posts = $crawler->filter('body')->filter('.arz-posts')->children();
        foreach ($posts as $post) {
            $this->spoilLink($post);
        }
    }

    protected function spoilLink($post)
    {
        $cr = new Crawler($post);
        foreach ($cr->links() as $link) {
            $this->logger($link->getUri(), 'Article Add');
            $this->postList = array_merge($this->postList, [$link->getUri()]);
            sleep(1);
        }
    }
}

