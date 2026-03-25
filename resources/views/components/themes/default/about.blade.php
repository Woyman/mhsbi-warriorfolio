@if ($is_active)
<x-core.layout :$is_filled :$with_padding :$module_name :$button_header :$button_url :$is_centered :$title :$subtitle
    :$is_section_filled_inverted :$is_heading_visible :$button_icon :$module_slug>
    <div class="my-12 flex flex-wrap" id="about-section-wrapper">
        {{-- Profile Section --}}
        <div class="w-full p-4 text-center md:w-1/3 lg:w-1/4 lg:p-8" id="profile">
            <x-themes.common.profile />
        </div>
        {{-- About Section --}}
        <div class="about-you-section w-full p-4 text-sm leading-loose md:w-2/3 lg:w-3/4 lg:px-8">
            <div class="profile-course-header mb-8 flex items-center gap-2 text-sm font-semibold"
                id="profile-course-header">
                <x-ui.ionicon :icon="'rocket-sharp'" />
                {{ __('Bio') }}
            </div>
            {!! $user->profile->about !!}
            {{-- Empty Section --}}
            @if (!$user->profile->about)
            <x-ui.empty-section :auth="'Update your Bio'" />
            @endif

            <div class="mt-12 flex md:flex-row flex-col  gap-8">
                <div class="w-full lg:flex-1 md:w-1/2">
                    {{-- Experiences Section --}}
                    <x-themes.default.partials.experiences :$experiences />
                </div>

                <div class="w-full lg:flex-1 md:w-1/2">
                    {{-- Courses and Graduations Section --}}
                    <x-themes.default.partials.courses :$courses />
                </div>
            </div>
        </div>
    </div>
    {{-- Core: Slider --}}
</x-core.layout>
@endif
