<div class="container whitespace-nowrap py-3 grid">
   <x-slot name="title">{{ __('Books') }}</x-slot>
   <div
      class="w-auto flex flex-col sm:flex-row items-center justify-between py-3 px-2 my-5
      font-bold text-purple-100 bg-purple-600 rounded-lg shadow-md 
      focus:outline-none focus:shadow-outline-purple">
      <div class="flex items-center mb-2 sm:mb-0">
         <span>{{ __('Books') . ' (' . count($books_count) . ')' }}</span>
      </div>
      <span>
         <button
            class="px-3 py-2 text-sm font-medium leading-5 text-white 
            transition-colors duration-150 bg-purple-600 border 
            border-transparent rounded-lg hover:text-black
            hover:bg-white focus:outline-none border-white border-2"
            wire:click="addForm">
            Add Book
         </button>
      </span>
   </div>

   @if ($tableShow === true)
      <div class="w-full mb-8 flex flex-col items-center sm:justify-center sm:ml-0">
         <div class="flex gap-4 mb-3">
            <input
               class="block w-auto shadow my-1 text-sm dark:border-gray-600 dark:bg-gray-700 bg-slate-100 
            focus:border-purple-400 focus:outline-none focus:shadow-outline-purple mb-2
            dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
               placeholder="Search for a book..." wire:model='searchBook' type="text" />
            <input
               class="block w-auto shadow my-1 text-sm dark:border-gray-600 dark:bg-gray-700 bg-slate-100 
            focus:border-purple-400 focus:outline-none focus:shadow-outline-purple mb-2
            dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
               placeholder="Search for a author..." wire:model='searchAuthor' type="text" />
         </div>

         <table class="table-auto w-9/12 whitespace-no-wrap rounded border border-2 border-blue-500 mb-2">
            <thead>
               <tr
                  class="text-xs font-semibold tracking-wide text-center text-gray-500 
                  uppercase border-b dark:border-gray-700 bg-gray-100 dark:text-gray-400 
                  dark:bg-gray-800">
                  <th class="p-3">Title</th>
                  <th class="p-3">Pages Count</th>
                  <th class="p-3">Publish Date</th>
                  <th class="p-3">Author Name</th>
                  <th class="p-3">Actions</th>
               </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
               @foreach ($books as $book)
                  <tr class="text-gray-700 dark:text-gray-400 text-center">
                     <td class="p-3">{{ ucwords($book->title) }}</td>
                     <td class="p-3">{{ ucwords($book->page_count) }}</td>
                     <td class="p-3">{{ ucwords($book->publish_date) }}</td>
                     <td class="p-3 text-blue-700">
                        <p class="rounded-lg bg-slate-200 p-1">
                           {{ ucwords($book->author->firstname . ' ' . ucwords($book->author->lastname)) }}</p>
                     </td>
                     <td class="p-3">
                        <button class="btn bg-green-500 rounded p-1 font-bold text-white"
                           wire:click='edit({{ $book->id }})'>Edit</button>
                        <button class="btn bg-red-500 rounded p-1 font-bold text-white"
                           wire:click='destroy({{ $book->id }})'>Delete</button>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   @endif

   @if ($createForm === true)
      <div class="p-3 w-max rounded bg-slate-300 flex text-center place-self-center mb-2 shadow">
         <form action="" wire:submit.prevent='store'>
            @csrf
            <div class="flex flex-col gap-3">
               <div class="flex gap-3">
                  <div class="flex flex-col">
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                        focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                        dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Title" wire:model.lazy='title' />
                     @error('title')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>

                  <div class="flex flex-col">
                     <input
                        class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none 
                     focus:shadow-outline-purple form-input rounded p-2"
                        placeholder="Page Count" wire:model.lazy='page_count' />
                     @error('page_count')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>
               </div>

               <div class="flex flex-col">
                  <select
                     class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none 
                  focus:shadow-outline-purple form-input rounded p-2"
                     wire:model.lazy='author_id'>
                     <option selected>Select Author</option>
                     @foreach ($authors as $author)
                        <option value="{{ $author->id }} "> {{ $author->firstname }} </option>
                     @endforeach
                  </select>
                  @error('author_id')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex flex-col">
                  <label for="date">Publish Date</label>
                  <input
                     class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
         focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
         dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                     placeholder="Publish Date" type="date" wire:model.lazy='publish_date' />
                  @error('publish_date')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <button type="submit"
               class="bg-black mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700">Add</button>
            <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
               wire:click='showTable'>Cancel</button>
         </form>
      </div>
   @endif

   @if ($updateForm === true)
      <div class="p-3 w-max rounded bg-slate-300 flex text-center place-self-center mb-2 shadow">
         <form wire:submit.prevent='update({{ $book_id }})'>
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
               <div class="flex flex-col">
                  <div class="mb-3">
                     <label for="title">Title</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                        focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                        dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Title" wire:model='title' />
                     @error('title')
                        <span class="text-red-600 ">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="date">Publish Date</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Publish Date" type="date" wire:model='publish_date' />
                     @error('publish_date')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>
               </div>

               <div class="flex flex-col">
                  <div class="mb-3">
                     <label for="page_count">Page Count</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                        focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                        dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Page Count" wire:model='page_count' />
                     @error('page_count')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>

                  <div class="mb-3">
                     <label for="author">Author</label>
                     <select
                        class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none 
                     focus:shadow-outline-purple form-input rounded p-2"
                        wire:model='author_id'>
                        @foreach ($authors as $author)
                           @if ($author->id === $author_id)
                              <option value="{{ $author->id }}" selected> {{ $author->firstname }}
                              </option>
                           @else
                              <option value="{{ $author->id }} "> {{ $author->firstname }} </option>
                           @endif
                        @endforeach
                     </select>
                     @error('author_id')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>

               </div>
            </div>
            <button type="submit"
               class="bg-black mt-3 text-white rounded px-3 py-2 font-bold hover:bg-purple-700">Update</button>
            <button class="bg-yellow-300 mt-3 text-black rounded px-3 py-2 font-bold hover:bg-white"
               wire:click='showTable'>Cancel</button>
         </form>
      </div>
   @endif

</div>
