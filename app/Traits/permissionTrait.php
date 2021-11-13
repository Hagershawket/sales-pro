<?php
 namespace App\Traits;
 use DB;

 trait permissionTrait{

    public function checkPermission( $role , $permission )
    {
        $add_permission = DB::table('permissions')->where([
            ['name', $permission],
            ['guard_name', 'admin']
        ])->first();
        $permission_active = DB::table('role_has_permissions')->where([
            ['permission_id', $add_permission->id],
            ['role_id', $role->id]
        ])->first();

        return $permission_active;
    }
 }