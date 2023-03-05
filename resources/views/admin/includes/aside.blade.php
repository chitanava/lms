{{-- <aside x-data :class="{'-translate-x-[var(--nav-size)]' : !$store.aside.isOpen}" x-cloak
  class="transition-all duration-300 ease-in-out fixed w-[var(--nav-size)] h-screen bg-white shadow-2xl left-0 top-[70px] before:content-[''] before:absolute before:w-2/3 before:h-px before:bg-slate-500 before:-top-px before:left-0 before:right-0 before:mx-auto before:bg-gradient-to-r before:from-gray-200 before:via-purple-700 before:to-gray-200"> --}}
{{-- <aside @resize.window.debounce.200="
  console.log('aaa');
  $watch('$store.aside.isOpen', (value, oldValue) => console.log('bbb', value, oldValue));
  window.innerWidth < 728 ? $store.aside.isOpen = false : $store.aside.isOpen = true
  " x-data :class="{'-translate-x-[var(--nav-size)]' : !$store.aside.isOpen}" x-cloak
  class="transition-all duration-300 ease-in-out fixed w-[var(--nav-size)] h-screen bg-white shadow-2xl left-0 top-[70px] before:content-[''] before:absolute before:w-2/3 before:h-px before:bg-slate-500 before:-top-px before:left-0 before:right-0 before:mx-auto before:bg-gradient-to-r before:from-gray-200 before:via-purple-700 before:to-gray-200"> --}}
  <aside x-data x-cloak :class="
    if(!isMobile){
      if(!open){
        return '-translate-x-[var(--nav-size)]'
      }
    } else {
      if(!openOnMobile){
        return '-translate-x-[var(--nav-size)]'
      }
    }
  "
  class="transition-all duration-300 ease-in-out fixed w-[var(--nav-size)] h-screen bg-white shadow-2xl left-0 top-[70px] before:content-[''] before:absolute before:w-2/3 before:h-px before:bg-slate-500 before:-top-px before:left-0 before:right-0 before:mx-auto before:bg-gradient-to-r before:from-gray-200 before:via-purple-700 before:to-gray-200">
  <nav class="text-sm px-4 py-4 ">
    <ul>
      <li class="mb-1">
        <a href="#" class="flex px-3 py-2 items-center rounded-lg bg-purple-700 text-white"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
          </svg><span>Dashboard</span></a>
      </li>
      <li class="mb-1">
        <a href="#" class="flex px-3 py-2 hover:bg-gray-50 items-center rounded-lg"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
          </svg><span>Pages</span></a>
      </li>
      <li class="mb-1">
        <a href="#" class="flex px-3 py-2 hover:bg-gray-50 items-center rounded-lg"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg><span>Components</span></a>
      </li>
      <li class="mb-1">
        <a href="#" class="flex px-3 py-2 hover:bg-gray-50 items-center rounded-lg"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
          </svg>
          <span>Users</span></a>
      </li>
      <li class="mb-1">
        <a href="#" class="flex px-3 py-2 hover:bg-gray-50 items-center rounded-lg"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802" />
          </svg>
          <span>Translations</span></a>
      </li>
      <li>
        <a href="#" class="flex px-3 py-2 hover:bg-gray-50 items-center rounded-lg"><svg class="w-4 h-4 mr-3"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
          </svg><span>Settings</span></a>
      </li>
    </ul>
  </nav> 
</aside>