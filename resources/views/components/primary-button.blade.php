@props(['compact' => false])

<button {{ $attributes->merge(['type' => 'submit', 'class' => $compact
    ? 'auth-gradient-button inline-flex items-center justify-center rounded-xl border border-transparent px-4 py-2.5 text-sm font-semibold text-white shadow-xl shadow-primary/20 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-white transition'
    : 'auth-gradient-button inline-flex items-center justify-center rounded-xl border border-transparent px-4 py-3 text-sm font-semibold text-white shadow-xl shadow-primary/20 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-white transition']) }}>
    {{ $slot }}
</button>
