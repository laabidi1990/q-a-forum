<?php

use App\Question;
use App\User;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->all();
        $usersNumber = count($users);

        foreach (Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, $usersNumber); $i++)
            {
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }
    }
}
