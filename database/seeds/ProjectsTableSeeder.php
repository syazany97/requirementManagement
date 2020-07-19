<?php

use App\Models\Module;
use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

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
        $usersId = User::pluck('id')->toArray();

        for ($i = 0; $i < 3; $i++) {
            Project::create([
                'name' => $faker->catchPhrase,
                'description' => $faker->realText,
                'user_id' => rand(0, count($usersId) - 1),
                'project_status_id' => ProjectStatus::first()->id]);
        }

        $projectsId = Project::pluck('id')->toArray();

        // create parent module
        $parentModulesName = [
            'Login and registration',
            'Searching the application',
            'Leave application',
            'Advanced claim request',
            'Profile'
        ];

        foreach ($projectsId as $id) {
            $i = 0;

            foreach ($parentModulesName as $moduleName) {
                Module::create([
                    'project_id' => $id,
                    'title' => $moduleName,
                    'numbering' => 1 . $i
                ]);
                $i++;
            }


        }

        //create module
        $parentModulesId = Module::whereNull('parent_id')->select('id', 'project_id', 'numbering')->get();

        foreach ($parentModulesId as $parentId) {
            for ($j = 0; $j < 6; $j++) {
                Module::create([
                    'project_id' => $parentId->project_id,
                    'parent_id' => $parentId->id,
                    'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                    'numbering' => $parentId->numbering . '.' . $j
                ]);
            }
        }


    }
}
