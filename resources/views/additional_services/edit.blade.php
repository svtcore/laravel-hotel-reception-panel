@extends('layouts.header')
@section('title', 'Edit service')
@section('services_navbar_state', 'active')
@section('additional_style')
@endsection

@section('content')
@section('navbar_header_button')
<span class="header-navbar">Edit service</span>
@endsection
<div class="container-fluid">
    <div class="content-container main-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Session Messages Handling -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="custom-error-message">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="editForm" class="" action="{{ route('admin.services.update', $service->id) }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-8">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Service information</b></h4><br /><br />
                                    @csrf
                                    @method('PUT')
                                    <!-- Input fields for name and email -->
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control text-center @error('name') is-invalid @enderror" id="name" name="name" required maxlength="255" value="{{ $service->name }}" >
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price:</label>
                                            <input type="number" class="form-control text-center @error('price') is-invalid @enderror" id="price" name="price" required maxlength="10" min="0" value="{{ $service->price }}">
                                        </div>
                                    </div>
                                    <!-- Select field for role -->
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Available:</label>
                                            <select class="form-select text-center @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="" @if ($service->available != 1 && $service->available != 0) selected @endif > -- Select availability --</option>
                                                <option value="1" @if ($service->available == 1) selected @endif >Yes</option>
                                                <option value="0" @if ($service->available == 0) selected @endif >No</option>
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
                                    <h4 class="card-title pl-4"><b>Action</b></h4><br /><br />
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Save changes</button>
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