@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Update Akun Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Update Akun Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Menammbahkan Akun Admin</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="{{ route('admin.admindaerah.update', Crypt::encrypt($data->id)) }}" method="post"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Your Name</label>
                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                        name="nama" value="{{ $data->nama }}" required autocomplete="nama" autofocus>
                    @if ($errors->has('nama'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nama') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <select class="form-control" name="teacher_id" required>
                            @forelse ($daerahs as $daerah)
                                <option value="{{ $daerah->id }}" {{ $data->daerah_id == $daerah->id ? 'selected' : '' }}>
                                    {{ $daerah->nama_daerah }}</option>
                            @empty
                                <option value="NULL">Kota belum diinput</option>
                            @endforelse
                        </select>
                        @if ($errors->has('teacher'))
                            <span class="help-block">
                                <strong>{{ $errors->first('teacher') }}</strong>
                            </span>
                        @endif
                        <label for="floatingSelect">State</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ $data->user->email }}" autocomplete="email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-12">
                    <label for="inputPassword4" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="new-password"
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
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        autocomplete="new-password">
                    @if ($errors->has('password-confirm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
@endsection
