<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $wifi=new Service();
      $wifi->name='Wi-Fi';
      $wifi->slug='wi-fi';
      $wifi->save();

      $parking=new Service();
      $parking->name='Posto Macchina';
      $parking->slug='posto-macchina';
      $parking->save();

     
      $pool=new Service();
      $pool->name='Piscina';
      $pool->slug='piscina';
      $pool->save();

      
      $consierge=new Service();
      $consierge->name='Consierge';
      $consierge->slug='consierge';
      $consierge->save();

       
      $sauna=new Service();
      $sauna->name='Sauna';
      $sauna->slug='sauna';
      $sauna->save();

       
      $sea_view=new Service();
      $sea_view->name='Vista Mare';
      $sea_view->slug='vista-mare';
      $sea_view->save();



    }
}
