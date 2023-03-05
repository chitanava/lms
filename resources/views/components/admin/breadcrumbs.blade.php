@props([
  'data' => []
])

<ul class="gap-4 items-center text-sm lg:flex">
  @foreach ($data as $item)
  <x-admin.breadcrumbs-item :title="$item['title']" :href="$item['url']" :is-last="$loop->last"/>

  @unless ($loop->last)
  <li class="h-6 border-r border-slate-300 -skew-x-12"></li>
  @endunless

  @endforeach
</ul>