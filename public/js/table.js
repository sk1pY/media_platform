$(document).ready(function () {
    $("#table").DataTable({
        "paging": false,
        "searching": true,
        "info": false
    });

    // Инициализация сортировки строк таблицы
    $("#tablecontents").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6
    });
});
