@props([
'title' => null,
'active' => false,
'icon' => null
])

<li>
  <a {{ $attributes->class([
    'py-2 px-4 text-sm flex items-center rounded-lg',
    'text-slate-400 hover:text-slate-50' => !$active,
    'bg-slate-700 text-slate-50' => $active])->merge(['href' => '#']) }}>

    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
      stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="{{ $icon }}" />
    </svg>

    <span>{{ $title }}</span>
  </a>
</li>