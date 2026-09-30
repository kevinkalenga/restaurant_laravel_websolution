<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationTime;
use Yajra\DataTables\Facades\DataTables;

class ReservationTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $reservationTimes = ReservationTime::query();

            return DataTables::of($reservationTimes)

                /*
                |--------------------------------------------------------------------------
                | Start Time
                |--------------------------------------------------------------------------
                */
                ->addColumn('start_time', function ($time) {

                    return $time->start_time ?? 'N/A';
                })

                /*
                |--------------------------------------------------------------------------
                | End Time
                |--------------------------------------------------------------------------
                */
                ->addColumn('end_time', function ($time) {

                    return $time->end_time ?? 'N/A';
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */
                ->addColumn('status', function ($time) {

                    return $time->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })

                /*
                |--------------------------------------------------------------------------
                | Action
                |--------------------------------------------------------------------------
                */
                ->addColumn('action', function ($time) {

                    return '
                        <a href="' . route('admin.reservation-time.edit', $time->id) . '"
                            class="btn btn-sm btn-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="' . route('admin.reservation-time.destroy', $time->id) . '"
                            class="btn btn-sm btn-danger"
                            onclick="event.preventDefault();
                            if(confirm(\'Are you sure you want to delete?\')) {
                                document.getElementById(\'delete-form-' . $time->id . '\').submit();
                            }">
                            <i class="fas fa-trash"></i>
                        </a>

                        <form id="delete-form-' . $time->id . '"
                            action="' . route('admin.reservation-time.destroy', $time->id) . '"
                            method="POST"
                            style="display:none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>
                    ';
                })

                ->rawColumns([
                    'status',
                    'action'
                ])

                ->make(true);
        }

        return view('admin.reservation.reservation-time.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reservation.reservation-time.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
            'status' => ['required', 'boolean'],
        ]);

        ReservationTime::create([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.reservation-time.index')
            ->with('success', 'Reservation time created successfully!');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $time = ReservationTime::findOrFail($id);

        return view(
            'admin.reservation.reservation-time.edit',
            compact('time')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $time = ReservationTime::findOrFail($id);

        $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
            'status' => ['required', 'boolean'],
        ]);

        $time->start_time = $request->start_time;
        $time->end_time = $request->end_time;
        $time->status = $request->status;

        $time->save();

        return redirect()
            ->route('admin.reservation-time.index')
            ->with('success', 'Reservation time updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $time = ReservationTime::findOrFail($id);

        $time->delete();

        return redirect()
            ->route('admin.reservation-time.index')
            ->with('success', 'Reservation time deleted successfully!');
    }
}

