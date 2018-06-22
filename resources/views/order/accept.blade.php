@extends('layouts.master')

@section('title')
    <title>Student Course</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Student Course</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Student Course</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @card
                            @slot('title')
                            <form action="{{ route('order.accept') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="q" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="unpaid" {{ request()->q == 'unpaid' ? 'selected':'' }}>Unpaid</option>
                                                <option value="paid" {{ request()->q == 'paid' ? 'selected':'' }}>Paid</option>
                                                <option value="high" {{ request()->q == 'high' ? 'selected':'' }}>High Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm">Filter</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            @endslot
                            
                            @if (session('success'))
                                @alert(['type' => 'success'])
                                    {!! session('success') !!}
                                @endalert
                            @endif
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Code</td>
                                            <td>Student</td>
                                            <td>Total Amount</td>
                                            <td>Status</td>
                                            <td>Date</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse ($payment as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row->code }}</td>
                                            <td>{{ $row->student->email }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td>
                                                @if ($row->status)
                                                <label for="" class="badge badge-success">Paid</label>
                                                @else
                                                <label for="" class="badge badge-danger">Unpaid</label>
                                                @endif
                                            </td>
                                            <td>{{ $row->date }}</td>
                                            <td>
                                                @if ($row->status == 0)
                                                <form action="{{ route('order.change_status', $row->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-success btn-sm"><i class="fa fa-refresh"></i> Accept</button>
                                                </form>
                                                @else
                                                -
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Records Found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {!! $payment->links() !!}
                            </div>
                            @slot('footer')

                            @endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection