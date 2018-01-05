import $ from 'jquery';
import Cookies from 'js-cookie';
export default {
    init: function() {
        this.initAjax();
        this.bindAction();
    },
    initAjax: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
              that.checkLogin();

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
    },
    checkLogin: function() {
        const url = '/checkLogin';
        const that = this;
        $.ajax({
            url,
            success: function(data) {
                if (data !== '1') {
                    that.showLoginDialog();
                    return;
                }
            }
        })
    },
    showLoginDialog: function() {
        if ($('.loginDialog').length > 0) {
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
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    },
    showMessage: function(title, content) {
        $('.message-dialog h4').html(title);
        $('.message-dialog .modal-body').html(content);
        $('.message-dialog').modal();
    }
}
