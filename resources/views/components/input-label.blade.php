@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-primary-dark']) }}>
    {{ $value ?? $slot }}
</label>
