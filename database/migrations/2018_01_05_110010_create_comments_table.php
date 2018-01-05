<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->comment('所属文章id');
            $table->integer('parent_id')->comment('是否有父评论, 若有则为回复');
            $table->integer('user_id')->comment('所属用户id');
            $table->text('content')->comment('评论内容');
            $table->enum('status', ['pending', 'active', 'deleted'])->comment('评论需要审核，审核通过才会显示在页面上');
            $table->integer('good_count')->comment('点赞数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
