@extends('layouts.app')
@section('title', $ticket->subject)
@include('elements.markdown-editor', [
'imagesUploadUrl' => route('support.comments.attachments.pending', $pendingId),
'autosaveId' => 'support_ticket_'.$ticket->id,
])
@section('content')
<div>
   <div class="border rounded-2xl border-steel-200 p-8 container mx-auto w-full">
      <div class="text-center my-12">
         <h1 class="text-2xl font-bold text-white sm:text-4xl">
            Ticket #{{ $ticket->id }} - {{ $ticket->subject }}
         </h1>
         <p class="mt-3 text-steel-100">
         <p class="text-steel-50 text-sm">@lang('support::messages.tickets.info', ['author' => e($ticket->author->name), 'category' => e($ticket->category->name), 'date' => format_date($ticket->created_at)])</p>
         </p>
      </div>
      <ul class="space-y-5">
      @foreach($ticket->comments as $comment)
        @if ($comment->author->name == Auth::user()->name)
        <!--- GUAUCHE --->

        <li class="flex gap-x-4">
            <div class="relative bg-steel-400 border border-steel-200 h-10 w-10 rounded-full flex justify-center items-center overflow-hidden shadow flex-shrink-0">
               <img class="mx-auto flex w-7 mt-2 shadow-xl object-contain" src="https://minotar.net/bust/{{ $comment->author->name }}/100.png" alt="avatar">
            </div>
            <div>
               <div class="py-2 hs-tooltip inline-block [--prevent-popper:*] [--trigger:hover] [--placement:bottom]">
                  <div class="hs-tooltip-toggle block text-left cursor-pointer">
                     <p class="font-semibold text-white">
                     {{ $comment->author->name }}
                     </p>
                     <p class="text-xs font-semibold text-steel-100 my-auto">
                        {{ format_date($comment->created_at, true) }}
                     </p>
                     <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-steel-200 shadow-lg rounded-xl" role="tooltip" style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(645px, 398px);" data-popper-placement="bottom">
                        <div class="p-4 sm:p-5">
                           <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                              <div class="flex-shrink-0">
                                 <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}">
                                 <div class="flex items-center justify-center w-6 h-6 rounded-full bg-steel-300">
                                    <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                       <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                       </circle>
                                       <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                       </path>
                                    </svg>
                                 </div>
                              </div>
                              <div class="grow flex">
                                 <p class="text-sm font-semibold text-white my-auto">
                                 {{ $comment->author->name }}
                                 </p>
                                 <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold" style="color: #fff; background: #e10d11;;">
                                 {{ $comment->author->role->name }}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="bg-steel-400 border border-steel-200 rounded-xl p-4 space-y-3 article text-white break-all">
               {{ $comment->parseContent() }}
               </div>
            </div>
         </li>

        @else
        <!--- DROITE --->

        <li class="max-w-2xl ms-auto flex justify-end gap-x-4">
            <div class="grow text-end space-y-3">
               <div class="inline-flex flex-col">
                  <div class="flex justify-end items-end py-2 hs-tooltip [--prevent-popper:*] [--trigger:hover] [--placement:bottom]">
                     <div class="hs-tooltip-toggle block text-left cursor-pointer">
                        <p class="font-semibold text-white flex justify-end items-end ">
                        {{ $comment->author->name }}
                        </p>
                        <p class="text-xs font-semibold text-steel-100 my-auto flex justify-end items-end ">
                            {{ format_date($comment->created_at, true) }}
                        </p>
                        <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-steel-200 shadow-lg rounded-xl hidden" role="tooltip" style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(217px, 298px);" data-popper-placement="bottom">
                           <div class="p-4 sm:p-5">
                              <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                                 <div class="flex-shrink-0">
                                    <img class="absolute z-50 h-6 mx-auto text-transparent rounded-full shadow-xl" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}">
                                    <div class="flex items-center justify-center w-6 h-6 rounded-full bg-steel-300">
                                       <svg class="animate-spin h-3.5 w-3.5 text-white mx-auto flex" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                          </circle>
                                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                          </path>
                                       </svg>
                                    </div>
                                 </div>
                                 <div class="grow flex">
                                    <p class="text-sm font-semibold text-white my-auto">
                                    {{ $comment->author->name }}
                                    </p>
                                    <div class="bg-steel-100 px-1.5 py-0.5 my-auto ml-1.5 text-xs text-white rounded font-semibold" style="color: #fff; background: #e10d11;;">
                                    {{ $comment->author->role->name }}
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="inline-block bg-steel-400 border border-steel-200 rounded-xl p-4 shadow-sm article text-white break-all">
                  {{ $comment->parseContent() }}
                  </div>
               </div>
            </div>
            <div class="relative bg-steel-400 border border-steel-200 h-10 w-10 rounded-full flex justify-center items-center overflow-hidden shadow flex-shrink-0">
               <img class="mx-auto flex w-7 mt-2 shadow-xl object-contain" src="https://minotar.net/bust/{{ $comment->author->name }}/100.png" alt="avatar">
            </div>
         </li>

        @endif
        @endforeach
         
         
      </ul>
      @if($ticket->isClosed())
      @if($canReopen)
      @else
      <div class="py-5 px-6 border-steel-200 border justify-cenetr items-center flex gap-x-3 mt-8 text-white rounded-2xl text-sm">
         <svg class="h-6 w-6 fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.84308 3.80211C9.8718 2.6007 10.8862 2 12 2C13.1138 2 14.1282 2.6007 16.1569 3.80211L16.8431 4.20846C18.8718 5.40987 19.8862 6.01057 20.4431 7C21 7.98943 21 9.19084 21 11.5937V12.4063C21 14.8092 21 16.0106 20.4431 17C19.8862 17.9894 18.8718 18.5901 16.8431 19.7915L16.1569 20.1979C14.1282 21.3993 13.1138 22 12 22C10.8862 22 9.8718 21.3993 7.84308 20.1979L7.15692 19.7915C5.1282 18.5901 4.11384 17.9894 3.55692 17C3 16.0106 3 14.8092 3 12.4063V11.5937C3 9.19084 3 7.98943 3.55692 7C4.11384 6.01057 5.1282 5.40987 7.15692 4.20846L7.84308 3.80211ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM12 6.25C12.4142 6.25 12.75 6.58579 12.75 7V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V7C11.25 6.58579 11.5858 6.25 12 6.25Z"/>
         </svg>
         {{ trans('support::messages.tickets.closed') }}
      </div>
      @if($canReopen)
      <form action="{{ route('support.tickets.open', $ticket) }}" method="POST">
         @csrf
         <button type="submit" class="btn btn-primary">
         <i class="bi bi-arrow-repeat"></i> {{ trans('support::messages.actions.reopen') }}
         </button>
      </form>
      @endif
      @endif
      @else
      <form action="{{ route('support.tickets.comments.store', $ticket) }}" method="POST" class="mt-8 mb-2 text-white">
         @csrf
         <input type="hidden" name="pending_id" value="{{ $pendingId }}">
         <div>
            <label class="text-white text-md" for="content">{{ trans('support::messages.fields.comment') }}</label>
            <div class="border border-steel-200 rounded-xl mt-2">
               <textarea class="markdown-editor @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content') }}</textarea>
            </div>
         </div>
         @error('content')
         <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
         @enderror
         <button type="submit" class="mt-8 w-full py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent font-medium bg-steel-400 hover:bg-steel-200 text-sm text-white transition duration-200">{{ trans('messages.actions.comment') }}</button>
      </form>
      <form action="{{ route('support.tickets.close', $ticket) }}" method="POST">
         @csrf
         <button type="submit" class="mt-3 w-full py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent font-medium bg-danger hover:bg-danger/90 text-sm text-white transition duration-200">{{ trans('support::messages.actions.close') }}</button>
      </form>
      @endif
      @if ($ticket->isClosed())
      @if($canReopen)
      <form action="{{ route('support.tickets.open', $ticket) }}" method="POST">
         @csrf
         <button type="submit" class="mt-8 w-full py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent font-medium bg-steel-400 hover:bg-steel-200 text-sm text-white transition duration-200">
         {{ trans('support::messages.actions.reopen') }}
         </button>
      </form>
      @endif
      @endif
   </div>
</div>
@endsection
