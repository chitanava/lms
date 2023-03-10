<header class="h-[var(--header-height)] flex gap-8 items-center px-8 border-b border-b-slate-200 backdrop-blur-sm bg-white/80 shadow-sm sticky top-0">
  <button x-on:click="toggle()" class="w-10 h-10 rounded-full flex justify-center items-center hover:bg-slate-100">
    <svg x-show="open" x-cloak class="w-8 h-8 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
    </svg>
    <svg x-show="!open" x-cloak class="w-8 h-8 text-slate-900" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
    </svg>
  </button>

  @yield('breadcrumbs')

  <div class="flex-1 flex justify-end">
    <x-admin.dropdown 
      class="min-w-[250px]" 
      :data="[
        ['title' => 'Profile', 'url' => '#', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
        ['title' => 'Log out', 'url' => '#', 'icon' => 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75'],
      ]">
      
      <x-slot:button class="w-10 h-10 rounded-full text-white bg-slate-900 flex justify-center items-center">
        <span class="font-semibold">NC</span>
      </x-slot:button>
      
      <x-slot:header>
        <p class="font-semibold">Nika Chitanava</p>
        <p class="text-xs text-slate-400">chitanava@gmail.com</p>
      </x-slot:header>
    </x-admin.dropdown>
  </div>
</header>