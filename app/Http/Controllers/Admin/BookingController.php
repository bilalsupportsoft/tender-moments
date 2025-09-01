<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Booking;
use Exception;
use Carbon\Carbon;
use  DB;
use Barryvdh\DomPDF\Facade\Pdf;
class BookingController extends Controller
{


    public function index(Request $request)
    {
        $query = Booking::with(['user', 'slot'])->where('status', '!=', 'pending');

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

    public function downloadInvoice($id)
    {
        $booking = Booking::with('slot', 'user')->findOrFail($id);
        $residency = $booking->user->residency ?? null;
        $basePrice = $booking->price ?? 0;
        $gstIncluded = false;
        $gstAmount = 0;
        $total = $basePrice;

        if ($residency === 'australian') {
            $gstIncluded = true;
            $gstAmount = round($basePrice * 0.10, 2);
            $total = $basePrice + $gstAmount;
        }

        $currentDateTime = \Carbon\Carbon::now();
        $slotDateTime = \Carbon\Carbon::parse($booking->slot_date . ' ' . $booking->start_time);
        $slotEndTime  = \Carbon\Carbon::parse($booking->slot_date . ' ' . $booking->end_time);
        if ($booking->status === '0') {
            $displayStatus = 'Cancelled';
        } elseif ($booking->status === 'pending') {
            $displayStatus = 'Pending';
        } elseif ($booking->status === 'confirmed') {
            if ($slotDateTime->isFuture()) {
                $displayStatus = 'Upcoming';
            } elseif (
                $slotDateTime->isToday() ||
                ($slotDateTime->isPast() && $slotEndTime->isFuture())
            ) {
                $displayStatus = 'Active';
            } else {
                $displayStatus = 'Completed';
            }
        } else {
            $displayStatus = ucfirst($booking->status);
        }

        $invoice = [
            'invoice_no' => 'INV-' . $booking->id,
            'slot_id'    => $booking->slot_id,
            'slot_date'  => $booking->slot_date,
            'start_time' => $booking->slot->start_time,
            'end_time'   => $booking->slot->end_time,
            'status'     => $displayStatus,
            'price'      => $booking->price,
            'gst_amount' => $gstAmount,
            'total'      => $total,
            'residency'  => $residency,
            'user'       => [
                'name'  => $booking->user->name ?? 'Client',
                'email' => $booking->user->email ?? '',
            ],
            'business_email' => 'info@tendermoments.com',
        ];
        $pdf = Pdf::loadView('web.pages.partials.invoices-admin', compact('invoice'));
        return $pdf->download('invoice_' . $booking->id . '.pdf');
    }


}
