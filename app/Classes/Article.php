<?php /** @noinspection PhpVoidFunctionResultUsedInspection */


namespace App\Classes;


use App\ArticleHasCategory;
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
            $body = $this->getBodyNormal($html->filter('.arz-post-content')->html());
            $insert = $this->newArticle(['user_id' => 1, 'title' => $title, 'slug' => str_slug($title), 'body' => $body, 'image' => $img, 'base_url' => $url]);
            if ($insert) {
                $this->getCategories($html->filter('.arz-main-categories')->html(), $insert->id);
            }
        }
    }

    protected function getBodyNormal($postDate)
    {
        $crawler = new Crawler($postDate);
        $crawler->filter('body article .yarpp-related')->each(function (Crawler $crawler) {
            foreach ($crawler as $node) {
                $node->parentNode->removeChild($node);
            }
        });
        return $crawler->filter('body article')->html();
    }

    protected function getCategories($post, $articleId)
    {
        $crawler = new Crawler($post);
        foreach ($crawler->filter('body')->children() as $node) {
            $node = new Crawler($node);
            $node->filter('body')
                ->filter('.arz-main-category')->filter('a > span');
            $category_id = $this->spoilCategoryLink($node->text());
            ArticleHasCategory::query()->insert(['article_id' => $articleId, 'category_id' => $category_id]);
        }
    }

    protected function spoilCategoryLink($category, $baseUrl = null)
    {
        $c = \App\Category::query()->where('title', $category)->first();
        if ($c == null):
            $cate = new \App\Category(['title' => $category, 'slug' => str_slug($category), 'base_url' => $baseUrl]);
            $cate->save();
            return $cate->id;
        else:
            return $c->id;
        endif;
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
        $check = \App\Article::query()->where('title', $article['title'])->first();
        if (!$check):
            $insert = new \App\Article($article);
            $insert->save();
            $this->logger('added to database!');
            return $insert;
        else:
            return false;
        endif;
    }

}
