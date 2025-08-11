<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Slot;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function myBookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->latest()->get();

        return view('web.pages.my-booking', compact('bookings'));
    }


    public function filterBookings(Request $request)
    {
        $filter = $request->input('filter');
        $today = now()->toDateString();
        $nowTime = now()->format('H:i:s');
        $userId = auth()->id();

        $bookings = Booking::with('slot')->where('user_id', $userId);

        if ($filter === 'active') {
            $filteredBookings = Slot::where(function ($query) use ($today, $nowTime) {
                $query->where('slot_date', '>', $today)
                    ->orWhere(function ($q) use ($today, $nowTime) {
                        $q->where('slot_date', $today)
                            ->where('start_time', '>=', $nowTime);
                    });
            })
                ->whereDoesntHave('booking')
                ->orderBy('slot_date', 'asc')
                ->get();
            return view('web.pages.partials.booking-list', ['activeSlots' => $filteredBookings]);
        } elseif ($filter === 'upcoming') {
            $bookings->where('status', 'confirmed')
                ->whereHas('slot', function ($query) use ($today) {
                    $query->where('slot_date', '>', $today);
                });
        } elseif ($filter === 'completed') {
            $bookings->where('status', 'confirmed')
                ->whereHas('slot', function ($query) use ($today, $nowTime) {
                    $query->where(function ($q) use ($today, $nowTime) {
                        $q->where('slot_date', '<', $today)
                            ->orWhere(function ($q2) use ($today, $nowTime) {
                                $q2->where('slot_date', $today)
                                    ->where('end_time', '<', $nowTime);
                            });
                    });
                });
        } elseif ($filter === 'cancelled') {
            $bookings->where('status', 'cancelled');
        } else {
            $bookings = Booking::with('slot')
                ->where('user_id', $userId)
                ->where(function ($q) use ($today, $nowTime) {
                    $q->where(function ($q2) use ($today, $nowTime) {
                        $q2->whereNotIn('status', ['confirmed', 'pending', 'cancelled'])
                            ->whereHas('slot', function ($query) use ($today, $nowTime) {
                                $query->where(function ($q3) use ($today, $nowTime) {
                                    $q3->where('slot_date', '>', $today)
                                        ->orWhere(function ($q4) use ($today, $nowTime) {
                                            $q4->where('slot_date', $today)
                                                ->where('start_time', '>=', $nowTime);
                                        });
                                });
                            });
                    })->orWhere(function ($q3) use ($today) {
                        $q3->where('status', 'confirmed')
                            ->whereHas('slot', function ($query) use ($today) {
                                $query->where('slot_date', '>', $today);
                            });
                    })->orWhere(function ($q4) use ($today, $nowTime) {
                        $q4->where('status', 'confirmed')
                            ->whereHas('slot', function ($query) use ($today, $nowTime) {
                                $query->where(function ($q5) use ($today, $nowTime) {
                                    $q5->where('slot_date', '<', $today)
                                        ->orWhere(function ($q6) use ($today, $nowTime) {
                                            $q6->where('slot_date', $today)
                                                ->where('end_time', '<', $nowTime);
                                        });
                                });
                            });
                    });
                });
        }

        $filteredBookings = $bookings->orderByDesc('id')->get();
        return view('web.pages.partials.booking-list', compact('filteredBookings'));
    }



    public function downloadInvoice($id)
    {
        $booking = Booking::with('slot')->findOrFail($id);
        $pdf = Pdf::loadView('web.pages.partials.invoices', compact('booking'));
        return $pdf->download('invoice_' . $booking->id . '.pdf');
    }


    public function downloadSlotInvoice($id)
{
    $slot = Slot::findOrFail($id);

    $invoiceData = [
        'slot_id'    => $slot->id,
        'slot_date'  => $slot->slot_date,
        'start_time' => $slot->start_time,
        'end_time'   => $slot->end_time,
        'price'      => $slot->price ?? 0,
        'status'     => 'Active (Not Booked)',
    ];

    $pdf = Pdf::loadView('web.pages.partials.slot-invoice', ['invoice' => $invoiceData]);
    return $pdf->download('slot_invoice_' . $slot->id . '.pdf');
}

}
