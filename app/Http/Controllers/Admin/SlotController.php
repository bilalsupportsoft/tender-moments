<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Booking;
use Exception;
use Carbon\Carbon;
use  DB;
class SlotController extends Controller
{


    public function index()
    {

        // $slots = Slot::with('booking')->get();
        $slots = Slot::whereIn('id', function ($q) {
            $q->selectRaw('MAX(id)')
              ->from('slots')
              ->groupBy('slot_date');
        })
        ->withCount(['dateSlots as slot_count' => function ($q) {
            $q->selectRaw('count(*)');
        }])
        ->orderBy('slot_date', 'asc')
        ->get();
        return view("admin.slot.index", compact('slots'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,pending,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.slot.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required',
            'slot_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $slot_date = Carbon::createFromFormat('d-m-Y', $request->slot_date)->format('Y-m-d');
        $start_time = Carbon::createFromFormat('h:i A', $request->start_time);
        $end_time   = Carbon::createFromFormat('h:i A', $request->end_time);

        $lunchStart = Carbon::parse('12:00 PM');
        $lunchEnd   = Carbon::parse('01:00 PM');

        $duplicateFound = false; // 🔹 Track if duplicate slot found

        try {
            $current = $start_time->copy();

            while ($current->lt($end_time)) {
                $slotStart = $current->copy();
                $slotEnd   = $slotStart->copy()->addMinutes(20);

                if ($slotEnd->gt($end_time)) {
                    break;
                }

                if ($slotStart->lt($lunchEnd) && $slotEnd->gt($lunchStart)) {
                    $current = $lunchEnd->copy();
                    continue;
                }
                $exists = Slot::where('slot_date', $slot_date)
                    ->where('start_time', $slotStart->format('H:i:s'))
                    ->where('end_time', $slotEnd->format('H:i:s'))
                    ->exists();

                if ($exists) {
                    $duplicateFound = true;
                    $current->addMinutes(20);
                    continue;
                }
                Slot::create([
                    'price'      => $request->price,
                    'slot_date'  => $slot_date,
                    'start_time' => $slotStart->format('H:i:s'),
                    'end_time'   => $slotEnd->format('H:i:s'),
                ]);

                $current->addMinutes(20);
            }
            if ($duplicateFound) {
                return redirect()->route('admin.slot.index')
                    ->with('warning', 'Some slots were skipped because they already exist!');
            }

            return redirect()->route('admin.slot.index')
                ->with('success', 'Slots generated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $slots = Slot::where('slot_date', $slot->slot_date)->get();
        return view('admin.slot.edit', compact('slot', 'slots'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slot_date'   => 'required',
            'start_time'  => 'required',
            'end_time'    => 'required',
        ]);

        try {
            $slot_date  = Carbon::createFromFormat('d-m-Y', $request->slot_date)->format('Y-m-d');
            $start_time = Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i:s');
            $end_time   = Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i:s');

            // 🔍 duplicate check: same date + same start_time but different id
            $exists = Slot::where('slot_date', $slot_date)
                ->where('start_time', $start_time)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return redirect()->back()->withErrors(['start_time' => 'This slot time already exists for the selected date.']);
            }

            $lunchStart = Carbon::parse('12:00 PM')->format('H:i:s');
            $lunchEnd   = Carbon::parse('01:00 PM')->format('H:i:s');

            if (
                ($start_time >= $lunchStart && $start_time < $lunchEnd) ||
                ($end_time > $lunchStart && $end_time <= $lunchEnd) ||
                ($start_time <= $lunchStart && $end_time >= $lunchEnd) // slot covering entire lunch break
            ) {
                return redirect()->back()->withErrors(['start_time' => 'Slot cannot be during lunch break (12:00 PM - 01:00 PM).']);
            }

            $slot = Slot::findOrFail($id);
            $slot->slot_date  = $slot_date;
            $slot->start_time = $start_time;
            $slot->end_time   = $end_time;
            $slot->save();

            return redirect()->back()->with('success', 'Slot updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $slot = Slot::find($id);
            $slot->delete();
            return response()->json([
                'status' => true,
                'message' => 'slot deleted successfully',
            ]);
            return response()->json([
                'status' => true,
                'message' => 'slot deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function status($id)
    {
        $slot = Slot::findOrFail($id);
        $slot->status = !$slot->status;
        $slot->save();
        return response()->json([
            'status' => true,
            'new_status' => $slot->status,
            'message' => 'status updated successfully',
        ]);
    }
}
