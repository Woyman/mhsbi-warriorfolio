<?php

use App\Models\Section;
use App\Models\Setting;
use Filament\Notifications\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Returns the first active slider for a given module.
 *
 * @param  string  $module_name  Name of the module to search for.
 * @param  Model  $model  Eloquent model instance related to the slider.
 * @return Model|Collection|null The first active slider found or null.
 */
if (! function_exists('getSlider')) {
    function getSlider(string $module_name, Model $model): Model|Collection|null
    {
        $sliders = $model
            ->query()
            ->select()
            ->where('module_name', '=', $module_name)
            ->where('is_active', '=', true)
            ->get();

        return $sliders->first();
    }

    /**
     * Retrieves settings from the layout container in the database.
     *
     * @param  string  $key  The configuration key (e.g., 'layout.name').
     * @param  mixed  $default  Default value if the key does not exist.
     * @return mixed The configuration value or the default value.
     */
    if (! function_exists('settings')) {
        function settings(string $key, mixed $default = null): mixed
        {
            $setting = Setting::query()
                ->with(['layout'])
                ->first();

            return data_get($setting, $key, $default);
        }
    }

    /**
     * Admin-facing plural label for the Notes (blog) module — from Settings or default "Notes".
     */
    if (! function_exists('notesModuleLabel')) {
        function notesModuleLabel(): string
        {
            $custom = settings('blog.module_label');

            return filled($custom) ? (string) $custom : (string) __('Notes');
        }
    }

    /**
     * Admin-facing singular label for a single entry — from Settings or default "Note".
     */
    if (! function_exists('notesEntryLabel')) {
        function notesEntryLabel(): string
        {
            $custom = settings('blog.module_entry_label');

            return filled($custom) ? (string) $custom : (string) __('Note');
        }
    }

    /**
     * Whether a navigation URL points at the blog listing (single path segment, e.g. /blog), not a single post.
     */
    if (! function_exists('isBlogListingNavigationUrl')) {
        function isBlogListingNavigationUrl(?string $url): bool
        {
            if (! filled($url)) {
                return false;
            }
            $path = parse_url($url, PHP_URL_PATH);
            if ($path === null || $path === false || $path === '') {
                $path = $url;
            }
            $segments = array_values(array_filter(explode('/', trim((string) $path, '/'))));
            $blogBase = trim((string) config('warriorfolio.app_blog_basepath', 'blog'), '/');
            if ($blogBase === '') {
                $blogBase = 'blog';
            }

            return count($segments) === 1 && $segments[0] === $blogBase;
        }
    }

    /**
     * @param  array<int, array<string, mixed>>|null  $navigation
     * @return array<int, array<string, mixed>>|null
     */
    if (! function_exists('navigationContentWithNotesModuleLabels')) {
        function navigationContentWithNotesModuleLabels(?array $navigation): ?array
        {
            if ($navigation === null) {
                return null;
            }

            return array_map(static function (array $item): array {
                if (! isBlogListingNavigationUrl($item['url'] ?? null)) {
                    return $item;
                }
                $item['name'] = navigationItemNameWithNotesModuleLabel((string) ($item['name'] ?? ''));

                return $item;
            }, $navigation);
        }
    }

    /**
     * Replace plain-text prefix of a nav item title with the configured module label; keep trailing HTML (badges, etc.).
     */
    if (! function_exists('navigationItemNameWithNotesModuleLabel')) {
        function navigationItemNameWithNotesModuleLabel(string $existingName): string
        {
            $label = e(notesModuleLabel());
            $pos = strpos($existingName, '<');
            if ($pos !== false) {
                return $label.' '.substr($existingName, $pos);
            }

            return $label;
        }
    }

    /**
     * Replace default English “Notes” / “Note” words in blog setting HTML with the configured module labels.
     */
    if (! function_exists('blogHtmlWithNotesModuleLabels')) {
        function blogHtmlWithNotesModuleLabels(string $html): string
        {
            $label = e(notesModuleLabel());
            $entry = e(notesEntryLabel());
            $html = preg_replace('/\bNotes\b/u', $label, $html);
            $html = preg_replace('/\bNote\b/u', $entry, $html);

            return $html;
        }
    }

    /**
     * @param  array<string, mixed>  $blog
     * @return array<string, mixed>
     */
    if (! function_exists('blogForFrontDisplay')) {
        function blogForFrontDisplay(array $blog): array
        {
            foreach ([
                'name',
                'description',
                'header_title',
                'header_subtitle',
                'button',
                'more_articles_title',
                'more_articles_btn_title',
            ] as $key) {
                if (! empty($blog[$key]) && is_string($blog[$key])) {
                    $blog[$key] = blogHtmlWithNotesModuleLabels($blog[$key]);
                }
            }

            return $blog;
        }
    }

    /**
     * Limits content to a number of words, removing <figure> tags.
     *
     * @param  string  $content  HTML or text content.
     * @param  int  $words  Maximum number of words.
     * @param  string  $end  Suffix to indicate truncation.
     * @return string Formatted content.
     */
    if (! function_exists('formatContent')) {
        function formatContent(string $content, int $words = 15, string $end = '...'): string
        {
            return Str::words(
                preg_replace('/<figure[^>]*>.*?<\/figure>/s', '', strip_tags($content, '<figure>')),
                $words,
                $end
            );
        }
    }

    /**
     * Returns the activation status of a section by slug.
     *
     * @param  string  $slug  Section identifier slug.
     * @return Section|null Section instance with the is_active field or null.
     */
    if (! function_exists('sectionStatus')) {
        function sectionStatus($slug)
        {
            return Section::where('slug', $slug)->first(['is_active']);
        }
    }
}
