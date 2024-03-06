(function($) {
    "use strict";
    $('#userDatatable').DataTable({
        responsive: true
    });
    $('#userDatatable').on('click', '.editModalClick', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let phone = $(this).data('phone');
        let email = $(this).data('email');
        let address = $(this).data('address');
        let qualification = $(this).data('qualification');
        let specialization = $(this).data('specialization');
        let link = $(this).data('link');
        $('#editid').val(id);
        $('#editname').val(name);
        $('#editphone').val(phone);
        $('#editemail').val(email);
        $('#editaddress').val(address);
        $('#editqualification').val(qualification);
        $('#editspecialization').val(specialization);
        $('#editlink').val(link);
        $('.editModal').modal('show');
    }).on('click', '.deleteModalClick', function () {
        let id = $(this).data('id');
        $('#deleteid').val(id);
        $('.deleteModal').modal('show');
    }).on('click', '.lock', function () {
        let id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: "{{route('lockUser')}}",
            data: {
                '_token': "{{csrf_token()}}",
                'id': id,
                'fs_id': fs_id,
                'product_id': product_id,
                'shop_id': shop_id
            },
            success: function (response) {
                if (response['status'] == 'true') {
                    $('.message').html(response['message']).show();
                }
            }
        });
    }).on('click', '.unlock', function () {
        let id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: "{{route('unlockUser')}}",
            data: {
                '_token': "{{csrf_token()}}",
                'id': id,
            },
            success: function (response) {
                if (response['status'] == 'true') {
                    $('.message').html(response['message']).show();
                }
            }
        });
    });
})(jQuery);
