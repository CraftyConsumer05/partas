<?php
namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Support\Facades\Request as RequestFacade; 
use Illuminate\Http\Request as HttpRequest; 
use Inertia\Inertia;
use LDAP\Result;

class LocationController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function indexAPI(){
        $locations=Location::select('location','longtitude','latitude')->get();
        return response()->json($locations);
    }

    public function index(){
        $locations= Location::all();
        return Inertia::render('Locations/List',[
            'locations'=>$locations,
            'message' => session('message')
        ]);
    }

    public function create(){
        return Inertia::render('Locations/Create');

    }

    /**
    * Store a newly created resource in storage.
    */

    public function store(HttpRequest $request){
        $locationName = $request->input('location');

        // Check if the location already exists in the database
        $existingLocation = Location::where('location',
        $locationName)->first();

        if ($existingLocation) {
            // If the location exists, show an alert and redirect back

            return redirect()->route('locations')->with('message', 'error:Location
            already exists.');
        }

        // If the location doesn't exist, create a new entry
        Location::create([
        "location" => $locationName,
        ]);

        return redirect()->route('locations')->with('message', 'success:New location
        created.');


        
    }

    /**
    * Display the specified resource.
    */

    public function show(Location $location){
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit(){
        $location= Location::find(RequestFacade::get("id"));
        return Inertia::render('Locations/Edit',['location'=>$location]);
    }

    /**
    * Update the specified resource in storage.
    */

    public function update(Location $location, HttpRequest $httpRequest){

        $httpRequest->validate([
        "location"=> 'required',
        ]);

        Location::where('id',$location->id)
        ->update([
            "location"=> $httpRequest->get("location"),
        ]);
        return to_route('locations')->with('message', 'success:location
        Updated.');
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy(Location $location){
        Location::destroy($location->id);
        return to_route('locations');
    }
}