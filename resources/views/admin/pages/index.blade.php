@extends('admin.layouts.base')

@section('breadcrumbs')
<x-admin.breadcrumbs :data="[
  ['title' => 'Pages', 'url' => route('admin.pages')],
  ['title' => 'List', 'url' => '#']
]"/>
@endsection

@section('content')
<x-admin.page-header title="Pages">
  <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">New page</a>
</x-admin.page-header>

<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, iste.</div>
@endsection