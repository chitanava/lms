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

  <aside x-cloak :class="{ '-translate-x-[var(--nav-size)]':!open }"
    class="transition-all fixed w-[var(--nav-size)] h-screen top-0 left-0 border-r border-slate-200 bg-slate-900">
    <x-admin.sidebar.nav />
  </aside>

  <main x-cloak :class="{ 'pl-[var(--nav-size)]':open }" class="transition-all">
    <header class="h-[70px] flex items-center px-6 border-b border-slate-200 bg-white shadow-sm">
      <button @click="toggle()" class="w-10 h-10 rounded-full flex justify-center items-center hover:bg-slate-100">
        <svg x-cloak x-show="open" class="w-8 h-8 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
        </svg>
        <svg x-cloak x-show="!open" class="w-8 h-8 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
        </svg>
      </button>

      <div class="flex-1 flex justify-end">
        <div class="flex relative flex-1 justify-end" x-data={open:false}>
          <button @click="open = !open"
            class="w-10 h-10 rounded-full text-white bg-slate-900 flex justify-center items-center">
            <span class="font-semibold">NC</span>
          </button>
          <div x-transition @click.outside="open = false" x-show="open"
            class="min-w-[250px] absolute top-full right-0 mt-1 bg-white rounded-lg border-slate-200 border shadow-md"
            x-cloak>
            <div class="py-3 px-5 border-b border-b-slate-200">
              <p class="font-semibold">Nika Chitanava</p>
              <p class="text-xs text-slate-400">chitanava@gmail.com</p>
            </div>
            <ul class="p-1">
              <li class="mb-0">
                <a href="#" class=" hover:bg-slate-100 rounded-lg py-2 px-4 text-sm flex items-center">
                  <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                  </svg><span>Profile</span>
                </a>
              </li>
              <li>
                <a href="#" class=" hover:bg-slate-100 rounded-lg py-2 px-4 text-sm flex items-center">
                  <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                  </svg><span>Log out</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
  </main>
  @vite('resources/js/app.js')
</body>

</html>