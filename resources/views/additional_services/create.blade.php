@extends('layouts.header')
@section('services_navbar_state', 'active')
@section('additional_style')
@endsection

@section('content')
@section('navbar_header_button')
<span class="nav-page-info">Add new service</span>
@endsection
<div class="container-fluid mt-5">
    <div class="content-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid mt-4">
                <!-- Session Messages Handling -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="createForm" class="" action="{{ route('admin.services.store') }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-8">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Service information</b></h4><br /><br />
                                    @csrf
                                    <!-- Input fields for name and email -->
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control text-center" id="name" name="name" required maxlength="255">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control text-center" id="price" name="price" required maxlength="10">
                                        </div>
                                    </div>
                                    <!-- Select field for role -->
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Available</label>
                                            <select class="form-select text-center" id="status" name="status">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Save changes button -->
                        <div class="col-md-4">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Actions</b></h4><br /><br />
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Confirm service data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@section('custom-scripts')
@endsection

@endsection