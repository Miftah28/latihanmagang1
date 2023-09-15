@extends('layouts.dashboard')
@section('main-content')
    <div class="pagetitle">
        <h1>Data Tables Jadwal Keberangkatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Jadwal Keberangkatan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    {{-- table jadwal pemberangkatan --}}
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-2">
                    <a href="{{ route('admindaerah.jadwal.pemberangkatan.create') }}" class="btn btn-primary" type="button"> <i
                            class="bi bi-plus-circle-dotted"></i> Tambah</a>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Data Kategori Daerah</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Keberangkatan</th>
                                    <th scope="col">Tujuan</th>
                                    <th scope="col">Waktu Keberangkatan</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $jadwals)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $jadwals->keberangkatan }}</td>
                                        <td>{{ $jadwals->tujuan }}</td>
                                        <td>
                                            Tanggal : {{ $jadwals->tanggal_keberangkatan }}
                                            <br>
                                            Jam Berangkat : {{$jadwals->waktu}}
                                        </td>
                                        <td>{{$jadwals->alamat}}</td>
                                        <td>{{$jadwals->phone}}</td>
                                        {{-- <td>
                                            <div class="d-flex">
                                                <div class="mr-2">
                                                    <a href="{{ route('admin.jadwal.edit', Crypt::encrypt($jadwals->id)) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </div>
                                                <div class="mr-2">
                                                    <form
                                                        action="{{ route('admin.jadwal.destroy', Crypt::encrypt($jadwals->id)) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
