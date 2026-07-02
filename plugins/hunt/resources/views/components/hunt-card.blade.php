<div class="col-md-3">
    <a href="{{ route('hunt.show', $hunt) }}">
        <div class="card">
            <div class="card-body text-center">
                @if($hunt->hasImage())
                    <img src="{{ $hunt->imageUrl() }}" alt="{{ $hunt->name }}" class="mb-3" style="width: 64px; height: 64px; object-fit: cover;">
                @else
                    <i class="bi bi-gift fs-1 mb-3 text-primary"></i>
                @endif

                <h2>{{ $hunt->name }}</h2>

                <div>
                    @include('hunt::components.hunt-status')
                </div>
            </div>
        </div>
    </a>
</div>
