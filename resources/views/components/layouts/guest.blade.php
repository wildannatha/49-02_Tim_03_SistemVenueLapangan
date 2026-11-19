@props(['title'])

<x-layouts.base :title="$title">
    <main class="container container-xs guest">
        <div class="card">
            <h1>{{ $title }}</h1>

            {{ $slot }}
        </div>
    </main>
</x-layouts.base>
