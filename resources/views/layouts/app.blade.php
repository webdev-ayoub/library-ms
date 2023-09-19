<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   @vite(['resources/css/app.css', 'resources/js/app.js'])
   @livewireStyles
  
   <title> {{ $title }} </title>
</head>

<body>
   @include('includes.navbar')
   <div class="flex flex-col flex-1 w-full">
      <main class="h-full overflow-y-auto">
         <div class="container px-6 mx-auto grid">
            {{ $slot }}
         </div>
      </main>
   </div>
   @livewireScripts
</body>

</html>
