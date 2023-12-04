<?php

namespace App\Http\Controllers;

use App\Models\Busroute;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UpdateBusrouteRequest;
use App\Models\Location;
use Inertia\Inertia;

class BusrouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $busroutes = Busroute::all();
        return Inertia::render('Busroutes/List',[
            'busroutes' => $busroutes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations=Location::all();
        return Inertia::render('Busroutes/Create',['locations'=>$locations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
        ]);
    
        $origin = $request->input('origin');
        $destination = $request->input('destination');
    
        // Check if the route already exists in the database
        $existingRoute = BusRoute::where('origin', $origin)
            ->where('destination', $destination)
            ->first();
    
        if ($existingRoute) {
            // If the route exists, show an alert and redirect back
            return redirect()->route('busroutes')->with('message', 'error:Route already exists.');
        }
    
        // If the route doesn't exist, create a new entry
        BusRoute::create([
            'origin' => $origin,
            'destination' => $destination,
        ]);
    
        return redirect()->route('busroutes')->with('success', 'New Route created.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Busroute $busroute)
    {
        $id=Request::get("id");
        $busroute= Busroute::find($id);
        $locations= Location::all();
        return Inertia::render('Busroutes/Edit',['busroute'=>$busroute,'locations'=>$locations]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Busroute $busroute)
    {
        Request::validate([
            'origin' => 'required',
            'destination' => 'required',
        ]);

        Busroute::where('id',$busroute->id)
        ->update([
            'origin' =>Request::get('origin'),
            'destination' => Request::get('destination')
        ]);
        return to_route('busroutes')->with('success', 'Route  edited.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Busroute $busroute)
    {
        Busroute::destroy($busroute->id);
        to_route('busroutes');
    }
}
