@extends('layouts.app')

@section('title', trans('spin-wheel::admin.plugin.name'))

@section('content')

@if(setting('spin.freeSpin') && $freeSpin !== 'false')
    @if($freeSpin == 'true')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @lang('spin-wheel::messages.freeSpin.available')
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif( $freeSpin !== false)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ trans('spin-wheel::messages.freeSpin.notAvailable') }} <strong>{{ $freeSpin }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endif

@if(Auth::user() && !Auth::user()->hasPermission('spin-wheel.user'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ trans('spin-wheel::admin.permission.denied') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="row" onresize="resizeCanvas()">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h4>{{ trans('spin-wheel::admin.plugin.name') }}</h4>
                @auth
                <h6>{{ trans('spin-wheel::admin.infos.sold') }} {{ Auth::user()->money }} {{ money_name() }}</h6>
                @endauth
            </div>
            <div class="card-body">
                @if(count($rewards) == 0)
                <div class="d-flex">
                    <span class="mx-auto">{{ trans('spin-wheel::messages.tables.rewards.row.empty') }}</span>
                </div>
                @else
                    <div class="d-flex justify-content-center">
                        <div style="position: relative; width: 434px; height: 500px;">
                            <canvas id="canvasWheel" width="434" height="500" style="position: absolute; top: 0; left: 0; z-index: 1;"></canvas>

                            <canvas id="canvasConfetti" width="434" height="500" style="position: absolute; top: 0; left: 0; z-index: 2; pointer-events: none;"></canvas>
                        </div>
                    </div>
                <div class="text-center">
                    @auth
                        @if(Auth::user()->hasPermission('spin-wheel.user'))
                        <button id="spin" class='btn btn-primary' onClick="check();">{{ trans('spin-wheel::messages.wheel.spin') }}</button>
                        @endif
                    @else
                    <a href="{{ route('login') }}" class='btn btn-primary'>{{ trans('spin-wheel::messages.wheel.guest') }}</a>
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ trans('spin-wheel::messages.tables.rewards.title') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ trans('spin-wheel::messages.tables.rewards.cols.reward') }}</th>
                            @if(displayPercentage())
                            <th scope="col">{{ trans('spin-wheel::messages.tables.rewards.cols.chances') }}</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @if(count($rewards) == 0)
                        <tr class="text-center">
                            <td colspan="2">{{ trans('spin-wheel::messages.tables.rewards.row.empty') }}</td>
                        </tr>
                        @else
                        @foreach($rewards as $reward)
                        <tr>
                            <th scope="row">{{ $reward->name }}</th>
                            @if(displayPercentage())
                            <td>{{ $reward->chances }} %</td>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if((int) setting("spin.homeWins") !== 0)
        <div class="card">
            <div class="card-header">
                <h4>{{ trans('spin-wheel::messages.tables.players.title') }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('spin-wheel::messages.tables.players.cols.player') }}</th>
                            <th scope="col">{{ trans('spin-wheel::messages.tables.players.cols.reward') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($laps) == 0)
                        <tr class="text-center">
                            <td colspan="3">{{ trans('spin-wheel::messages.tables.players.row.empty') }}</td>
                        </tr>
                        @else
                        @foreach($laps as $lap)
                        <tr>
                            <th scope="row">{{ $lap->id }}</th>
                            <td>{{ $lap->name }}</td>
                            <td>{{ $lap->reward_name }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Spin Confirmation -->
<div class="modal fade" id="spinConfirmModal" tabindex="-1" aria-labelledby="spinConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="spinConfirmModalLabel">{{ trans('spin-wheel::messages.wheel.modal.validation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="spinPriceText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('spin-wheel::messages.wheel.modal.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="confirmSpinBtn">{{ trans('spin-wheel::messages.wheel.modal.spin') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Prize -->
<div class="modal fade" id="prizeModal" tabindex="-1" aria-labelledby="prizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prizeModalLabel">{{ trans('spin-wheel::messages.wheel.prize.title') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="prizeText" class="fs-4"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">{{ trans('spin-wheel::messages.wheel.prize.button') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ plugin_asset('spin-wheel', 'css/style.css') }}">
@endpush

@push("scripts")
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script src="{{ plugin_asset('spin-wheel', 'js/Winwheel.js') }}"></script>
<script src="{{ plugin_asset('spin-wheel', 'js/script.js') }}"></script>
@endpush

@push('footer-scripts')

@if(setting('spin.freeSpin') && $freeSpin == "true")
    <script>let spinPrice = "{{ trans('spin-wheel::messages.wheel.modal.freePlay') }}";</script>
@else
    <script>let spinPrice = "{{ trans('spin-wheel::messages.wheel.modal.price') . ' ' . setting('spin.price', 0) . ' ' . money_name()}}";</script>
@endif

<script>
    let rawardsApi = "{{ route('spin-wheel.rewards') }}";
    let play = "{{ route('spin-wheel.play') }}";

    let TextTitle = "{{ trans('spin-wheel::messages.wheel.modal.validation') }}";
    let TextConfirm = "{{ trans('spin-wheel::messages.wheel.modal.spin') }}"
    let TextCancel = "{{ trans('spin-wheel::messages.wheel.modal.cancel') }}";

    let theWheel;
    let wheelSpinning;
    let tcanvas = document.getElementById('canvasWheel');
    let tx = tcanvas.getContext('2d');
    let xhr = new XMLHttpRequest();

    let confettiCanvas = document.getElementById('canvasConfetti');
    let myConfetti = confetti.create(confettiCanvas, {
        resize: true,
        useWorker: true
    });


    function drawTriangle() {
        tx.strokeStyle = '#fff';
        tx.fillStyle = '#4ed4c6';
        tx.lineWidth = 2;
        tx.beginPath();
        tx.moveTo(200, 2);
        tx.lineTo(234, 2);
        tx.lineTo(217, 30);
        tx.lineTo(201, 2);
        tx.stroke();
        tx.fill();
    }

    if (tx) {
        drawTriangle();
    }

    xhr.open('GET', rawardsApi);
    xhr.send();

    xhr.onload = function() {
        if (xhr.status != 200) {
            alert(`Error ${xhr.status}: ${xhr.statusText} Ask help here : https://discord.com/invite/Gh2yBxUWvV`);
        } else {
            let data = JSON.parse(xhr.response);
            console.log(data)
            theWheel = new Winwheel({
                'numSegments': data.length,
                'outerRadius': 212,
                'textFontSize': 28,
                'segments': data,
                'animation': {
                    'type': 'spinToStop',
                    'duration': 5,
                    'spins': 8,
                    'callbackFinished': alertPrize,
                    'callbackAfter': 'drawTriangle()'
                }
            });

            drawTriangle();
            wheelSpinning = false;
        }
    };


    function testConfetti() {
        myConfetti({
            particleCount: 50,
            spread: 360,
            gravity: 0.8,
            decay: 0.94,
            startVelocity: 30,
            shapes: ['star'],
            origin: { x: 0.5, y: 0.5 },
            colors: ['#FFE400', '#FFBD00', '#E89611', '#E89611', '#FFCA28']
        });
    }

    function alertPrize(indicatedSegment) {

        myConfetti({
            particleCount: 150,
            spread: 70,
            origin: { x: 0.5, y: 0.5 },
            colors: ['#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#f0932b', '#eb4d4b', '#6c5ce7']
        });

        setTimeout(() => {
            myConfetti({
                particleCount: 100,
                ticks: 500,
                angle: 60,
                spread: 55,
                origin: { x: 0.5, y: 0.5 },
                colors: ['#ff6b6b', '#4ecdc4', '#45b7d1']
            });
        }, 200);

        setTimeout(() => {
            myConfetti({
                particleCount: 100,
                ticks: 500,
                angle: 120,
                spread: 55,
                origin: { x: 0.5, y: 0.5 },
                colors: ['#f9ca24', '#f0932b', '#eb4d4b']
            });
        }, 400);

        setTimeout(() => {
            myConfetti({
                particleCount: 100,
                ticks: 500,
                spread: 360,
                gravity: 0.8,
                decay: 0.94,
                startVelocity: 30,
                shapes: ['star'],
                origin: { x: 0.5, y: 0.5 },
                colors: ['#FFE400', '#FFBD00', '#E89611', '#E89611', '#FFCA28']
            });
        }, 600);

        setTimeout(() => {
            document.getElementById('prizeText').textContent = indicatedSegment.text;
            const prizeModal = new bootstrap.Modal(document.getElementById('prizeModal'));
            prizeModal.show();

            document.getElementById('prizeModal').addEventListener('hidden.bs.modal', function () {
                resetSpin();
                window.location = window.location;
            }, { once: true });
        }, 800);
    }

    function startSpin(prize) {
        if (wheelSpinning == false) {
            let targetStopAngle = theWheel.getRandomForSegment(prize);

            if (Math.random() < 0.8 && prize > 1 && theWheel && theWheel.segments && theWheel.segments.length > 0) {
                let jackpotSegmentIndex = 0;

                let jackpotSegment = theWheel.segments[jackpotSegmentIndex];
                let prizeSegment = theWheel.segments[prize - 1];

                // Check if both segments exist before accessing their properties
                if (jackpotSegment && prizeSegment && jackpotSegment.startAngle !== undefined && prizeSegment.startAngle !== undefined) {
                    let jackpotStartAngle = jackpotSegment.startAngle;
                    let jackpotEndAngle = jackpotSegment.endAngle;

                    let nearMissAngle = jackpotEndAngle + (Math.random() * 10 + 5);

                    let prizeStartAngle = prizeSegment.startAngle;
                    let prizeEndAngle = prizeSegment.endAngle;

                    if (nearMissAngle > prizeEndAngle || nearMissAngle < prizeStartAngle) {
                        targetStopAngle = prizeStartAngle + (prizeEndAngle - prizeStartAngle) * 0.1;
                    } else {
                        targetStopAngle = nearMissAngle;
                    }

                    targetStopAngle += 360 * (Math.floor(Math.random() * 3) + 3);
                }
            }

            theWheel.animation.stopAngle = targetStopAngle;
            document.getElementById('spin').setAttribute('disabled', '');
            theWheel.startAnimation();
            wheelSpinning = true;
        }
    }

    function resetSpin() {
        document.getElementById('spin').removeAttribute('disabled');
        theWheel.stopAnimation(false);
        theWheel.rotationAngle = 0;
        theWheel.draw();
        drawTriangle();
        wheelSpinning = false;
    }
</script>
@endpush
