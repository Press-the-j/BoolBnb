<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin=new Role();
      $admin->name= 'admin';
      $admin->slug= 'admin';
      $admin->save();

      $upr=new Role();
      $upr->name= 'upr';
      $upr->slug= 'upr';
      $upr->save();

      
      $upra=new Role();
      $upra->name= 'upra';
      $upra->slug= 'upra';
      $upra->save();
    }
}
