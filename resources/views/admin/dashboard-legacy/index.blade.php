<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;1,400;1,600&display=swap"
    rel="stylesheet">
  @vite('resources/css/app.css')
</head>

<body x-data="{
  width: window.innerWidth,
  breakpoint: 1024,
  isMobile: false,
  open: $persist(true),
  openOnMobile: false,
  init(){
      this.isMobile = this.width < this.breakpoint
  },
  toggle(){
    if(this.isMobile){
      this.openOnMobile = !this.openOnMobile
      if(this.openOnMobile){
        this.open = true
      }
    } else {
      this.open = !this.open
    }
  },
}" x-on:resize.window.debounce.300="
    isMobile = window.innerWidth < breakpoint
    if(!isMobile) openOnMobile = false 
  {{-- if(window.innerWidth < breakpoint){
    isMobile = true
  } else {
    isMobile = false
    openOnMobile =  false 
  } --}}
" class="bg-gray-100 text-gray-900 font-montserrat font-normal bg-[var(--secondary-color)]">
  @include('admin/includes/header')
  @include('admin/includes/aside')


  <script>
    // document.addEventListener('alpine:init', () => {
    //   Alpine.store('aside', {
    //     isOpen: Alpine.$persist(true),
    //     toggle() {
    //       this.isOpen = !this.isOpen
    //     }
    //   })
    // })
  </script>
  @vite('resources/js/app.js')
</body>

</html>