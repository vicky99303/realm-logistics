(function ($) {
    "use strict";
    $('#packageDatatable').DataTable({
        responsive: true
    })
        .on('click', '.editModalClick', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let marketplace = $(this).data('marketplace');
            let receiving_chat = $(this).data('receiving_chat');
            let uploading_products = $(this).data('uploading_products');
            let receiving_orde = $(this).data('receiving_orde');
            let price = $(this).data('price');
            let limit = $(this).data('limit');
            $('#editid').val(id);
            $('#editname').val(name);
            $('#editmarketplace').val(marketplace);
            $('#editreceiving_chat').val(receiving_chat);
            $('#edituploading_products').val(uploading_products);
            $('#editreceiving_orde').val(receiving_orde);
            $('#editlimit').val(limit);
            $('#editprice').val(price);
            $('.editModal').modal('show');
        })
        .on('click', '.deleteModalClick', function () {
            let id = $(this).data('id');
            $('#deleteid').val(id);
            $('.deleteModal').modal('show');
        });
})(jQuery);
