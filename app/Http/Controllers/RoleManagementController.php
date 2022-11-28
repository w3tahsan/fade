<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Symfony\Component\String\b;

class RoleManagementController extends Controller
{
    function role_manager(){
        $all_user = User::all();
        $all_permission = Permission::all();
        $all_roles = Role::all();
        return view('admin.role.role_manager', [
            'all_permission'=>$all_permission,
            'all_roles'=>$all_roles,
            'all_user'=>$all_user,
        ]);
    }

    function add_permission(Request $request){
        Permission::create(['name' => $request->permission_name]);
        return back();
    }

    function add_role(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back();
    }

    function assign_role(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role_id);
        return back();
    }

    function edit_permission($user_id){
        $user_info = User::find($user_id);
        $all_permission = Permission::all();
        return view('admin.role.edit_permission', [
            'all_permission'=>$all_permission,
            'user_info'=>$user_info,
        ]);
    }

    function update_permission(Request $request){
        $user = User::find($request->user_id);
        $user->syncPermissions($request->permission);
        return back();
    }

    function remove_role($user_id){
        $user = User::find($user_id);
        $user->syncRoles([]);
        $user->syncPermissions([]);
        return back();
    }

    function role_edit($role_id){
        $role = Role::find($role_id);
        $all_permission = Permission::all();
        return view('admin.role.edit_role', [
            'role'=>$role,
            'all_permission'=>$all_permission,
        ]);
    }

    function role_update(Request $request){
        $role = Role::find($request->role_id);
        $role->syncPermissions($request->permission);
        return back();
    }
}
