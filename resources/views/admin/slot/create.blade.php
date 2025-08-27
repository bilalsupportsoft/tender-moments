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
            <span class="text-primary fw-light">Add Slot</span>
        </h5>
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="card profile-card">
                    <div class="card-body pb-5">
                        <form action="{{ route('admin.slot.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control" placeholder="Price" value="200">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slot Date</label>
                                        <input type="text" id="datepicker" name="slot_date" class="form-control" placeholder="Select Slot Date" readonly>
                                        @error('slot_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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

                            <div class="pt-4">
                                <div class="col-md-12 submit-btn">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

    <script>
        flatpickr("#datepicker", {
            dateFormat: "d-m-Y",
            minDate: new Date().fp_incr(1),
            disableMobile: true,
            onChange: function () {
                generateFixedSlots();
            }
        });

        function generateFixedSlots() {
            const slotsContainer = document.getElementById("slots-container");
            const totalSlotsEl = document.getElementById("total-slots");
            slotsContainer.innerHTML = "";

            const timeSlots = [
                { start: "10:00 AM", end: "12:00 PM" },
                { start: "01:00 PM", end: "05:00 PM" }
            ];

            const duration = 20; // minutes
            let totalSlots = 0;

            timeSlots.forEach(period => {
                let startTime = moment(period.start, "hh:mm A");
                const endTime = moment(period.end, "hh:mm A");

                while (startTime.isBefore(endTime)) {
                    const slotStart = startTime.clone();
                    const slotEnd = slotStart.clone().add(duration, "minutes");

                    if (slotEnd.isAfter(endTime)) break;

                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${slotStart.format("hh:mm A")}</td>
                        <td>${slotEnd.format("hh:mm A")}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-slot">Remove</button>
                            <input type="hidden" name="slots[]" value="${slotStart.format("HH:mm")}-${slotEnd.format("HH:mm")}">
                        </td>
                    `;
                    slotsContainer.appendChild(row);
                    totalSlots++;
                    startTime.add(duration, "minutes");
                }
            });

            totalSlotsEl.textContent = totalSlots;
        }

        // Remove slot and update count
        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-slot")) {
                e.target.closest("tr").remove();
                document.getElementById("total-slots").textContent = document.querySelectorAll("#slots-container tr").length;
            }
        });
    </script>
@endsection
