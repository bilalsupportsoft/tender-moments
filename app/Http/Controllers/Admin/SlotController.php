<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Booking;
use Exception;
use Carbon\Carbon;

class SlotController extends Controller
{


    public function index()
    {

        $slots = Slot::with('booking')->get();
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'price' => 'required',
            'slot_date' => 'required',
            'start_time' => 'required',

        ]);

        $slot_date = Carbon::createFromFormat('d-m-Y', $request->slot_date)->format('Y-m-d');
        $start_time = Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i:s');
        $end_time = Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i:s');
        try {
            Slot::create([
                'price' => $request->price,
                'slot_date' => $slot_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);

            return redirect()->route('admin.slot.index')->with('success', 'Slot added successfully!');
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
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
        return view('admin.slot.edit', compact('slot'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'price' => 'required',
            'slot_date' => 'required',
            'start_time' => 'required',

        ]);
        try {

            $slot_date = Carbon::createFromFormat('d-m-Y', $request->slot_date)->format('Y-m-d');
            $start_time = Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i:s');
            $end_time = Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i:s');

            $slot = Slot::findOrFail($id);
            $slot->price = $request->price;
            $slot->slot_date = $slot_date;
            $slot->start_time = $start_time;
            $slot->end_time = $end_time;
            $slot->save();
            return redirect()->route('admin.slot.index')->with('success', 'Slot updated successfully.');
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
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
