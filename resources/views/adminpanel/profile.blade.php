@extends('adminpanel.layout.app')
@section('content')
<!--**********************************
        Content body start
    ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="pt-3">
                            <div class="settings-form">
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>{!! \Session::get('success') !!}</li>
                                        </ul>
                                    </div>
                                @endif
                                <h4 class="text-primary">Account Setting</h4>
                                <form method="POST" action="{{route('sprofile')}}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{Auth::user()->name}}">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Email</label>
                                            <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" readonly>
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Address</label>
                                            <input type="text" placeholder="1234 Main St" class="form-control @error('address1') is-invalid @enderror" name="address1" value="{{Auth::user()->address1}}">
                                            @error('address1')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Address 2</label>
                                            <input type="text" placeholder="Apartment, studio, or floor" class="form-control @error('address2') is-invalid @enderror" name="address2" value="{{Auth::user()->address2}}">
                                            @error('address2')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('profile_img') is-invalid @enderror" name="profile_img">
                                                    <label class="custom-file-label">Choose file</label>
                                                </div>
                                            </div>
                                            @error('profile_img')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>City</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror " name="city" value="{{Auth::user()->city}}">
                                            @error('city')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Zip</label>
                                            <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{Auth::user()->zip}}">
                                            @error('zip')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </form>
                            </div>
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
@push('dashboard')
    <script src="{{asset('adminpanel//vendor/global/global.min.js')}}"></script>
    <script src="{{asset('adminpanel//js/custom.min.js')}}"></script>
    <script src="{{asset('adminpanel//js/deznav-init.js')}}"></script>
@endpush
@endsection
