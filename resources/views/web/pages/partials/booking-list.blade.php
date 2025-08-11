<style>
    .pending-bookingbtn{
        background-color: #0000ff7a;
    color: #fff;
    padding: 3px 11px;
    font-size: 15px;
    border-radius: 3px;
    }
</style>
@if (isset($activeSlots) && count($activeSlots) > 0)
    @foreach ($activeSlots as $slot)
        <div class="all-booking-info">
            <div class="first-info-box">
                <div class="row">
                    <div class="time-and-stats d-flex justify-content-between">
                        <div class="active-booking">
                            <span class="active-bookingbtn">Active</span>
                        </div>
                        <div class="dateof-booking">
                            <div class="timeand-invoice">
                                <span class="download-invoice">
                                    <a href="{{ route('download.slot.invoice', $slot->id) }}">
                                        <img src="{{ asset('assets/web/bill.png') }}" alt="" width="32">
                                        Download Invoice
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/booking-infobel.png') }}"
                                    alt="" width="60"></div>
                            <div class="date-and-info">
                                <h4>Date of Booking</h4>
                                <p>{{ \Carbon\Carbon::parse($slot->slot_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/time-info.png') }}" alt=""
                                    width="60"></div>
                            <div class="date-and-info">
                                <h4>Booking Time</h4>
                                <p>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} to
                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/price.png') }}" alt=""
                                    width="60"></div>
                            <div class="date-and-info">
                                <h4>Booking Price</h4>
                                <p><strong>${{ $slot->price }}</strong></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@elseif(isset($filteredBookings) && count($filteredBookings) > 0)
    @foreach ($filteredBookings as $booking)
        <div class="all-booking-info">
            <div class="first-info-box">
                <div class="row">
                    <div class="time-and-stats d-flex justify-content-between">
                        <div class="active-booking">

                            @php
                                $currentDateTime = \Carbon\Carbon::now();
                                $slotDateTime = \Carbon\Carbon::parse($booking->slot_date . ' ' . $booking->start_time);
                                $slotEndTime = \Carbon\Carbon::parse($booking->slot_date . ' ' . $booking->end_time);

                                if ($booking->status === 'cancelled') {
                                    $displayStatus = 'Cancelled';
                                    $cssClass = 'cancel-bookingbtn';
                                } elseif ($booking->status === 'pending') {
                                    $displayStatus = 'Pending';
                                    $cssClass = 'pending-bookingbtn';
                                } elseif ($booking->status === 'confirmed') {
                                    if ($slotDateTime->isFuture()) {
                                        $displayStatus = 'Upcoming';
                                        $cssClass = 'upcoming-bookingbtn';
                                    } elseif (
                                        $slotDateTime->isToday() ||
                                        ($slotDateTime->isPast() && $slotEndTime->isFuture())
                                    ) {
                                        $displayStatus = 'Active';
                                        $cssClass = 'active-bookingbtn';
                                    } else {
                                        $displayStatus = 'Completed';
                                        $cssClass = 'completed-bookingbtn';
                                    }
                                } else {
                                    $displayStatus = ucfirst($booking->status);
                                    $cssClass = strtolower($displayStatus) . '-bookingbtn';
                                }
                            @endphp

                            <span class="{{ $cssClass }}">{{ $displayStatus }}</span>

                        </div>

                        <div class="dateof-booking">
                            <div class="timeand-invoice">
                                <span class="download-invoice">
                                    <a href="{{ route('download.invoice', $booking->id) }}">
                                        <img src="{{ asset('assets/web/bill.png') }}" alt="" width="32">
                                        Download Invoice
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/booking-infobel.png') }}"
                                    alt="" width="60"></div>
                            <div class="date-and-info">
                                <h4>Date of Booking</h4>
                                <p>{{ \Carbon\Carbon::parse($booking->slot_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/time-info.png') }}" alt=""
                                    width="60"></div>
                            <div class="date-and-info">
                                <h4>Booking Time</h4>
                                <p>{{ \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') }} to
                                    {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="date-of-booking d-flex">
                            <div class="icon-of-date"><img src="{{ asset('assets/web/price.png') }}" alt=""
                                    width="60"></div>
                            <div class="date-and-info">
                                <h4>Booking Price</h4>
                                <p><strong>${{ $booking->price }}</strong></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="alert alert-warning">No slots or bookings found.</div>
@endif
