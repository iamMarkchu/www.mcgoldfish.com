<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->addProvider(new \BlogArticleFaker\FakerProvider($faker));
        // 创建用户
        $user = new User;
        $user->name = 'markchu';
        $user->email = 'demo@163.com';
        $user->password = bcrypt('demo123');
        $user->remember_token = str_random(10);
        $user->avatar = 'https://avatars3.githubusercontent.com/u/14805449?s=460&v=4';
        $user->status = 'pending';
        $user->role = 'editor';
        $user->save();

        // 创建类别
        $categoryArr = ['php', 'mysql', '人工智能', '前端', '后端', '工具资源', '阅读'];
        foreach ($categoryArr as $category_name)
        {
            $category = new Category;
            $category->category_name = $category_name;
            $category->parent_id = 0;
            $category->display_order = 99;
            $category->save();
        }

        // 创建文章
        $articleCount = 100;
        for ($i=0;$i<$articleCount;$i++)
        {
            $article = new Article;

            $article->user_id = $user->id;
            $article->category_id = Category::orderByRaw('RAND()')->first()->id;
            $article->title = $faker->unique()->articleTitle;
            $article->content = $faker->articleContentMarkdown;
            $article->image = '';
            $article->display_order = 99;
            $article->status = 'republish';
            $article->source = 'origin';
            $article->click_count = $faker->randomDigitNotNull;
            $article->vote_count = $faker->randomDigitNotNull;
            $article->save();
        }
    }
}
