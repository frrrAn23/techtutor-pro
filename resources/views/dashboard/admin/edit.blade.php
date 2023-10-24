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

                <h4 class="card-title">Ubah Admin</h4>
                <p class="card-title-desc">Ubah informasi dibawah ini</p>

                <form method="POST" action="{{ route('dashboard.admin.update', $admin->id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') ?? $admin->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukan email" name="email" value="{{ old('email') ?? $admin->email }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="avatar-url" class="form-label">Foto Profile</label>
                                <small class="text-muted">(Opsional)</small>
                                <img class="d-block mt-1 mb-1" src="{{ getFile($admin->avatar_url, asset('images/default-profile.jpg')) }}" height="100">
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
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Masukan username" name="username" value="{{ old('username') ?? $admin->username }}">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new-password" class="form-label">Password Baru</label>
                                <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new-password" placeholder="Masukan password baru" name="new_password">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>

                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option disabled>Pilih</option>
                                    <option value="{{ App\Enums\UserStatusEnum::ACTIVE }}" {{ (old('status') ?? $admin->status) == App\Enums\UserStatusEnum::ACTIVE ? 'selected' : '' }}>Active</option>
                                    <option value="{{ App\Enums\UserStatusEnum::SUSPENDED }}" {{ (old('status') ?? $admin->status) == App\Enums\UserStatusEnum::SUSPENDED ? 'selected' : '' }}>Suspended</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <a href="{{ route('dashboard.admin.index') }}" class="btn btn-secondary waves-effect waves-light">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@endpush
