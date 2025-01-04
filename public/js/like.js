$(document).ready(function () {
    $('.like-button').off('click').on('click', function () {
        var postId = $(this).data('post-id');
        var button = $(this);
        var likeCountSpan = button.closest('.comment').find('.like-count');
        var heartIcon = button.find('.fa-heart');

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
                        heartIcon.addClass('fa-solid red-heart');
                    } else {
                        heartIcon.removeClass('fa-solid ');
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
