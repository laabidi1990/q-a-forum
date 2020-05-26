<?php

use App\User;
use App\Answer;
use App\Question;
use Illuminate\Database\Seeder;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $usersNumber = count($users);
        $votes = [-1, 1];

        foreach (Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, $usersNumber); $i++)
            {
                $user = $users[$i];
                $user->voteTheQuestion($question, $votes[rand(0, 1)]);
            }
        }

        foreach (Answer::all() as $answer)
        {
            for ($i = 0; $i < rand(1, $usersNumber); $i++)
            {
                $user = $users[$i];
                $user->voteTheAnswer($answer, $votes[rand(0, 1)]);
            }
        }
    }
}
