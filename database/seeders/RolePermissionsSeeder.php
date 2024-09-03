<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $permissions = ['show', 'create', 'update', 'delete'];
    private $modelsDirectory;
    private $modelNames;
    private $modelFiles;
    public function run(): void
    {
        $this->modelsDirectory = app_path('Models');
        // $this->modelFiles = File::files($this->modelsDirectory);
        $this->modelFiles = File::allFiles($this->modelsDirectory);
        // Extract the model class names from the file paths
        $this->modelNames = collect($this->modelFiles)
            ->map(function ($file) {
                // Get the file name without the extension
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                return "$fileName";
            })
            ->push('Role' , 'Permission');
            // meger is new 
            // ->merge($this->customPermissions)->toArray();
        $admin_role = Role::create(['name' => 'admin']);
        $client_role = Role::create(['name' => 'client', 'guard_name' => 'api']);
        $admin_role->save();
        $client_role->save();
        foreach ($this->modelNames as $modelName) {
            foreach ($this->permissions as $permission) {
                $permission = Permission::create(['name' => $modelName . ' ' . $permission , 'guard_name' => 'api']);
                if($permission->save())
                $admin_role->givePermissionTo($permission);
                // $role1->givePermissionTo($permission);
            }
        }
        // $custom_permissions = [
        //     'Book add to fovorite' , 'Book remove from fovorite' , 'Book library index',
        // ];
        // foreach($custom_permissions as $cus_per)
        // Permission::create([
        //     'name' => $cus_per,
        // ]);


    }
}
