$(document).ready(function () {
    $('#search').on('keyup', function () {
        var value = $(this).val();
        $.ajax({
            method: 'get',
            url: '{{ route("live.search") }}',
            data: {'search': value},
            success: function (data) {
                $('.search-result').html(data).show();
            }
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // success: function (response) {
        //     console.log('Success:', response);
        // },
        // error: function (xhr, status, error) {
        //     console.error('Error:', status, error);
        //     console.error('Response:', xhr.responseText);
        // }
    });
    $(document).click(function (event) {
        let target = $(event.target);
        if (!target.closest('#search').length && !target.closest('.search-result').length) {
            $('.search-result').hide();
        }
    });

});
