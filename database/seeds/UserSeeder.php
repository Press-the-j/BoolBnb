<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = new User();
      $admin->name = 'Admin';
      $admin->surname='Admin';
      $admin->date_birth='1900-10-10';
      $admin->image_path='default';
      $admin->email = 'Admin@admin.com';
      $admin->password = bcrypt('admin');
      $admin->save();
      $admin->roles()->attach(Role::where('slug', 'admin')->first());
      
      $fakeUser = new User();
      $fakeUser->name = 'fakeOne';
      $fakeUser->surname='fakeOne';
      $fakeUser->date_birth='1901-10-10';
      $fakeUser->image_path='default';
      $fakeUser->email = 'fake@one.com';
      $fakeUser->password = bcrypt('fake');
      $fakeUser->save();
      $fakeUser->roles()->attach(Role::where('slug', 'upra')->first());

      $fakeUser2 = new User();
      $fakeUser2->name = 'fakeTwo';
      $fakeUser2->surname='fakeTwo';
      $fakeUser2->date_birth='1901-10-10';
      $fakeUser2->image_path='default';
      $fakeUser2->email = 'fake@two.com';
      $fakeUser2->password = bcrypt('fake');
      $fakeUser2->save();
      $fakeUser2->roles()->attach(Role::where('slug', 'upr')->first());

    }
}
