<div class="container whitespace-nowrap py-3 grid">
   <x-slot name="title">{{ __('Authors') }}</x-slot>
   <div
      class="w-auto flex flex-col sm:flex-row items-center justify-between py-3 px-2 my-5
      font-bold text-purple-100 bg-purple-600 rounded-lg shadow-md 
      focus:outline-none focus:shadow-outline-purple">
      <div class="flex items-center mb-2 sm:mb-0">
         <span>{{ __('Authors') . ' (' . count($authors_count) . ')' }}</span>
      </div>
      <span>
         <button
            class="px-3 py-2 text-sm font-medium leading-5 text-white 
            transition-colors duration-150 bg-purple-600 border 
            border-transparent rounded-lg hover:text-black
            hover:bg-white focus:outline-none border-white border-2"
            wire:click="addForm">
            Add Author
         </button>
      </span>
   </div>

   @if ($tableShow === true)
      <div class="w-full mb-8 flex flex-col items-center sm:justify-center sm:ml-0">
         <input
            class="block w-75 my-1 text-sm dark:border-gray-600 dark:bg-gray-700 bg-slate-100 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple mb-2
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
            placeholder="Search for author..." wire:model='search' />
         <table class="table-auto w-9/12 whitespace-no-wrap rounded border border-2 border-blue-500 mb-2">
            <thead>
               <tr
                  class="text-xs font-semibold tracking-wide text-center text-gray-500 
                  uppercase border-b dark:border-gray-700 bg-gray-100 dark:text-gray-400 
                  dark:bg-gray-800">
                  <th class="p-3">First Name</th>
                  <th class="p-3">Last Name</th>
                  <th class="p-3">Actions</th>
               </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
               @foreach ($authors as $author)
                  <tr class="text-gray-700 dark:text-gray-400 text-center">
                     <td class="p-3">{{ ucwords($author->firstname) }}</td>
                     <td class="p-3">{{ ucwords($author->lastname) }}</td>
                     <td class="p-3">
                        <button class="btn bg-green-500 rounded p-1 font-bold text-white"
                           wire:click='edit({{ $author->id }})'>Edit</button>
                        <button class="btn bg-red-500 rounded p-1 font-bold text-white"
                           wire:click='destroy({{ $author->id }})'>Delete</button>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
         {{ $authors->links() }}
      </div>
   @endif

   @if ($createForm === true)
      <div class="p-3 w-max rounded bg-slate-300 flex text-center place-self-center mb-2 shadow">
         <form action="" wire:submit.prevent='store' enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
               <div class="flex flex-col">
                  <input
                     class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                     placeholder="First Name" wire:model.lazy='firstname' />
                  @error('firstname')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex flex-col">
                  <input
                     class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                     placeholder="Last Name" wire:model.lazy='lastname' />
                  @error('lastname')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <button type="submit" class="bg-black mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700"
               id="addBtn">Add</button>
            <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
               wire:click='showTable'>Cancel</button>
         </form>
      </div>
   @endif

   @if ($updateForm === true)
      <div class="p-3 w-max rounded bg-slate-300 flex text-center place-self-center mb-2 shadow">
         <form wire:submit.prevent='update({{ $author_id }})'>
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
               <div class="flex flex-col">
                  <input
                     class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                  dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                     placeholder="First Name" wire:model='firstname' />
                  @error('firstname')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex flex-col">
                  <input
                     class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                  dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                     placeholder="Last Name" wire:model='lastname' />
                  @error('lastname')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <button type="submit" class="bg-black mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700"
               id="uptBtn">Update</button>
            <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
               wire:click='showTable'>Cancel</button>
         </form>
      </div>
   @endif

</div>
