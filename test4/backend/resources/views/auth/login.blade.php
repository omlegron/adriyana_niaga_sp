@extends('layouts/fullApp')

@section('styles')
<link nonce="{{ csp_nonce() }}" href="{{ asset('assets/css/pages/login/classic/login-1.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css" nonce="{{ csp_nonce() }}">
  .bg-kt-login{
    background-image: url('public/img/img.png');
  }

  .kt-width-login-form{
    width:400px;
  }

  .color-black{
    font-weight: bold;
    color:black;
  }
</style>
@endsection

@section('content')
<div class="d-flex flex-column flex-root">
  <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
    <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10 bg-kt-login" >
      <div class="d-flex flex-row-fluid flex-column justify-content-between">
       
        <div class="flex-column-fluid d-flex flex-column justify-content-center">
         
        </div>
        <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
          <div class="font-weight-bold text-black text-bold color-black">© {{ \Carbon\Carbon::now()->format('Y')  }} APS - ASDP PORT SERVICES</div>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
      <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
        <div class="login-form login-signin">
          <div class="text-center mb-5 mb-lg-5">
            <img src="{{ asset('img/logo.png') }}" width="180">
            <br><br>
            <h1 class="font-size-h1 mb-5 text-black">ASDP PORT SERVICES</h1>
          </div>
          
          <form class="form" id="formData" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <input class="form-control form-control-solid h-auto py-5 px-6 @error('username') is-invalid @enderror" type="text" placeholder="Username" name="username" autocomplete="off" value="{{ old('username') }}"/>
              @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            @php
              $masterPos = App\Models\MasterPos::get();
            @endphp
            <div class="form-group">
              <select name="pos" class="form-control form-control-solid h-auto py-5 px-6 @error('poss') is-invalid @enderror ">
                <option value="">Pilih Pos</option>
                @if($masterPos->count() > 0)
                  @foreach($masterPos as $k => $value)
                    <option value="{{ $value->id }}">{{ $value->pos }} - {{ $value->pelabuhan }}</option>
                  @endforeach
                @endif
              </select>
              @error('pos')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <select name="shift" class="form-control form-control-solid h-auto py-5 px-6 @error('shift') is-invalid @enderror">
                <option value="">Pilih Shift</option>
                <option value="Shift 1">Shift 1 (07.00-19.00 WIB)</option>
                <option value="Shift 2">Shift 2 (19.00-07.00 WIB)</option>
                {{-- <option value="Shift 3">Shift 3 (02.00-08.00 WIB)</option> --}}
              </select>
              @error('shift')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group">
              <input class="form-control form-control-solid h-auto py-5 px-6 @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" autocomplete="current-password"/>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <center>
                <div class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4 loginKt">Sign In</div>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
        <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© {{ \Carbon\Carbon::now()->format('Y')  }} APS - ASDP PORT SERVICES</div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
@endsection