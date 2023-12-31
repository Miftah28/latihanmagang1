@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Data Tables Akun Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data Akun Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-2">
                    <a href="{{ route('admin.admin.create') }}" class="btn btn-primary" type="button"> <i
                            class="bi bi-plus-circle-dotted"></i> Tambah</a>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Data Akun Admin</h5>
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
                                @forelse ($admin as $admins)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $admins->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                {{-- Cek apakah akun admin saat ini sedang digunakan --}}
                                                @if ($admins->id !== Auth::user()->admin->id)
                                                    {{-- <div class="mr-2">
                                                        <a href=""type="button" class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#basicModal{{ $admins->id }}">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="modal fade" id="basicModal{{ $admins->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Basic Modal</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table datatable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">No</th>
                                                                                <th scope="col">Name</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <td scope="row">{{ $loop->iteration }}</td>
                                                                            <td>{{ $admins->name }}</td>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- End Basic Modal--> --}}
                                                    <div class="mr-2">
                                                        <a href="{{ route('admin.admin.edit', Crypt::encrypt($admins->id)) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <form
                                                            action="{{ route('admin.admin.destroy', Crypt::encrypt($admins->id)) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <button type="button" class="btn btn-outline-success"
                                                        disabled>Aktif</button>
                                                @endif
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
