$(document).on('change', '.js-role-update', function () {
    let isChecked =  $(this).is(':checked') ? 1 : 0;
    let permissionId = $(this).val();

    $.ajax({
        url: url,
        method: 'PUT',
        data: {
            permission_id: permissionId,
            status: isChecked,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Status updated successfully.');
            console.log(this.url);
        },
        error: function (error) {
            console.error('Error updating status.', error);
        }
    })
})
