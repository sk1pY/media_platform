$(document).ready(function () {
    $('.js-switch').change(function () {
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Status updated successfully.');
                console.log(this.status);
            },
            error: function (error) {
                console.error('Error updating status.', error);
            }
        })
    });
});
