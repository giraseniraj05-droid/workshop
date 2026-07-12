@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'w-full max-w-xl']) }}>
    <div class="overflow-hidden rounded-[2rem] border border-white/80 bg-white shadow-2xl shadow-blue-950/10 backdrop-blur transition focus-within:border-primary/30 focus-within:shadow-2xl">
        @if ($title || $subtitle)
            <div class="border-b border-slate-100 bg-[linear-gradient(135deg,var(--primary-lightest)_0%,#ffffff_50%,var(--secondary-lightest)_100%)] px-6 py-7 sm:px-8">
                @if ($title)
                    <h1 class="text-3xl font-black tracking-tight text-primary-darker sm:text-4xl">
                        {{ $title }}
                    </h1>
                @endif

                @if ($subtitle)
                    <p class="mt-3 text-sm leading-6 text-slate-600 sm:text-base">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <div class="px-6 py-8 sm:px-8 sm:py-9">
            {{ $slot }}
        </div>
    </div>
</div>
