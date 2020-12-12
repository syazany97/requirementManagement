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
use Illuminate\Support\Facades\DB;
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
        $projects = [];
        $statusId = ProjectStatus::first()->id;

        for ($i = 0; $i < 40; $i++) {
            $project = [
                'name' => $faker->catchPhrase,
                'uuid' => Str::uuid()->toString(),
                'description' => $faker->realText,
                'user_id' => 1,
                'project_status_id' => $statusId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            array_push($projects, $project);
        }

        DB::table("projects")->insert($projects);
    }
}
