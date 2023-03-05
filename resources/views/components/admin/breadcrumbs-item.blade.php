@props([
  'title' => null,
  'isLast' => false
])

<li>
  <a {{ $attributes->class(['text-slate-400' => $isLast])->merge(['href' => '#']) }}>
    {{ $title }}
  </a>
</li>