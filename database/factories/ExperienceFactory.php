<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-8 years', '-1 year');
        $isCurrent = fake()->boolean(25);
        $endDate = $isCurrent ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'title'             => fake()->randomElement([
                'Software Engineer',
                'Backend Developer',
                'Fullstack Developer',
                'Frontend Developer',
                'Web Developer',
            ]),
            'company'           => fake()->company(),
            'start_date'        => $startDate,
            'end_date'          => $endDate,
            'currently_working' => $isCurrent,
            'skills'            => fake()->randomElement([
                'Laravel, PHP, MySQL',
                'TypeScript, React, TailwindCSS',
                'REST API, Docker, Git',
                'Node.js, PostgreSQL, Redis',
                null,
            ]),
            'description' => fake()->boolean(80)
                ? fake()->text(180)
                : null,
        ];
    }
}
