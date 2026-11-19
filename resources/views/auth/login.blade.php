<x-layouts.guest title="Login">
    <x-form.errors />

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <x-form.field name="email" label="Email" type="email" required autofocus />
        <x-form.field name="password" label="Password" type="password" required />

        <label class="checkbox">
            <input type="checkbox" name="remember" value="1"> Ingat saya
        </label>

        <button type="submit" class="btn btn-block">Masuk</button>
    </form>

    <p class="form-footer">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
</x-layouts.guest>
