<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Super-Admin permissions
        $superAdminPermissions = [
            'update_ui_images',
            'update_ui_text',
            'create_admins_accounts',
            'give_permissions',
            'upload_summaries_for_all_sections',
            'add_new_section',
            'update_section',
            'delete_section',
            'add_new_tag',
            'update_tag',
            'delete_tag',
            'add_new_category',
            'update_category',
            'delete_category',
            'full_control'
        ];

        // Admin permissions managed by the Super-Admin
        $adminPermissions = [
            'upload_movie_summary',
            'upload_audiobook_summary',
            'upload_podcast_summary',
            'add_new_tag',
            'update_tag',
            'delete_tag'
        ];

        // Create and assign permissions
        Role::findOrCreate('super-admin');
        Role::findOrCreate('admin');

        // Attach permissions to super-admin
        foreach ($superAdminPermissions as $permission) {
            Permission::findOrCreate($permission);
            Role::findByName('super-admin')->givePermissionTo($permission);
        }

        // Create permissions for admin
        foreach ($adminPermissions as $permission) {
            Permission::findOrCreate($permission);
        }
    }
}