<x-layouts.guest title="Daftar Akun Venue">
    <x-form.errors />

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <x-form.field name="name" label="Nama:" required autofocus />
        <x-form.field name="email" label="Email:" type="email" required />
        <x-form.field name="password" label="Kata Sandi (min. 8 karakter):" type="password" required />
        <x-form.field name="password_confirmation" label="Konfirmasi Kata Sandi:" type="password" required />

        <div class="form-button">
            <button type="submit">Daftar</button>
        </div>
    </form>

    <p class="form-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</x-layouts.guest>
