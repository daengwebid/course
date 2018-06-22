@extends('layouts.auth')

@section('title')
    <title>Register</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Register Your Account</p>

            <form method="POST" action="{{ route('student.registered') }}">
                @csrf
                @if (session('error'))
                    @alert(['type' => 'danger'])
                        {{ session('error') }}
                    @endalert
                @endif
                <div class="form-group has-feedback">
                    <input type="email"
                        name="email" 
                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                        placeholder="{{ __('E-Mail Address') }}"
                        value="{{ old('email') }}">
                    <span class="fa fa-envelope form-control-feedback"> {{ $errors->first('email') }}</span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" 
                        name="password"
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} " 
                        placeholder="{{ __('Password') }}">
                    <span class="fa fa-lock form-control-feedback"> {{ $errors->first('password') }}</span>
                </div>
                <div class="form-group has-feedback">
                    <select name="gender" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <span class="fa fa-intersex form-control-feedback"> {{ $errors->first('gender') }}</span>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="checkbox icheck">
                            
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection