@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Kategori Kota</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Kategori kota</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Menambahkan Kategori kota</h5>

            <!-- Vertical Form -->
            <form class="row g-3" method="POST" action="{{ route('admin.kota.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-12">
                    <label for="nama_kota" class="form-label">Nama Kota</label>
                    <input id="nama_kota" type="text" class="form-control @error('nama_kota') is-invalid @enderror"
                        name="nama_kota" value="{{ old('nama_kota') }}" required autocomplete="nama_kota" autofocus>
                    @if ($errors->has('nama_kota'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nama_kota') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
@endsection
