<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->default(0)->comment('外键，类别id');
            $table->integer('user_id')->unsigned()->default(0)->comment('外键，用户id');
            $table->string('title')->default('')->comment('文章标题');
            $table->text('content')->default('')->comment('文章内容，为markdown格式内容');
            $table->tinyInteger('display_order')->default(0)->unsigned()->comment('排序字段');
            $table->enum('status', ['active', 'republish', 'deleted'])->default('republish')->comment('文章状态');
            $table->enum('source', ['origin', 'reprint'])->default('origin')->comment('文章来源');
            $table->integer('click_count')->unsigned()->default(0)->comment('文章点击次数');
            $table->integer('vote_count')->unsigned()->default(0)->comment('点赞次数');
            $table->timestamps();

            // index
            $table->index('category_id');
            $table->index('user_id');
            $table->unique('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
