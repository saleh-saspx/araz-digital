<?php


namespace App\Classes;


use App\Cache;
use GuzzleHttp\Client;
use Monolog\Logger;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class Article
{
    protected $cache = null;

    public function logger($text, $name = 'Article')
    {
        $log = new Logger($name);
        return $log->info('Status', ['get : ' . $text]);
    }

    public function __construct()
    {
        $this->cache = Cache::query()->where('value', 'article')->where('expiration', 0)->get();
        $this->handle();
    }

    public function handle()
    {
        if ($this->cache != null) {
            foreach ($this->cache as $builder) {
                $data = \Illuminate\Support\Facades\Cache::get($builder->key);
                $urls = json_decode($data);
                foreach ($urls as $url) {
                    $this->getUrl($url);
                }
                Cache::query()->where('key', $builder->key)->delete();
                \Illuminate\Support\Facades\Cache::forget($builder->key);
            }
        }
    }

    protected function getUrl($url)
    {
        if ($this->checkUrl($url) == 200) {
            $browser = new HttpBrowser(HttpClient::create());
            $crawler = $browser->request('GET', $url);
            $html = $crawler->filter('body')->filter('.arz-post')->children();
            $header = $html->filter('.arz-post-header');
            $img = $this->getImage($header->filter('.arz-post-image')->html());
            $title = $this->getTitle($header->filter('.arz-post-title')->html());
            $body = $html->filter('.arz-post-content')->filter('article')->html();
            $this->newArticle(['user_id' => 1, 'title' => $title, 'slug' => str_slug($title), 'body' => $body, 'image' => $img, 'base_url' => $url]);
        }
    }

    protected function checkUrl($url)
    {
        $client = new Client();
        $response = $client->request('get', $url);
        return $response->getStatusCode();
    }

    protected function getImage($post)
    {
        $img = new Crawler($post);
        return $img->filter('img')->image()->getUri();
    }

    protected function getTitle($post)
    {
        $img = new Crawler($post);
        return $img->filter('h1')->filter('a')->text();
    }

    protected function newArticle($article)
    {
        $insert = (new \App\Article($article))->save();
        $this->logger('added to database!');
        return $insert;
    }
}
