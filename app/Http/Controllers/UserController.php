<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CustomRole as Role;
use Inertia\Inertia;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class UserController extends Controller
{

    public function __construct(){
        $this->middleware('permission:read user', ['only' => ['index', 'show']]); // Allow viewing users
        $this->middleware('permission:write user', ['only' => ['create', 'store']]); // Allow creating users
        $this->middleware('permission:edit user', ['only' => ['edit', 'update']]); // Allow editing users
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->orderBy('id', 'ASC')
            ->whereNull('deleted_at')
            ->filter($request->only('filter'))
            ->paginate(5)
            ->withQueryString();
      
        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roleNames = Role::pluck('name');

        return Inertia::render(
            'Users/Create',[
                'roles' => $roleNames,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')->with('message', 'User Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $blog)
    {
        return Inertia::render(
            'Users/View',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render(
            'Users/Edit',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $blog)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'slug' => 'required||unique:blogs,slug,'.$blog->id.',id|string|max:255'
        ]);
        $blog->update([
            'heading' => $request->heading,
            'slug' => Str::slug($request->slug),
            'description' => $request->description
        ]);

        return redirect()->route('blogs.index')->with('message', 'User Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('message', 'User Post Deleted Successfully');
    }
}
