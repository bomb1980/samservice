@extends('layouts.app')

@section('content')
    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
            <div class="brand">
                {{-- <img class="brand-img" src="{{ asset('assets') }}/images/logo_pbms.png"> --}}
                <h2 class="brand-text">OOAP</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="sr-only" for="inputName">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="tcmad" required autofocus>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="inputPassword">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                @if ($errors->any())
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4 py-3 text-danger">
                            {{ __($errors->first()) }}
                        </div>
                    </div>
                @endif
            </form>

            <footer class="page-copyright page-copyright-inverse">
                <p>สงวนลิขสิทธิ์ © 2564 สำนักงานปลัดกระทรวงแรงงาน</p>
            </footer>
        </div>
    </div>
    <!-- End Page -->
@endsection
