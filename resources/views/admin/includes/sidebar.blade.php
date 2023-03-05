<aside 
  :class="{ '-translate-x-[var(--nav-size)]':!open }"
  class="transition-all fixed w-[var(--nav-size)] h-screen top-0 left-0 border-r border-slate-200 bg-slate-900" 
  x-cloak>
  
  <x-admin.sidebar-menu/>
</aside>