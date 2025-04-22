<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Sensor;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sensor = Sensor::query()
            ->orderBy('created_at', 'DESC')
            ->whereNull('deleted_at')
            ->filter($request->only('filter'))
            ->paginate(5)
            ->withQueryString();
      
        return Inertia::render('Sensors/Index', [
            'sensors' => $sensor,
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
            'Sensors/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive', // Ensure status is either 'active' or 'inactive'
            'min_value' => 'required|integer|min:0', // Minimum value must be a non-negative integer
            'max_value' => 'required|integer|min:0|gt:min_value', // Must be greater than min_value
            'installation_date' => 'nullable|date', // Optional, must be a valid 
        ]);

        Sensor::create([
            'name' => $request->name,
            'type' =>  $request->type,
            'location' => $request->location,
            'status' => $request->status,
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'installation_date' => $request->installation_date,
        ]);

        return redirect()->route('sensors.index')->with('message', 'Sensor Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $blog)
    {
        return Inertia::render(
            'Sensors/View',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        return Inertia::render(
            'Sensors/Edit',
            [
                'sensor' => $sensor
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $blog)
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

        return redirect()->route('blogs.index')->with('message', 'Sensor Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('message', 'Sensor Post Deleted Successfully');
    }
}