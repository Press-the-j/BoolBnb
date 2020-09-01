<?php

use Illuminate\Database\Seeder;
use App\Flat;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Str;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      $flat=new Flat();
      $flat->user_id=1;
      $flat->title = 'un appartamento molto bello';
      $flat->slug = Str::slug('un appartamento molto bello', '-');     
      $flat->position= new Point($faker->latitude , $faker->longitude);
      $flat->save();
    }
}
