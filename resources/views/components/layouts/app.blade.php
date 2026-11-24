@props(['title'])

<x-layouts.base :title="$title">
    <x-nav />

    <main class="main-content">
        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </main>
</x-layouts.base>
