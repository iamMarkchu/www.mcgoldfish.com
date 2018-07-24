import $ from 'jquery';
import Cookies from 'js-cookie';
// import './highlight.config';
import lazyload from 'lazyload';

export default {
    init: function() {
        alert(1);
        this.initAjax();
        this.initPlugins();
        this.bindAction();
    },
    initAjax: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },
    initPlugins: function () {
        // 文章块图片 lazy load
        let images = document.querySelectorAll(".img");
        new lazyload(images);
    },
    bindAction: function() {
      const that = this
      // 评论提交
      if ($('.commentSubmit').length > 0) {
          $('.commentSubmit').click(function() {
              if ($('#comment_content').val().length === 0) {
                  that.showMessage('错误提示！', '评论内容不能为空!!');
                  return ;
              }
              // 检查登录状态
              that.checkLogin('comment');

              that.submitComment();
          })
      }
      if ($('.commentCancel').length > 0) {
          $('.commentCancel').click(function() {
              $('#comment_content').val('');
              $('#showCommentBlock').collapse('toggle');
          })
      }
      // 点赞
      if ($('.comment-good').length > 0) {
          $('.comment-good').click(function() {
              const comment_id = $(this).attr('data-comment-id');
              const cookie_prefix = 'voted_comment_';
              let count = parseInt($(this).find('.good_count').html());
              const url = '/comments/vote';
              const type = 'POST';
              let data = { id: comment_id, action: 'add' };
              if ($(this).hasClass('voted_good')) {
                  count -= 1;
                  Cookies.remove(cookie_prefix + comment_id, '1');
                  $(this).removeClass('btn-success').removeClass('voted_good').addClass('btn-info').addClass('comment-good');
                  $(this).html('赞(<span class="good_count">'+ count +'</span>)');
                  data = { id: comment_id, action: 'delete' };
              } else {
                  count += 1;
                  Cookies.set(cookie_prefix + comment_id, '1');
                  $(this).removeClass('btn-info').removeClass('comment-good').addClass('btn-success').addClass('voted_good');
                  $(this).html('已赞(<span class="good_count">'+ count +'</span>)');
              }

              $.ajax({
                  url,
                  type,
                  data,
                  success: function(data) {
                      console.log(data);
                  }
              })
          })
      }
      // 左侧边栏 滚动事件
      // if ($('.columen-view-fixed').length > 0) {
      //    $(window).scroll(function() {
      //        if ($(this).scrollTop() > 200 && !$('.article-suspending-panel').hasClass('show')) {
      //            $('.article-suspending-panel').addClass('show');
      //        }else if ($(this).scrollTop() <= 200 && $('.article-suspending-panel').hasClass('show')) {
      //            $('.article-suspending-panel').removeClass('show');
      //        }
      //
      //    });
      // }
      // 右侧边栏 滚动时间
      if ($('.suspension-panel').length > 0) {
          $(window).scroll(function() {
              if ($(this).scrollTop() > 150 && !$('.suspension-panel-sub').hasClass('show')) {
                  $('.suspension-panel-sub').addClass('show');
              }else if ($(this).scrollTop() <= 200 && $('.suspension-panel-sub').hasClass('show')) {
                  $('.suspension-panel-sub').removeClass('show');
              }
          });
          $('.suspension-panel').click(function() {
              document.documentElement.scrollTop = 0;
          });
      }
      // 左侧边栏 wx hover事件
      if ($('.wx-share').length > 0) {
          $('.wx-share').hover(function (){
              $('.qrcode').removeClass('hidden');
              if($('.qrcode').hasClass('no_qrcode'))
              {
                  const url = '/qrcode';
                  const data = {type: 'article', id: $(this).attr('data-article-id')};
                  $.ajax({
                      url,
                      data,
                      type: 'POST',
                      dataType: 'html',
                      success: function(data) {
                        $('.qrcode').html(data);
                        $('.qrcode').removeClass('no_qrcode');
                      }
                  })
              }
          }, function () {
              $('.qrcode').addClass('hidden');
          });
      }

      // 点赞事件
      if ($('.vote').length > 0) {
          $('.vote').click(function (){
              // 检查登录状态
              that.checkLogin('vote');

              const article_id = $(this).attr('data-article-id');
              const cookie_prefix = 'voted_article_';
              let count = parseInt($('.vote_count').html());
              const url = '/articles/vote';
              const type = 'POST';
              let data = { id: article_id, action: 'add' };
              if ($(this).hasClass('voted_good')) {
                  count -= 1;
                  Cookies.remove(cookie_prefix + article_id, '1');
                  data = { id: article_id, action: 'delete' };
                  $(this).removeClass('voted_good');
                  $(this).find('i').removeClass('fa-heart').addClass('fa-heart-o');
              } else {
                  count += 1;
                  Cookies.set(cookie_prefix + article_id, '1');
                  $(this).addClass('voted_good');
                  $(this).find('i').removeClass('fa-heart-o').addClass('fa-heart');
              }

              $('.vote_count').html(count);
              $.ajax({
                  url,
                  type,
                  data,
                  success: function(data) {
                      console.log(data);
                  }
              });
          });
      }

      // 文章块 图片点击事件
      if($('.mark-markdown-block img').length > 0) {
          $('.mark-markdown-block img').click(function() {
              $('.viewImageDialog .modal-body').html($(this).clone());
              $('.viewImageDialog').modal();
          });
      }
    },
    checkLogin: function(type) {
        const url = '/checkLogin';
        const that = this;
        $.ajax({
            url,
            success: function(data) {
                if (data !== '1') {
                    const title = (type == 'comment') ? '评论需要登录': '点赞需要登录';
                    that.showLoginDialog(title);
                    return;
                }
            }
        });
    },
    showLoginDialog: function(title) {
        if ($('.loginDialog').length > 0) {
            $('.loginDialog .modal-title').html(title)
            $('.loginDialog').modal();
        }
    },
    submitComment: function() {
        // 提交到 后端处理
        const that = this;
        const url = '/comments';
        const type = 'POST';
        const data = { article_id: $('input[name="article_id"]').val(),content: $('#comment_content').val() }
        $.ajax({
            url,
            type,
            data,
            success: function(data) {
                if(data.content == '1') {
                    // 清空内容然后关闭评论区
                    $('#comment_content').val('');
                    $('#showCommentBlock').collapse('toggle');
                    that.showMessage('评论成功！', '待审核通过后，方可展示出来');
                    setTimeout(function(){
                        if (window.location.href.indexOf('#comment') === -1) {
                            window.location.href += '#comment';
                        }else{
                            window.location.reload();
                        }
                    }, 1000);
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    },
    showMessage: function(title, content) {
        $('.message-dialog h4').html(title);
        $('.message-dialog .modal-body').html(content);
        $('.message-dialog').modal();
    }
}
