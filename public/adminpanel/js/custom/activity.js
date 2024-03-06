(function ($) {
    "use strict";
    var table = $('#activityDatatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'selected',
            'selectedSingle',
            'selectAll',
            'selectNone',
            'selectRows',
            'selectColumns',
            'selectCells'
        ],
        responsive: true,
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        order: [[1, 'asc']]
    });
    // single select and deselect controlling
    $('#activityDatatable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    // multi select and deselect checkbox functionality
    table.on("click", "th.select-checkbox", function () {
        if ($("th.select-checkbox").hasClass("selected")) {
            table.rows().deselect();
            $("th.select-checkbox").removeClass("selected");
        } else {
            table.rows().select();
            $("th.select-checkbox").addClass("selected");
        }
    }).on("select deselect", function () {
        ("Some selection or deselection going on")
        if (table.rows({
            selected: true
        }).count() !== table.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
        } else {
            $("th.select-checkbox").addClass("selected");
        }
    });
    // delete function action code
    $('#button').click(function () {
        table.rows('.selected').remove().draw(false);
    });

    $('#activityDatatable').on('click', '.editModalClick', function () {
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
    });

    $('#activityDatatable').on('click', '.deleteModalClick', function () {
        let id = $(this).data('id');
        $('#deleteid').val(id);
        $('.deleteModal').modal('show');
    });
})(jQuery);
