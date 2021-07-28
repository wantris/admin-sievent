<?php

use App\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        foreach (range(1, 20) as $index) {
            $ps = new Participant();
            $ps->nama_participant = $faker->name;
            $ps->save();
        }
    }
}
