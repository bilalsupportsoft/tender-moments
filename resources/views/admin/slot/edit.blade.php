@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    input[readonly] {
        background-color: #fff !important;
        cursor: not-allowed;
    }
</style>
    <div class="container-fluid flex-grow-1 container-p-y">
        <h5 class="py-2 mb-2">
            <span class=" fw-light">Edit Slot</span>
        </h5>
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="card profile-card">
                    <div class="card-body  pb-5">
                        <form action="{{ route('admin.slot.update', $slot->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" value="{{ $slot->price }}" placeholder="price">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slot Date</label>
                                        <input type="text" id="datepicker" name="slot_date" class="form-control" value="{{ \Carbon\Carbon::parse($slot->slot_date)->format('d-m-Y') }}" placeholder="Select Slot Date">
                                        @error('slot_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <input type="text" id="start_time" name="start_time" class="form-control" value="{{ $slot->start_time }}" placeholder="Start Time">
                                        @error('start_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                                <!-- End Time -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time (20 mins session)</label>
                                        <input type="text" id="end_time" name="end_time" class="form-control" value="{{ $slot->end_time }}" placeholder="End Time" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <div class="col-md-12 submit-btn">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("#datepicker", {
    dateFormat: "d-m-Y",
    minDate: "today",
    disableMobile: true,
    onChange: function(selectedDates) {
        const today = new Date();
        const selectedDate = selectedDates[0];
        const isToday =
            selectedDate.getDate() === today.getDate() &&
            selectedDate.getMonth() === today.getMonth() &&
            selectedDate.getFullYear() === today.getFullYear();

        // Update minTime dynamically if needed
        startTimePicker.set('minTime', isToday ? today.toTimeString().slice(0, 5) : "00:00");
    }
});

const startTimePicker = flatpickr("#start_time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K",
    time_24hr: false,
    minTime: "00:00", // default
    onChange: function (selectedDates) {
        if (selectedDates.length > 0) {
            let start = selectedDates[0];
            let end = new Date(start.getTime() + 20 * 60000);
            let options = { hour: 'numeric', minute: '2-digit', hour12: true };
            let formattedEnd = end.toLocaleTimeString([], options);
            document.getElementById('end_time').value = formattedEnd;
        }
    }
});

flatpickr("#end_time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K",
    time_24hr: false,
    clickOpens: false
});
</script>

</script>
@endsection
