@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Kategori Daerah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Kategori Daerah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Menambahkan Kategori Daerah</h5>

            <!-- Vertical Form -->
            <form class="row g-3" method="POST" action="{{ route('admin.daerah.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-12">
                    <label for="nama_daerah" class="form-label">Nama Daerah</label>
                    <input id="nama_daerah" type="text" class="form-control @error('nama_daerah') is-invalid @enderror"
                        name="nama_daerah" value="{{ old('nama_daerah') }}" required autocomplete="nama_daerah" autofocus>
                    @if ($errors->has('nama_daerah'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nama_daerah') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="State" name="kota_id" required>
                            <option value="">Pilih Kota kota</option>
                            @forelse ($kotas as $kota)
                                <option value="{{ $kota->id }}">{{ $kota->nama_kota }}</option>
                            @empty
                                <option value="NULL">Kota belum diinput</option>
                            @endforelse
                        </select>
                        <label for="floatingSelect">State</label>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
@endsection
