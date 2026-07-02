@extends('layouts.app')
@section('title', $page->title)
@section('description', $page->description)
@section('content')
<div class="container mx-auto w-full col-span-12 flex-col">
   <div class="w-full border-steel-200 border rounded-2xl py-8 px-8 article text-white">
      {!! $page->content !!}
   </div>
</div>
@endsection
