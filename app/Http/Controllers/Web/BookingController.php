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
        $bookings = Booking::where('user_id', $user->id)->whereNotIn('status', ['pending'])->latest()->get();

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

            $user = auth()->user();
            $residency = $user->residency ?? 'non_australian';
            $filteredBookings->transform(function ($slot) use ($residency) {
                $basePrice = $slot->price ?? 0;
                if ($residency === 'australian') {
                    $slot->final_price = round($basePrice * 1.10, 2);
                } else {
                    $slot->final_price = $basePrice;
                }
                return $slot;
            });
            return view('web.pages.partials.booking-list', [
                'activeSlots' => $filteredBookings,
                'residency'   => $residency
            ]);
        } elseif ($filter === 'upcoming') {
            $bookings->where('status', 'confirmed')
                ->whereHas('slot', function ($query) use ($today, $nowTime) {
                    $query->where(function ($q) use ($today, $nowTime) {
                        $q->where('slot_date', '>', $today)
                            ->orWhere(function ($q2) use ($today, $nowTime) {
                                $q2->where('slot_date', $today)
                                    ->where('start_time', '>', $nowTime);
                            });
                    });
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
        } elseif ($filter === '0') {
            $bookings->where('status', '0');
        }

        $filteredBookings = $bookings->orderByDesc('id')->get();
        return view('web.pages.partials.booking-list', compact('filteredBookings'));
    }


    public function downloadInvoice($id)
    {
        $booking = Booking::with('slot', 'user')->findOrFail($id);
        $user = Auth::user();
        $residency = $user->residency ?? null;
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
            'start_time' => $booking->start_time,
            'end_time'   => $booking->end_time,
            'status'     => $displayStatus,
            'price'      => $booking->price,
            'total'      => $total,
            'residency'  => $residency,
            'user'       => [
                'name'  => $booking->user->name ?? 'Client',
                'email' => $booking->user->email ?? '',
            ],
            'business_email' => 'info@tendermoments.com',
        ];

        $pdf = Pdf::loadView('web.pages.partials.invoices', compact('invoice'));
        return $pdf->download('invoice_' . $booking->id . '.pdf');
    }



    public function downloadSlotInvoice($id)
    {
        $slot = Slot::with(['booking.user'])->findOrFail($id);
        $user = Auth::user();

        $residency = $user->residency ?? null;

        $basePrice = $slot->price ?? 0;
        $gstIncluded = false;
        $gstAmount = 0;
        $total = $basePrice;

        if ($residency === 'australian') {
            $gstIncluded = true;
            $gstAmount = round($basePrice * 0.10, 2);
            $total = $basePrice + $gstAmount;
        }

        $invoiceData = [
            'slot_id'    => $slot->id,
            'slot_date'  => $slot->slot_date,
            'start_time' => $slot->start_time,
            'end_time'   => $slot->end_time,
            'price'      => $basePrice,
            'status'     => 'Active (Not Booked)',
            'residency'  => $residency,
            'gstIncluded' => $gstIncluded,
            'gstAmount'  => $gstAmount,
            'total'      => $total,
            'user' => [
                'name'    => $user->name ?? 'Client Name',
                'email'   => $user->email ?? null,
                'address' => $user->address ?? null,
            ],
        ];

        $pdf = Pdf::loadView('web.pages.partials.slot-invoice', ['invoice' => $invoiceData]);
        return $pdf->download('slot_invoice_' . $slot->id . '.pdf');
    }
}
