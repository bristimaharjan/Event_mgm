<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostControllercls extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'content' => 'required|string|max:255',
        ]);


        // Logic to store the chirp would go here
        Post::create([
            'content' => $request->input('content'),    // gets only one value (the content field) from the request.
        ]);

        // Post::create($request->only('content'));     // returns an array with the given key(s) from the request. shorter and more readable. useful when you want to insert multiple fields. eg. Post::create($request->only(['title', 'content', 'user_id']));

        return redirect()->route('chirps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
