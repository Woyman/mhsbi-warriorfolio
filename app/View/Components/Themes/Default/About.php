<?php

namespace App\View\Components\Themes\Default;

use App\Models\Course;
use App\Models\Experience;
use App\Models\Setting;
use App\Models\Slideshow;
use App\Models\User;
use App\Traits\SectionLoader;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class About extends Component
{
    /**
     * Create a new component instance.
     */
    use SectionLoader;

    public $user;

    public $courses;

    public $experiences;

    public $sliders;

    public function __construct()
    {
        $this->loadSection('about-me');
        $this->user = $this->user();
        $this->courses = $this->courses();
        $this->experiences = $this->experiences();
        $this->sliders = $this->sliders();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.themes.default.about');
    }

    public function courses()
    {
        return Course::all()
            ->sortDesc()
            ->take(5);
    }

    public function sliders()
    {
        return getSlider('about-me', new Slideshow);
    }

    public function experiences()
    {
        return Experience::query()
            ->orderByDesc('start_date')
            ->take(5)
            ->get();
    }

    public function user()
    {
        return User::first();
    }
}
