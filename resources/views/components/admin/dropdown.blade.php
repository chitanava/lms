@props([
  'data' => [],
])

<div 
  x-transition x-on:click.outside="open = false" x-show="open"
  {{ $attributes->merge(['class' => 'absolute top-full right-0 mt-1 bg-white rounded-lg border-slate-200 border shadow-md']) }}
  x-cloak>
  {{ $slot }}

  <ul class="p-1">
    @foreach ($data as $item)
    <x-admin.dropdown-menu-item 
      :title="$item['title']"
      :icon="$item['icon']" 
      :href="$item['url']"
      />
    @endforeach
  </ul>
</div>