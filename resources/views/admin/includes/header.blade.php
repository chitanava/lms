<header class="fixed w-full h-[70px] bg-white top-0 left-0 border-b border-gray-200 flex items-center px-8">
  {{-- <button x-data @click="$store.aside.toggle()"
    class="w-10 h-10 rounded-full flex justify-center items-center hover:bg-gray-50">
    <svg x-cloak x-show="$store.aside.isOpen" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
    </svg>
    <svg x-cloak x-show="!$store.aside.isOpen" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
    </svg>
  </button> --}}
  <button x-data @click="toggle()"
  class="w-10 h-10 rounded-full flex justify-center items-center hover:bg-gray-50">
  <svg x-cloak x-show="isMobile ? openOnMobile : open" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
  </svg>
  <svg x-cloak x-show="isMobile ? !openOnMobile : !open" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
  </svg>
</button>
  <span class="ml-4 font-semibold italic text-3xl">LMS</span>
  <div class="flex relative flex-1 justify-end" x-data={open:false}>
    <button @click="open = !open" class="w-10 h-10 rounded-full text-white bg-gray-900 flex justify-center items-center"><span class="text-sm font-semibold">NC</span></button>
    <div x-transition @click.outside="open = false" x-show="open" class="min-w-[250px] absolute top-full right-0 mt-1 bg-white rounded-lg border-gray-200 border shadow-sm text-sm" x-cloak>
      <div class="p-4 border-b border-b-gray-200">
        <p class="font-semibold">Nika Chitanava</p>
        <p class="text-xs text-gray-400">chitanava@gmail.com</p>
      </div>
      <ul class="py-1 px-1">
        <li class="mb-1">
          <a href="#" class="flex items-center hover:bg-purple-700 px-3 py-2 rounded-lg hover:text-white">
            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg><span>Profile</span>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center hover:bg-purple-700 px-3 py-2 rounded-lg hover:text-white">
            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg><span>Log out</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>