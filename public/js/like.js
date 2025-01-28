$(document).ready(function () {
    $('.like-button').off('click').on('click', function () {
        var postId = $(this).data('post-id');
        var button = $(this);
        var likeCountSpan = button.closest('.post').find('.like-count');
        var heartIcon = button.find('.red-heart');

        $.ajax({
            method: 'post',
            url: '/like-post',
            data: {
                post_id: postId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    likeCountSpan.text(response.likes);
                    if (response.liked) {
                        heartIcon.addClass('bi-heart-fill ').removeClass('bi-heart');
                    } else {
                        heartIcon.removeClass('bi-heart-fill').addClass('bi-heart');
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
