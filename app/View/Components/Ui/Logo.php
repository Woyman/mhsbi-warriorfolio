<?php

namespace App\View\Components\Ui;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;

class Logo extends Component
{
    /**
     * @param  string|bool|null  $link  Absolute URL, or false to disable the wrapping link
     */
    public function __construct(
        public ?string $logo = null,
        public ?string $logoDark = null,
        public ?string $logoSize = null,
        public string|bool|null $link = null,
        public ?string $siteName = null,
        public ?string $size = null,
    ) {
        $setting = Schema::hasTable('settings') ? Setting::first() : null;
        $design = $setting?->design ?? [];
        $application = $setting?->application ?? [];

        $this->logo ??= $design['logo'] ?? null;
        $this->logoDark ??= $design['logo_dark_mode'] ?? $design['logo_dark'] ?? null;
        $this->logoSize ??= $design['logo_size'] ?? null;

        if ($this->link === null) {
            $this->link = $design['logo_link'] ?? config('app.url');
        }

        $this->siteName ??= $application['name'] ?? config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.logo', [
            //
        ]);
    }
}
