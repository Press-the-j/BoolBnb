<?php

use Illuminate\Database\Seeder;
use App\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotionA=new Promotion();
        $promotionA->type= 'base';
        $promotionA->duration=24;
        $promotionA->price=2.99;
        $promotionA->save();

        $promotionB=new Promotion();
        $promotionB->type= 'medium';
        $promotionB->duration=72;
        $promotionB->price=5.99;
        $promotionB->save();

        $promotionC=new Promotion();
        $promotionC->type= 'premium';
        $promotionC->duration=144;
        $promotionC->price=9.99;
        $promotionC->save();


    }
}
