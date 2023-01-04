<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Index') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">Product List</h2>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('product-create') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image Produk</th>
                                    <th>Kode Produk</th>
                                    <th>Nomor BPOM</th>
                                    <th>Nama Kategori</th>
                                    <th>Nama Produk</th>
                                    <th>Harga End User</th>
                                    <th>Harge Reseller</th>
                                    <th>Harge Agen</th>
                                    <th>Stok Produk</th>
                                    <th>Kategori Produk</th>
                                    <th>Jenis Produk</th>
                                    <th>Status Produk</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($products as $key => $row)
                                    <tr>
                                        <td> {{ ++$key }} </td>
                                        <td> <img src="{{ asset('storage/product/' . $row->image) }}"
                                                class="{{ $row->image != null ? '' : 'hidden' }}" alt=""
                                                title="">
                                            <p class="{{ $row->image != null ? 'hidden' : '' }}">Data Masih kosong</p>
                                        </td>
                                        <td> {{ $row->product_code }} </td>
                                        <td> {{ $row->product_bpom }} </td>
                                        <td> {{ $row->category_name }} </td>
                                        <td> {{ $row->product_name }} </td>
                                        <td> {{ $row->end_user }} </td>
                                        <td> {{ $row->reseller }} </td>
                                        <td> {{ $row->agen }} </td>
                                        <td> {{ $row->product_stock }} </td>
                                        <td> {{ $row->category_type }} </td>
                                        <td> {{ $row->category_pay }} </td>
                                        <td> {{ $row->product_status }} </td>
                                        <td>
                                            <form action="{{ route('product-destroy', $row->product_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('product-edit', $row->product_code) }}"
                                                    class="btn btn-warning mb-2"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger text-gray-800"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14">
                                            <p
                                                class="text-center mb-5 mt-5 font-semibold text-base leading-tight text-gray-800">
                                                Data Masih Kosong</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">Product List</h2>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('product-create') }}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
            <div class="w-full grid grid-cols-12 gap-6 mt-5 px-4">
                @forelse ($products as $key => $row)
                    <div
                        class="relative overflow-hidden col-span-12 md:col-span-6 lg:col-span-4 p-6 bg-white rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all transform duration-500">
                        <div class="ribbon font-semibold whitespace-no-wrap px-5 text-white {{ $row->product_status == 1 ? 'bg-green-500 text-md' : 'bg-red-500 text-xs' }}">{{ $row->product_status == 1 ? "Active" : "Nonactive" }}</div>
                        <img class="w-fit object-cover rounded-t-md"
                        src="{{ asset('storage/product/' . $row->image) }}" alt="" />
                        <div class="mt-4">
                            <h1 class="text-2xl font-bold text-gray-700">{{ $row->product_name }} <span class="text-xs">({{ $row->product_stock }})</span></h1>
                            <p class="text-sm mt-2 text-gray-700">{{ $row->product_code }} | {{ $row->category_name }}</p>
                            <div class="mt-3 space-x-4 flex p-1 justify-center">
                                <div class="p-1 border-4 rounded-xl cursor-pointer hover:border-green-200 hover:scale-105 transition transform duration-200">
                                    <div class="bg-green-400 text-white p-1 rounded-md shadow-md">
                                        <p class="text-xs">End User</p>
                                        <p class="text-lg font-semibold">{{ number_format($row->end_user) }}</p>
                                    </div>
                                </div>
                                <div class="p-1 border-4 rounded-xl cursor-pointer hover:border-blue-200 hover:scale-105 transition transform duration-200">
                                    <div class="bg-blue-400 text-white p-1 rounded-md shadow-md">
                                        <p class="text-xs">Reseller</p>
                                        <p class="text-lg font-semibold">{{ number_format($row->reseller) }}</p>
                                    </div>
                                </div>
                                <div class="p-1 border-4 rounded-xl cursor-pointer hover:border-yellow-200 hover:scale-105 transition transform duration-200">
                                    <div class="bg-yellow-400 text-white p-1 rounded-md shadow-md">
                                        <p class="text-xs">Agen</p>
                                        <p class="text-lg font-semibold">{{ number_format($row->agen) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-2 flex justify-between pl-4 pr-2">
                                <button class="block text-md font-semibold text-gray-700 cursor-auto">{{ $row->category_pay }} | {{ $row->category_type }}</button>
                                <a href="{{ route('product-edit', $row->product_code) }}"
                                    class="text-lg block font-semibold py-2 px-6 text-green-100 hover:text-white bg-green-400 rounded-lg shadow hover:shadow-md transition duration-300"><i class="fas fa-edit"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex mx-auto">Data Kosong</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
