<?php

use App\Models\Project\Project;
use App\Models\Requirement\Requirement;
use App\Models\Requirement\RequirementPriority;
use App\Models\TestCase\TestCase;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class TestCaseStepsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $usersId = User::pluck('id');

        $requirementsId = Requirement::pluck('id');

        $requirementPriorities = RequirementPriority::pluck('id');

        $testCases = [];

        for($i = 0; $i< $requirementsId->count(); $i++) {

            $testCase = [
                'requirement_id' => $requirementsId[$i],
                'user_id' => $usersId->random(),
                'title' => 'Test Case : Allow to set log in page',
                'preconditions' => $faker->text(),
                'description' => $faker->realText(),
                'execution_date' => now(),
                'priority_id' => $requirementPriorities->random(),
                'created_at' => now(),
                'updated_at' => now()
            ];
            array_push($testCases, $testCase);
        }


        DB::table('test_cases')->insert($testCases);

        $testCaseSteps = [];
        $testCaseId = TestCase::pluck('id');
        $boolean = collect([true, false]);

//        for ($i = 0; $i < $testCaseId->count(); $i++) {
        for ($i = 0; $i < 200; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $step = [
                    'test_case_id' => $testCaseId[$i],
                    'description' => $faker->realText(),
                    'order' => $j + 1,
                    'expected_result' => $faker->realText(),
                    'input' => $faker->realText(),
                    'is_passed' => $boolean->random(),
                    'comment' => $faker->realText(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                array_push($testCaseSteps, $step);
            }
        }

        DB::table('test_case_steps')->insert($testCaseSteps);

    }
}
