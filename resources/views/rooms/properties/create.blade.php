@extends('layouts.header')
@section('title', 'Add Property')
@section('room_properties_navbar_state', 'active')
@section('additional_style')
@vite(['resources/css/rooms-properties-style.css'])
@endsection
@section('navbar_header_button')
<span id="header_add_room_property">Add room property</span>
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

                <form action="{{ route('admin.rooms.properties.store') }}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><b>Property Information</b></h4>
                                    <br /><br />
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" 
                                                   maxlength="255" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status" class="form-label">Available</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="" @if (old('status') === null) selected @endif>-- Select Status --</option>
                                                <option value="1" @if (old('status') == 1) selected @endif>Yes</option>
                                                <option value="0" @if (old('status') == 0) selected @endif>No</option>
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
                                    <button type="submit" class="btn btn-success w-100 mb-4 mt-4">Confirm Property Data</button>
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
