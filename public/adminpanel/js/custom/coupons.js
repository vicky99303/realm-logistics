(function ($) {
    "use strict";
    $('#couponsDatatable').DataTable({
        responsive: true
    }).on('click', '.editModalClick', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let opening_date = $(this).data('opening_date');
        let closing_date = $(this).data('closing_date');
        let discount_amount = $(this).data('discount_amount');
        let limit = $(this).data('limit');
        $('#editid').val(id);
        $('#editname').val(name);
        $('#editopening_date').val(opening_date);
        $('#editclosing_date').val(closing_date);
        $('#editdiscount_amount').val(discount_amount);
        $('#editlimit').val(limit);
        $('.editModal').modal('show');
    }).on('click', '.deleteModalClick', function () {
        let id = $(this).data('id');
        $('#deleteid').val(id);
        $('.deleteModal').modal('show');
    });
})(jQuery);
