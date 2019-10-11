<?php

namespace App\Http\Controllers;

use App\Error;
use App\Project;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web')->only(['index', 'show']);
        $this->middleware('auth:api')->only('store');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('errors.index', ['errors' => $project->errors->paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'trace' => 'required|json',
            'exception' => 'required|string|min:5',
            'importance' => 'required|in:low,medium,high,critical'
        ]);
        $created = $project->errors()->create($validated);

        return response()->json($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Error  $error
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Error $error)
    {
        return view('errors.show', compact($project, $error));
    }
}
