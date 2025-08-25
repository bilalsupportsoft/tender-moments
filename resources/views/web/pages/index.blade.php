@extends('web.layouts.app')
@section('content')
    <!-- tmp banner area start -->
    @guest
    <div id="age-popup">
        <div class="popup-box">
            <h2 style="font-size:24px; color:#000;">Are you 18 years old or above?</h2>
            <button class="yes-btn" onClick="closePopup()">Yes, I am 18+</button>
            <button class="no-btn" onClick="stayOnPopup()">No</button>
        </div>
    </div>
    @endguest
    <div class="main-wrapper-inner">
    <div class="banner-right-thumbnail-area v2 tmp-section-gap tmp-gradient-main" id="home"
        style="background-image:url(assets/web/love-bg.png);  background-position: left;">
        <div class="container">
            <div class="row align-items-center pt--50">
                <div class="col-lg-9">
                    <div class="banner-right-thumb-left-content">
                        <div class="info-bell-timothy">
                            <p class="hello-title">Hello</p>
                            <h1>I’m Timothy</h1>
                            <p class="disc"> I’m an intuitive guide offering unique one-on-one sessions designed for
                                adult women who are open to exploring deep presence, sensual energy</p>
                            <div class="header-right-info d-flex align-items-center myauto-width mt-5">
                                <a class="tmp-btn hover-icon-reverse btn-border tmp-modern-button download-icon w-100 btn-md"
                                    href="javascript:void(0)" onClick="{{ Auth::check() ? 'openVerifiedPopup()' : 'openCustomPopup()' }}">
                                    <div class="icon-reverse-wrapper">
                                        <span class="btn-text">Book Appointment</span>
                                        <div class="btn-hack"></div>
                                        <img src="assets/web/images/button/btg-bg.svg" alt="" class="btn-bg">
                                        <img src="assets/web/images/button/btg-bg-2.svg" alt=""
                                            class="btn-bg-hover">
                                        <span class="btn-icon"><i
                                                class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                        <span class="btn-icon"><i
                                                class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tmp banner area end -->
    <!-- tmp service area start -->
    <div class="tmp-service-area tmp-section-gapBottom" id="service">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-head mb--50">
                        <div class="section-sub-title center-title tmp-scroll-trigger tmp-fade-in animation-order-1">
                            <span class="subtitle" style="font-size: 22px;color: #f8967d;"><strong>What I
                                    Do</strong></span>
                        </div>
                        <h2 class="title split-collab tmp-scroll-trigger tmp-fade-in animation-order-2">What I Provide
                            For You</h2>
                    </div>
                </div>
            </div>
            <div class="about-us-section-card row g-5 animation-action-2">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12  paralax-image">
                    <div class="about-us-card tmp-scroll-trigger tmponhover single-animation active tmp-fade-in animation-order-4"
                        style="--x: 153px; --y: 11px;">
                        <div class="card-head">
                            <div class="logo-img">
                                <img src="assets/web/love.png" align="" width="36">
                            </div>
                            <h3 class="card-title" style="color:#f86e86;">One On One Sessions </h3>
                        </div>
                        <p class="card-para" style="color:#fff;">These one-on-one sessions are designed to help women
                            explore their sensual energy and inner truth in a grounded, non-physical setting.
                        </p>
                        <div class="tmp-light light-center"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12  paralax-image">
                    <div class="about-us-card tmp-scroll-trigger tmponhover single-animation tmp-fade-in animation-order-5"
                        style="--x: 193px; --y: 152px;">
                        <div class="card-head">
                            <div class="logo-img">
                                <img src="assets/web/presence.png" align="" width="40">
                            </div>
                            <h3 class="card-title" style="color:#f86e86;"> Deep Presence</h3>
                        </div>
                        <p class="card-para" style="color:#fff;">In this space, you’re invited to slow down, connect
                            inward, and become fully attuned to your body and emotions.
                            With gentle guidance, deep presence
                        </p>
                        <div class="tmp-light light-center"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12  paralax-image">
                    <div class="about-us-card tmp-scroll-trigger tmponhover single-animation tmp-fade-in animation-order-4"
                        style="--x: 339px; --y: -1px;">
                        <div class="card-head">
                            <div class="logo-img">
                                <img src="assets/web/in-love.png" align="" width="40">
                            </div>
                            <h3 class="card-title" style="color:#f86e86;">Sensual Energy</h3>
                        </div>
                        <p class="card-para" style="color:#fff;"> These sessions offer a safe, non-physical space to
                            explore your aliveness, sensitivity, and inner flow.
                            Through presence and intuitive guidance,
                        </p>
                        <div class="tmp-light light-center"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12  paralax-image">
                    <div class="about-us-card tmp-scroll-trigger tmponhover single-animation tmp-fade-in animation-order-5"
                        style="--x: 15px; --y: 61px;">
                        <div class="card-head">
                            <div class="logo-img">
                                <img src="assets/web/personal-awareness.png" align="" width="40">
                            </div>
                            <h3 class="card-title" style="color:#f86e86;">Personal Awareness </h3>
                        </div>
                        <p class="card-para" style="color:#fff;"> These sessions support you in gently uncovering
                            patterns, emotions, and truths that shape your life.
                            With compassionate guidance, personal awareness
                        </p>
                        <div class="tmp-light light-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="latest-service-area tmp-section-gapTop">
        <div class="container">
            <div class="section-head mb--50">
                <div class="section-sub-title center-title tmp-scroll-trigger tmp-fade-in animation-order-1">
                    <span class="subtitle" style="color:#f86688;">About Me</span>
                </div>
                <h2 class="title split-collab tmp-scroll-trigger tmp-fade-in animation-order-2">My Experience Areas
                    Where <br>
                    I
                    Gained Skill
                </h2>
                <p class="description section-sm tmp-scroll-trigger tmp-fade-in animation-order-3"> Over the years,
                    I’ve cultivated deep skills through personal exploration, intuitive practice, and guided sessions.
                    Each area reflects a lived understanding that supports the transformative work I now offer. </p>
            </div>
            <div class="row animation-action-2">
                <div class="col-lg-6 my-auto order-2 order-lg-1">
                    <div class="paralax-image"
                        style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
                        <div
                            class="service-card-v2 single-animation tmponhover tmp-scroll-trigger tmp-fade-in animation-order-1 active">
                            <h2 class="service-card-num"><span>-</span>About the Experience</h2>
                            <p class="service-para" style="color:#fff;">These sessions are immersive, guided
                                experiences that blend intuitive presence and energetic focus. They are designed to help
                                you feel more attuned to your body, emotions, and inner sensuality—without physical
                                touch.<br>
                                Each session is tailored to your comfort, curiosity, and openness to the moment.</p>
                            <div class="tmp-light light-center"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 paralax-image order-1 order-lg-2"
                    style="will-change: transform; transform: perspective(1000px) rotateX(0deg) rotateY(0deg);">
                    <div class="service-card-user-image tmponhover single-animation tmp-control">
                        <img class="tmp-scroll-trigger tmp-zoom-in animation-order-1"
                            src="assets/web/images/services/latest-services-user-image.png" alt="latest-user-image">
                        <div class="tmp-light light-top-left"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tpm My Skill Area End -->
    <div class="fond-end-bol">
        <div class="container">
            <div class="contact-get-in-touch-wrap">
                <div class="get-in-touch-wrapper tmponhover active">
                    <div class="contact-get-in-touch-wrap">
                        <div class="get-in-touch-wrapper position-relative overflow-hidden">
                            <div class="row g-5 align-items-center">
                                <div class="col-lg-7">
                                    <div class="section-head text-align-left">
                                        <h2 class="title split-collab tmp-scroll-trigger tmp-fade-in animation-order-2"
                                            style="font-size:24px;">What to Expect </h2>
                                        <p style="color:#fff; font-size:16px; margin-top:20px; margin-bottom:10px;">
                                            This is a private, non-contact experience focused on personal connection,
                                            energy awareness, and mindful sensuality. Some clients describe the sessions
                                            as deeply relaxing, emotionally energizing, or quietly transformative.
                                            However, results vary, and no outcomes are guaranteed.
                                        </p>
                                        <p style="color:#fff; font-size:16px;"> Sessions are <strong>10
                                                minutes</strong> long and are offered via a secure online platform. The
                                            fee is <strong>$200 AUD</strong> per session.</p>
                                    </div>
                                    <div class="section-head text-align-left">
                                        <h2 class="title split-collab tmp-scroll-trigger tmp-fade-in animation-order-2"
                                            style="font-size:24px; margin-top:30px;">Who It's For </h2>
                                        <p style="color:#fff; font-size:16px; margin-top:20px;">
                                            These sessions are open to consenting adults aged 18 and older. While my
                                            work is especially suited to women who seek deeper connection with their
                                            inner energy and sensual self, all clients are treated with discretion,
                                            dignity, and respect.
                                        </p>
                                    </div>
                                    <div class="header-right-info d-flex align-items-center w-50 mt-5">
                                        <a class="tmp-btn hover-icon-reverse btn-border tmp-modern-button download-icon w-100 btn-md"
                                            href="javascript:void(0)" onClick="{{ Auth::check() ? 'openVerifiedPopup()' : 'openCustomPopup()' }}">
                                            <div class="icon-reverse-wrapper">
                                                <span class="btn-text">Book Appointment</span>
                                                <div class="btn-hack"></div>
                                                <img src="assets/web/images/button/btg-bg.svg" alt=""
                                                    class="btn-bg">
                                                <img src="assets/web/images/button/btg-bg-2.svg" alt=""
                                                    class="btn-bg-hover">
                                                <span class="btn-icon"><i
                                                        class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                                <span class="btn-icon"><i
                                                        class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <img src="assets/web/love-info.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tmp-light light-top-left"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heing-in-tag">
                    <h3>Important Disclaimer</h3>
                    <p>This is not a sexual service. There is no physical touch or nudity involved.
                        This is not a form of therapy, medical treatment, or spiritual counseling.
                        The service is for entertainment and personal enrichment only.
                    </p>
                </div>
                <div class="heing-in-tag">
                    <h3>Booking Your Session</h3>
                    <p>To reserve your private session, please use the online booking form. Once payment is received,
                        you’ll receive confirmation and session access instructions.
                    </p>
                </div>
                <div class="heing-in-tag">
                    <h3>Legal Disclaimer:</h3>
                    <p>Disclaimer – Important Information for Clients<br>
                        By booking or participating in a session with Timothy, you acknowledge and agree to the
                        following:
                    </p>
                </div>
                <div class="heing-in-tag">
                    <h3>Non-Therapeutic Nature</h3>
                    <p>These sessions are not a form of medical, psychological, psychiatric, or therapeutic treatment.
                        Timothy is not a licensed therapist, counsellor, psychologist, or medical practitioner, and no
                        such claims are made or implied.
                    </p>
                </div>
                <div class="heing-in-tag">
                    <h3>Entertainment Purpose Only</h3>
                    <p>All sessions are intended solely for personal enjoyment, relaxation, and entertainment. While
                        clients may experience subjective emotional or energetic responses, no specific outcomes are
                        promised or guaranteed.law.
                    </p>
                </div>
                <div class="heing-in-tag">
                    <h3>Client Eligibility</h3>
                    <p>This service is available only to consenting adults aged 18 years and older. By booking, you
                        confirm that you meet this requirement and that you are participating voluntarily.
                    </p>
                </div>
                <div class="heing-in-tag" style="margin: 0 0 100px 0;">
                    <h3>Personal Responsibility</h3>
                    <p>You are responsible for your own physical, emotional, and psychological wellbeing during and
                        after the session. If you have any medical, psychological, or emotional concerns, please consult
                        a qualified health professional.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection




