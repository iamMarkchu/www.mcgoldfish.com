<?php

namespace App\Console\Commands\Website;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\Category;

class CheckUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:checkurl';

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
        $articles = Article::whereNull('url_name')->get();
        foreach ($articles as $article)
        {
            $this->info($article->title);
            $article->url_name = generate_url($article->title);
            $article->save();
            $this->info('success');
        }

        $categories = Category::whereNull('url_name')->get();
        foreach ($categories as $category)
        {
            $this->info($category->category_name);
            $category->url_name = generate_url($category->category_name);
            $category->save();
            $this->info('success');
        }
    }
}
