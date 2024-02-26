<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index')->with("projects", $projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->get("name");
        $description = $request->get("description");
        $project  = Project::create([
            "name" => $name,
            "description" => $description,
            "owner_id" => auth()->user()->id,
            "status" => "pending"
        ]);
        $project->save();
        return dd($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show')->with("project", $project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
