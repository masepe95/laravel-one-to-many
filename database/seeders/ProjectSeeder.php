<?php

namespace Database\Seeders;

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        Storage::makeDirectory('project_images');
        for ($i = 0; $i < 20; $i++) {
            $proj = new Project();
            $proj->title = $faker->text(20);
            $proj->slug = Str::slug($proj->title, '-');
            $proj->image = $faker->image(storage_path('app/public/project_images'), 250, 250);
            $proj->description = $faker->paragraph(10, true);
            $proj->main_lang = $faker->word();
            $proj->other_langs = $faker->words(3, true);
            $proj->n_stars = $faker->randomDigit();
            $proj->is_public = $faker->boolean();
            $proj->save();
        }
    }
}
