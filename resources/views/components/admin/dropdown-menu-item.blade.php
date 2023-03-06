@props([
'title' => null,
'icon' => null
])

<li>
  <a 
    class="hover:bg-slate-100 rounded-lg py-2 px-4 text-sm flex items-center"
    {{ $attributes->merge(['href' => '#']) }}
  >
    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
      stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="{{ $icon }}" />
    </svg>
    
    <span>{{ $title }}</span>
  </a>
</li>