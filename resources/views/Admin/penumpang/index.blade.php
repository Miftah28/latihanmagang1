@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Data Tables Akun Penumpang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Akun Penumpang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-2">
                    <a href="{{ route('admin.penumpang.create') }}" class="btn btn-primary" type="button"> <i
                            class="bi bi-plus-circle-dotted"></i> Tambah</a>
                </div>
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title">Data Akun Penumpang</h5>
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
                                @forelse ($Penumpang as $Penumpangs)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $Penumpangs->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                    <div class="mr-2">
                                                        <a href="{{route('admin.penumpang.edit', Crypt::encrypt($Penumpangs->id)) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <form
                                                            action="{{ route('admin.penumpang.destroy', Crypt::encrypt($Penumpangs->id)) }}"
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
