<?php

namespace App\Http\Controllers;

use App\Models\MeasurementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class MeasurementController extends Controller
{
    public function index()
    {
        return view('measurements.index', [
            'measurementTypes' => MeasurementType::with('user')
                ->orderBy('name', 'asc')
                ->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('measurement_types', 'name')->where(function ($query) use ($request) {
                    return $query->where('name', $request->input('name'))
                        ->where('user_id', Auth::user()->id);
                }),
            ],
        ]);

        $type = MeasurementType::create([
            'name' => $request->input('name'),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()
            ->route('measurements.index')
            ->with('success', "Measurement '$type->name' added successfully.");
    }

    public function destroy(MeasurementType $measurementType)
    {
        Gate::authorize('delete', $measurementType);

        $name = $measurementType->name;
        $measurementType->delete();

        return redirect()
            ->route('measurements.index')
            ->with('success', "Measurement '$name' deleted successfully.");
    }
}
