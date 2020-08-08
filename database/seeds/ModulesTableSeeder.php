<?php

use App\Models\Module;
use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementPriority;
use App\Models\Requirement\RequirementStatus;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        $usersId = User::pluck('id');

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
                    'uuid' => Str::uuid()->toString(),
                    'name' => $moduleName,
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
                    'uuid' => Str::uuid()->toString(),
                    'parent_id' => $parentId->id,
                    'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
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

        foreach ($normalModule as $module) {
            for ($i = 1; $i < 5; $i++) {
                Requirement::create([
                    'module_id' => $module['id'],
                    'uuid' => Str::uuid()->toString(),
                    'description' => $faker->realText(),
                    'name' => 'Requirement ' . $i,
                    'requirement_priority_id' => $priorities[rand(0, count($priorities) - 1)],
                    'requirement_status_id' => $requirementStatuses[rand(0, count($requirementStatuses) - 1)],
                    'numbering' => $module['numbering'] . '.' . $i,
                    'creator_id' => $usersId->random()
                ]);

            }
        }

        $requirementsId = Requirement::pluck('id');

        $requirementAssignees = $requirementsId->map(function ($value) use ($usersId) {
            $assignees = [];
            $loop = collect([2, 4])->random();
            for ($i = 0; $i < $loop; $i++) {
                array_push($assignees, [
                    'assignee_id' => $usersId->random(),
                    'requirement_id' => $value,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            return $assignees;
        })->flatten(1)->values()->all();

        DB::table('requirement_assignees')->insert($requirementAssignees);


    }
}
