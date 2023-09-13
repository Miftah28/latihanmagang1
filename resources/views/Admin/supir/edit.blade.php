@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Update Akun Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Update Akun Admin Daerah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Vertical Form -->
    <form class="row g-3" action="{{ route('admin.supir.update', Crypt::encrypt($data->id)) }}" method="post"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="m-0 font-weight-bold text-black">Foto Profil</h4>
                    </div>
                    <div class="card-profile-image mt-4 mb-2 text-center">
                        <div id="preview-image">
                            <img src="{{ $data->photo == null ? asset('images/preview.png') : asset('storage/' . $data->photo) }}"
                                width="200px" height="200px" />
                        </div>
                    </div>
                    <div class="card-body mb-2">
                        <input id="id" type="hidden" class="form-control" name="id"
                            value="{{ $data->id }}">
                        <input id="user_id" type="hidden" class="form-control" name="user_id"
                            value="{{ $data->user_id }}">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                                    <input id="photo" type="file" class="form-control preview-image" name="photo"
                                        value="{{ old('photo') }}">
                                    @if ($errors->has('photo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="m-0 font-weight-bold text-black">Edit Supir</h4>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Your Name</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $data->name }}" required autocomplete="name" autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $data->user->email }}" required autocomplete="email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12">
                                <label for="inputPassword4" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password"
                                    pattern="^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$#%@]).*$">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                <div class="alert alert-secondary mt-2 mb-0" role="alert" id="message">
                                    <p style="font-weight: bold;">Kata Sandi harus terdiri dari:</p>
                                    <p id="length" class="invalid">Minimal <b>8 karakter</b></p>
                                    <p id="letter" class="invalid">Huruf <b>kecil (a-z)</b></p>
                                    <p id="capital" class="invalid">Huruf <b>KAPITAL (A-Z)</b></p>
                                    <p id="number" class="invalid"><b>Angka</b> (0-9)</p>
                                    <p id="symbol" class="invalid"><b>Symbol</b> (!$#%@)</p>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="inputAddress" class="form-label">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                                @if ($errors->has('password-confirm'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password-confirm') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form><!-- Vertical Form -->
@endsection
