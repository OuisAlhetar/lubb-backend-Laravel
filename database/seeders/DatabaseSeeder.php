<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories first
        Category::factory()->count(5)->create();

        // Create users
        // User::factory()->count(10)->create();
        $superAdmin = User::factory()->create([
            'name' => 'Jaleela Abbas',
            'email' => 'jaleela@gmail.com',
        ]);
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdmin->assignRole($superAdminRole);

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        $role = Role::create(['name' => 'Admin']);
        $user->assignRole($role);

        $testUser = User::factory()->create([
            'name' => 'Writer',
            'email' => 'writer@gmail.com',
        ]);

        $testRole = Role::create(['name' => 'Writer']);
        $testUser->assignRole($testRole);

        Section::factory()->count(3)->create();

        // Create items (books, audiobooks, etc.)
        Item::factory()->count(20)->create();


    }
}
