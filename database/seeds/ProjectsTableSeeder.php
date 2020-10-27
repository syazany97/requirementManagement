<?php

use App\Models\Module;
use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementPriority;
use App\Models\Requirement\RequirementStatus;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 3; $i++) {
            Project::create([
                'name' => $faker->catchPhrase,
                'uuid' => Str::uuid()->toString(),
                'description' => $faker->realText,
                'user_id' => 1,
                'project_status_id' => ProjectStatus::first()->id]);
        }
    }
}
