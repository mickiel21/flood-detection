<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use Inertia\Inertia;
use App\Models\Sensor;
class AlertController extends Controller
{
    public function __construct(){
        $this->middleware('permission:read alert', ['only' => ['index', 'show']]); // Allow viewing alerts
        $this->middleware('permission:write alert', ['only' => ['create', 'store']]); // Allow creating alerts
        $this->middleware('permission:edit alert', ['only' => ['edit', 'update']]); // Allow editing alerts
        $this->middleware('permission:delete alert', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $alert = Alert::with('sensor')
            ->orderBy('created_at', 'DESC')
            ->whereNull('deleted_at')
            ->filter($request->only('filter'))
            ->paginate(5)
            ->withQueryString();
      
        return Inertia::render('Alerts/Index', [
            'alerts' => $alert,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sensors = Sensor::select('id', 'name', 'location')->get();

        return Inertia::render('Alerts/Create', [
            'sensors' => $sensors,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'type' => 'required|string|max:255',
            'severity' => 'required|in:Low,Medium,High,Critical',
            'message' => 'required|string',
        ]);

        // Create alert record
        Alert::create($validatedData);

        return redirect()->route('alerts.index')->with('message', 'Alert created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Alert $alert)
    {
        return Inertia::render('Alerts/Show', [
            'alert' => $alert->load('sensor'),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alert $alert)
    {
        // Fetch all sensors for the dropdown
        $sensors = Sensor::select('id', 'name', 'location')->get();

        return Inertia::render('Alerts/Edit', [
            'alert' => $alert->load('sensor'),
            'sensors' => $sensors,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        // Validate input
        $validatedData = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'type' => 'required|string|max:255',
            'severity' => 'required|in:Low,Medium,High,Critical',
            'message' => 'required|string',
        ]);

        // Update alert record
        $alert->update($validatedData);

        return redirect()->route('alerts.index')->with('message', 'Alert updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();
        return redirect()->route('alerts.index')->with('message', 'Alert deleted successfully!');
    }

}
