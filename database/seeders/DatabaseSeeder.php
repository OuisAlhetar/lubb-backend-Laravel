<?php
//
//namespace Database\Seeders;
//
//// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
//
//
//class DatabaseSeeder extends Seeder
//{
//    /**
//     * Seed the application's database.
//     */
//    public function run(): void
//    {
//        Permission::create(['name' => 'upload movies']);
//        Permission::create(['name' => 'upload audiobook summaries']);
//        Permission::create(['name' => 'upload movie summaries']);
//
//        // Create Roles and assign permissions
//        $userRole = Role::create(['name' => 'user']);
//        $PodcastUploaderRole = Role::create(['name' => 'podcast-uploader']);
//        $MovieUploaderRole = Role::create(['name' => 'movie-uploader']);
//        $SuperAdminRole = Role::create(['name' => 'super-admin']);
//
//        // Assign permissions to roles
//        $SuperAdminRole->givePermissionTo(['upload movies', 'upload audiobook summaries', 'upload movie summaries']);
//        $MovieUploaderRole->givePermissionTo(['create posts', 'edit posts']);
//
//        // \App\Models\User::factory(10)->create();
//
//        // \App\Models\User::factory()->create([
//        //     'name' => 'Test User',
//        //     'email' => 'test@example.com',
//        // ]);
//    }
//}


namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

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
        User::factory()->count(10)->create();

        Section::factory()->count(3)->create();

        // Create items (books, audiobooks, etc.)
        Item::factory()->count(20)->create();


    }
}
