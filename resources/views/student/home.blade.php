@extends('layouts.front')

@section('title')
    <title>Dashboard</title>
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card-deck mb-3">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Order</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('student.enroll') }}" method="POST">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">
                            {!! session('success') !!}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Select Course</label>
                        <select name="course_id[]" id="course_id" class="form-control" multiple width="100%">
                            @foreach ($course as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger btn-sm">Enroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#course_id').select2();
    });
</script>
@endsection