$(document).ready(function () {
    setTimeout(function () {
        $.ajax({
            url: incrementViewsUrl,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#view-number').text(data.views);
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
                console.log("Status: " + status);
                console.log(xhr.responseText);
            }
        });
    }, 1000);
});

$(document).keydown(function (e) {
    if (e.keyCode === 13) {
        $("#commForm").submit();
    }
});
