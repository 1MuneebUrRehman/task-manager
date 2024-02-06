<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class RoleController
 *
 * This class handles operations related to roles, such as displaying roles, showing role details,
 * and updating role permissions. It extends the Laravel Controller class.
 *
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    /**
     * RoleController constructor.
     *
     * Apply the 'admin' middleware to restrict access to admin-only actions.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of roles.
     *
     * @return \Illuminate\Contracts\View\View A view containing a listing of roles.
     */
    public function index()
    {
        $roles = Role::paginate();
        return view('role.index', compact('roles'));
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id  The ID of the role to be displayed.
     *
     * @return \Illuminate\Contracts\View\View A view containing details of the specified role.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the role with the specified ID is not found.
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::paginate();
        return view('role.show', compact('role', 'permissions'));
    }

    /**
     * Update the permissions of the specified role.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing updated permissions.
     * @param  int  $id  The ID of the role whose permissions are to be updated.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the show route of the role.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the role with the specified ID is not found.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Sync permissions for the role
        $role->syncPermissions($request->input('permissions', []));
        Auth::user()->syncPermissions($request->input('permissions', []));

        return redirect()->route('role.show', $role->id)
            ->with('success', 'Role permissions updated successfully.');
    }
}
