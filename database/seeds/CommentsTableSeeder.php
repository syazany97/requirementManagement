<?php

use App\Models\Requirement\Requirement;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $requirementsId = Requirement::pluck('id');
        $userId = User::pluck('id');
        $commentAmount = collect([1, 3, 4]);

        $allComments = $requirementsId->map(function ($item) use ($faker, $userId, $commentAmount) {
            $comments = [];
            for ($i = 0; $i < $commentAmount->random(); $i++) {
                array_push($comments, [
                    'commentable_id' => $item,
                    'commentable_type' => Requirement::class,
                    'details' => $faker->realText(),
                    'user_id' => $userId->random(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            return $comments;
        })->flatten(1)->values()->all();

        DB::table('comments')->insert($allComments);
    }
}
