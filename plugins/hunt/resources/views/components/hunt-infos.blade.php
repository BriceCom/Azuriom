
@guest()
    <div class="mt-4">
        <div class="alert alert-info d-flex flex-wrap align-items-center justify-content-between" role="alert">
            <span><i class="bi bi-info-circle"></i> {{ trans('hunt::messages.login_description') }}</span>

            <a href="{{ route('login') }}" class="btn btn-primary ms-auto">
                <i class="bi bi-box-arrow-in-right"></i> {{ trans('hunt::messages.login') }}
            </a>
        </div>
    </div>
@endguest

<div class="card mb-4">
    <div class="card-body">
       <div class="d-flex flex-column flex-md-row gap-2">
           @if($hunt->hasImage())
               <img src="{{ $hunt->imageUrl() }}"
                    alt="{{ $hunt->name }}"
                    class="rounded"
                    style="width: 80px; height: 80px; object-fit: cover;">
           @endif

           <div class="d-flex flex-column">
               <div class="mb-1">
                   @include('hunt::components.hunt-status')
               </div>

               @if($hunt->description)
                   <p class="card-text">{{ $hunt->description }}</p>
               @endif

           </div>
       </div>

        @if($hunt->global_cap > 0)
            <div class="mt-3">
                <p> {{ trans('hunt::messages.global_progress', [
                        'current' => $stats['total_claims'] ?? 0,
                        'total' => $hunt->global_cap
                    ]) }}</p>
                <div class="progress" style="height: 20px;">
                    @php
                        $percentage = min(100, (($stats['total_claims'] ?? 0) / $hunt->global_cap) * 100);
                    @endphp
                    <div class="progress-bar"
                         role="progressbar"
                         style="width: {{ $percentage }}%"
                         aria-valuenow="{{ $stats['total_claims'] ?? 0 }}"
                         aria-valuemin="0"
                         aria-valuemax="{{ $hunt->global_cap }}">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
                <small class="text-muted">
                    @if($hunt->hasReachedGlobalCap())
                        - <strong class="text-danger">{{ trans('hunt::messages.cap_reached') }}</strong>
                    @endif
                </small>
            </div>
        @endif
    </div>
</div>
