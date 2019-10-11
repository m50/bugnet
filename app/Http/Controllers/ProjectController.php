<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Project::class);
        $query = auth()->user()->projects();
        if (request()->has('filter')) {
            $filter = '%'.request()->filter.'%';
            $query->whereRaw('tags LIKE ?', [$filter]);
        }
        $projects = $query->paginate(10);
        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);
        $validated = $request->validate([
            'name' => 'required|string|max:50|min:3|unique:projects',
            'description' => 'nullable|string|max:255',
            'url' => 'nullable|active_url',
            'tags' => 'nullable|string|regex:/^(?:\w+,\s*)*\w+$/'
        ]);
        auth()->user()->projects()->create($validated);
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'url' => 'nullable|active_url',
            'tags' => 'nullable|string|regex:/^(?:\w+,\s*)*\w+$/'
        ]);
        $project->update($validated);
        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->errors->each->delete();
        $project->delete();
        return redirect()->route('projects.index');
    }
}
