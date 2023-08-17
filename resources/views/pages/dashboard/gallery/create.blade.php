<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prodcut &raquo; {{ $product->name }} &raquo; upload foto
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div>
            @if($errors->any())
            <div class="mb-5" role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    Sesuatu ada yang salah
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    <p>
                        <ul>
                            @foreach ($error->all() as $error )
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </p>
                </div>
            </div>
            @endif

            <form action="{{ route('dashboard.product.gallery.store', $product->id) }}" class="w-full" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="flex flex-wrap -max-3 mb-6">
                    <div class="w-full px-3 mb-6">
                        <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Upload Photos :</label>
                        <input type="file" multiple name="files[]" accept="image/*" placeholder="Photos" class="block w-full bg-gray-700 border boder-gray-200 rounded py-3 px-4 leading-light focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>                
                </div>
                <div class="w-full px-3 mb-6">
                    <button type='submit' class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                        Save Gallery    
                    </button>  
                </div>
            </form>
            
           </div>
        </div>
    </div>

   
</x-app-layout>


