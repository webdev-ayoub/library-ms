<div class="container whitespace-nowrap py-3 grid">
   <x-slot name="title">{{ __('Issue Book') }}</x-slot>
   <div
      class="w-auto flex flex-col sm:flex-row items-center justify-between py-3 px-2 my-5
      font-bold text-purple-100 bg-purple-600 rounded-lg shadow-md 
      focus:outline-none focus:shadow-outline-purple">
      <div class="flex items-center mb-2 sm:mb-0">
         <span>{{ __('Issued Books') . ' (' . count($issuedBooks_count) . ')' }}</span>
      </div>
      <span>
         <button
            class="px-3 py-2 text-sm font-medium leading-5 text-white 
            transition-colors duration-150 bg-purple-600 border 
            border-transparent rounded-lg hover:text-black
            hover:bg-white focus:outline-none border-white border-2"
            wire:click="addForm">
            Issue Book
         </button>
      </span>
   </div>

   @if ($tableShow === true)
      <div class="w-full mb-8 flex flex-col items-center sm:justify-center sm:ml-0">
         <div class="flex flex-col items-center justify-center sm:flex-row gap-3 mb-3">
            <input
               class="block w-full shadow text-sm bg-slate-200 focus:border-purple-400 
               focus:outline-none focus:shadow-outline-purple mb-2
               rounded p-2"
               placeholder="Search for author..." type="date" wire:model='fromDate' />
            <input
               class="block w-full shadow text-sm bg-blue-300 font-bold focus:border-purple-400 
            focus:outline-none focus:shadow-outline-purple mb-2
            rounded-full p-2"
               type="button" value="Clear" wire:click.prevent='clearFilter' />
            <input
               class="block w-full shadow text-sm bg-slate-200 focus:border-purple-400 
               focus:outline-none focus:shadow-outline-purple mb-2 
               rounded p-2"
               placeholder="Search for author..." type="date" wire:model='toDate' />
         </div>
         <div class="mb-3">
            <select
               class="block w-full shadow text-sm bg-slate-200 focus:border-purple-400 
         focus:outline-none focus:shadow-outline-purple mb-2
         rounded p-2"
               wire:model='book_id'>
               <option selected value="">Select Book</option>
               @foreach ($all_books as $book)
                  <option value="{{ $book->id }} "> {{ $book->title }} </option>
               @endforeach
            </select>
         </div>
         <table class="table-auto w-9/12 whitespace-no-wrap rounded border border-2 border-blue-500 mb-2">
            <thead>
               <tr
                  class="text-xs font-semibold tracking-wide text-center text-gray-500 
                  uppercase border-b dark:border-gray-700 bg-gray-100 dark:text-gray-400 
                  dark:bg-gray-800">
                  <th class="p-3">Book Name</th>
                  <th class="p-3">Book Author</th>
                  <th class="p-3">Issue Date</th>
                  <th class="p-3">Return Date</th>
                  <th class="p-3">Actions</th>
               </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
               @foreach ($issueBooks as $issueBook)
                  <tr class="text-gray-700 dark:text-gray-400 text-center">
                     <td class="p-3">
                        {{ ucwords($issueBook->book->title) }}
                     </td>
                     <td class="p-3">
                        {{ ucwords($issueBook->book->author->firstname) . ' ' . ucwords($issueBook->book->author->lastname) }}
                     </td>
                     <td class="p-3">{{ ucwords($issueBook->issue_date) }}</td>
                     <td class="p-3">{{ ucwords($issueBook->return_date) }}</td>
                     <td class="p-3 w-auto">
                        <button class="btn bg-green-500 rounded p-1 font-bold text-white"
                           wire:click.prevent='edit({{ $issueBook->id }})'>Edit</button>
                        <button class="btn bg-red-500 rounded p-1 font-bold text-white"
                           wire:click.prevent='destroy({{ $issueBook->id }})'>Delete</button>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
         {{ $issueBooks->links() }}
      </div>
   @endif

   @if ($createForm === true)
      <div class="p-3 w-max rounded bg-slate-300 flex text-center place-self-center mb-2 shadow">
         <form action="" wire:submit.prevent='store'>
            @csrf
            <div class="flex flex-col sm:flex-col gap-3">
               <div class="flex flex-col">
                  <select class="rounded p-1" wire:model.lazy='book_id'>
                     <option selected>Select Book</option>
                     @foreach ($all_books as $book)
                        <option value="{{ $book->id }} "> {{ $book->title }} </option>
                     @endforeach
                  </select>
                  @error('book_id')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex gap-2">
                  <div class="flex flex-col">
                     <label for="">Issue Date</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                  dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Issue Date" type="date" wire:model.lazy='issue_date' />
                     @error('issue_date')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="flex flex-col">
                     <label for="">Return Date</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Return Date" type="date" wire:model.lazy='return_date' />
                     @error('return_date')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>

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
         <form wire:submit.prevent='update({{ $issuedBook_id }})'>
            @csrf
            <div class="flex flex-col sm:flex-col gap-3">
               <div class="flex flex-col">
                  <select class="rounded p-1" wire:model='book_id'>
                     @foreach ($all_books as $book)
                        @if ($book->id === $book_id)
                           <option value="{{ $book->id }} " selected> {{ $book->title }} </option>
                        @else
                           <option value="{{ $book->id }} "> {{ $book->title }} </option>
                        @endif
                     @endforeach
                  </select>
                  @error('book_id')
                     <span class="text-red-600">{{ $message }}</span>
                  @enderror
               </div>

               <div class="flex gap-2">
                  <div class="flex flex-col">
                     <label for="">Issue Date</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                  focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                  dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Issue Date" type="date" wire:model='issue_date' />
                     @error('issue_date')
                        <span class="text-red-600">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="flex flex-col">
                     <label for="">Return Date</label>
                     <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 
                     focus:border-purple-400 focus:outline-none focus:shadow-outline-purple 
                     dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded p-2"
                        placeholder="Return Date" type="date" wire:model='return_date' />
                     @error('return_date')
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
