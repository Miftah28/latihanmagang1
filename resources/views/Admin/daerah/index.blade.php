@extends('layouts.dashboard')

@section('main-content')
<div class="pagetitle">
    <h1>Data Tabel Kategori Daerah</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active">Data Kategori Daerah</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


    {{-- table kategori daerah --}}
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-2">
                    <a href="{{ route('admin.daerah.create') }}" class="btn btn-primary" type="button"> <i
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
                                    <th scope="col">Nama Kota</th>
                                    <th scope="col">Nama Daerah</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daerah as $daerahs)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $daerahs->kota->nama_kota }}</td>
                                        <td>{{ $daerahs->nama_daerah }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="mr-2">
                                                    <a href="{{ route('admin.daerah.edit', Crypt::encrypt($daerahs->id)) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </div>
                                                <div class="mr-2">
                                                    <form
                                                        action="{{ route('admin.daerah.destroy', Crypt::encrypt($daerahs->id)) }}"
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