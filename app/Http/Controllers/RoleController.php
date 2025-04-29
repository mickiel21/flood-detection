<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\CustomRole as Role;
use App\Models\CustomPermission as Permission;

class RoleController extends Controller
{

    public function __construct(){
        $this->middleware('permission:read role', ['only' => ['index', 'show']]); // Allow viewing roles
        $this->middleware('permission:write role', ['only' => ['create', 'store']]); // Allow creating roles
        $this->middleware('permission:edit role', ['only' => ['edit', 'update']]); // Allow editing roles
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::query()
            ->orderBy('created_at', 'DESC')
            ->filter($request->only('filter'))
            ->paginate(5)
            ->withQueryString();
      
        

        return Inertia::render('Roles/Index', [
            'roles' => $roles,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render(
            'Roles/Create',[
                'permissions' => $permissions,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);
  
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']); // Attach selected permissions

        return redirect()->route('roles.index')->with('message', 'Role created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Inertia::render(
            'Roles/View',
            [
                'role' => $role
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return Inertia::render(
            'Roles/Edit',
            [
                'role' => $role,
                'permissions' => $permissions,
                'role_permissions' => $role->permissions->pluck('name'),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('message', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Role Deleted Successfully');
    }
}
