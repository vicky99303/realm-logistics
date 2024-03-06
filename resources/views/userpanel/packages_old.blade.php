@extends('userpanel.layout.app')
@section('content')
    @push('packagecss')
        <!-- Datatable -->
        <link href="{{asset('adminpanel/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
        <!-- Custom Stylesheet -->
        <link href="{{asset('adminpanel/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
        <link href="{{asset('adminpanel/css/style.css')}}" rel="stylesheet">
        <style>
            .loader {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://js.xendit.co/v1/xendit.min.js"></script>
    <script>
        Xendit.setPublishableKey('xnd_public_development_uzhyKyU7arC6hMCupZHycUtUqY4IDtx1admNLygJMIr8iDO1oyt7qZ54xtaxc');
        $(function () {
            $('#package_id').change(function (){
                var amount = $(this).find(':selected').attr('data-amount');
                $('#amount').val(amount);
            });

            $('.loader-div').hide();
            var fileEnv = "production";
            if (fileEnv !== 'production') {
                Xendit._useIntegrationURL(true);
            }
            var $form = $('#payment-form');
            $form.submit(function (event) {
                hideResults();
                Xendit.setPublishableKey($form.find('#api-key').val());
                // Disable the submit button to prevent repeated clicks:
                $form.find('.submit').prop('disabled', true);

                // Request a token from Xendit:
                var tokenData = getTokenData();

                Xendit.card.createToken(tokenData, xenditResponseHandler);

                // Prevent the form from being submitted:
                return false;
            });

            $('#bundle-authentication').change(function () {
                if (this.checked) {
                    $('#card-cvn').val('');
                }
            });

            function xenditResponseHandler(err, creditCardToken) {
                $form.find('.submit').prop('disabled', false);
                if (err) {
                    return displayError(err);
                }
                if (creditCardToken.status === 'APPROVED' || creditCardToken.status === 'VERIFIED') {
                    displaySuccess(creditCardToken);
                } else if (creditCardToken.status === 'IN_REVIEW') {
                    window.open(creditCardToken.payer_authentication_url, 'sample-inline-frame');
                    $('.overlay').show();
                    $('#three-ds-container').modal('show');
                } else if (creditCardToken.status === 'FRAUD') {
                    displayError(creditCardToken);
                } else if (creditCardToken.status === 'FAILED') {
                    displayError(creditCardToken);
                }
            }

            function displayError(err) {
                $('#three-ds-container').modal('hide');
                $('.overlay').hide();
                $('#error .result').text(err.message);
                $('#error').show();
                $('.loader-div').hide();
                $('.submit').show();
            };

            function displaySuccess(creditCardToken) {
                $('#three-ds-container').modal('hide');
                $('.overlay').hide();
                ajaxCall(creditCardToken);
            }

            function getTokenData() {
                return {
                    amount: $form.find('#amount').val(),
                    card_number: $form.find('#card-number').val(),
                    card_exp_month: $form.find('#card-exp-month').val(),
                    card_exp_year: $form.find('#card-exp-year').val(),
                    card_cvn: $form.find('#card-cvn').val(),
                    package_id: $form.find('#package_id').val(),
                    is_multiple_use: $form.find('#bundle-authentication').prop('checked') ? true : false,
                    should_authenticate: $form.find('#skip-authentication').prop('checked') ? false : true,
                    currency: $form.find('#currency').val(),
                    on_behalf_of: $form.find('#on-behalf-of').val()
                };
            }

            function hideResults() {
                $('#success').hide();
                $('#error').hide();
                $('.submit').hide();
                $('.loader-div').show();
            }

            function ajaxCall(dataObject) {
                var getTokenDataVar = getTokenData();
                $.ajax({
                    url: "{{route('getPaymentAmount')}}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        token_id: dataObject.id,
                        package_id: getTokenDataVar.package_id,
                        authentication_id: dataObject.authentication_id,
                        masked_card_number: dataObject.masked_card_number,
                        status: dataObject.status,
                        bank: dataObject.metadata.bank,
                        country_code: dataObject.metadata.country_code,
                        type: dataObject.metadata.type,
                        brand: dataObject.metadata.brand,
                        amount: getTokenDataVar.amount,
                        card_cvn: getTokenDataVar.card_cvn,
                        card_exp_month: getTokenDataVar.card_exp_month,
                        card_exp_year: getTokenDataVar.card_exp_year,
                        card_number: getTokenDataVar.card_number,
                    },
                    cache: false,
                    success: function (response) {
                        if (response.status == true) {
                            $('#three-ds-container').modal('hide');
                            $('.overlay').hide();
                            $('#success .result').text(response.message);
                            $('#success').show();
                            $('.submit').show();
                            $('.loader-div').hide();
                            setTimeout(function(){ location.reload(); }, 3000);
                        } else if (response.status == false) {
                            $('#three-ds-container').modal('hide');
                            $('.overlay').hide();
                            $('#error .result').text(response.message);
                            $('#error').show();
                            $('.submit').show();
                            $('.loader-div').hide();
                        }
                    }
                });
            }
        });
    </script>
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Buy Package</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Buy Collection</h4>
                            <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal" data-target=".addModal"><span
                                    class="btn-icon-left text-primary"><i class="fa fa-plus color-info"></i>
                                    </span>Buy
                            </button>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">{{$errors->first()}}</div>
                            @elseif(session()->has('message'))
                                <div class="alert alert-success">{{ session()->get('message') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table id="buyPackageDatatable" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>package_id</th>
                                        <th>Status</th>
                                        <th>authorized_amount</th>
                                        <th>capture_amount</th>
                                        <th>currency</th>
                                        <th>business_id</th>
                                        <th>merchant_id</th>
                                        <th>merchant_reference_code</th>
                                        <th>external_id</th>
                                        <th>eci</th>
                                        <th>charge_type</th>
                                        <th>masked_card_number</th>
                                        <th>created_at</th>
                                        {{--                                        <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($dataCoupon->isNotEmpty())
                                        @foreach($dataCoupon as $single)
                                            <tr>
                                                <td>{{$single->id}}</td>
                                                <td>{{$single->package_id}}</td>
                                                <td>{{$single->status}}</td>
                                                <td>{{$single->authorized_amount}}</td>
                                                <td>{{$single->capture_amount}}</td>
                                                <td>{{$single->currency}}</td>
                                                <td>{{$single->business_id}}</td>
                                                <td>{{$single->merchant_id}}</td>
                                                <td>{{$single->merchant_reference_code}}</td>
                                                <td>{{$single->external_id}}</td>
                                                <td>{{$single->eci}}</td>
                                                <td>{{$single->charge_type}}</td>
                                                <td>{{$single->masked_card_number}}</td>
                                                <td>{{$single->created_at}}</td>
                                                {{--                                                <td>--}}
                                                {{--                                                    <div class="d-flex">--}}
                                                {{--                                                        <button class="btn btn-primary shadow btn-xs sharp mr-1 editModalClick"><i class="fa fa-pencil"></i></button>--}}
                                                {{--                                                        <button class="btn btn-danger shadow btn-xs sharp deleteModalClick"><i class="fa fa-trash"></i></button>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </td>--}}
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
    </div>

    <!--**********************************
        Content body end
    ***********************************-->
    {{--  Add Modal  --}}
    <div class="modal fade addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Package</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                        <div id="error" style="display:none;">
                            <div class=" alert alert-danger alert-dismissible fade show request">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                <strong>Error!</strong> <span class="result"></span>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                                    <span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                        <div id="success" style="display:none;">
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <strong>Success!</strong><span class="result"></span>
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                                    <span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" id="api-key" value="xnd_public_development_uzhyKyU7arC6hMCupZHycUtUqY4IDtx1admNLygJMIr8iDO1oyt7qZ54xtaxc"/>
                        <div class="form-row credit-card-box">
                            <div class="form-group col-md-6">
                                <label>Package</label>
                                <select id="package_id" name="package_id" class="form-control">
                                    <option selected>Choose...</option>
                                    @if($dataPackage->isNotEmpty())
                                        @foreach($dataPackage as $single)
                                            <option value="{{$single->id}}" data-amount="{{$single->price}}">{{$single->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>AMOUNT</label>
                                <input class="form-control" type="text" id="amount" placeholder="Amount" value="75000" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CARD NUMBER</label>
                                <input class="form-control" type="text" id="card-number" placeholder="Card number" value="4000000000000002" required/> <br/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>EXP </span>MONTH</label>
                                <input class="form-control" type="text" id="card-exp-month" placeholder="Card expiration month (mm)" value="12" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>EXP </span>YEAR</label>
                                <input class="form-control" type="text" id="card-exp-year" placeholder="Card expiration year (yyyy)" value="2020" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CVN CODE</label>
                                <input class="form-control" type="text" id="card-cvn" placeholder="Cvn" value="123" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CURRENCY</label>
                                <input class="form-control" type="text" id="currency" placeholder="IDR" value=""/>
                            </div>
                        </div>
                        <button class="submit subscribe btn btn-success btn-lg btn-block" type="submit">Pay</button>
                        <div class="loader-div">
                            <button class="btn btn-success btn-lg btn-block d-flex justify-content-center">
                                <div class="loader "></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  Edit Modal  --}}
    <div class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Coupons</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('coupons-store')}}">
                        @csrf
                        <input type="hidden" class="form-control" name="type" value="edit">
                        <input type="hidden" class="form-control" id="editid" name="id" value="">
                        <div class="form-group">
                            <label class="mb-1"><strong>Name</strong></label>
                            <input type="text" class="form-control" id="editname" name="name" placeholder="Coupon" value="">
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Opening date</strong></label>
                            <input type="date" class="form-control" id="editopening_date" name="opening_date" value="">
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Closing date</strong></label>
                            <input type="date" class="form-control" id="editclosing_date" name="closing_date" value="">
                        </div>
                        <div class="form-group">
                            <label class="mb-1"><strong>Discount amount</strong></label>
                            <input type="text" class="form-control" id="editdiscount_amount" name="discount_amount" value="">
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
    {{--  Delete Modal  --}}
    <div class="modal fade deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really Want to delete ?
                    <form method="POST" action="{{route('coupons-store')}}">
                        @csrf
                        <input type="hidden" class="form-control" name="type" value="delete">
                        <input type="hidden" class="form-control" id="deleteid" name="id" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="three-ds-container">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title">Payment Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 440px">
                    <iframe class="w-100 h-100" id="sample-inline-frame" name="sample-inline-frame"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @push('packagejs')
        <!-- Dashboard 1 -->
        <script src="{{asset('adminpanel/js/deznav-init.js')}}"></script>
        <!-- Datatable -->
        <script src="{{asset('adminpanel/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('adminpanel/js/custom/user/package.js')}}"></script>
    @endpush
@endsection
