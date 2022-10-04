@extends("backend.template.layout")

@section('per_page_css')
<style>
    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }

    .blast-freezer-entry {
        padding: 15px;
    }

    .blast-freezer-entry .card-item {
        background: white;
        padding: 15px;
    }


    .main {
        background-color: #011327;
        display: block;
        justify-content: center;
        align-items: center;
        font-family: Calibri Light
    }

    .countDown {
        background-color: white;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;

    }

    .item {
        background-color: #02244a;
        color: white;
        font-size: 25px;
        margin: 11px 0;
        text-align: center;
        font-weight: 100;
    }

    .column {
        background-color: #02244a;
        margin: 0.5vw;
        width: 65px;
        height: 30px;

    }

    .text {

        height: 15vw;
        text-align: center;
        font-size: 4.5vw;

        font-weight: 100;
        color: white;
        text-align: center;
        width: 100%;
    }

    .column {
        background-color: #02244a;
        margin: .5vw;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Blast Freezer Entry</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        @if( can('add_freezer') )
                        <button type="button" data-content="{{ route('freezer.add.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- freezer entry data row start -->
        <div class="row blast-freezer-entry">

            <!-- card item start -->
            <div class="col-md-4 card-item">
                <div class="main">

                    <div class="countDown">
                        <div class="your-element" data-tilt>
                            <div class="column">
                                <div id="Hours" class="item">0</div>
                                <p>H</p>
                            </div>
                        </div>
                        <div class="your-element" data-tilt>
                            <div class="column">
                                <div id="Minutes" class="item">0</div>
                                <p>M</p>
                            </div>
                        </div>
                        <div class="your-element" data-tilt>
                            <div class="column">
                                <div id="Seconds" class="item">0</div>
                                <p>S</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- card item end -->

        </div>
        <!-- freezer entry data row end -->

    </div>


    @endsection

    @section('per_page_js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
    <script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>
    <script>
        let date = new Date("1,1,2023")

        let CountHour = document.getElementById("Hours")
        let CountMinutes = document.getElementById("Minutes")
        let CountSeconds = document.getElementById("Seconds")
        let Int = setInterval(UpdateTime, 1)

        function UpdateTime() {
            let Now = new Date().getTime()
            let distance = date - Now

            CountHour.innerHTML = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            CountMinutes.innerHTML = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

            CountSeconds.innerHTML = Math.floor((distance % (1000 * 60)) / 1000);


            if (distance < 0) {
                clearInterval(Int)
                document.getElementById("Hours").innerHTML = "pen";
                document.getElementById("Minutes").innerHTML = "is";
                document.getElementById("Seconds").innerHTML = "Exp"

            }
        }

        var VanillaTilt = (function() {
            'use strict';



            class VanillaTilt {
                constructor(element, settings = {}) {
                    if (!(element instanceof Node)) {
                        throw ("Can't initialize VanillaTilt because " + element + " is not a Node.");
                    }

                    this.width = null;
                    this.height = null;
                    this.clientWidth = null;
                    this.clientHeight = null;
                    this.left = null;
                    this.top = null;


                    this.gammazero = null;
                    this.betazero = null;
                    this.lastgammazero = null;
                    this.lastbetazero = null;

                    this.transitionTimeout = null;
                    this.updateCall = null;
                    this.event = null;

                    this.updateBind = this.update.bind(this);
                    this.resetBind = this.reset.bind(this);

                    this.element = element;
                    this.settings = this.extendSettings(settings);

                    this.reverse = this.settings.reverse ? -1 : 1;
                    this.glare = VanillaTilt.isSettingTrue(this.settings.glare);
                    this.glarePrerender = VanillaTilt.isSettingTrue(this.settings["glare-prerender"]);
                    this.fullPageListening = VanillaTilt.isSettingTrue(this.settings["full-page-listening"]);
                    this.gyroscope = VanillaTilt.isSettingTrue(this.settings.gyroscope);
                    this.gyroscopeSamples = this.settings.gyroscopeSamples;

                    this.elementListener = this.getElementListener();

                    if (this.glare) {
                        this.prepareGlare();
                    }

                    if (this.fullPageListening) {
                        this.updateClientSize();
                    }

                    this.addEventListeners();
                    this.reset();
                    this.updateInitialPosition();
                }

                static isSettingTrue(setting) {
                    return setting === "" || setting === true || setting === 1;
                }


                getElementListener() {
                    if (this.fullPageListening) {
                        return window.document;
                    }

                    if (typeof this.settings["mouse-event-element"] === "string") {
                        const mouseEventElement = document.querySelector(this.settings["mouse-event-element"]);

                        if (mouseEventElement) {
                            return mouseEventElement;
                        }
                    }

                    if (this.settings["mouse-event-element"] instanceof Node) {
                        return this.settings["mouse-event-element"];
                    }

                    return this.element;
                }


                addEventListeners() {
                    this.onMouseEnterBind = this.onMouseEnter.bind(this);
                    this.onMouseMoveBind = this.onMouseMove.bind(this);
                    this.onMouseLeaveBind = this.onMouseLeave.bind(this);
                    this.onWindowResizeBind = this.onWindowResize.bind(this);
                    this.onDeviceOrientationBind = this.onDeviceOrientation.bind(this);

                    this.elementListener.addEventListener("mouseenter", this.onMouseEnterBind);
                    this.elementListener.addEventListener("mouseleave", this.onMouseLeaveBind);
                    this.elementListener.addEventListener("mousemove", this.onMouseMoveBind);

                    if (this.glare || this.fullPageListening) {
                        window.addEventListener("resize", this.onWindowResizeBind);
                    }

                    if (this.gyroscope) {
                        window.addEventListener("deviceorientation", this.onDeviceOrientationBind);
                    }
                }

                removeEventListeners() {
                    this.elementListener.removeEventListener("mouseenter", this.onMouseEnterBind);
                    this.elementListener.removeEventListener("mouseleave", this.onMouseLeaveBind);
                    this.elementListener.removeEventListener("mousemove", this.onMouseMoveBind);

                    if (this.gyroscope) {
                        window.removeEventListener("deviceorientation", this.onDeviceOrientationBind);
                    }

                    if (this.glare || this.fullPageListening) {
                        window.removeEventListener("resize", this.onWindowResizeBind);
                    }
                }

                destroy() {
                    clearTimeout(this.transitionTimeout);
                    if (this.updateCall !== null) {
                        cancelAnimationFrame(this.updateCall);
                    }

                    this.reset();

                    this.removeEventListeners();
                    this.element.vanillaTilt = null;
                    delete this.element.vanillaTilt;

                    this.element = null;
                }

                onDeviceOrientation(event) {
                    if (event.gamma === null || event.beta === null) {
                        return;
                    }

                    this.updateElementPosition();

                    if (this.gyroscopeSamples > 0) {
                        this.lastgammazero = this.gammazero;
                        this.lastbetazero = this.betazero;

                        if (this.gammazero === null) {
                            this.gammazero = event.gamma;
                            this.betazero = event.beta;
                        } else {
                            this.gammazero = (event.gamma + this.lastgammazero) / 2;
                            this.betazero = (event.beta + this.lastbetazero) / 2;
                        }

                        this.gyroscopeSamples -= 1;
                    }

                    const totalAngleX = this.settings.gyroscopeMaxAngleX - this.settings.gyroscopeMinAngleX;
                    const totalAngleY = this.settings.gyroscopeMaxAngleY - this.settings.gyroscopeMinAngleY;

                    const degreesPerPixelX = totalAngleX / this.width;
                    const degreesPerPixelY = totalAngleY / this.height;

                    const angleX = event.gamma - (this.settings.gyroscopeMinAngleX + this.gammazero);
                    const angleY = event.beta - (this.settings.gyroscopeMinAngleY + this.betazero);

                    const posX = angleX / degreesPerPixelX;
                    const posY = angleY / degreesPerPixelY;

                    if (this.updateCall !== null) {
                        cancelAnimationFrame(this.updateCall);
                    }

                    this.event = {
                        clientX: posX + this.left,
                        clientY: posY + this.top,
                    };

                    this.updateCall = requestAnimationFrame(this.updateBind);
                }

                onMouseEnter() {
                    this.updateElementPosition();
                    this.element.style.willChange = "transform";
                    this.setTransition();
                }

                onMouseMove(event) {
                    if (this.updateCall !== null) {
                        cancelAnimationFrame(this.updateCall);
                    }

                    this.event = event;
                    this.updateCall = requestAnimationFrame(this.updateBind);
                }

                onMouseLeave() {
                    this.setTransition();

                    if (this.settings.reset) {
                        requestAnimationFrame(this.resetBind);
                    }
                }

                reset() {
                    this.event = {
                        clientX: this.left + this.width / 2,
                        clientY: this.top + this.height / 2
                    };

                    if (this.element && this.element.style) {
                        this.element.style.transform = `perspective(${this.settings.perspective}px) ` +
                            `rotateX(0deg) ` +
                            `rotateY(0deg) ` +
                            `scale3d(1, 1, 1)`;
                    }

                    this.resetGlare();
                }

                resetGlare() {
                    if (this.glare) {
                        this.glareElement.style.transform = "rotate(180deg) translate(-50%, -50%)";
                        this.glareElement.style.opacity = "0";
                    }
                }

                updateInitialPosition() {
                    if (this.settings.startX === 0 && this.settings.startY === 0) {
                        return;
                    }

                    this.onMouseEnter();

                    if (this.fullPageListening) {
                        this.event = {
                            clientX: (this.settings.startX + this.settings.max) / (2 * this.settings.max) * this.clientWidth,
                            clientY: (this.settings.startY + this.settings.max) / (2 * this.settings.max) * this.clientHeight
                        };
                    } else {
                        this.event = {
                            clientX: this.left + ((this.settings.startX + this.settings.max) / (2 * this.settings.max) * this.width),
                            clientY: this.top + ((this.settings.startY + this.settings.max) / (2 * this.settings.max) * this.height)
                        };
                    }


                    let backupScale = this.settings.scale;
                    this.settings.scale = 1;
                    this.update();
                    this.settings.scale = backupScale;
                    this.resetGlare();
                }

                getValues() {
                    let x, y;

                    if (this.fullPageListening) {
                        x = this.event.clientX / this.clientWidth;
                        y = this.event.clientY / this.clientHeight;
                    } else {
                        x = (this.event.clientX - this.left) / this.width;
                        y = (this.event.clientY - this.top) / this.height;
                    }

                    x = Math.min(Math.max(x, 0), 1);
                    y = Math.min(Math.max(y, 0), 1);

                    let tiltX = (this.reverse * (this.settings.max - x * this.settings.max * 2)).toFixed(2);
                    let tiltY = (this.reverse * (y * this.settings.max * 2 - this.settings.max)).toFixed(2);
                    let angle = Math.atan2(this.event.clientX - (this.left + this.width / 2), -(this.event.clientY - (this.top + this.height / 2))) * (180 / Math.PI);

                    return {
                        tiltX: tiltX,
                        tiltY: tiltY,
                        percentageX: x * 100,
                        percentageY: y * 100,
                        angle: angle
                    };
                }

                updateElementPosition() {
                    let rect = this.element.getBoundingClientRect();

                    this.width = this.element.offsetWidth;
                    this.height = this.element.offsetHeight;
                    this.left = rect.left;
                    this.top = rect.top;
                }

                update() {
                    let values = this.getValues();

                    this.element.style.transform = "perspective(" + this.settings.perspective + "px) " +
                        "rotateX(" + (this.settings.axis === "x" ? 0 : values.tiltY) + "deg) " +
                        "rotateY(" + (this.settings.axis === "y" ? 0 : values.tiltX) + "deg) " +
                        "scale3d(" + this.settings.scale + ", " + this.settings.scale + ", " + this.settings.scale + ")";

                    if (this.glare) {
                        this.glareElement.style.transform = `rotate(${values.angle}deg) translate(-50%, -50%)`;
                        this.glareElement.style.opacity = `${values.percentageY * this.settings["max-glare"] / 100}`;
                    }

                    this.element.dispatchEvent(new CustomEvent("tiltChange", {
                        "detail": values
                    }));

                    this.updateCall = null;
                }


                prepareGlare() {

                    if (!this.glarePrerender) {

                        const jsTiltGlare = document.createElement("div");
                        jsTiltGlare.classList.add("js-tilt-glare");

                        const jsTiltGlareInner = document.createElement("div");
                        jsTiltGlareInner.classList.add("js-tilt-glare-inner");

                        jsTiltGlare.appendChild(jsTiltGlareInner);
                        this.element.appendChild(jsTiltGlare);
                    }

                    this.glareElementWrapper = this.element.querySelector(".js-tilt-glare");
                    this.glareElement = this.element.querySelector(".js-tilt-glare-inner");

                    if (this.glarePrerender) {
                        return;
                    }

                    Object.assign(this.glareElementWrapper.style, {
                        "position": "absolute",
                        "top": "0",
                        "left": "0",
                        "width": "100%",
                        "height": "100%",
                        "overflow": "hidden",
                        "pointer-events": "none"
                    });

                    Object.assign(this.glareElement.style, {
                        "position": "absolute",
                        "top": "50%",
                        "left": "50%",
                        "pointer-events": "none",
                        "background-image": `linear-gradient(0deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%)`,
                        "transform": "rotate(180deg) translate(-50%, -50%)",
                        "transform-origin": "0% 0%",
                        "opacity": "0",
                    });

                    this.updateGlareSize();
                }

                updateGlareSize() {
                    if (this.glare) {
                        const glareSize = (this.element.offsetWidth > this.element.offsetHeight ? this.element.offsetWidth : this.element.offsetHeight) * 2;

                        Object.assign(this.glareElement.style, {
                            "width": `${glareSize}px`,
                            "height": `${glareSize}px`,
                        });
                    }
                }

                updateClientSize() {
                    this.clientWidth = window.innerWidth ||
                        document.documentElement.clientWidth ||
                        document.body.clientWidth;

                    this.clientHeight = window.innerHeight ||
                        document.documentElement.clientHeight ||
                        document.body.clientHeight;
                }

                onWindowResize() {
                    this.updateGlareSize();
                    this.updateClientSize();
                }

                setTransition() {
                    clearTimeout(this.transitionTimeout);
                    this.element.style.transition = this.settings.speed + "ms " + this.settings.easing;
                    if (this.glare) this.glareElement.style.transition = `opacity ${this.settings.speed}ms ${this.settings.easing}`;

                    this.transitionTimeout = setTimeout(() => {
                        this.element.style.transition = "";
                        if (this.glare) {
                            this.glareElement.style.transition = "";
                        }
                    }, this.settings.speed);

                }


                extendSettings(settings) {
                    let defaultSettings = {
                        reverse: false,
                        max: 15,
                        startX: 0,
                        startY: 0,
                        perspective: 1000,
                        easing: "cubic-bezier(.03,.98,.52,.99)",
                        scale: 1,
                        speed: 300,
                        transition: true,
                        axis: null,
                        glare: false,
                        "max-glare": 1,
                        "glare-prerender": false,
                        "full-page-listening": false,
                        "mouse-event-element": null,
                        reset: true,
                        gyroscope: true,
                        gyroscopeMinAngleX: -45,
                        gyroscopeMaxAngleX: 45,
                        gyroscopeMinAngleY: -45,
                        gyroscopeMaxAngleY: 45,
                        gyroscopeSamples: 10
                    };

                    let newSettings = {};
                    for (var property in defaultSettings) {
                        if (property in settings) {
                            newSettings[property] = settings[property];
                        } else if (this.element.hasAttribute("data-tilt-" + property)) {
                            let attribute = this.element.getAttribute("data-tilt-" + property);
                            try {
                                newSettings[property] = JSON.parse(attribute);
                            } catch (e) {
                                newSettings[property] = attribute;
                            }

                        } else {
                            newSettings[property] = defaultSettings[property];
                        }
                    }

                    return newSettings;
                }

                static init(elements, settings) {
                    if (elements instanceof Node) {
                        elements = [elements];
                    }

                    if (elements instanceof NodeList) {
                        elements = [].slice.call(elements);
                    }

                    if (!(elements instanceof Array)) {
                        return;
                    }

                    elements.forEach((element) => {
                        if (!("vanillaTilt" in element)) {
                            element.vanillaTilt = new VanillaTilt(element, settings);
                        }
                    });
                }
            }

            if (typeof document !== "undefined") {
                /* expose the class to window */
                window.VanillaTilt = VanillaTilt;


                VanillaTilt.init(document.querySelectorAll("[data-tilt]"));
            }

            return VanillaTilt;

        }());
    </script>
    @endsection