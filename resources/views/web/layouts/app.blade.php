<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="assets/web/favicon.ico">
    <title>Tender Moments </title>
    <!-- Bootstrap min css -->
    <link rel="stylesheet" href="{{asset('assets/web/css/vendor/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/webcss/plugins/swiper.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/css/plugins/odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/css/vendor/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/css/semantic.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/web/css/vendor/bootstrap.min.css')}}">
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset('assets/web/css/style.css')}}">
</head>
<style>
    #age-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 9999;
    }
    .popup-box {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        width: 460px;
    }
    .popup-box h2 {
        margin-bottom: 20px;
        font-family: "Montserrat", sans-serif;
    }
    .popup-box button {
    padding: 10px 20px;
    margin: 0px 0px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 150px;
}
    .yes-btn {
        background-color: #4CAF50;
        color: white;
    }
    .no-btn {
        background-color: #f44336;
        color: white;
    }
    header.tmp-header-area-start.header-one {
    background-color: #20012b;
}

header.header--sticky.header--transparent {
    position: sticky;
    top: 0;
    z-index: 999;
}
</style>
<body class="spybody" data-spy="scroll" data-bs-target=".navbar-example2" data-offset="150">


    @include('web.layouts.elements.header')
            @yield('content')
            @include('web.layouts.elements.footer')
      <!---->
      <script src="{{asset('assets/web/js/vendor/modernizer.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/jquery.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/jquery-ui.min.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/waypoints.min.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/odometer.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/appear.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/jquery-one-page-nav.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/tilt.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/swiper.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/gsap.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/splittext.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/scrolltigger.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/scrolltoplugins.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/smoothscroll.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/twinmax.js')}}"></script>
      <!-- bootstrap Js-->
      <script src="{{asset('assets/web/js/vendor/bootstrap.min.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/waw.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/isotop.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/animation.js')}}"></script>
      <script src="{{asset('assets/web/js/vendor/backtop.js')}}"></script>
      <script src="{{asset('assets/web/js/semantic.min.js')}}"></script>
      <script src="{{asset('assets/web/js/plugins/text-type.js')}}"></script>
      <!-- custom Js -->
      <script src="{{asset('assets/web/js/main.js')}}"></script>
      <script src="{{asset('assets/web/js/date-script.js')}}"></script>
      @yield('script')
      <script>
          const start = document.getElementById("startTime");
          const end = document.getElementById("endTime");
          const output = document.getElementById("timeOutput");
          const fill = document.getElementById("rangeFill");
          const totalHours = document.getElementById("totalHours");

          function formatAMPM(hour) {
              const h = hour % 12 === 0 ? 12 : hour % 12;
              const ampm = hour < 12 ? "AM" : "PM";
              return (h < 10 ? "0" : "") + h + ":00 " + ampm;
          }

          function updateSlider() {
              let startVal = parseInt(start.value);
              let endVal = parseInt(end.value);
              // Prevent overlap
              if (startVal >= endVal) {
                  if (event.target.id === "startTime") {
                      startVal = endVal - 1;
                      if (startVal >= 0) start.value = startVal;
                  } else {
                      endVal = startVal + 1;
                      if (endVal <= 24) end.value = endVal;
                  }
              }
              output.textContent = `${formatAMPM(startVal)} - ${formatAMPM(endVal)}`;
              totalHours.textContent = `Total: ${endVal - startVal} hour${endVal - startVal > 1 ? "s" : ""}`;
              const range = end.max - start.min;
              const percent1 = ((startVal - start.min) / range) * 100;
              const percent2 = ((endVal - start.min) / range) * 100;
              fill.style.left = percent1 + "%";
              fill.style.width = (percent2 - percent1) + "%";
          }
          updateSlider();
      </script>
      @guest
      <script>
          // Disable scroll on load
          document.body.style.overflow = "hidden";

          function closePopup() {
              document.getElementById("age-popup").style.display = "none";
              document.body.style.overflow = "auto"; // enable scroll
          }

          function stayOnPopup() {
              alert("You must be 18+ to enter this site.");
          }
      </script>
      @endguest
      <script type="text/javascript">
          function openCustomPopup() {
              const popup = document.getElementById('custom-popup');
              popup.classList.add('active');
              document.body.classList.add('noscroll2');
              document.documentElement.classList.add('noscroll2'); // Add to <html>
               // Default show login form
                document.getElementById('register-section').style.display = 'none';
                document.getElementById('login-section').style.display = 'block';
          }

          function closeCustomPopup() {
              const popup = document.getElementById('custom-popup');
              popup.classList.remove('active');
              document.body.classList.remove('noscroll2');
              document.documentElement.classList.remove('noscroll2'); // Remove from <html>
          }

          function openOtpPopup() {
              const popupCus = document.getElementById('custom-popup');
              const popup = document.getElementById('otp-popup');
              popupCus.classList.remove('active');
              popup.classList.add('active');
              document.body.classList.add('noscroll2');
              document.documentElement.classList.add('noscroll2'); // Add to <html>
          }

          function closeOtpPopup() {
              const popup = document.getElementById('otp-popup');
              popup.classList.remove('active');
              document.body.classList.remove('noscroll2');
              document.documentElement.classList.remove('noscroll2'); // Remove from <html>
          }

          function openVerifiedPopup() {
              const popupOtp = document.getElementById('otp-popup');
              const popupAvailable = document.getElementById('avalability-popup');
              const popup = document.getElementById('verified-popup');
              popupOtp.classList.remove('active');
              popupAvailable.classList.remove('active');
              popup.classList.add('active');
              document.body.classList.add('noscroll2');
              document.documentElement.classList.add('noscroll2'); // Add to <html>
          }

          function closeVerifiedPopup() {
              const popup = document.getElementById('verified-popup');
              popup.classList.remove('active');
              document.body.classList.remove('noscroll2');
              document.documentElement.classList.remove('noscroll2'); // Remove from <html>
          }

          function openAvailabilityPopup() {
              const popupVerify = document.getElementById('verified-popup');
              const popup = document.getElementById('avalability-popup');
              popupVerify.classList.remove('active');
              popup.classList.add('active');
              document.body.classList.add('noscroll2');
              document.documentElement.classList.add('noscroll2'); // Add to <html>
              setSelectedDate();
          }

          function closeAvailabilityPopup() {
              const popup = document.getElementById('avalability-popup');
              popup.classList.remove('active');
              document.body.classList.remove('noscroll2');
              document.documentElement.classList.remove('noscroll2'); // Remove from <html>
          }
      </script>
      <script>
          function moveToNext(input, event) {
              if (input.value.length === 1) {
                  let next = input.nextElementSibling;
                  if (next && next.classList.contains('otp_box')) {
                      next.focus();
                  }
              }
          }

          function validateDigit(e) {
              // Allow backspace
              if (e.key === "Backspace") return;
              // Block non-digit keys
              if (!/^\d$/.test(e.key)) {
                  e.preventDefault();
              }
          }

          function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("show");
    }

    window.onclick = function(e) {
      if (!e.target.closest('.profile-menu')) {
        document.getElementById("dropdownMenu").classList.remove('show');
      }
    }
      </script>
      </body>

      </html>
