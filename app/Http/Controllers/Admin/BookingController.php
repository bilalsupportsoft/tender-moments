<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Booking;
use Exception;
use Carbon\Carbon;
use  DB;
class BookingController extends Controller
{

    // public function index(Request $request)
    // {

    //     $query = Slot::with('booking')->orderBy('slot_date', 'asc');

    //     // status filter
    //     if ($request->has('status') && $request->status !== '') {
    //         $status = $request->status;

    //         if ($status === 'Booked') {
    //             $query->whereHas('booking', function ($q) {
    //                 $q->where('status', 'confirmed');
    //             });
    //         } elseif ($status === 'Not Booked') {
    //             $query->whereDoesntHave('booking')
    //                   ->where('slot_date', '<', now());
    //         } elseif ($status == '1') { // Upcoming
    //             $query->whereDoesntHave('booking')
    //                   ->where('status', 1)
    //                   ->where('slot_date', '>=', now());
    //         } elseif ($status == '0') { // Cancelled
    //             $query->where('status', 0);
    //         }
    //     }

    //     // slot_date filter
    //     if ($request->filled('slot_date')) {
    //         $query->whereDate('slot_date', $request->slot_date);
    //     }

    //     $bookingslots = $query->get();
    //     return view("admin.slot.booking", compact('bookingslots'));
    // }

    public function index(Request $request)
    {
        $query = Booking::with(['user', 'slot']);

        // Date filter
        if ($request->filled('slot_date')) {
            $query->whereHas('slot', function ($q) use ($request) {
                $q->whereDate('slot_date', $request->slot_date);
            });
        }

        // Custom Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            $today = Carbon::today();

            if ($status === 'Booked') { // Today Booking
                $query->where('status', 'confirmed')
                    ->whereHas('slot', function ($q) use ($today) {
                        $q->whereDate('slot_date', $today);
                    });
            } elseif ($status === '1') { // Upcoming
                $query->where('status', 'confirmed')
                    ->whereHas('slot', function ($q) use ($today) {
                        $q->whereDate('slot_date', '>', $today);
                    });
            } elseif ($status === '0') { // Cancelled
                $query->where('status', '0');
            } elseif ($status === 'Completed') {
                $query->where('status', 'confirmed')
                    ->whereHas('slot', function ($q) use ($today) {
                        $q->whereDate('slot_date', '<', $today);
                    });
            }
        }

        $bookingslots = $query->latest()->paginate(15);
        return view('admin.slot.booking', compact('bookingslots'));
    }



    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:0,1',
            ]);
            $booking = Slot::findOrFail($id);
            $booking->status = (int) $request->status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => $booking->status == 1 ? 'Booking marked as Upcoming' : 'Booking marked as Cancelled',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function cancelBooking($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->status = 0; // cancelled
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking has been cancelled successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }




}
