<style>
    .slot-btn {
        padding: 8px 16px;
        border: 1px solid #52012c;
        border-radius: 5px;
        background-color: white;
        cursor: pointer;
        color: #52012c;
    }

    .slot-btn.selected {
        background-color: #52012c;
        color: white;
    }

    #continueBtn:disabled {
        background-color: #ccc !important;
        cursor: not-allowed;
        border-color: #ccc !important;
    }

    .bg-ragi-info.signup-height {
        height: 300px;
        background-size: cover;
    }

    /* Sign In ke liye */
    .signin-height {
        min-height: 400px;
    }
    input[type="radio"] ~ label::after {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    top: 4px;
    border: none;
}

body.modal-open {
  overflow: hidden;
}

.popup-overlay {
  overflow-y: auto;
}

/* New css */

/* Mobile Responsive */
/* Ensure .register-infotech stacks in column on small screens */
@media (max-width: 768px) {

    .popup-box {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh; /* important */
        overflow-y: auto; /* scroll inside popup */
        }

  .register-infotech {
    flex-direction: column !important;
    align-items: center;
  }

  .bg-ragi-info {
    width: 100%;
  }

  .bg-ragi-info .booking-info img {
    width: 100%;
    height: auto;
    display: block;
    object-fit: cover;
  }

  .right-info-rights {
    width: 100%;
    padding-top: 15px;
  }

  .slot-booking-box li {
    flex: 1 1 100%;
  }

  .slot-booking-box button {
    width: 100%;
  }

  .ui.input.left.icon {
    width: 100%;
  }

  .check-availability-btn {
    text-align: center;
  }

  #continueBtn {
    width: 100%;
  }
}

</style>
<div class="footer-stars-animation-wrapper-footer">
    <!-- Start Footer Area  -->
    <footer class="footer-area footer-style-one-wrapper bg-color-footer bg_images tmp-section-gap-info"
        style="background-image:url(assets/web/bg-footer.jpg);background-size: 100%;
         background-repeat: no-repeat;">
        <div class="separator-animated-border border-top-footer animated-true"></div>
        <div class="separator-animated-border animated-true"></div>
        <div class="container">
            <div class="footer-main footer-style-one">
                <div class="row g-5">
                    <div class="col-lg-5 col-md-6">
                        <div class="single-footer-wrapper border-right mr--20">
                            <div class="logo">
                                <a href="{{ route('/') }}">
                                    <img src="assets/web/footer-logo.png" alt="">
                                </a>
                                <p
                                    style="    font-size: 16px;
                                    color: #fff;
                                    padding: 30px 0 0 0;">
                                    Hi, my name is
                                    Timothy. I’m an intuitive guide offering unique one-on-one sessions designed for
                                    adult women who are open to exploring deep presence, sensual energy, and personal
                                    awareness in a respectful, non-physical setting.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-wrapper quick-link-wrap">
                            <h5 class="ft-title">Quick Link</h5>
                            <ul class="ft-link tmp-link-animation">
                                <li>
                                    <a href="{{ route('/') }}">Home</a>
                                </li>
                                <li>
                                    <a href="#">About Me</a>
                                </li>
                                <li>
                                    <a href="#">What to Expect</a>
                                </li>
                                <li>
                                    <a href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single-footer-wrapper contact-wrap">
                            <h5 class="ft-title">Contact </h5>
                            <ul class="ft-link tmp-link-animation">
                                <li><span class="ft-icon"><i class="fa-solid fa-envelope"></i></span><a
                                        href="#">tendermoments@mail.com </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright-area-one">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-wrapper">
                        <p class="copy-right-para tmp-link-animation"> <a href="#" target="_blank">Tender Moments
                            </a>
                            2025 | All Rights Reserved
                        </p>

                        <p class="copy-right-para tmp-link-animation text-white">
                            <strong>ABN</strong> 52114429886
                        </p>
                        <ul class="tmp-link-animation">
                            <li><a href="{{ route('term-condition') }} ">Terms &amp; Conditions</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Area  -->
    <div class="slider-bg-light">
        <img class="blocksync-scroll-trigger fade_in animation-order-8" src="assets/web/images/banner/shape/light.svg"
            alt="Top Light Shape">
    </div>
    <div class="slider-bg-dot-shape">
        <div class="wrapper blocksync-scroll-trigger blocksync-stars-area fade_in animation-order-16">
            <div class="blocksync-stars"></div>
            <div class="blocksync-stars2"></div>
            <div class="blocksync-stars3"></div>
        </div>
    </div>
</div>

<!-- New Popup -->
<div id="custom-popup">
    <div class="custom-popup-box">
        <div class="custom-close" onClick="closeCustomPopup()">×</div>
        <div class="register-infotech">
            <div class="bg-ragi-info login-info signup-height">
                <div class="logo-title-info">
                </div>
            </div>
            <div class="right-info-rights">
                <div id="register-section">
                    <h3>Create account</h3>
                    <p>Please enter the following details to create an account and book an appointment</p>
                    <form id="registerForm">
                        @csrf
                        <div class="info-fild-box">
                            <!--<form>-->
                            <div class="form-info-fild">
                                <label><img src="assets/web/user.png" alt="" width="24"> Full Name</label>
                                <input type="text" class="lable-icon-info" name="name"
                                    placeholder="Enter full name">
                                <span class="error-text text-danger"></span>
                            </div>
                            <div class="form-info-fild">
                                <label><img src="assets/web/email-id.png" alt="" width="24"> Email
                                    Address</label>
                                <input type="email" class="lable-icon-info" name="email"
                                    placeholder="Enter your email address">
                                <span class="error-text text-danger"></span>
                            </div>
                            <div class="form-info-fild position-relative">
                                <label><img src="assets/web/password.png" width="24"> Password</label>
                                <input type="password" id="register-password" class="lable-icon-info" name="password"
                                    placeholder="Enter your password">
                                <span class="error-text text-danger"></span>
                                <i class="fa fa-eye toggle-password"
                                    onclick="togglePasswordVisibility('register-password', this)"
                                    style="position:absolute; right:10px; top:53px; cursor:pointer;"></i>
                            </div>
                            <div class="form-info-fild" style="position: relative;">
                                <label><img src="assets/web/confirm-password.png" width="24"> Confirm
                                    Password</label>
                                <input type="password" id="confirm-password" name="password_confirmation"
                                    placeholder="Confirm your password">
                                <span class="error-text text-danger"></span>
                                <i class="fa fa-eye toggle-password"
                                    onclick="togglePasswordVisibility('confirm-password', this)"
                                    style="position:absolute; right:10px; top:53px; cursor:pointer;"></i>
                            </div>

                            <div class="form-info-fild">
                                <label> I am</label>
                                <div>
                                    <input type="radio" id="resident_au" name="residency" value="australian"
                                        required>
                                    <label for="resident_au">Australian Resident</label>
                                </div>
                                <div>
                                    <input type="radio" id="resident_nonau" name="residency"
                                        value="non_australian" required>
                                    <label for="resident_nonau">Non-Australian Resident</label>
                                </div>
                                <span class="error-text text-danger"></span>
                            </div>
                            <div class="submit-btn-info">
                                <button type="submit" class="submit-btn-infobnt-verify" id="registerBtn">
                                    <span class="btn-text">Sign Up</span>
                                    <span class="spinner-border spinner-border-sm text-light" role="status"
                                        aria-hidden="true" style="display:none;"></span>
                                </button>
                            </div>
                            <!--</form>-->
                        </div>
                    </form>
                    <p class="toggle-form">Already have an account? <a href="#" onclick="showLoginForm()"
                            style="color: blue">Sign In</a></p>
                </div>

                <!-- Login Form -->
                <div id="login-section" style="display:none;">
                    <div id="login-message" class="text-success mb-2" style="display:none;"></div>
                    <h3>Sign In</h3>
                    <form id="loginForm">
                        @csrf
                        <div class="info-fild-box">
                            <div class="form-info-fild">
                                <label><img src="assets/web/email-id.png" width="24"> Email Address</label>
                                <input type="email" name="email" placeholder="Enter your email">
                                <span class="error-text text-danger"></span>
                            </div>
                            <div class="form-info-fild position-relative">
                                <label><img src="assets/web/password.png" width="24"> Password</label>
                                <input type="password" id="login-password" name="password"
                                    placeholder="Enter your password">
                                <i class="fa fa-eye toggle-password"
                                    onclick="togglePasswordVisibility('login-password', this)"
                                    style="position:absolute; right:10px; top:53px; cursor:pointer;"></i>
                                <span class="error-text text-danger"></span>
                            </div>
                            <div class="submit-btn-info">
                                <button type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                    <p class="toggle-form mt-3">Don't have an account? <a href="#" onclick="showRegisterForm()"
                            style="color: blue;">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="otp-popup" class="popup-overlay">
    <div class="popup-box">
        <div class="popup-close" onClick="closeOtpPopup()">×</div>
        <div class="otp-verificaion-info">
            <img src="assets/web/otp-img.png" alt="" width="150" style="margin-bottom:30px;">
            <h3>OTP Verification</h3>
            <p>One-time passwrold sent to your Email Address</p>
            <div class="input_box_otp">
                <input type="text" class="otp_box" maxlength="1" oninput="moveToNext(this, event)"
                    onKeyDown="validateDigit(event)">
                <input type="text" class="otp_box" maxlength="1" oninput="moveToNext(this, event)"
                    onKeyDown="validateDigit(event)">
                <input type="text" class="otp_box" maxlength="1" oninput="moveToNext(this, event)"
                    onKeyDown="validateDigit(event)">
                <input type="text" class="otp_box" maxlength="1" oninput="moveToNext(this, event)"
                    onKeyDown="validateDigit(event)">
                <div class="submit-btn-infobnt-verify">
                    <button type="submit" class="submit-btn-infobnt-verify" onClick="openVerifiedPopup()">
                        Verify OTP</button>
                </div>
                <p class="info-donot">Didn’t received the code? <a href="#">Resend Code ?</a></p>
            </div>
        </div>
    </div>
</div>


<div id="verified-popup" class="popup-overlay">
    <div class="popup-box main-widthbooking">
        <div class="popup-close" onClick="closeVerifiedPopup()">×</div>
        <div class="otp-verificaion-info">
            <div class="input_box_otp">
                <div class="register-infotech">
                    <div class="bg-ragi-info booking-info">
                    </div>
                    <div class="right-info-rights">
                        <h3>Book Appointment</h3>
                        <p>Schedule your session easily—choose a time that works best for you </p>
                        <div class="info-fild-box">
                            <!--<form>-->
                            <label for="exampleFormControlInput1" class="form-label label-title">Date Of
                                Appointment</label>
                            <div class="ui calendar" id="example2">
                                <div class="ui input left icon">
                                    <div class="position-relative dob-user">
                                        <div class="icon-date"> <img src="assets/web/date.png" alt=""> </div>
                                        <input type="text" id="appointment-date"
                                            class="form-control select-dateinfo"
                                            placeholder="Select Date Of Appointment">
                                    </div>
                                </div>
                            </div>

                            <div class="available-booking-slot">
                                <div class="timte-and-heading d-flex justify-content-between">
                                    <div class="booking-heding-av">
                                        <h5>Available Slots</h5>
                                    </div>
                                    <div class="only-timebooking">
                                        <p><img src="assets/web/time-slot.png" alt="" width="18"> 20
                                            Mins/Session</p>
                                    </div>

                                </div>
                                <ul class="slot-booking-box" id="slot-list">
                                    <li><button>10:20 AM - 10: 40 AM</button></li>
                                    <li><button>11:20 AM - 11: 40 PM</button></li>
                                    <li><button class="active-slots">3:40 AM - 04: 00 PM</button></li>
                                    <li><button>04:20 AM - 04: 40 AM</button></li>
                                    <li><button>3:40 AM - 04: 00 PM</button></li>
                                    <li><button>04:20 AM - 04: 40 AM</button></li>
                                </ul>
                            </div>
                            <div class="check-availability-btn">
                                <button type="submit" id="continueBtn" disabled
                                    onClick="openAvailabilityPopup()">Continue</button>
                            </div>
                            <!--</form>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="avalability-popup" class="popup-overlay">
    <div class="popup-box main-widthbooking">
        <div class="popup-close" onClick="closeAvailabilityPopup()">×</div>
        <div class="otp-verificaion-info">
            <div class="input_box_otp">
                <div class="register-infotech">
                    <div class="bg-ragi-info booking-info">

                    </div>
                    <div class="right-info-rights padding-infoset">

                        <div class="info-fild-box">
                            <!--<form>-->
                            <div class="booking-avalable-data">
                                <div class="row">
                                    <div class="col-md-12 mt-0">
                                        <div class="box-info-data d-flex ">
                                            <div class="img-icon-info">
                                                <span><img src="assets/web/date-info.png" alt=""
                                                        width="60">
                                                </span>
                                            </div>
                                            <div class="info-details-bar">
                                                <h3>Date</h3>
                                                <p id="slot-date">23 July 2025 </p>
                                            </div>
                                        </div>
                                        <div class="box-info-data d-flex">
                                            <div class="img-icon-info">
                                                <span><img src="assets/web/time-info.png" alt=""
                                                        width="60">
                                                </span>
                                            </div>
                                            <div class="info-details-bar">
                                                <h3>Time</h3>
                                                <p id="slot-time">10:00 AM to 10:20 PM (20 Minutes) </p>
                                            </div>
                                        </div>
                                        <div class="box-info-data d-flex no-border">
                                            <div class="img-icon-info">
                                                <span><img src="assets/web/price.png" alt="" width="60">
                                                </span>
                                            </div>
                                            <div class="info-details-bar">
                                                <h3>Price</h3>
                                                <p id="slot-price"><strong>$220 </strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between padding-action-btn">
                                <div class="button-go-back">
                                    <button type="button" onClick="openVerifiedPopup()"> <i
                                            class="fa-regular fa-chevron-left"></i> Go Back</button>
                                </div>
                                <div class="button-go-back">
                                    <button id="bookPayBtn" type="button" onclick="bookAndPay()">
                                        <span id="bookPayText">Book & Pay</span>
                                        <span id="bookPaySpinner" class="spinner-border spinner-border-sm"
                                            style="display:none;"></span>
                                    </button>
                                </div>
                            </div>
                            <!--</form>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function showLoginForm() {
        $('#register-section').hide();
        $('#login-section').show();
        // Height class change
        $('.bg-ragi-info').removeClass('signup-height').addClass('signin-height');
        document.getElementById('register-section').style.display = 'none';
        document.getElementById('login-section').style.display = 'block';
    }

    function showRegisterForm() {
        $('#login-section').hide();
        $('#register-section').show();
        // Height class change
        $('.bg-ragi-info').removeClass('signin-height').addClass('signup-height');
        document.getElementById('login-section').style.display = 'none';
        document.getElementById('register-section').style.display = 'block';
    }
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        // Clear previous errors
        form.find('.error-text').text('');
        form.find('input').removeClass('is-invalid');

        let btn = document.getElementById("registerBtn");
        let btnText = btn.querySelector(".btn-text");
        let spinner = btn.querySelector(".spinner-border");

        // Show loader
        btn.disabled = true;
        btnText.style.display = "none";
        spinner.style.display = "inline-block";

        $.ajax({
            url: '{{ route('user.register') }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                // alert("Registration successful!");
                // form[0].reset();
                //         if (response.success === true) {
                //             openVerifiedPopup();
                //             $('#registerForm')[0].reset();
                //             closeCustomPopup();
                //     setTimeout(() => {
                //     btn.disabled = false;
                //     btnText.style.display = "inline";
                //     spinner.style.display = "none";
                // }, 3000);
                //         }

                if (response.success === true) {
                    sessionStorage.setItem("openVerifiedPopup", "true");
                    location.reload();
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        let input = form.find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.next('.error-text').text(value[0]);
                    });
                } else {
                    alert("Something went wrong.");
                }
                btn.disabled = false;
                btnText.style.display = "inline";
                spinner.style.display = "none";
            }
        });
    });

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $('.error-text').text('');
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('login') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#login-message')
                        .removeClass('text-danger')
                        .addClass('text-success')
                        .text('Login successful!')
                        .show();
                    setTimeout(function() {
                        window.location.href = response.redirect_url ?? "/dashboard";
                    }, 1000);
                } else {
                    $('#login-message')
                        .removeClass('text-success')
                        .addClass('text-danger')
                        .text(response.message ?? 'Login failed.')
                        .show();
                }
            },
            error: function(xhr) {
                $('#login-message').removeClass('text-success').addClass('text-danger');
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        $(`[name="${key}"]`).siblings('.error-text').text(val[0]);
                    });
                } else {
                    $('#login-message').text('Something went wrong.').show();
                }
            }
        });
    });

    function togglePasswordVisibility(inputId, iconElement) {
        const passwordInput = document.getElementById(inputId);
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        }
    }

    //////..........booking-slot-....................................///

    let selectedDate = null;
    let selectedSlot = null;

    function checkEnableContinue() {
        if (selectedDate && selectedSlot) {
            $('#continueBtn').prop('disabled', false);
        } else {
            $('#continueBtn').prop('disabled', true);
        }
    }

    $(document).ready(function() {
        const today = new Date();

        $('#example2').calendar({
            type: 'date',
            minDate: today,
            formatter: {
                date: function(date, settings) {
                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return (day < 10 ? '0' + day : day) + '-' +
                        (month < 10 ? '0' + month : month) + '-' +
                        year;
                }
            },
            onChange: function(date, text, mode) {
                if (text) {
                    selectedDate = text;
                    selectedSlot = null;
                    checkEnableContinue();
                    loadSlots(text);
                }
            }
        });

        const formattedToday = ('0' + today.getDate()).slice(-2) + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
            today.getFullYear();

        $('#example2').calendar('set date', today);
        selectedDate = formattedToday;
        loadSlots(formattedToday);
        checkEnableContinue();
    });

    function loadSlots(selectedDateParam) {
        $.ajax({
            url: "{{ route('get.slots') }}",
            type: "GET",
            data: {
                date: selectedDateParam
            },
            success: function(response) {
                $('#slot-list').empty();
                if (response.slots.length > 0) {
                    $.each(response.slots, function(index, slot) {
                        const button = $(
                            `<li><button class="slot-btn">${slot.start_time} - ${slot.end_time}</button></li>`
                        );
                        button.find('button').on('click', function() {
                            $('.slot-btn').removeClass('selected');
                            $(this).addClass('selected');
                            selectedSlot = slot;
                            checkEnableContinue();
                        });
                        $('#slot-list').append(button);
                    });
                } else {
                    $('#slot-list').append('<li><button disabled>No slots available</button></li>');
                    selectedSlot = null;
                    checkEnableContinue();
                }
            },
            error: function() {
                $('#slot-list').html('<li><button disabled>Error loading slots</button></li>');
                selectedSlot = null;
                checkEnableContinue();
            }
        });
    }
    let userResidency = "{{ Auth::user()->residency ?? '' }}";

    function setSelectedDate() {
        $('#slot-date').text(selectedDate);
        $('#slot-time').text(`${selectedSlot.start_time} to ${selectedSlot.end_time} (20 Minutes)`);
        let basePrice = parseFloat(selectedSlot.total);
        let residency = userResidency;
        if (residency === 'australian') {
        $('#slot-price').html(`
            <div>Base Price: <strong>$${parseFloat(selectedSlot.price).toFixed(2)}</strong></div>
            <div>(Includes GST 10%): <strong>$${parseFloat(selectedSlot.gst_amount).toFixed(2)}</strong></div>
            <div>Total: <strong>$${parseFloat(selectedSlot.total).toFixed(2)}</strong></div>
        `);
    } else if (residency === 'non_australian') {
        $('#slot-price').html(`
            <div>Total (GST Free): <strong>$${parseFloat(selectedSlot.price).toFixed(2)}</strong></div>
        `);
    } else {
        $('#slot-price').html(`<strong>$${parseFloat(selectedSlot.price).toFixed(2)}</strong> (not)`);
    }
    }



    ////.........................booking...................................
    function bookAndPay() {
        if (!selectedDate || !selectedSlot || !selectedSlot.id) {
            alert('Please select a valid slot first.');
            return;
        }

        let btn = document.getElementById('bookPayBtn');
        let text = document.getElementById('bookPayText');
        let spinner = document.getElementById('bookPaySpinner');

        // Show spinner, hide text
        text.style.display = '';
        spinner.style.display = 'inline-block';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('book.slot') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                slot_id: selectedSlot.id,
                date: selectedDate,
                price: selectedSlot.price,
                gst_amount: selectedSlot.gst_amount,
                total_amount: selectedSlot.total,
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    alert(response.message || 'Booking failed.');
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    }

    $(document).ready(function() {
        if (sessionStorage.getItem("openVerifiedPopup") === "true") {
            closeCustomPopup();
            openVerifiedPopup();
            sessionStorage.removeItem("openVerifiedPopup");
        }
    });
</script>
