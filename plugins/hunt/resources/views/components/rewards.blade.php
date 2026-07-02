@if($hunt->rewards->isNotEmpty())
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('hunt::messages.rewards') }}
            </h2>

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">{{ trans('hunt::admin.rewards.fields.chance_percentage') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hunt->rewards()->enabled()->get() as $reward)
                    <tr>
                        <th scope="row">
                            @if($reward->hasImage())
                                <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" width="45">
                            @endif
                            {{ $reward->name }}
                        </th>
                        <td>{{ $reward->chances }} %</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
