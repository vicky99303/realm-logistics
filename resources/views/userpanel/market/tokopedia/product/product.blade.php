@extends('userpanel.layout.app')
@section('content')
    <link href="{{asset('adminpanel')}}/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
          rel="stylesheet">
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
                        <h4 class="card-title">Product List</h4>
                        <div class="btn-group mb-2  btn-group-sm float-right ">
                            <a href="{{route('new-product')}}" class="btn btn-primary btn-xs float-right">Add
                                Product</a>
                            <a href="#" class="btn btn-primary btn-xs float-right">Export Product</a>
                            <a href="#" class="btn btn-primary btn-xs float-right">Import Product</a>
                            <a href="{{route('tokopedia-product-refresh',['tokenId'=>$tokenId,'fs_id'=>$tokenId,'shop_id'=>$shop_id])}}"
                               class="btn btn-primary btn-xs float-right">Refresh Data</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">{{$errors->first()}}</div>
                        @endif
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                        <div class="alert alert-success message" style="display: none"></div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Categories</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image Product</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($productInfo->isNotEmpty())
                                    @foreach($productInfo as $singleProduct)
                                        <tr>
                                            <td>{{$singleProduct->id}}</td>
                                            <td>
                                                @if($singleProduct->getCategories->isNotEmpty())
                                                    <ol>
                                                        @foreach($singleProduct->getCategories as $singleCategory)
                                                            <li>
                                                                <span>&bull;&nbsp;</span>{{$singleCategory->name}}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @endif
                                            </td>
                                            <td>{{$singleProduct->name}}</td>
                                            <td>{{$singleProduct->price_value}}</td>
                                            <td>{{$singleProduct->getStock->main_stock}}</td>
                                            <td>
                                                @if($singleProduct->getImages->isNotEmpty())
                                                    @foreach($singleProduct->getImages as $singleImage)
                                                        <img class="img-thumbnail"
                                                             src="{{$singleImage->thumbnail_url}}"
                                                             alt="productImage"/>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{($singleProduct->status == 1)?'Active':'Not Active'}}</td>
                                            <td>
                                                <button type="button"
                                                        data-id="{{$singleProduct->id}}"
                                                        data-fs_id="{{$singleProduct->fs_id}}"
                                                        data-product_id="{{$singleProduct->product_id}}"
                                                        data-shop_id="{{$singleProduct->shop_id}}"
                                                        data-status="{{$singleProduct->status}}"
                                                        data-name="{{$singleProduct->name}}"
                                                        data-category_id="{{$singleProduct->child_category_id}}"
                                                        data-short_desc="{{$singleProduct->short_desc}}"
                                                        data-price_currency="{{$singleProduct->price_currency}}"
                                                        data-price="{{$singleProduct->price_value}}"
                                                        data-weight_value="{{$singleProduct->weight_value}}"
                                                        data-weight_unit="{{$singleProduct->weight_unit}}"
                                                        data-condition="{{$singleProduct->condition}}"
                                                        data-stock="{{$singleProduct->main_stock}}"
                                                        class="btn btn-xxs editButton">
                                                    <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                </button>
                                                @if($singleProduct->status == 1)
                                                    <button type="button"
                                                            data-id="{{$singleProduct->id}}"
                                                            data-fs_id="{{$singleProduct->fs_id}}"
                                                            data-product_id="{{$singleProduct->product_id}}"
                                                            data-shop_id="{{$singleProduct->shop_id}}"
                                                            data-name="{{$singleProduct->name}}"
                                                            data-category_id="{{$singleProduct->child_category_id}}"
                                                            data-price_currency="{{$singleProduct->price_currency}}"
                                                            data-price="{{$singleProduct->price}}"
                                                            data-weight_unit="{{$singleProduct->weight_unit}}"
                                                            data-condition="{{$singleProduct->condition}}"
                                                            data-stock="{{$singleProduct->stock}}"
                                                            class="btn btn-xxs deleteButton">
                                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            data-id="{{$singleProduct->id}}"
                                                            data-fs_id="{{$singleProduct->fs_id}}"
                                                            data-product_id="{{$singleProduct->product_id}}"
                                                            data-shop_id="{{$singleProduct->shop_id}}"
                                                            data-name="{{$singleProduct->name}}"
                                                            data-category_id="{{$singleProduct->child_category_id}}"
                                                            data-price_currency="{{$singleProduct->price_currency}}"
                                                            data-price="{{$singleProduct->price}}"
                                                            data-weight_unit="{{$singleProduct->weight_unit}}"
                                                            data-condition="{{$singleProduct->condition}}"
                                                            data-stock="{{$singleProduct->stock}}"
                                                            class="btn btn-xxs undeleteButton">
                                                        <i class="fa fa-unlock" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
    {{--  Edit Modal  --}}
    <div class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('editProduct')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="type" value="edit">
                        <input type="hidden" class="form-control" name="shop" id="shop_id">
                        <input type="hidden" class="form-control" name="product_id" id="product_id">
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
                                <label>name</label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                       readonly/>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('product_img') is-invalid @enderror"
                                           name="product_img">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>category_id</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <textarea class="form-control" type="text" id="description" name="description"
                                          required></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>price</label>
                                <input class="form-control" type="number" min="100" id="price" name="price" required/>
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
                                       required
                                />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stock</label>
                                <input class="form-control" type="text"
                                       id="stock"
                                       name="stock"
                                       required
                                />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Min Order</label>
                                <input class="form-control" type="number"
                                       id="min_order"
                                       name="min_order"
                                       value="1"
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    @push('dashboard')
        <script src="{{asset('adminpanel/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('adminpanel/')}}/dist/js/pages/datatable/datatable-basic.init.js"></script>
        <script>

            $('#zero_config tbody').on('click', '.deleteButton', function () {
                let id = $(this).data('id');
                let fs_id = $(this).data('fs_id');
                let product_id = $(this).data('product_id');
                let shop_id = $(this).data('shop_id');
                $.ajax({
                    type: 'POST',
                    url: "{{route('deleteProduct')}}",
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
            }).on('click', '.undeleteButton', function () {
                let id = $(this).data('id');
                let fs_id = $(this).data('fs_id');
                let product_id = $(this).data('product_id');
                let shop_id = $(this).data('shop_id');
                $.ajax({
                    type: 'POST',
                    url: "{{route('undeleteProduct')}}",
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
                            location.reload();
                        }
                    }
                });
            }).on('click', '.editButton', function () {
                let id = $(this).data('id');
                let fs_id = $(this).data('fs_id');
                let product_id = $(this).data('product_id');
                let status = $(this).data('status');
                let short_desc = $(this).data('short_desc');
                let shop_id = $(this).data('shop_id');
                let name = $(this).data('name');
                let category_id = $(this).data('category_id');
                let price_currency = $(this).data('price_currency');
                let price = $(this).data('price');
                let weight_value = $(this).data('weight_value');
                let weight_unit = $(this).data('weight_unit');
                let condition = $(this).data('condition');
                let stock = $(this).data('stock');
                let status_val = 'UNLIMITED';
                if (status == 2) {
                    status_val = 'LIMITED';
                } else if (status == 3) {
                    status_val = 'EMPTY';
                }
                let condition_val = 'USED';
                if (condition == 1) {
                    condition_val = 'NEW';
                }
                let weight_unit_val = 'KG';
                if (weight_unit == 1) {
                    weight_unit_val = 'GR';
                }
                let price_currency_val = 'IDR';
                if (price_currency == 1) {
                    price_currency_val = 'IDR';
                }

                let strValue = fs_id;
                if (strValue != "") {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('getShopInfo')}}",
                        data: {
                            '_token': "{{csrf_token()}}",
                            'fs_id': strValue
                        },
                        success: function (response) {
                            for (var j = 0; j < Object.keys(response["data"]['categoryDetail']).length; j++) {
                                if (response['data']['categoryDetail'][j]) {
                                    if (response['data']['categoryDetail'][j]['id'] == category_id) {
                                        $("select#category").append('<option value="' + response['data']['categoryDetail'][j]['id'] + '" selected>' + response['data']['categoryDetail'][j]['name'] + '</option>');
                                    }
                                    $("select#category").append('<option value="' + response['data']['categoryDetail'][j]['id'] + '">' + response['data']['categoryDetail'][j]['name'] + '</option>');
                                }
                            }
                        }
                    });
                }
                $('#id').val(id);
                $('#fs_id').val(fs_id);
                $('#product_id').val(product_id);
                $('#description').val(short_desc);
                $('#shop_id').val(shop_id);
                $('#name').val(name);
                $('#status').val(status_val);
                $('#price_currency').val(price_currency_val);
                $('#price').val(price);
                $('#weight').val(weight_value);
                $('#weight_unit').val(weight_unit_val);
                $('#condition').val(condition_val);
                $('#stock').val(stock);
                $('.editModal').modal('show');
            });
        </script>
    @endpush
@endsection
