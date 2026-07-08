<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Webrek\MongoPermission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Display a listing of administrators.
     */
    public function index()
    {
        // Get all users who are Admins or Super Admins
        $admins = User::whereIn('role', ['Admin', 'Super Admin'])->get();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new administrator.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.admins.create', compact('permissions'));
    }

    /**
     * Store a newly created administrator in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:Admin,Super Admin'],
            'status' => ['required', 'in:active,inactive'],
            'permissions' => ['nullable', 'array'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Assign core role
        $user->assignRole($request->role);

        // Sync custom permissions if provided
        if (!empty($request->permissions)) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', __('messages.admin_create_success'));
    }

    /**
     * Show edit form for administrator.
     */
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        $permissions = Permission::all();
        
        // Get names of assigned permissions
        $assignedPermissions = $admin->permissions->pluck('name')->toArray();

        return view('admin.admins.edit', compact('admin', 'permissions', 'assignedPermissions'));
    }

    /**
     * Update administrator account and permissions.
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id . ',_id'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:Admin,Super Admin'],
            'status' => ['required', 'in:active,inactive'],
            'permissions' => ['nullable', 'array'],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->status = $request->status;

        // Change role if it changed
        if ($admin->role !== $request->role) {
            $admin->removeRole($admin->role);
            $admin->role = $request->role;
            $admin->assignRole($request->role);
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        
        $admin->save();

        // Sync permissions
        $permissions = $request->permissions ?? [];
        $admin->syncPermissions($permissions);

        return redirect()->route('admin.admins.index')
            ->with('success', __('messages.admin_update_success'));
    }

    /**
     * Delete an administrator account.
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Prevent Super Admin from deleting themselves
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', __('messages.admin_delete_self_error'));
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', __('messages.admin_delete_success'));
    }
}
