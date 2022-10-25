<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Index') }}
        </h2>
    </x-slot>

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
                                        <td> <img src="{{ asset('storage/product/' . $row->image) }}" class="{{ $row->image != null ? '' : 'hidden' }}" alt="" title=""> <p class="{{ $row->image != null ? 'hidden' : '' }}">Data Masih kosong</p></td>
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
                                            <form action="{{ route('product-destroy', $row->product_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('product-edit', $row->product_code) }}" class="btn btn-warning mb-2"><i class="fas fa-edit"></i></a>
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
    </div>
</x-app-layout>
