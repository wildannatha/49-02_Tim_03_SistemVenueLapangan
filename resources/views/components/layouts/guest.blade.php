@props(['title'])

<x-layouts.base :title="$title">
    <main class="main-content">
        <div class="form-card">
            <h1 class="form-title">{{ $title }}</h1>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif
            
            {{ $slot }}
        </div>
    </main>
</x-layouts.base>
