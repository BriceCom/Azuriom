@props([
    'icon' => null,
    'title' => null,
    'resources' => null
])

<button type="button" class="btn btn-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#{{$title}}Modal">{{ $title }}</button>

<div class="modal modal-lg fade" id="{{$title}}Modal" tabindex="-1" aria-labelledby="{{$title}}Modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    @if($icon)
                        <span class="d-inline-grid place-items-center btn-icon bg-primary bg-opacity-10 rounded-2 p-2 text-primary border border-primary border-opacity-10">
                    <i class="{{ $icon }}"></i>
                </span>
                    @endif
                    @if($title)
                        <h3 class="d-inline-block fs-4 m-0">{{ $title }}</h3>
                    @endif
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
               <ul class="list-unstyled vstack gap-2 m-0">
                   @foreach($resources as $resource)
                       <li class="d-flex align-items-center justify-content-between">
                           <div>
                               <b>{{ $resource['name'] }}
                                   @if(isset($resource['purchased']))
                                    <span class="badge bg-success">{{trans('theme::admin.purchased')}}</span>
                                  @endif
                               </b>
                               <small class="d-block">{{ $resource['short_description'] }}</small>
                           </div>

                           <a href="{{ $resource['info_url'] }}" target="_blank" class="btn btn-outline-primary btn-sm">{{trans('theme::admin.more_information')}}</a>
                       </li>
                   @endforeach
               </ul>
           </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
