@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Data Tables Akun supir</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Akun supir</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.supir.create') }}" class="btn btn-primary" type="button"> <i
                            class="bi bi-plus-circle-dotted"></i> Tambah</a>
                </div>
                <br>
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title">Data Akun supir</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($supir as $supirs)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $supirs->nama }}</td>
                                        <td>
                                            <div class="d-flex">
                                                {{-- Cek apakah akun supir saat ini sedang digunakan --}}
                                                    <div class="mr-2">
                                                        <a href="{{ route('admin.supir.edit', Crypt::encrypt($supirs->id)) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <form
                                                            action="{{ route('admin.supir.destroy', Crypt::encrypt($supirs->id)) }}"
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Data Tidak Ditemukan</td>
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
