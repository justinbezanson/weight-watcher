<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    
    public function chart(Request $request)
    {
        $titleUnit = 'kg';
        if (Auth::user()->lbs) {
            $titleUnit = 'lbs';
        }

        $start = '0001-01-01';
        $end = '9999-12-31';

        $range = $request->get('filter_range') ?? '7d';

        switch ($range) {
            case '7d':
                $start = Carbon::now()->subDays(7)->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '1m':
                $start = Carbon::now()->subMonth()->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '3m':
                $start = Carbon::now()->subMonths(3)->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '6m':
                $start = Carbon::now()->subMonths(6)->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '1y':
                $start = Carbon::now()->subYear()->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '3y':
                $start = Carbon::now()->subYears(3)->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
            case '5y':
                $start = Carbon::now()->subYears(5)->format('Y-m-d');
                $end = Carbon::now()->format('Y-m-d');
                break;
        }

        $chart_options = [
            'chart_title' => 'Weight Chart (' . $titleUnit . ')',
            'report_type' => 'group_by_date',
            'filter_field' => 'date',
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
            'range_date_start' => $start . ' 00:00:00',
            'range_date_end' => $end . ' 23:59:59',
        ];
    
        $chart = new LaravelChart($chart_options);
        
        return view('weights.chart', [
            'chart' => $chart,
            'filter_range' => $range,
        ]);
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
