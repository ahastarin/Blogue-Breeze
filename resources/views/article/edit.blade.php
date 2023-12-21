{{-- {{ dd($article->tags->implode('name', ",")) }} --}}
{{-- {{ dd($article->tags->toArray()) }} --}}
<x-app-layout>
    <x-slot name="header">
        <div class="inline-block">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Article  
            </h2>    
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="/dashboard/article/{{ $article->id }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" id="oldImage" name="oldImage" value="{{ $article->image }}">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="border border-gray-300 text-gray-900text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-25  @error('title') border-red-500 @enderror" value="{{ $article->title }}">
                        @error('title')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <br>
                        
                        <label for="category" class="block mb-2 text-sm font-large text-gray-900dark:text-white">Category</label>
                        <select id="category" name="category" class="border border-gray-300 text-gray-900text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-25">
                        @foreach ($categories as $category)
                            @if($category->id === $article->category->id) 
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else 
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                        </select>
                        <br>
                        
                        <label for="content" class="block mb-2 text-sm font-large text-gray-900">Content</label>
                        <input id="x" type="hidden" name="content" value="{{ $article->content }}">
                        <trix-editor input="x"></trix-editor>
                        <br>

                        <label for="image" class="block mb-2 text-sm font-large text-gray-900">Image</label>
                        @isset($article->image)
                            <img id="preview" src="/{{ $article->image }}" class="w-40">    
                        @endisset
                        <img id="preview" class="w-40">    
                        <input type="file" name="image" id="image" onchange="loadFile(event)"">
                        @error('image')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <br><br>

                        {{-- tags --}}

                        <label for="Tags" class="block mb-2 text-sm font-large text-gray-900">Tags : </label>

                        <div id="tags-container">
                            
                        </div>
                        <input type="text" id="tagInput" class="border border-gray-300 text-gray-900text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-25 inline" value="{{ $article->tags->implode('name', ',') }}">

                        {{-- pass tags to laravel --}}
                        <input type="hidden" id="tags" name="tags">

                        <button type="button" onclick="addTag()" class="text-white bg-gradient-to-r from-gray-400 via-gray-500 to-gray-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Add Tag</button>
                        <br>

                        {{-- endtags --}}
                        
                        <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
            var loadFile = function(event) {
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
              URL.revokeObjectURL(output.src) // free memory
            }
        };

        
    let tagValue = [];

    function addTag() {
      const tagInput = document.getElementById('tagInput');
      const tagContainer = document.getElementById('tags-container');
      const tags = document.getElementById('tags');

      if (tagInput.value.trim() !== '') {

        const tag = document.createElement('span');
        
        tag.className = 'tag bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300';
        tagContainer.className = 'my-2';
        tag.textContent = tagInput.value.trim();
        
        tagValue.push(tag.textContent);

        // delete tag
        tag.addEventListener('click', function() {
          tagContainer.removeChild(tag);
          // remove array that deleted from tagValue
          var filteredArray = tagValue.filter(e => e !== tag.textContent)
          tagValue = filteredArray;
          tags.value = tagValue;
        });

        tagContainer.appendChild(tag);
        tagInput.value = '';

        //add tags value
        tags.value = tagValue;
      }
    }
    </script>
</x-app-layout>
