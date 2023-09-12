@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Update Akun Admin Daerah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Update Akun Admin Daerah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    {{-- <div class="card">
        <div class="card-body">
            <h5 class="card-title">Menammbahkan Akun Admin</h5> --}}

    <!-- Vertical Form -->
    <form class="row g-3" action="{{ route('admin.admindaerah.update', Crypt::encrypt($data->id)) }}" method="post"
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
                        <h4 class="m-0 font-weight-bold text-black">Edit Admin Daerah</h4>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="col-12 mb-4">
                                <label for="inputNanme4" class="form-label">Your Name</label>
                                <input id="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ $data->nama }}" required autocomplete="name" autofocus>
                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <div class="col-12">
                                    <select class="form-control" name="daerah_id" required>
                                        @forelse ($daerahs as $daerah)
                                            <option value="{{ $daerah->id }}"
                                                {{ $data->daerah_id == $daerah->id ? 'selected' : '' }}>
                                                {{ $daerah->nama_daerah }}</option>
                                        @empty
                                            <option value="NULL">Kota belum diinput</option>
                                        @endforelse
                                    </select>
                                    @if ($errors->has('daerah'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('daerah') }}</strong>
                                        </span>
                                    @endif
                            </div> --}}
                            <div class="col-12 mb-4">
                                <select class="form-select" id="kotaSelect" aria-label="State" name="kota_id" required>
                                    <option value="">Pilih Kota</option>
                                    @forelse ($kotas as $kota)
                                        <option
                                            value="{{ $kota->id }}"{{ $data->kota_id == $kota->id ? 'selected' : '' }}>
                                            {{ $kota->nama_kota }}</option>
                                    @empty
                                        <option value="NULL">Kota belum diinput</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-12 mb-1">
                                <select class="form-select" id="daerahSelect" aria-label="State" name="daerah_id" required>
                                    <option value="">Pilih Kota Daerah</option>
                                    {{-- Default data daerahs, akan diganti dengan data yang relevan --}}
                                    @forelse ($daerahs as $daerah)
                                        <option class="daerahOption" value="{{ $daerah->id }}"
                                            data-kota="{{ $daerah->kota->nama_kota }}" {{ $data->daerah_id == $daerah->id ? 'selected' : '' }}>
                                            Kota {{ $daerah->kota->nama_kota }}, Daerah
                                            {{ $daerah->nama_daerah }}</option>
                                    @empty
                                        <option value="NULL">Daerah belum diinput</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $data->user->email }}" autocomplete="email">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Mendapatkan referensi ke elemen-elemen dropdown
        const kotaSelect = document.getElementById('kotaSelect');
        const daerahSelect = document.getElementById('daerahSelect');

        // Data daerah yang relevan berdasarkan kota
        const daerahs = @json($daerahs); // Gantilah ini dengan cara Anda mendapatkan data daerah dari PHP

        // Menambahkan event listener untuk perubahan dalam dropdown kota
        kotaSelect.addEventListener('change', function() {
            const selectedKota = kotaSelect.value;

            // Mengosongkan dropdown daerah
            daerahSelect.innerHTML = '<option value="">Pilih Kota Daerah</option>';

            // Mengisi dropdown daerah dengan opsi yang sesuai
            daerahs.forEach(daerah => {
                if (daerah.kota.id === parseInt(selectedKota)) {
                    const option = document.createElement('option');
                    option.value = daerah.id;
                    option.textContent = `Kota ${daerah.kota.nama_kota}, Daerah ${daerah.nama_daerah}`;
                    daerahSelect.appendChild(option);
                }
            });
        });
    </script>
@endsection
