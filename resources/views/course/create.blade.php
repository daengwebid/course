@extends('layouts.master')

@section('title')
    <title>Add New</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Add New</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Course</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        @card
                            @slot('title')
                            @endslot
                            
                            @if (session('error'))
                                @alert(['type' => 'danger'])
                                    {!! session('error') !!}
                                @endalert
                            @endif

                            <form role="form" action="{{ route('course.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" 
                                        name="name"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea
                                        name="description"
                                        class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}" id="name"
                                        rows="5" cols="5" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">Instructor</label>
                                    <select name="instructor_id" class="form-control {{ $errors->has('instructor_id') ? 'is-invalid':'' }}" required>
                                        <option value="">Pilih</option>
                                        @foreach ($instructor as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Price</label>
                                    <input type="number" 
                                        name="price"
                                        class="form-control {{ $errors->has('price') ? 'is-invalid':'' }}" id="price" required>
                                </div>
                            @slot('footer')
                                <div class="card-footer">
                                    <button class="btn btn-primary">Send</button>
                                </div>
                            </form>
                            @endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection