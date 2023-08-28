<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User &raquo; {{ $user->name }} &raquo; Edit
        </h2>
    </x-slot>
    
    <x-slot name="script">

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

            <form action="{{ route('dashboard.user.update', $user->id) }}" class="w-full" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')

                <div class="flex flex-wrap -max-3 mb-6">
                    <div class="w-full px-3 mb-6">
                        <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Name :</label>
                        <input type="text" value="{{ old('name') ?? $user->name }}" name="name" placeholder="username" class="block w-full bg-gray-700 border boder-gray-200 rounded py-3 px-4 leading-light focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                    <div class="w-full px-3 mb-6">
                        <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">email :</label>
                        <input type="text" value="{{ old('email') ?? $user->email }}" name="email" placeholder="email" class="block w-full bg-gray-700 border boder-gray-200 rounded py-3 px-4 leading-light focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                    <div class="w-full px-3 mb-6">
                        <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">email :</label>
                        <select name="roles" id="roles" class="block w-full bg-gray-700 border boder-gray-200 rounded py-3 px-4 leading-light focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="{{ $user->roles }}">{{ $user->roles }}</option>
                            <option value="" disabled>======================================</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="USER">USER</option>
                        </select>
                    </div>
                    <div class="w-full px-3 mb-6">
                        <button type='submit' class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                            Update Transaciton
                        </button>  
                    </div>
                </div>

            </form>
            
           </div>
        </div>
    </div>

   
</x-app-layout>


