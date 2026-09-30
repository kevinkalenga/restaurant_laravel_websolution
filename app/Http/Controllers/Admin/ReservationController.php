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

                    if ($reservation->status === 'confirmed') {
                        return '<span class="badge badge-success">Confirmed</span>';
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

                ->rawColumns([
                    'status'
                ])

                ->make(true);
        }

        return view('admin.reservation.index');

    }





}
