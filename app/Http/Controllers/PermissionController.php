<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\CustomPermission as Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = Permission::query()
            ->orderBy('created_at', 'DESC')
            ->filter($request->only('filter'))
            ->paginate(5)
            ->withQueryString();
      
        return Inertia::render('Permissions/Index', [
            'permissions' => $permission,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Permissions/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
       
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')->with('message', 'Permission Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return Inertia::render(
            'Permissions/View',
            [
                'permission' => $permission
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return Inertia::render(
            'Permissions/Edit',
            [
                'permission' => $permission
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')->with('message', 'Permission Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('message', 'Permission Post Deleted Successfully');
    }
}
