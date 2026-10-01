<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Yajra\DataTables\Facades\DataTables;

class ReservationController extends Controller
{
    
    public function index()
    {
        if (request()->ajax()) {


            $reservations = Reservation::query();

            return DataTables::of($reservations)

                ->addColumn('reservation_id', function ($reservation) {

                    return $reservation->reservation_id ?? 'N/A';
                })

                ->addColumn('name', function ($reservation) {

                    return $reservation->name ?? 'N/A';
                })

                ->addColumn('phone', function ($reservation) {

                    return $reservation->phone ?? 'N/A';
                })

                ->addColumn('date', function ($reservation) {

                    return $reservation->date ?? 'N/A';
                })

                ->addColumn('time', function ($reservation) {

                    return $reservation->time ?? 'N/A';
                })

                ->addColumn('persons', function ($reservation) {

                    return $reservation->persons ?? 'N/A';
                })

                ->addColumn('status', function ($reservation) {

                    if ($reservation->status === 'pending') {
                        return '<span class="badge badge-warning">Pending</span>';
                    }

                    if ($reservation->status === 'Approved') {
                        return '<span class="badge badge-success">Approved</span>';
                    }

                    if ($reservation->status === 'completed') {
                        return '<span class="badge badge-primary">Completed</span>';
                    }

                    if ($reservation->status === 'cancelled') {
                        return '<span class="badge badge-danger">Cancelled</span>';
                    }

                    return '<span class="badge badge-secondary">'
                        . ($reservation->status ?? 'N/A') .
                        '</span>';
                })

                ->addColumn('created_at', function ($reservation) { 
                    return $reservation->created_at ? 
                    $reservation->created_at->format('d/m/Y H:i') : 'N/A'; 
                })
                  ->addColumn('action', function ($reservation) {

                    return '
                        <button type="button"
                                class="btn btn-sm btn-primary edit-reservation"
                                data-id="'.$reservation->id.'">
                            <i class="fas fa-edit"></i>
                        </button>
                         |

                        <button type="button"
                                class="btn btn-sm btn-danger delete-reservation"
                                data-id="'.$reservation->id.'">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns([
                    'status',
                    'action'
                ])

                ->make(true);
        }

        return view('admin.reservation.index');

    }

    public function edit(Reservation $reservation)
    {
        return response()->json([
            'reservation' => $reservation
        ]);
    }


    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'persons' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);

        $reservation->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'persons' => $request->persons,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservation updated successfully.',
        ]);
    }


    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully.',
        ]);
    }





}
