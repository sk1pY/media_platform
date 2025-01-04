// LIKE
$(document).ready(function () {
    $('.likedislike-comment-button').off('click').on('click', function () {
        const commentId = this.getAttribute('data-comment-id');
        var likeCountSpan = $(this).closest('.comment').find('.like-count');
        var dislikeCountSpan = $(this).closest('.comment').find('.dislike-count');
        var type = $(this).find('i').data('type');

        var commentButtonLike = $(this).find('.like_button');
        var commentButtonDislike = $(this).find('.dislike_button');
        console.log(commentButtonDislike);
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
                    dislikeCountSpan.text(response.dislike);
                    if (response.liked) {
                        commentButtonLike.addClass('bi bi-hand-thumbs-up-fill').removeClass('bi bi-hand-thumbs-up');
                        commentButtonDislike.addClass('bi bi-hand-thumbs-down').removeClass('bi bi-hand-thumbs-down-fill');
                    } else {
                        commentButtonLike.addClass('bi bi-hand-thumbs-up').removeClass('bi bi-hand-thumbs-up-fill');
                    }
                    if (response.disliked) {
                        commentButtonDislike.addClass('bi bi-hand-thumbs-down-fill').removeClass('bi bi-hand-thumbs-up');
                        commentButtonLike.addClass('bi bi-hand-thumbs-up').removeClass('bi bi-hand-thumbs-up-fill');
                    } else {
                        commentButtonDislike.addClass('bi bi-hand-thumbs-down').removeClass('bi bi-hand-thumbs-down-fill');

                    }
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
//DISLIKE
$(document).ready(function () {
    $('.dislike-comment-button').off('click').on('click', function () {
        const commentId = this.getAttribute('data-comment-id');
        var likeCountSpan = $(this).closest('.comment').find('.dislike-count');

        var commentButtonDislike = $(this).find('.dislike_button');
        var commentButtonLike = $(this).find('.like_button');

        $.ajax({
            method: 'post',
            url: '/comments/dislike',
            data: {
                comment_id: commentId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    likeCountSpan.text(response.dislike);
                    if (response.liked) {
                        commentButtonDislike.addClass('bi bi-hand-thumbs-down-fill').removeClass('bi bi-hand-thumbs-down');
                        commentButtonLike.addClass('bi bi-hand-thumbs-up').removeClass('bi bi-hand-thumbs-up-fill');
                    } else {
                        commentButtonDislike.addClass('bi bi-hand-thumbs-down').removeClass('bi bi-hand-thumbs-down-fill');
                    }
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
