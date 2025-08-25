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

        try {
            if ($request->has('slots')) {
                foreach ($request->slots as $slot) {
                    [$slotStart, $slotEnd] = explode('-', $slot);

                    // Duplicate check
                    $exists = Slot::where('slot_date', $slot_date)
                        ->where('start_time', $slotStart)
                        ->where('end_time', $slotEnd)
                        ->exists();

                    if (!$exists) {
                        Slot::create([
                            'price'      => $request->price,
                            'slot_date'  => $slot_date,
                            'start_time' => $slotStart,
                            'end_time'   => $slotEnd,
                        ]);
                    }
                }
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

    // public function status($id)
    // {
    //     $slot = Slot::findOrFail($id);
    //     $slot->status = !$slot->status;
    //     $slot->save();
    //     return response()->json([
    //         'status' => true,
    //         'new_status' => $slot->status,
    //         'message' => 'status updated successfully',
    //     ]);
    // }
}
