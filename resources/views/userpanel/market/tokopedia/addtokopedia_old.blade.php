@extends('userpanel.layout.app')
@section('content')
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sdashboard')}}">App</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                        <li class="breadcrumb-item"><a href="{{route('market')}}">Marketplace</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tokopedia</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tokopedia List</h4>
                        </div>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <form id="tokopedia_submit" method="post" action="{{route('tokopedia-post')}}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Client Id</label>
                                        <input type="text" class="form-control @error('client_id') is-invalid @enderror"
                                               name="client_id" placeholder="Client Id">
                                        @error('client_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Client Secret</label>
                                        <input type="text" class="form-control @error('client_secret') is-invalid @enderror"
                                               name="client_secret"
                                               placeholder="Client Secret">
                                        @error('client_secret')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>App ID</label>
                                        <input type="text" class="form-control @error('app_id') is-invalid @enderror"
                                               name="app_id" placeholder="App ID">
                                        @error('app_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Base64 </label>
                                        <input type="text" class="form-control @error('base64') is-invalid @enderror"
                                               name="base64"
                                               placeholder="Y2xpZW50X2lkOmNsaWVudF9zZWNyZXQK">
                                        @error('base64')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
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
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
    @push('dashboard')
    @endpush
@endsection
