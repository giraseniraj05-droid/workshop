@props(['disabled' => false, 'compact' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => $compact
	? 'border-slate-300 focus:border-primary focus:ring-primary rounded-xl bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm'
	: 'border-slate-300 focus:border-primary focus:ring-primary rounded-xl bg-white text-slate-900 placeholder:text-slate-400 shadow-sm']) }}>
