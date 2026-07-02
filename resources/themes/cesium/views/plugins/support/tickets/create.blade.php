@extends('layouts.app')

@section('title', trans('support::messages.tickets.open'))

@include('elements.markdown-editor', [
    'imagesUploadUrl' => route('support.comments.attachments.pending', $pendingId),
    'autosaveId' => 'support_ticket',
])

@section('content')




    <div class="flex border rounded-2xl border-steel-200 p-8 container mx-auto w-full">
   <div class="overflow-x-auto w-full">
      <h1 class="text-white text-xl font-semibold">{{ trans('support::messages.tickets.open') }}</h1>


      <form action="{{ route('support.tickets.store') }}" method="POST">
                @csrf

                <input type="hidden" name="pending_id" value="{{ $pendingId }}">




                
                <div class="mt-8 flex flex-col w-full">
                  <label for="subjectInput" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <input id="subjectInput" placeholder="{{ trans('support::messages.fields.subject') }}" name="subject" value="{{ old('subject', $category->subject ?? '') }}" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis" required>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('support::messages.fields.subject') }}</span>
                  </label>
                  @error('subject')
                    <span class="text-danger text-sm" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mt-8 flex flex-col w-full">
                  <label for="categorySelect" class="flex relative w-full h-14 py-4 border border-steel-200 hover:border-white rounded-xl">
                     <select id="categorySelect" name="category_id" class="px-5 h-full block w-full outline-none bg-transparent text-white placeholder-steel-100 font-medium focus:ring-0 focus:outline-none border-0 focus:border-0 truncate whitespace-nowrap overflow-ellipsis">
                        @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') === $category->id)>{{ $category->name }}</option>
                            @endforeach
                    </select>
                     <span class="absolute bottom-full left-0 ml-3 -mb-1 transform translate-y-0.5 text-xs font-semibold text-white px-1.5 bg-steel-300">{{ trans('support::messages.fields.category') }}</span>
                  </label>
                  @error('category_id')
                        <span class="text-danger text-sm" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                </div>

                <div class="mt-8 mb-2 text-white">
                    <label class="text-white text-md" for="contentInput">{{ trans('messages.fields.content') }}</label>
                    <div class="border border-steel-200 rounded-xl mt-2">
                        <textarea placeholder="Ecrivez votre message ici" class="form-control markdown-editor @error('content') is-invalid @enderror" id="contentInput" name="content" rows="5">{{ old('content', $category->content ?? '') }}</textarea>
                    </div>

                    
                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="mt-8 w-full py-4 px-4 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent font-medium bg-steel-400 hover:bg-steel-200 text-sm text-white transition duration-200">{{ trans('messages.actions.send') }}</button>
            </form>

   </div>
</div>
















@endsection
