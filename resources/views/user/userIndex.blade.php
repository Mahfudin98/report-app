<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Index') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">User List</h2>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('user-create') }}" class="btn btn-primary">Add User</a>
                </div>
            </div>
            <div class="w-full grid grid-cols-12 gap-6 mt-5 px-4">
                @forelse ($user as $key => $row)
                    <div class="col-span-12 md:col-span-6 lg:col-span-4">
                        <div class="box-border bg-white shadow-md shadow-black/10 rounded-md hover:scale-105">
                            <div class="flex items-start px-5 pt-3">
                                <div class="w-full flex flex-col lg:flex-row items-center">
                                    <div class="w-16 h-16 image-fit">
                                        <img src="{{ route('user-image', $row->image != null ? $row->image : 'kosong') }}"
                                            class="rounded-full object-cover object-center aspect-square"
                                            alt="" />
                                    </div>
                                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                        <a href="" class="font-medium">
                                            {{ $row->nama_depan }} {{ $row->nama_belakang }}
                                        </a>
                                        <div class="text-slate-500 text-xs mt-0.5">
                                            {{ $row->division_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center lg:text-left px-5 py-3">
                                <div class="flex items-center justify-center lg:justify-start text-slate-500">
                                    <i class="fa-solid fa-at w-3 h-3 mr-2"></i>
                                    {{ $row->email }}
                                </div>
                                <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                    <i class="fa-solid fa-phone w-3 h-3 mr-2"></i>
                                    {{ $row->phone != null ? $row->phone : 'Belum ada Data' }}
                                </div>
                            </div>
                            <div class="text-center lg:text-right px-5 py-3 border-t border-slate-200/60">
                                <form action="{{ route('user-destroy', $row->user_id) }}" method="POST">
                                <a href="{{ route('user-edit', $row->user_id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm py-1 px-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm py-1 px-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
