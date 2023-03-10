@extends('admin.layouts.base')

@section('breadcrumbs')
<x-admin.breadcrumbs :data="[
  ['title' => 'Pages', 'url' => route('admin.pages')],
  ['title' => 'Create', 'url' => '#']
]"/>
@endsection

@section('content')
<x-admin.page-header title="Create Page"/>

<div>Lorem ipsum dolor sit amet.</div>
@endsection