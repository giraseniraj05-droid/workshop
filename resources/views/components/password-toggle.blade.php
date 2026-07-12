@props([
    'name' => 'password',
    'id' => 'password',
    'value' => '',
    'autocomplete' => 'current-password',
    'placeholder' => '',
    'required' => false,
    'compact' => false,
])

<div x-data="passwordVisibility()" class="relative">
    <input
        {{ $attributes->merge([
            'id' => $id,
            'name' => $name,
            'type' => 'password',
            'value' => $value,
            'autocomplete' => $autocomplete,
            'placeholder' => $placeholder,
            'class' => $compact
                ? 'block w-full rounded-xl border-slate-300 bg-white px-3.5 py-2.5 pe-11 text-sm text-primary-darker placeholder:text-slate-400 shadow-sm focus:border-primary focus:ring-primary'
                : 'block w-full rounded-xl border-slate-300 bg-white px-4 py-3 pe-12 text-primary-darker placeholder:text-slate-400 shadow-sm focus:border-primary focus:ring-primary',
        ]) }}
        @if ($required) required @endif
        x-bind:type="visible ? 'text' : 'password'"
    >

    <button
        type="button"
        class="absolute inset-y-0 end-0 flex items-center px-4 text-primary-dark hover:text-primary focus:outline-none"
        @click="toggle()"
        :aria-label="visible ? '{{ __('Hide password') }}' : '{{ __('Show password') }}'"
    >
        <i class="fa-regular" :class="visible ? 'fa-eye-slash' : 'fa-eye'"></i>
    </button>
</div>
