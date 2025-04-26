
$(document).ready(function () {
    $('.like-comment-button').off('click').on('click', function () {
        const commentId = this.getAttribute('data-comment-id');
        var likeCountSpan = $(this).closest('.comment').find('.like-count');
        var type = $(this).find('i').data('type');
        var url = $this.dataset.url;
        var commentButtonLike = $(this).find('.like_button');
        $.ajax({
            method: 'post',
            url: likeUrl,
            data: {
                comment_id: commentId,
                type: type,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    likeCountSpan.text(response.like);
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },
            error: function () {
                $('#message').text('An error occurred. Please try again later.').css('color', 'red');
            }
        });
    });
});

