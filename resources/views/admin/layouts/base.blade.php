<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;1,400;1,600&display=swap"
    rel="stylesheet">
  @vite('resources/css/app.css')
  <style>
    [x-cloak] { display: none; }
  </style>
</head>

<body class="text-slate-900 bg-slate-100 font-poppins" x-data="{
    width: window.innerWidth,
    breakpoint: 1024,
    open: null, 
    toggle(){
      this.open = !this.open
    },
    init(){
      this.open = this.width > this.breakpoint
    },
  }" x-on:resize.window.debounce.300="open = window.innerWidth > breakpoint">

  @include('admin.includes.sidebar')

  <main 
    :class="{ 'pl-[var(--nav-size)]':open }" 
    class="transition-all flex flex-col gap-6"
    x-cloak>
    
    @include('admin.includes.header')

    <div class="w-full max-w-7xl mx-auto px-8 gap-6 flex flex-col h-[900px]">
      @yield('content')
    </div>
  </main>

  @vite('resources/js/app.js')
</body>

</html>