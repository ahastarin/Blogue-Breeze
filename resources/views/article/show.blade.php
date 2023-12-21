<x-app-layout>
    <x-slot name="header">
        <div class="inline-block">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Article Detail
                <a href="/dashboard/article" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 ml-2 mb-2">Go Back</a>

                <a href="/dashboard/article/{{ $article->id }}/edit" class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 mb-2">Update</a>

                <form class="inline" action="/dashboard/article/{{ $article->id }}" method="post">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1 text-center me-2 mb-2">Delete</button>
                </form>
            </h2>
                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16 relative">
                        <div class="bg-cover bg-center text-center overflow-hidden"
                            style="min-height: 500px; background-image: url('/{{ $article->image }}')">
                        </div>
                        <div class="max-w-3xl mx-auto">
                            <div class="mt-3 bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
                                <div class="bg-white relative top-0 -mt-32 p-5 sm:p-10">
                                    <h1 href="#" class="text-gray-900 font-bold text-3xl mb-2">{{ $article->title }}</h1>
                                    <p class="text-gray-700 text-xs mt-2">Written By:
                                        <a href="#"
                                            class="text-indigo-600 font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                                            {{ $article->user->name }}
                                        </a> In
                                        <a href="#"
                                            class="text-xs text-indigo-600 font-medium hover:text-gray-900 transition duration-500 ease-in-out">
                                            {{ $article->category->name }}
                                        </a>                    
                                    </p>
                                    <br>
                                    <div class="content">
                                        {!! $article->content !!}
                                    </div>
                                    
                                    <br>
                                        @foreach($article->tags as $tag) 
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white">
                                            <span class="relative px-2 py-1 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-opacity-0">
                                            {{ $tag->name }}
                                            </span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
