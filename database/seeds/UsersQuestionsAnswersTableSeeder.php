<?php

use App\User;
use App\Answer;
use App\Question;
use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()->each(function($user) {
            $user->questions()->saveMany(factory(Question::class, rand(1, 10))->make())
            ->each(function($question) {
                $question->answers()->saveMany(factory(Answer::class, rand(0,10))->make());
            });
        });
    }
}
