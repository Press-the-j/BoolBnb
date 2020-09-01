<?php

use Illuminate\Database\Seeder;
use App\FlatInfo;

class FlatInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flat_info1= new FlatInfo();
        $flat_info1->flat_id=1;
        $flat_info1->image_path='default';
        $flat_info1->description='questo è un tipo di flat';
        $flat_info1->city= 'Roma';
        $flat_info1->address= 'via del corso';
        $flat_info1->postal_code= '00186';
        $flat_info1->square_meters = 44;
        $flat_info1->price= 50;
        $flat_info1->max_guest=4;
        $flat_info1->save();

    }
}
