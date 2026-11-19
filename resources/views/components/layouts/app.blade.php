@props(['title', 'width' => 'md'])

<x-layouts.base :title="$title">
    <x-nav />

    <main class="container container-{{ $width }}">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </main>
</x-layouts.base>
