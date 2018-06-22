@extends('layouts.front')

@section('title')
    <title>My Course</title>
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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Course Ordered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @forelse ($payment as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->date }}</td>
                                <td>
                                    @if ($row->status)
                                    <label for="" class="badge badge-success">Paid</label>
                                    @else   
                                    <label for="" class="badge badge-danger">Unpaid</label>
                                    @endif
                                </td>
                                <td>{{ $row->amount }}</td>
                                <td>{{ $row->detail_count }}</td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
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