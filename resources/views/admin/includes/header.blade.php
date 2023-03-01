<header class="fixed w-full h-[70px] bg-white top-0 left-0 border-b border-gray-200 flex items-center px-8">
  <button x-data @click="$store.aside.toggle()"
    class="w-10 h-10 rounded-full flex justify-center items-center hover:bg-gray-50">
    <svg x-show="!$store.aside.isOpen" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
    </svg>
    <svg x-show="$store.aside.isOpen" class="w-8 h-8 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
    </svg>
  </button>
</header>