@extends('layouts.admin')
@section('title', 'Ubah Password')
@section('topbar', 'Keamanan Akun')

@section('content')
<div class="heading">
    <div>
        <h1>Ubah Password</h1>
        <p>Gunakan password unik agar dashboard Temoe Tumbuh tetap aman.</p>
    </div>
</div>

<div class="card card-pad" style="max-width:680px">
    <form method="post" action="{{ route('admin.password.update') }}" class="stack">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="current_password">Password saat ini</label>
            <input
                class="input"
                id="current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                required
            >
            @error('current_password')<div class="help" style="color:var(--danger)">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password">Password baru</label>
            <input
                class="input"
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                minlength="12"
                required
            >
            <div class="help">Minimal 12 karakter, memakai huruf besar, huruf kecil, angka, dan simbol.</div>
            @error('password')<div class="help" style="color:var(--danger)">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Ulangi password baru</label>
            <input
                class="input"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                minlength="12"
                required
            >
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Simpan Password Baru</button>
        </div>
    </form>
</div>
@endsection
