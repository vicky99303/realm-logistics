@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{asset('adminpanel/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('adminpanel/css/style.css')}}" rel="stylesheet">
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item "><a href="{{route('product')}}">Product List</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">New</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">New Product</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" id="product_add_form" method="POST" action="javascript:void(0);">
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
                                        <label>name</label>
                                        <input class="form-control" type="text" id="name" name="pname" value=""
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
                                        <label>price</label>
                                        <input class="form-control" type="text" id="price" name="price" value=""
                                               required/>
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
                                        <label>min_order</label>
                                        <input class="form-control" type="text" id="min_order" value="" name="min_order"
                                               required/>
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
                                        <label>weight_unit</label>
                                        <select class="form-control" id="weight_unit" name="weight_unit" required>
                                            <option value="GR">GR (gram)</option>
                                            <option value="KG">KG (kilogram)</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>condition</label>
                                        <select class="form-control" required name="condition" id="condition">
                                            <option value="NEW">NEW</option>
                                            <option value="USED">USED</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Price Currency</label>
                                        <select class="form-control" required name="price_currency" id="price_currency">
                                            <option value="IDR">IDR</option>
                                            <option value="USD">USD</option>
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
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
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
            $('#product_add_form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{route('addProduct')}}",
                    data: $(this).serializeArray(),
                    success: function (response) {
                        console.log(response);
                    }
                });
            });
        </script>
    @endpush
@endsection
