@extends('layouts.dashboard')

@section('main-content')
    <div class="pagetitle">
        <h1>Data Tables</h1>
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
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.admin.create') }}" class="btn btn-primary" type="button"> <i
                            class="bi bi-plus-circle-dotted"></i> Tambah</a>
                </div>
                <br>
                <div class="card ">
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
                                {{-- Loop untuk menampilkan akun admin yang aktif --}}
                                @foreach ($admin as $admins)
                                    @if ($admins->id === Auth::user()->admin->id)
                                        <tr>
                                            <td scope="row">1</td>
                                            <td>{{ $admins->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-success" disabled>Aktif</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            
                                {{-- Loop untuk menampilkan akun admin yang tidak aktif --}}
                                @php $counter = 2; @endphp
                                @foreach ($admin as $admins)
                                    @if ($admins->id !== Auth::user()->admin->id)
                                        <tr>
                                            <td scope="row">{{ $counter }}</td>
                                            <td>{{ $admins->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="mr-2">
                                                        <a href="{{ route('admin.admin.edit', Crypt::encrypt($admins->id)) }}" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <form action="{{ route('admin.admin.destroy', Crypt::encrypt($admins->id)) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $counter++; @endphp
                                    @endif
                                @endforeach
                            
                                {{-- Pesan jika tidak ada data --}}
                                @if ($admin->isEmpty())
                                    <tr>
                                        <td colspan="3">Data Tidak Ditemukan</td>
                                    </tr>
                                @endif
                            </tbody>
                            

                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
