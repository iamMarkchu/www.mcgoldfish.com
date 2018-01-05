# www.mcgoldfish.com

## 简介
> 一个博客项目

## 开发计划
1. 评论功能
2. 优化article页面显示效果，注重移动端
3. 微信分享功能
4. 网站底部代码
5. 网站icon
6. 优化首页显示效果，注重移动端
7. article查看数统计以及点赞数统计

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
3. 


