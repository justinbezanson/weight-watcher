<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('weights.index', [
            'weights' => Weight::with('user')
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(4),
        ]);
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
        $validated = $request->validate([
            'date' => 'required|date',
            'weight' => 'required|numeric',
        ]);
 
        $request->user()->weights()->create($validated);
 
        return redirect(route('weights.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weight $weight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weight $weight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight): RedirectResponse
    {
        Gate::authorize('delete', $weight);
 
        $weight->delete();
 
        return redirect(route('weights.index'));
    }
}
