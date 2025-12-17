<?php

namespace App\Http\Controllers;

use App\Models\MeasurementType;
use App\Models\Weight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $type = $request->get('type', 'Weight');

        $types = MeasurementType::where('user_id', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('weights.index', [
            'types' => $types,
            'type' => $type,
            'weights' => Weight::with('user')
                ->where('type', $type)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(4),
        ]);
    }

    public function checkin(): View
    {
        $types = MeasurementType::where('user_id', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('weights.checkin', [
            'types' => $types,
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

        $range = $request->get('filter_range') ?? '3m';

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
            'chart_title' => 'Weight Chart ('.$titleUnit.')',
            'report_type' => 'group_by_date',
            'filter_field' => 'date',
            'model' => 'App\Models\Weight',
            'group_by_field' => 'date',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'weight',
            'aggregate_transform' => function ($value) {
                if (Auth::user()->lbs) {
                    return Weight::convertToLbs($value);
                }

                return $value;
            },
            'group_by_field_format' => 'Y-m-d',
            'chart_type' => 'line',
            'range_date_start' => $start.' 00:00:00',
            'range_date_end' => $end.' 23:59:59',
            'begin_at_zero' => false,
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
        // TODO: handle adding measurements for existing date
        // success message for deleting existing measurements for date
        DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'date' => 'required|date',
                'weight' => 'required|numeric',
            ]);

            if (Auth::user()->lbs) {
                $validated['weight'] = $validated['weight'] * 0.45359237;
            }

            $request->user()->weights()->create([
                'date' => $validated['date'],
                'type' => 'Weight',
                'amount' => $validated['weight'],
            ]);

            $types = MeasurementType::where('user_id', Auth::user()->id)
                ->orderBy('name', 'asc')
                ->get();

            foreach ($types as $type) {
                if ($request->has($type->name)) {
                    $measurement = $request->validate([
                        $type->name => 'nullable|numeric',
                    ]);

                    if ($measurement[$type->name] === null) {
                        continue;
                    }

                    if (Auth::user()->lbs) {
                        $measurement[$type->name] = $measurement[$type->name] * 0.3937007874;
                    }

                    $request->user()->weights()->create([
                        'date' => $validated['date'],
                        'type' => $type->name,
                        'amount' => $measurement[$type->name],
                    ]);
                }
            }
        });

        return redirect()->route('weights.checkin')->with('success', 'Measurements added successfully!');
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
