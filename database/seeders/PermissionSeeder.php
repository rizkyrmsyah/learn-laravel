<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities = ["authors", "books", "categories"];
        $routes = ["index", "store", "show", "update", "destroy"];

        try {
            DB::beginTransaction();

            foreach($entities as $entity){
                foreach($routes as $route){
                    $permission = new Permission;
                    $permission->id = Str::uuid();
                    $permission->name = $entity.'.'.$route;
                    $permission->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
