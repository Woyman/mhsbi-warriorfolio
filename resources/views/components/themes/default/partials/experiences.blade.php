{{-- Experience Timeline Feed --}}

<div id="profile-experience-header" class="profile-course-header mb-8 flex items-center gap-2 text-sm font-semibold">
    <x-ui.ionicon :icon="'briefcase-sharp'" />
    {{ __('Experience') }}
</div>

<ol class="relative border-s border-secondary-100 p-4 dark:border-secondary-800">
    @forelse ($experiences as $experience)
    <li class="mb-10 ms-4">
        <div
            class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-secondary-50 bg-secondary-200 dark:border-secondary-950 dark:bg-secondary-700">
        </div>
        <h3 class="mb-1 text-sm font-semibold">
            {{ $experience->title }}
        </h3>
        <p class="mb-1">
            {{ $experience->company }}
        </p>
        <p class="mb-2 text-sm font-normal leading-none opacity-55">
            {{ \Carbon\Carbon::parse($experience->start_date)->format('M, Y') }} -
            {{ $experience->currently_working ? __('Present') : ($experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M, Y') : __('Present')) }}
        </p>
        @if ($experience->skills)
        <p class="text-xs opacity-80">
            {{ $experience->skills }}
        </p>
        @endif
        @if ($experience->description)
        <p class="mt-2 text-xs leading-relaxed opacity-80">
            {{ $experience->description }}
        </p>
        @endif
    </li>
    @empty
    <x-ui.empty-section :auth="'Update your Experience'" />
    @endforelse
</ol>
