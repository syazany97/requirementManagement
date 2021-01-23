<?php


namespace App\Services;


use App\Models\Requirement\Requirement;
use App\Models\TestCase\TestCase;
use App\User;

class DeleteDemoUsersAction
{
    public static function execute()
    {
        $users = User::demo()->with(['projects'])->get();

        if ($users->isNotEmpty()) {
            $users->each(function (User $user) {
                $user->projects()->delete();
                $user->assignedRequirements()->detach();
                $user->comments()->delete();
                $user->requirements->each(function (Requirement $requirement) {
                    $requirement->testCases->each(function (TestCase $testCase) {
                        $testCase->steps()->delete();
                    });
                    $requirement->assignees()->detach();
                    $requirement->delete();
                });
                $user->testCases->each(function(TestCase $testCase) {
                    $testCase->steps()->delete();
                    $testCase->delete();
                });
                try {
                    $user->delete();
                } catch (\Exception $e) {
                }
            });
        }

        return true;
    }
}
