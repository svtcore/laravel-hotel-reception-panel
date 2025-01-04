@extends('layouts.header')
@section('title', 'Add service')
@section('services_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/additional-services-style.css'])
@endsection

@section('navbar_header_button')
<span id="header_new_service">Add new service</span>
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

                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="row justify-content-center g-3">
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><b>Service Information</b></h4>
                                    <br /><br />
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   maxlength="255" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                                   id="price" name="price" value="{{ old('price') }}" 
                                                   min="0" maxlength="10" required>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-2">
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Available</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="" selected>-- Select availability --</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><b>Actions</b></h4>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success w-100 mb-4 mt-4">Confirm service data</button>
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