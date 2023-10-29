@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tambah kategori kursus</h4>
                <p class="card-title-desc">Isi informasi dibawah ini</p>

                <form method="POST" action="{{ route('dashboard.admin.course-category.store') }}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="{{ route('dashboard.admin.course-category.index') }}" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
