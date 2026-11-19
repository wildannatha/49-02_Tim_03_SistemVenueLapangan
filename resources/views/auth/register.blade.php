<x-layouts.guest title="Daftar Akun">
    <x-form.errors />

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <x-form.field name="name" label="Nama" required autofocus />
        <x-form.field name="email" label="Email" type="email" required />
        <x-form.field name="password" label="Password (min. 8 karakter)" type="password" required />
        <x-form.field name="password_confirmation" label="Konfirmasi Password" type="password" required />

        <button type="submit" class="btn btn-block">Daftar</button>
    </form>

    <p class="form-footer">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</x-layouts.guest>
