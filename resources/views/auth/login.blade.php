@extends('layouts.login')

@section('content')

<div class="card col-lg-4 mx-auto">
    <div class="card-body px-5 py-5">
        <h3 class="card-title text-left mb-3">Login</h3>
        <form class="mt-4" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email *</label>
                <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Password *</label>
                <input placeholder="Senha" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection