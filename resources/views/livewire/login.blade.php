<div class="flex flex-col justify-center whitespace-nowrap py-3 w-full">
   <x-slot name="title">{{ __('Authentication') }}</x-slot>
   @error('Error')
      <p class="w-max mx-auto text-center text-2xl bg-red-500 rounded shadow my-2 p-2 text-white">{{ $message }}</p>
   @enderror
   @if ($registerForm)
      <div class="p-4 w-auto mx-auto md:w-1/3 flex-col flex rounded bg-slate-200 flex text-center shadow">
         <h1 class="text-center font-bold text-3xl my-2">Register</h1>
         <form wire:submit.prevent='signupStore'>
            @csrf
            <div class="flex flex-col gap-3">
               <div class="flex flex-col">
                  <input
                     class="block w-auto mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
               dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-3"
                     placeholder="Name" wire:model='name' />
                  @error('name')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
               <div class="flex flex-col">
                  <input
                     class="block w-auto mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
               dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-3"
                     placeholder="Email" type="email" wire:model='email' />
                  @error('email')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
               <div class="flex flex-col">
                  <input
                     class="block w-auto mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
               dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-3
               @error('passwordLength') peer-invalid:visible text-red-600 border border-2 border-red-600 font-bold @enderror"
                     placeholder="Password" type="password" wire:model='password' />
                  @error('password')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
                  @error('passwordLength')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

            </div>
            <button type="submit"
               class="bg-green-500 mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700">Register</button>
         </form>
         <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
            wire:click.prevent='login'>Login Here</button>
      </div>
   @else
      <div class="p-4 w-auto md:w-1/3 flex-col flex mx-auto rounded bg-slate-200 flex text-center shadow">
         <h1 class="text-center font-bold text-3xl my-2">Login</h1>
         <form wire:submit.prevent='loginStore'>
            @csrf
            <div class="flex flex-col gap-3">
               <div class="flex flex-col">
                  <input
                     class="block w-auto mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
               dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-3"
                     placeholder="Name" wire:model='name' />
                  @error('name')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex flex-col">
                  <input
                     class="block w-auto mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
               dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-3"
                     placeholder="Password" type="password" wire:model='password' />
                  @error('password')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <button type="submit"
               class="bg-green-500 mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700">Login</button>
         </form>
         <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
            wire:click.prevent='signup'>Signup Here</button>
      </div>
   @endif
</div>
