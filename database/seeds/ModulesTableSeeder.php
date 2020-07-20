<?php

use App\Models\Module;
use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projectsId = Project::pluck('id')->toArray();

        $usersId = User::pluck('id')->toArray();

        // create parent module
        $parentModulesName = [
            'Login and registration',
            'Searching the application',
            'Leave application',
            'Advanced claim request',
            'Profile'
        ];

        foreach ($projectsId as $id) {
            $i = 1;

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
            for ($j = 1; $j < 7; $j++) {
                Module::create([
                    'project_id' => $parentId->project_id,
                    'parent_id' => $parentId->id,
                    'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                    'numbering' => $parentId->numbering . '.' . $j
                ]);
            }
        }

        $normalModule = Module::whereNotNull('parent_id')->get()
            ->toArray();

        $priorities = RequirementPriority::pluck('id')
            ->toArray();

        $requirementStatuses = RequirementStatus::pluck('id')
            ->toArray();

        foreach($normalModule as $module) {
            for($i = 1; $i<5; $i++) {
                Requirement::create([
                    'module_id' => $module['id'],
                    'description' => $faker->realText(),
                    'name' => 'Requirement ' . $i,
                    'requirement_priority_id' => $priorities[rand(0, count($priorities) - 1)],
                    'requirement_status_id' => $requirementStatuses[rand(0, count($requirementStatuses) - 1)],
                    'numbering' => $module['numbering'] . '.' . $i,
                    'assigned_id' =>  $usersId[rand(0, count($usersId) - 1)],
                    'creator_id' =>  $usersId[rand(0, count($usersId) - 1)]
                ]);

            }
        }
    }
}
