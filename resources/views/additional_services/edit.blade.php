@extends('layouts.header')
@section('title', 'Edit service')
@section('services_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/additional-services-style.css'])
@endsection

@section('navbar_header_button')
<span id="header_edit_services">Edit service</span>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
            <div class="container-fluid mt-4">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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

                <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><b>Service Information</b></h4>
                                    <br /><br />
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" 
                                                   value="{{ $service->name }}" 
                                                   maxlength="255" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" 
                                                   value="{{ $service->price }}" 
                                                   min="0" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-6">
                                            <label for="status" class="form-label">Available</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="" @if ($service->available != 1 && $service->available != 0) selected @endif>
                                                    -- Select Availability --
                                                </option>
                                                <option value="1" @if ($service->available == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($service->available == 0) selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><b>Action</b></h4>
                                    <div>
                                        <button type="submit" class="btn btn-success w-100 mb-4 mt-4">Save Changes</button>
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
@endsection

@section('custom-scripts')
@endsection
