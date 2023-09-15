@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Form Jadwal Pemberangkatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Jadwal Pemberangkatan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Menambahkan Jadwal Pemberangkatan</h5>

            <!-- Vertical Form -->
            <form class="row g-3" method="POST" action="{{ route('admindaerah.jadwal.pemberangkatan.store') }}"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-12">
                    <label for="keberangkatan" class="form-label">Keberangkatan</label>
                    <input id="keberangkatan" type="text"
                        class="form-control @error('keberangkatan') is-invalid @enderror" name="keberangkatan"
                        value="{{ $pemberangkatan->nama_daerah }}" required autocomplete="keberangkatan" autofocus readonly>
                    @if ($errors->has('keberangkatan'))
                        <span class="help-block">
                            <strong>{{ $errors->first('keberangkatan') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="State" name="tujuan" required>
                            <option value="">Pilih Tujuan Daerah</option>
                            @php
                                $currentGroup = null;
                            @endphp
                            @forelse ($tujuans as $tujuan)
                                @if ($tujuan->kota->nama_kota != $currentGroup)
                                    @if ($currentGroup !== null)
                                        </optgroup>
                                    @endif
                                    @if ($tujuan->kota_id != $pemberangkatan->kota_id)
                                        <optgroup label="{{ $tujuan->kota->nama_kota }}">
                                            @php
                                                $currentGroup = $tujuan->kota->nama_kota;
                                            @endphp
                                    @endif
                                @endif
                                @if ($tujuan->kota_id != $pemberangkatan->kota_id)
                                    <option value="{{ $tujuan->nama_daerah }}">{{ $tujuan->nama_daerah }}</option>
                                @endif
                            @empty
                                <option value="NULL">Daerah Tujuan belum diinput</option>
                            @endforelse
                            @if ($currentGroup !== null)
                                </optgroup>
                            @endif
                        </select>
                        <label for="floatingSelect">Tujuan</label>
                    </div>
                </div>

                <div class="col-12">
                    <label for="tanggal_keberangkatan" class="form-label">Tanggal Keberangkatan</label>
                    <input id="tanggal_keberangkatan" type="date"
                        class="form-control @error('tanggal_keberangkatan') is-invalid @enderror"
                        name="tanggal_keberangkatan" value="{{ $pemberangkatan->nama_daerah }}" required
                        autocomplete="tanggal_keberangkatan" autofocus>
                    @if ($errors->has('tanggal_keberangkatan'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tanggal_keberangkatan') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-12">
                    <label for="waktu" class="form-label">Waktu Keberangkatan</label>
                    <input id="waktu" type="time" class="form-control @error('waktu') is-invalid @enderror"
                        name="waktu" value="{{ $pemberangkatan->nama_daerah }}" required autocomplete="waktu" autofocus>
                    @if ($errors->has('waktu'))
                        <span class="help-block">
                            <strong>{{ $errors->first('waktu') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-12">
                    <label for="alamat" class="form-label">alamat Keberangkatan</label>
                    {{-- <textarea class="form-control" style="height: 33px;"> --}}
                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                        value="{{ old('alamat') }}" required autocomplete="alamat" autofocus></textarea>
                    @if ($errors->has('alamat'))
                        <span class="help-block">
                            <strong>{{ $errors->first('alamat') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-12">
                    <label for="phone" class="form-label">phone </label>
                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
                        name="phone" value="{{ $pemberangkatan->nama_daerah }}" required autocomplete="phone" autofocus>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
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
