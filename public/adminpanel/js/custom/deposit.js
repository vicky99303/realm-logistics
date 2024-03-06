(function ($) {
    "use strict";
    $('#depositDatatable').DataTable({
        responsive: true
    })
        .on('click', '.editModalClick', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            $('#editid').val(id);
            $('#editname').val(name);
            $('#editprice').val(price);
            $('.editModal').modal('show');
        })
        .on('click', '.deleteModalClick', function () {
            let id = $(this).data('id');
            $('#deleteid').val(id);
            $('.deleteModal').modal('show');
        });
})(jQuery);
