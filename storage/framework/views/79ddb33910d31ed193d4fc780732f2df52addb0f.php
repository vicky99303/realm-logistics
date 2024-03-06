
<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('dashboardcss'); ?>
        <link href="<?php echo e(asset('adminpanel')); ?>/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
              rel="stylesheet">
    <?php $__env->stopPush(); ?>
    <!--**********************************
            Content body start
    ***********************************-->
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">

                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Journey Collection</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userDatatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Start Point</th>
                                    <th>End Point</th>
                                    <th>Route List</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if($dataCoupon->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $dataCoupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($single->id); ?></td>
                                            <td><?php echo e($single->StartingPoint); ?></td>
                                            <td><?php echo e($single->DestinationPoint); ?></td>
                                            <td>
                                                <a href="<?php echo e(url('/ridertracker/' . $single->RiderID . '/journey/' . $single->id)); ?>">Journey</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!--**********************************
        Content body end
    ***********************************-->
    <?php $__env->startPush('dashboard'); ?>
        <script src="<?php echo e(asset('adminpanel/')); ?>/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo e(asset('adminpanel/')); ?>/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script>
            (function ($) {
                "use strict";
                $('#userDatatable').DataTable({
                    responsive: true
                });
                $('#userDatatable tbody').on('click', '.editModalClick', function () {
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
                        url: "<?php echo e(route('lockUser')); ?>",
                        data: {
                            '_token': "<?php echo e(csrf_token()); ?>",
                            'id': id,
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                }).on('click', '.unlock', function () {
                    let id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo e(route('unlockUser')); ?>",
                        data: {
                            '_token': "<?php echo e(csrf_token()); ?>",
                            'id': id,
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });
            })(jQuery);

        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpanel.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\realmlogostics\resources\views/adminpanel/journey.blade.php ENDPATH**/ ?>