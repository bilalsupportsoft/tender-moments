@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        input[readonly] {
            background-color: #fff !important;
            cursor: not-allowed;
        }
    </style>
    <!-- Flatpickr CSS -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <h5 class="py-2 mb-2">
            <span class="text-primary fw-light">Add Slot</span>
        </h5>
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="card profile-card">
                    <div class="card-body  pb-5">
                        <form action="{{ route('admin.slot.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" placeholder="price"
                                            value="50">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slot Date</label>
                                        <input type="text" id="datepicker" name="slot_date" class="form-control"
                                            placeholder="Select Slot Date">
                                        @error('slot_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <input type="text" id="start_time" name="start_time" class="form-control"
                                            placeholder="Start Time">
                                        @error('start_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- End Time -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <input type="text" id="end_time" name="end_time" class="form-control"
                                            placeholder="End Time">
                                        @error('end_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <div class="col-md-12 submit-btn">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <label>Generated Slots</label>
                                <div class="mt-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="slots-container">
                                            <!-- Slots will be appended here -->
                                        </tbody>
                                    </table>
                                    <div class="mt-2">
                                        <strong>Total Slots: <span id="total-slots">0</span></strong>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            minDate: new Date().fp_incr(2),
            disableMobile: true,
            onChange: function(selectedDates) {
                const today = new Date();
                const selectedDate = selectedDates[0];
                const isToday =
                    selectedDate.getDate() === today.getDate() &&
                    selectedDate.getMonth() === today.getMonth() &&
                    selectedDate.getFullYear() === today.getFullYear();
            }
        });
        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
        });

        flatpickr("#end_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let startInput = document.getElementById("start_time");
            let endInput = document.getElementById("end_time");
            let slotsContainer = document.getElementById("slots-container");
            let totalSlotsEl = document.getElementById("total-slots");

            function generateSlots() {
                let start = startInput.value;
                let end = endInput.value;

                if (!start || !end) return;

                slotsContainer.innerHTML = "";

                let startTime = moment(start, "hh:mm A");
                let endTime = moment(end, "hh:mm A");

                // Lunch break times
                let lunchStart = moment("12:00 PM", "hh:mm A");
                let lunchEnd = moment("01:00 PM", "hh:mm A");

                let duration = 20;
                let totalSlots = 0;

                while (startTime.isBefore(endTime)) {
                    let slotStart = startTime.clone();
                    let slotEnd = slotStart.clone().add(duration, "minutes");

                    if (slotEnd.isAfter(endTime)) break;

                    // Skip lunch break
                    if (slotStart.isBefore(lunchEnd) && slotEnd.isAfter(lunchStart)) {
                        startTime = lunchEnd.clone();
                        continue;
                    }

                    // Add slot row in table + hidden input
                    let row = document.createElement("tr");
                    row.innerHTML = `
                <td>${slotStart.format("hh:mm A")}</td>
                <td>${slotEnd.format("hh:mm A")}</td>
                <td><button type="button" class="btn btn-sm btn-danger remove-slot">Remove</button></td>
                <input type="hidden" name="slots[]" value="${slotStart.format("HH:mm")}-${slotEnd.format("HH:mm")}">
            `;
                    slotsContainer.appendChild(row);

                    totalSlots++;
                    startTime.add(duration, "minutes");
                }

                // Update total slot count
                totalSlotsEl.textContent = totalSlots;
            }

            // Trigger slot generation
            startInput.addEventListener("change", generateSlots);
            endInput.addEventListener("change", generateSlots);

            // Handle remove button
            slotsContainer.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-slot")) {
                    e.target.closest("tr").remove();
                    totalSlotsEl.textContent = slotsContainer.querySelectorAll("tr").length;
                }
            });
        });
    </script>
@endsection
