@props(['name', 'label', 'type' => 'text', 'value' => null])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
        {{ $attributes->class(['is-invalid' => $errors->has($name)]) }}
    >
</div>
