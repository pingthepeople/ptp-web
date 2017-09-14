<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Session::class, 1)->create();

        factory(App\Legislator::class, 20)->create();

        factory(App\Committee::class, 20)->create()->each(function($committee) {
            $members = App\Legislator::inRandomOrder()->take(rand(4,8))->get();
            for ($i=0; $i < $members->count(); $i++) {
                $committee->members()->attach($members[$i]->id);
            }
        });

        factory(App\Subject::class, 60)->create();

        factory(App\Bill::class, 200)->create()->each(function($bill, $index) {
            $legislators = App\Legislator::inRandomOrder()->get();
            // give each bill 1-2 Authors
            $authors = $legislators->splice(0, rand(1,2));
            for ($i=0; $i < $authors->count(); $i++) {
                $bill->authors()->attach($authors[$i]->id, ['BillPosition'=>1]);
            }
            // give each bill 2-3 coauthors
            $coauthors = $legislators->splice(0, rand(2,3));
            for ($i=0; $i < $coauthors->count(); $i++) {
                $bill->coauthors()->attach($coauthors[$i]->id, ['BillPosition'=>2]);
            }
            // give each bill 4-6 sponsors
            $coauthors = $legislators->splice(0, rand(4,6));
            for ($i=0; $i < $coauthors->count(); $i++) {
                $bill->sponsors()->attach($coauthors[$i]->id, ['BillPosition'=>3]);
            }
            // give each bill 4-6 coauthors
            $coauthors = $legislators->splice(0, rand(4,6));
            for ($i=0; $i < $coauthors->count(); $i++) {
                $bill->cosponsors()->attach($coauthors[$i]->id, ['BillPosition'=>4]);
            }

            // give each bill 1-2 committees
            $committees = App\Committee::inRandomOrder()->take(rand(1,2))->get();
            for ($i=0; $i < $committees->count(); $i++) {
                $bill->committees()->attach($committees[$i]);
            }

            // give each bill 1-6 subjects
            $subjects = App\Subject::inRandomOrder()->take(rand(1,6))->get();
            for ($i=0; $i < $subjects->count(); $i++) {
                $bill->subjects()->attach($subjects[$i]);
            }
        });
    }
}
