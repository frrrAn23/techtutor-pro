@extends('layouts.master')

@push('style')
@endpush

@section('breadcrumb')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Tambah siswa</h4>
                <p class="card-title-desc">Isi informasi dibawah ini</p>

                <form method="POST" action="{{ route('dashboard.student.store') }}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukan email" name="email" value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone-number" class="form-label">Nomor Handphone</label>
                                <small class="text-muted">(Opsional)</small>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone-number" placeholder="Masukan nomor telepon" name="phone_number" value="{{ old('phone_number') }}">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="avatar-url" class="form-label">Foto Profile</label>
                                <small class="text-muted">(Opsional)</small>
                                <input class="form-control  @error('avatar_url') is-invalid @enderror" type="file" id="avatar-url" name="avatar_url">

                                @error('avatar_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Masukan username" name="username" value="{{ old('username') }}">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukan password" name="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>

                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option disabled>Pilih</option>
                                    <option value="{{ App\Enums\UserStatusEnum::ACTIVE }}" {{ old('status') == App\Enums\UserStatusEnum::ACTIVE ? 'selected' : '' }}>Active</option>
                                    <option value="{{ App\Enums\UserStatusEnum::SUSPENDED }}" {{ old('status') == App\Enums\UserStatusEnum::SUSPENDED ? 'selected' : '' }}>Suspended</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pendidikan saat ini/terakhir</label>

                                <select class="form-select @error('last_education') is-invalid @enderror" name="last_education">
                                    <option disabled>Pilih</option>

                                    @foreach (App\Enums\LastEducationEnum::getAll() as $lastEducation)
                                        <option value="{{ $lastEducation }}" {{ old('last_education') == $lastEducation ? 'selected' : '' }}>{{ $lastEducation }}</option>
                                    @endforeach
                                </select>

                                @error('last_education')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="{{ route('dashboard.student.index') }}" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
