@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
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
                        <h4 class="card-title">New Product</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">{{$errors->first()}}</div>
                        @elseif(session()->has('message'))
                            <div class="alert alert-success">{{ session()->get('message') }}</div>
                        @endif
                        <form role="form" id="product_add_form" method="POST" action="{{route('addProduct')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row credit-card-box">
                                <div class="form-group col-md-6">
                                    <label>FS_ID</label>
                                    <select class="form-control" name="fs_id" id="fs_id" required>
                                        <option value="">Select FS ID / APP ID</option>
                                        @if($fs_id->isNotEmpty())
                                            @foreach($fs_id as $singleFSID)
                                                <option value="{{$singleFSID->app_id}}">{{$singleFSID->app_id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Shop Name</label>
                                    <select class="form-control" id="shop" name="shop" required>
                                        <option>Select Shop</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Select Product Image</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('product_img') is-invalid @enderror" name="product_img">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                    @error('product_img')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>name</label>
                                    <input class="form-control" type="text" id="name" name="name" value=""
                                           required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>category_id</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option>Select Category</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Etalase</label>
                                    <select class="form-control" id="etalase" name="etalase" required>
                                        <option>Select Etalase</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>description</label>
                                    <textarea class="form-control" type="text" id="description" name="description"
                                              required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Price</label>
                                    <input class="form-control" type="number" id="price" min="100" name="price" value="" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="UNLIMITED">UNLIMITED</option>
                                        <option value="LIMITED">LIMITED</option>
                                        <option value="EMPTY">EMPTY</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>weight</label>
                                    <input class="form-control" type="text"
                                           id="weight"
                                           name="weight"
                                           value=""
                                           required
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Stock</label>
                                    <input class="form-control" type="text"
                                           id="stock"
                                           name="stock"
                                           value=""
                                           required
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Weight unit</label>
                                    <select class="form-control" id="weight_unit" name="weight_unit" required>
                                        <option value="GR">GR (gram)</option>
                                        <option value="KG">KG (kilogram)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Condition</label>
                                    <select class="form-control" required name="condition" id="condition">
                                        <option value="NEW">NEW</option>
                                        <option value="USED">USED</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Price Currency</label>
                                    <select class="form-control" required name="price_currency" id="price_currency">
                                        <option value="IDR">IDR</option>
                                    </select>
                                </div>
                            </div>
                            <button class="submit subscribe btn btn-success" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    @push('newProductjs')
    <script>
        $('#fs_id').on('change', function () {
            let strValue = $(this).val();
            if (strValue != "") {
                $.ajax({
                    type: 'POST',
                    url: "{{route('getShopInfo')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'fs_id': strValue
                    },
                    success: function (response) {
                        for (var i = 0; i < Object.keys(response["data"]['storeDetail']).length; i++) {
                            $("select#shop").append('<option value="' + response['data']['storeDetail'][i]['shop_id'] + '">' + response['data']['storeDetail'][i]['shop_name'] + '</option>');
                        }
                        for (var j = 0; j < Object.keys(response["data"]['categoryDetail']).length; j++) {
                            if (response['data']['categoryDetail'][j]) {
                                $("select#category").append('<option value="' + response['data']['categoryDetail'][j]['id'] + '">' + response['data']['categoryDetail'][j]['name'] + '</option>');
                            }
                        }
                        for (var i = 0; i < Object.keys(response["data"]['etalaseDetail']).length; i++) {
                            $("select#etalase").append('<option value="' + response['data']['etalaseDetail'][i]['etalase_id'] + '">' + response['data']['etalaseDetail'][i]['etalase_name'] + '</option>');
                        }
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
