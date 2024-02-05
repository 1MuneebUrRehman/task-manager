<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate();
        return view('role.index', compact('roles'));
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::paginate();
        return view('role.show', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        // Check if the authenticated user has the "admin" role
        if (!Auth::user()->hasRole(RolesEnum::ADMIN)) {
            // If the user doesn't have the "admin" role, redirect back with a message
            return redirect()->back()->with('error',
                'You do not have permission to update role permissions.');
        }
        // Sync permissions for the role
        $role->syncPermissions($request->input('permissions', []));
        Auth::user()->syncPermissions($request->input('permissions', []));

        return redirect()->route('role.show', $role->id)
            ->with('success', 'Role permissions updated successfully.');
    }
}
