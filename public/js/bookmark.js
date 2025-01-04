$(document).ready(function () {
    $('.bookmark-button').off('click').on('click', function () { // off() перед on()
        var bookmarkId = $(this).data('bookmark-id');
        var bookmarkButton = $(this).find('.bookmark_button ');

        $.ajax({
            url: '/bookmarks/add',
            method: 'POST',
            data: {
                bookmark_id: bookmarkId
            },
            success: function (response) {
                if (response.success) {
                    if (response.bookmark) {
                        bookmarkButton.addClass('bi bi-bookmark-fill color_grey').removeClass('bi bi-bookmark');
                    } else {
                        bookmarkButton.addClass('bi bi-bookmark').removeClass('bi bi-bookmark-fill color_grey');
                    }
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },
        });
    });
});
