@extends('admin.layouts.base')

@section('breadcrumbs')
<x-admin.breadcrumbs :data="[
  ['title' => 'Pages', 'url' => route('pages')],
  ['title' => 'List', 'url' => '#']
]"/>
@endsection

@section('content')
<x-admin.page.header title="Pages"/>
@endsection