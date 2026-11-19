@props(['label', 'value', 'small' => false])

<div @class(['stat-card', 'stat-card-small' => $small])>
    <div class="stat-label">{{ $label }}</div>
    <div class="stat-value">{{ $value }}</div>
</div>
