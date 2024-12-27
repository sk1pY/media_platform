$(document).ready(function () {
    $('.bookmark-button').on('click', function () {
        var bookmarkId = $(this).data('bookmark-id');
        var bookmarkButton = $(this).find('.fa-bookmark');

        $.ajax({
            url: '/bookmarks/add',
            method: 'POST',
            data: {
                bookmark_id: bookmarkId
            },
            success: function (response) {
                if (response.success) {
                    if (response.bookmark) {
                        bookmarkButton.addClass('fa-solid yellow-bookmark');
                    } else {
                        bookmarkButton.removeClass('fa-solid ');
                    }
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },
        });
    });
});
