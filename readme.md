# www.mcgoldfish.com

## 简介
> 一个博客项目

## 更新日志

### 2018-07-21
``` sql
ALTER TABLE `blog_base`.`articles` CHANGE `category_id` `category_id` INT(10) UNSIGNED DEFAULT 0 NOT NULL COMMENT '外键，类别id', CHANGE `user_id` `user_id` INT(10) UNSIGNED DEFAULT 0 NOT NULL COMMENT '外键，用户id', CHANGE `title` `title` VARCHAR(255) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' NOT NULL COMMENT '文章标题', CHANGE `content` `content` TEXT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '文章内容，为markdown格式内容', CHANGE `display_order` `display_order` TINYINT(3) UNSIGNED DEFAULT 100 NOT NULL COMMENT '排序字段', CHANGE `status` `status` ENUM('active','republish','deleted') CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'republish' NOT NULL COMMENT '文章状态', CHANGE `source` `source` ENUM('origin','reprint') CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'reprint' NOT NULL COMMENT '文章来源', CHANGE `click_count` `click_count` INT(10) UNSIGNED DEFAULT 0 NOT NULL COMMENT '文章点击次数', CHANGE `vote_count` `vote_count` INT(10) UNSIGNED DEFAULT 0 NOT NULL COMMENT '点赞次数', CHARSET=utf8;
ALTER TABLE `blog_base`.`votes` CHARSET=utf8; 
```

## 开发计划
1. 评论功能 (已完成, 2018-01-05)
2. 优化article页面显示效果，注重移动端 (初步完成, 2018-01-05)
3. 微信分享功能
4. 网站底部代码  (初步完成, 2018-01-05)
5. 网站icon (已完成, 2018-10-09)
6. 优化首页显示效果，注重移动端 (初步完成, 2018-01-05)
7. article查看数统计以及点赞数统计 (点赞统计已完成)
8. https (已完成, 2018-01-08)
9. 网站seo优化
10. 部署百度统计，谷歌分析代码 (百度统计代码已完成, 2018-01-09)
11. 分类页面 (已完成, 2018-01-10)
12. 返回顶部，给我留言按钮 (返回顶部已完成, 2018-01-08)
13. 文章区域点赞，到达评论区按钮 (已完成, 2018-01-10)
14. 网站sitemap (已完成, 2018-01-10)
15. 接入七牛云，进行图片管理
16. 后台管理用户模块
17. 第三方登录
18. 优化logo (已完成, 2018-10-09)
19. 用户修改头像

### 评论功能

**表结构设计**

表名: comments

字段 | 含义
---|---
id | 主键id
article_id | 所属article
parent_id | 是否有父评论, 若有则为回复
user_id |  所属用户
content | 评论内容
status  | 评论需要审核，审核通过才会显示在页面上
good_count | 点赞数
created_at | 创建时间
updated_at | 最后更新时间

**评论流程**
1. 必须为登录用户
2. 本人发的评论可以删除

### 图片管理功能

**表结构设计**

字段 | 含义
---|---
id | 主键id
user_id |  所属用户
name | 图片名称
description | 描述
url_name | 图片访问地址
status  | 图片状态
created_at | 创建时间
updated_at | 最后更新时间