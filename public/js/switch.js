$(document).ready(function () {
    $('.js-switch').change(function () {
        let status = $(this).is(':checked') ? 1 : 0;
        let url = $(this).data('url');
        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Status updated successfully.');
            },
            error: function (error) {
                console.error('Error updating status.', error);
            }
        })
    });
});
