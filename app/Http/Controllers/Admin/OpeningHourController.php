<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpeningHour;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OpeningHourController extends Controller
{
    /**
     * Display the opening hours.
     */
    public function index(Request $request)
    {
            if ($request->ajax()) {

                $openingHours = OpeningHour::query()
                    ->orderByRaw("
                        CASE day
                            WHEN 'monday' THEN 1
                            WHEN 'tuesday' THEN 2
                            WHEN 'wednesday' THEN 3
                            WHEN 'thursday' THEN 4
                            WHEN 'friday' THEN 5
                            WHEN 'saturday' THEN 6
                            WHEN 'sunday' THEN 7
                        END
                    ");

                return DataTables::of($openingHours)

                    ->addColumn('status', function ($openingHour) {

                        if ($openingHour->is_closed) {
                            return '<span class="badge bg-danger">Closed</span>';
                        }

                        return '<span class="badge bg-success">Open</span>';
                    })

                    ->addColumn('action', function ($openingHour) {

                           return '
                                <button type="button"
                                        class="btn btn-sm btn-warning edit-opening-hour"
                                        data-id="' . $openingHour->id . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                            ';
                    })

                    ->editColumn('day', function ($openingHour) {

                        return ucfirst($openingHour->day);
                    })

                    ->editColumn('open_time', function ($openingHour) {

                        if ($openingHour->is_closed) {
                            return '-';
                        }

                        return $openingHour->open_time
                            ? date('H:i', strtotime($openingHour->open_time))
                            : '-';
                    })

                    ->editColumn('close_time', function ($openingHour) {

                        if ($openingHour->is_closed) {
                            return '-';
                        }

                        return $openingHour->close_time
                            ? date('H:i', strtotime($openingHour->close_time))
                            : '-';
                    })

                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            // Création automatique des 7 jours
            $days = [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ];

            foreach ($days as $day) {
                OpeningHour::firstOrCreate(
                    ['day' => $day],
                    [
                        'open_time' => '10:00',
                        'close_time' => '22:00',
                        'is_closed' => false,
                    ]
                );
            }

            return view('admin.opening-hours.index');
    }


    /**
     * Store a new opening hour.
     */
    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'is_closed' => 'nullable|boolean',
        ]);

        OpeningHour::create([
            'day' => $request->day,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'is_closed' => $request->boolean('is_closed'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Opening hours created successfully.',
        ]);
    }


    /**
     * Get one opening hour.
     */
    public function edit(OpeningHour $openingHour)
    {
        return response()->json($openingHour);
    }


    /**
     * Update an opening hour.
     */
    public function update(Request $request, OpeningHour $openingHour)
    {
        $request->validate([
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'is_closed' => 'nullable|boolean',
        ]);

        $openingHour->update([
            'day' => $request->day,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'is_closed' => $request->boolean('is_closed'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Opening hours updated successfully.',
        ]);
    }


    /**
     * Delete an opening hour.
     */
    public function destroy(OpeningHour $openingHour)
    {
        $openingHour->delete();

        return response()->json([
            'success' => true,
            'message' => 'Opening hours deleted successfully.',
        ]);
    }
}
