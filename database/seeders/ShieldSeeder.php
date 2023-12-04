<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_course","view_any_course","create_course","update_course","restore_course","restore_any_course","replicate_course","reorder_course","delete_course","delete_any_course","force_delete_course","force_delete_any_course","view_lesson","view_any_lesson","create_lesson","update_lesson","restore_lesson","restore_any_lesson","replicate_lesson","reorder_lesson","delete_lesson","delete_any_lesson","force_delete_lesson","force_delete_any_lesson","view_topic","view_any_topic","create_topic","update_topic","restore_topic","restore_any_topic","replicate_topic","reorder_topic","delete_topic","delete_any_topic","force_delete_topic","force_delete_any_topic","view_shield::role","view_any_shield::role","create_shield::role","update_shield::role","delete_shield::role","delete_any_shield::role"]}]';
        $directPermissions = '{"24":{"name":"view_role","guard_name":"web"},"25":{"name":"view_any_role","guard_name":"web"},"26":{"name":"create_role","guard_name":"web"},"27":{"name":"update_role","guard_name":"web"},"28":{"name":"delete_role","guard_name":"web"},"29":{"name":"delete_any_role","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Utils::getRoleModel()::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $permissionModels = collect();

                    collect($rolePlusPermission['permissions'])
                        ->each(function ($permission) use($permissionModels) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web'
                            ]));
                        });
                    $role->syncPermissions($permissionModels);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Utils::getPermissionModel()::whereName($permission)->doesntExist()) {
                    Utils::getPermissionModel()::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
