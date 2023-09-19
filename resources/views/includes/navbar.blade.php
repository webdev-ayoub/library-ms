<nav class="bg-gray-100">
   <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between">

         <div class="flex space-x-4">
            <!-- logo -->
            <div>
               <a href="#" class="flex items-center py-5 px-2 text-gray-700 hover:text-gray-900">
                  <svg class="h-6 w-6 mr-1 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                  </svg>
                  <span class="font-bold uppercase">Library</span>
               </a>
            </div>

            <!-- primary nav -->
            <div class="hidden md:flex items-center space-x-1">
               <a href="{{ route('dashboard') }}"
                  class="py-2 px-3 rounded text-gray-700 hover:text-white hover:bg-blue-500">Dashboard</a>
               <a href="{{ route('authors') }}"
                  class="py-2 px-3 rounded text-gray-700 hover:text-white hover:bg-blue-500">Authors</a>
               <a href="{{ route('books') }}"
                  class="py-2 px-3 rounded text-gray-700 hover:text-white hover:bg-blue-500">Books</a>
               <a href="{{ route('issue-books') }}"
                  class="py-2 px-3 rounded text-gray-700 hover:text-white hover:bg-blue-500">Issue Book</a>
            </div>
         </div>

         <!-- secondary nav -->
         <div class="hidden md:flex items-center space-x-1">
            @livewire('logout')
            <h1 class="font-bold bg-green-500 rounded py-2 px-4 text-white">{{ ucwords(Auth::user()->name) }}</h1>
         </div>

         <!-- mobile button goes here -->
         <div class="md:hidden flex items-center">
            <button class="mobile-menu-button">
               <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
               </svg>
            </button>
         </div>

      </div>
   </div>

   <!-- mobile menu -->
   <div class="mobile-menu hidden md:hidden">
      <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-sm hover:bg-gray-200">Dashboard</a>
      <a href="{{ route('authors') }}" class="block py-2 px-4 text-sm hover:bg-gray-200">Authors</a>
      <a href="{{ route('books') }}" class="block py-2 px-4 text-sm hover:bg-gray-200">Books</a>
      <a href="{{ route('issue-books') }}" class="block py-2 px-4 text-sm hover:bg-gray-200">Issue
         Book</a>
      @livewire('logout')
      <h1 class="font-bold bg-green-500 rounded py-2 px-4 text-white">{{ ucwords(Auth::user()->name) }}</h1>
   </div>
</nav>
