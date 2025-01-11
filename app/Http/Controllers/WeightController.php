<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
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
    
    public function chart()
    {
        $titleUnit = 'kg';
        if (Auth::user()->lbs) {
            $titleUnit = 'lbs';
        }

        $chart_options = [
            'chart_title' => 'Weight Chart (' . $titleUnit . ')',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Weight',
            'group_by_field' => 'date',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'weight',
            'aggregate_transform' => function($value) {
                if (Auth::user()->lbs) {
                    return Weight::convertToLbs($value);
                }

                return $value;
            },
            'group_by_field_format' => 'Y-m-d',
            'chart_type' => 'line',
        ];
    
        $chart = new LaravelChart($chart_options);
        
        return view('weights.chart', compact('chart'));
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

        if (Auth::user()->lbs) {
            $validated['weight'] = $validated['weight'] * 0.45359237;
        }

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
