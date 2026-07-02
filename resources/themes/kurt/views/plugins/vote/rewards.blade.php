@if($displayRewards)
    <div class="card">
        <div class="card-body">
            <h3 class="fs-6">{{ trans('vote::messages.sections.rewards') }}</h3>

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">{{ trans('vote::messages.fields.chances') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($rewards as $reward)
                    <tr>
                        <th scope="row" class="py-2">
                            @if($reward->image)
                                <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" class="object-fit-contain" height="32" width="32">
                            @endif
                            {{ $reward->name }}
                        </th>
                        <td class="py-2">{{ $reward->chances }} %</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endif
