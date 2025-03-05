$(document).ready(function () {
    $('.sub-button').each(function () {
        var subId = $(this).data('author-id');
        if (subAuthors.includes(subId)) {
            $(this).text('Отписаться').removeClass('btn btn-secondary').addClass(' btn btn-outline-secondary')
        } else {
            $(this).text('Подписаться').removeClass('btn btn-outline-secondary').addClass('btn btn-secondary');
        }
    });

    $('.sub-button').on('click', function () {
        var subId = $(this).data('author-id');

        $.ajax({
            url: '/subscriptions',
            method: 'POST',
            data: {
                sub_id: subId
            },
            success: function (response) {
                if (response.success) {
                    if (response.sub) {
                        $('.sub-button[data-author-id="' + subId + '"]').text('Отписаться').removeClass('btn btn-secondary').addClass('btn btn-outline-secondary');
                    } else {

                        $('.sub-button[data-author-id="' + subId + '"]').text('Подписаться').removeClass('btn btn-outline-secondary').addClass('btn btn-secondary');
                    }
                } else {
                    $('#message').text(response.message).css('color', 'red');
                }
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка при добавлении/удалении закладки');
            }
        });
    });
});
