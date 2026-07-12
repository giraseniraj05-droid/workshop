<x-guest-layout page="legal">
    <x-auth-card :title="$title" :subtitle="$subtitle" class="mx-auto max-w-3xl">
        <div class="space-y-4 text-sm leading-7 text-slate-600">
            @foreach ($paragraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </x-auth-card>
</x-guest-layout>
