<aside 
  :class="{ '-translate-x-[var(--nav-size)]':!open }"
  class="transition-all fixed flex flex-col gap-8 w-[var(--nav-size)] h-screen top-0 left-0 bg-slate-900" 
  x-cloak>

  <div class="h-[var(--header-height)] flex justify-center items-center"></div>
  
  <x-admin.sidebar-menu/>
</aside>