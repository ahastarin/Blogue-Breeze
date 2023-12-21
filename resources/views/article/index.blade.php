<x-app-layout>
    <x-slot name="header">
        <div class="inline-block">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Article  
                <a href="/dashboard/article/create" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-100/50 dark:shadow-md dark:shadow-blue-800/80 text-center me-2 mb-2 font-bold text-xl py-1 px-2 rounded-xl">+</a>
            </h2>    
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  <table class="border-collapse border border-slate-500 w-full mt-8">
                    <thead>
                          <tr>
                            <th class="border border-slate-600">No.</th>
                            <th class="border border-slate-600">Title</th>
                            <th class="border border-slate-600">Category</th>
                            <th class="border border-slate-600">Image</th>
                            <th class="border border-slate-600">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($articles as $article)
                          <tr class="">
                            <td class="border border-slate-700 py-3 px-2">{{ $loop->iteration }}</td>
                            <td class="border border-slate-700 py-3 px-2">{{ $article->title }}</td>
                            <td class="border border-slate-700 py-3 px-2">{{ $article->category->name }}</td>

                            <td class="border border-slate-700 py-3 px-2 w-48"><img src="/{{ $article->image }}" class="w-36 m-auto"></td>

                            <td class="border border-slate-700 py-3 px-2 w-1/4 text-center">

                                <a href="/dashboard/article/{{ $article->id }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 ml-2 mb-2">View</a>

                                <a href="/dashboard/article/{{ $article->id }}/edit" class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 mb-2">Update</a>

                                <form class="inline" action="/dashboard/article/{{ $article->id }}" method="post">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 mb-2">Delete</button>
                                </form>

                            </td>
                          </tr>
                          @empty 
                          <tr>
                            <td colspan="5" class="text-center"><p>No Post Found</p></td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
