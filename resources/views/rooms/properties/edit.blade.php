@extends('layouts.header')
@section('room_properties_navbar_state', 'active')
@section('additional_style')
@endsection

@section('content')
@section('navbar_header_button')
<span class="nav-page-info">Edit room property data</span>
@endsection
<div class="container-fluid">
    <div class="content-container main-container">
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
                <form id="createForm" class="" action="{{ route('admin.rooms.properties.update', $property->id) }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-8">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Property information</b></h4><br /><br />
                                    @csrf
                                    @method('PUT')
                                    <!-- Input fields for name and email -->
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control text-center" id="name" name="name" required maxlength="255" value="{{ $property->name }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="status" class="form-label">Available</label>
                                            <select class="form-select text-center" id="status" name="status" required value="{{ $property->available }}">
                                                <option value="1" @if ($property->available == 1) selected @endif >Yes</option>
                                                <option value="0" @if ($property->available == 0) selected @endif >No</option>
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
                                    <div class="row mt-4 mb-4 ml-2 mr-2">
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