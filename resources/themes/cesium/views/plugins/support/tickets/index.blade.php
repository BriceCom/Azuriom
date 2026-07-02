@extends('layouts.app')
@section('title', trans('support::messages.title'))
@section('content')
<div class="flex border rounded-2xl border-steel-200 p-8 container mx-auto w-full">
   <div class="overflow-x-auto w-full">
      <h1 class="text-white text-xl font-semibold">{{ trans('support::messages.title') }}</h1>
      @if($infoText !== null)
      <div class="article text-white mt-6">
         {{ $infoText }}
      </div>
      @endif
      <div class="min-w-full inline-block align-middle">
         <div class="mt-8 border border-steel-100 rounded-xl shadow-sm overflow-hidden ">
            <div class="flex justify-between">
               <div class="px-6 py-4 flex gap-4">
                  <svg class="flex-shrink-0 my-auto h-8 w-8 fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M17.8144 21.2359L17.5433 21.6938C17.3017 22.102 16.6982 22.102 16.4567 21.6938L16.1856 21.2359C15.9754 20.8807 15.8702 20.7031 15.7014 20.6049C15.5325 20.5067 15.32 20.503 14.8948 20.4957C14.2671 20.4849 13.8734 20.4464 13.5433 20.3097C12.9307 20.0559 12.444 19.5693 12.1903 18.9567C12 18.4973 12 17.9148 12 16.75V16.25C12 14.6132 12 13.7949 12.3684 13.1937C12.5745 12.8573 12.8574 12.5745 13.1938 12.3683C13.7949 11.9999 14.6133 11.9999 16.25 11.9999H17.75C19.3867 11.9999 20.2051 11.9999 20.8062 12.3683C21.1426 12.5745 21.4255 12.8573 21.6316 13.1937C22 13.7949 22 14.6132 22 16.25V16.75C22 17.9148 22 18.4973 21.8097 18.9567C21.556 19.5693 21.0693 20.0559 20.4567 20.3097C20.1266 20.4464 19.7329 20.4849 19.1052 20.4957C18.68 20.503 18.4674 20.5067 18.2986 20.6049C18.1297 20.7031 18.0246 20.8807 17.8144 21.2359Z"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2007 2.27731C10.5998 2.38817 10.8335 2.80158 10.7226 3.20068L9.32006 8.24995H16.7633L18.2774 2.79921C18.3882 2.40011 18.8016 2.16645 19.2007 2.27731C19.5998 2.38817 19.8335 2.80158 19.7226 3.20068L18.3201 8.24995H22C22.4142 8.24995 22.75 8.58573 22.75 8.99995C22.75 9.41416 22.4142 9.74995 22 9.74995H17.9016C17.7716 10.1188 17.3761 10.3288 16.9937 10.2226C16.7488 10.1546 16.5662 9.97261 16.4873 9.74995H8.9034L7.37562 15.2499H9C9.41421 15.2499 9.75 15.5857 9.75 15.9999C9.75 16.4142 9.41421 16.7499 9 16.7499H6.95895L5.72264 21.2007C5.61178 21.5998 5.19837 21.8334 4.79927 21.7226C4.40016 21.6117 4.1665 21.1983 4.27736 20.7992L5.40216 16.7499H2C1.58579 16.7499 1.25 16.4142 1.25 15.9999C1.25 15.5857 1.58579 15.2499 2 15.2499H5.81882L7.3466 9.74995H4C3.58579 9.74995 3.25 9.41416 3.25 8.99995C3.25 8.58573 3.58579 8.24995 4 8.24995H7.76327L9.27736 2.79921C9.38822 2.40011 9.80163 2.16645 10.2007 2.27731Z"/>
                  </svg>
                  <h2 class="my-auto text-xl font-semibold text-white md:w-full w-64 truncate">
                     Demandes support
                  </h2>
               </div>
               <div class="flex py-4 px-6">
                  <a href="{{ route('support.tickets.create') }}" class="py-2 px-3 items-center gap-x-2 text-sm font-medium rounded-lg border border-steel-100 bg-steel-400 text-white shadow-sm truncate flex">
                     <svg class="h-5 w-5 fill-white my-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z"/>
                        <path d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.17157 3.17157C3 4.34315 3 6.22876 3 10V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284C20.9812 19.6756 20.9997 17.8316 21 14.1801L18.1817 16.9984C17.9119 17.2683 17.691 17.4894 17.4415 17.6841C17.1491 17.9121 16.8328 18.1076 16.4981 18.2671C16.2124 18.4032 15.9159 18.502 15.5538 18.6225L13.2421 19.3931C12.4935 19.6426 11.6682 19.4478 11.1102 18.8898C10.5523 18.3318 10.3574 17.5065 10.607 16.7579L10.8805 15.9375L11.3556 14.5121L11.3775 14.4463C11.4981 14.0842 11.5968 13.7876 11.7329 13.5019C11.8924 13.1672 12.0879 12.8509 12.316 12.5586C12.5106 12.309 12.7317 12.0881 13.0017 11.8183L17.0081 7.81188L18.12 6.70004L18.2472 6.57282C18.9626 5.85741 19.9003 5.49981 20.838 5.5C20.6867 4.46945 20.3941 3.73727 19.8284 3.17157C18.6569 2 16.7712 2 13 2H11C7.22876 2 5.34315 2 4.17157 3.17157ZM7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H10.5C10.9142 12.25 11.25 12.5858 11.25 13C11.25 13.4142 10.9142 13.75 10.5 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z"/>
                     </svg>
                     {{ trans('support::messages.actions.create') }}
                  </a>
               </div>
            </div>
            <table class="min-w-full divide-y divide-steel-100">
               <thead class="bg-steel-400">
                  <tr>
                     <th scope="col" class="px-6 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                           <span class="text-xs font-semibold uppercase tracking-wide text-white">
                           {{ trans('support::messages.fields.subject') }}
                           </span>
                        </div>
                     </th>
                     <th scope="col" class="px-6 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                           <span class="text-xs font-semibold uppercase tracking-wide text-white">
                           {{ trans('support::messages.fields.category') }}
                           </span>
                        </div>
                     </th>
                     <th scope="col" class="px-6 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                           <span class="text-xs font-semibold uppercase tracking-wide text-white">
                           {{ trans('messages.fields.status') }}
                           </span>
                        </div>
                     </th>
                     <th scope="col" class="px-6 py-3 text-start">
                        <div class="flex items-center gap-x-2">
                           <span class="text-xs font-semibold uppercase tracking-wide text-white">
                           {{ trans('messages.fields.date') }}
                           </span>
                        </div>
                     </th>
                  </tr>
               </thead>
               <tbody class="divide-y divide-steel-100">
                  @foreach($tickets as $ticket)
                  <tr class="hover:bg-steel-400">
                     <td class="h-px w-px whitespace-nowrap">
                        <a class="w-full" href="{{ route('support.tickets.show', $ticket) }}">
                           <div class="px-6 py-3">
                              <div class="flex items-center gap-x-3">
                                 <div class="grow">
                                    <span class="block text-sm font-semibold text-white">{{ $ticket->subject }}</span>
                                 </div>
                              </div>
                           </div>
                        </a>
                     </td>
                     <td class="h-px w-px whitespace-nowrap">
                        <a class="w-full" href="{{ route('support.tickets.show', $ticket) }}">
                           <div class="px-6 py-3">
                              <span class="text-sm text-white">{{ $ticket->category->name }}</span>
                           </div>
                        </a>
                     </td>
                     <td class="h-px w-px whitespace-nowrap">
                        <a class="w-full" href="{{ route('support.tickets.show', $ticket) }}">
                           <div class="px-6 py-3">
                              <span class="text-sm text-white">{{ $ticket->statusMessage() }}</span>
                           </div>
                        </a>
                     </td>
                     <td class="h-px w-px whitespace-nowrap">
                        <a class="w-full" href="{{ route('support.tickets.show', $ticket) }}">
                           <div class="px-6 py-3">
                              <span class="text-sm text-white">{{ format_date_compact($ticket->created_at) }}</span>
                           </div>
                        </a>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
