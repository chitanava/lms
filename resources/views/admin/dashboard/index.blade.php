<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;1,100;1,400&display=swap"
    rel="stylesheet">
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 font-montserrat font-normal bg-[var(--secondary-color)]">
  @include('admin/includes/header')
  @include('admin/includes/aside')
  
  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('aside', {
          isOpen: false,
          toggle() {
                this.isOpen = ! this.isOpen
            }
        })
    })
  </script>
  @vite('resources/js/app.js')
</body>

</html>