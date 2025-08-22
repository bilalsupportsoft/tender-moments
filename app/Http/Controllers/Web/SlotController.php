<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Slot;
use Carbon\Carbon;
use Stripe\Stripe;
use Mail, DB, Hash, Validator, File, Exception;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{


    public function getSlotsByDate(Request $request)
    {
        $date = $request->date;
        try {
            $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['slots' => []]);
        }
        $confirmedSlotIds = Booking::where('status', 'confirmed')
            ->whereDate('slot_date', $formattedDate)
            ->pluck('slot_id')
            ->toArray();
        $query = Slot::whereDate('slot_date', $formattedDate)
            ->where('status', 1)
            ->whereNotIn('id', $confirmedSlotIds);
        if ($formattedDate == Carbon::now()->format('Y-m-d')) {
            $currentTime = Carbon::now()->format('H:i:s');
            $query->where('start_time', '>=', $currentTime);
        }
        $slots = $query->orderBy('start_time')->get(['id', 'start_time', 'end_time', 'price']);
        $slots = $slots->map(function ($slot) use ($request) {
            $gstRate   = 0.10; // 10%

            $residency = Auth::user()->residency ?? 'non_australian';

            if ($residency === 'australian') {
                $gstAmount = $slot->price * $gstRate;
                $total     = $slot->price + $gstAmount;
                $gstRateShow = "10%";
            } else {
                $gstAmount = 0;
                $total     = $slot->price;
                $gstRateShow = "0%";
            }

            return [
                'id'         => $slot->id,
                'price'      => number_format($slot->price, 2),
                'gst_rate'   => $gstRateShow,
                'gst_amount' => number_format($gstAmount, 2),
                'total'      => number_format($total, 2),
                'start_time' => Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A'),
                'end_time'   => Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A'),
            ];
        });

        return response()->json(['slots' => $slots]);
    }




    public function bookSlot(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'date'    => 'required|date_format:d-m-Y',
            'price'   => 'required|numeric'
        ]);

        $slot = Slot::find($request->slot_id);

        // GST Calculation
        $gstRate = 0.10; // 10%

        $residency = Auth::user()->residency ?? 'non_australian';
        if ($residency === 'australian') {
            $finalPrice  = $slot->price + ($slot->price * $gstRate);
            $description = 'Slot Booking (includes 10% GST)';
        } else {
            $finalPrice  = $slot->price;
            $description = 'Slot Booking (GST Free)';
        }

        // Save booking
        $booking = Booking::create([
            'user_id'   => auth()->id(),
            'slot_id'   => $slot->id,
            'slot_date' => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
            'price'   => $request->price,
            'gst_amount'  => $request->gst_amount,
            'total_amount'  => $request->total_amount,
            'status'    => 'pending'
        ]);

        // Stripe setup
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $priceInCents = intval($finalPrice * 100);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => Auth::user()->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd', // change if needed
                    'product_data' => [
                        'name'        => 'Slot Booking',
                        'description' => $description
                    ],
                    'unit_amount' => $priceInCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['booking_id' => $booking->id]),
            'cancel_url'  => route('stripe.cancel', ['booking_id' => $booking->id]),
        ]);

        return response()->json([
            'success'      => true,
            'redirect_url' => $session->url
        ]);
    }


    public function stripeSuccess($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('my-booking')->with('success', 'Payment successful and slot booked!');
    }

    public function stripeCancel($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('my-booking')->with('error', 'Payment cancelled.');
    }
}
