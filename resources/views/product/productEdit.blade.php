<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('product-update', $product->product_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Category Product <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="category_id" required>
                                        <option value="">Pilih Category</option>
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}" {{ $row->id == $product->category_id ? 'selected' : '' }}>{{ $row->category_name }} - {{ $row->category_type }} - {{ $row->category_pay }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="product_code" class="form-label">Kode Produk <span class="text-danger">*</span></label>
                                    <input type="text" id="product_code" name="product_code" class="form-control rounded-lg"
                                        placeholder="Kode Produk" value="{{ $product->product_code }}" aria-label="product_code" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_bpom" class="form-label">Nomor BPOM</label>
                                    <input type="text" id="product_bpom" name="product_bpom" class="form-control rounded-lg"
                                        placeholder="Nomor BPOM" value="{{ $product->product_bpom }}" aria-label="product_bpom" aria-describedby="basic-addon1">
                                </div>
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="product_name" class="form-control rounded-lg"
                                        placeholder="Nama Produk" value="{{ $product->product_name }}" aria-label="product_name" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="file_input" class="form-label">Foto Produk</label>
                                    <input
                                        class="form-control block w-full px-2 py-1 text-base
                                        font-normal text-gray-800 bg-white bg-clip-padding
                                        border border-solid border-gray-800 rounded transition ease-in-out m-0
                                        focus:text-gray-800 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-describedby="file_input_help" id="file_input" name="image"
                                        type="file">
                                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG or JPG(MAX.
                                        800x400px).</p>
                                </div>
                                <div class="mb-3">
                                    <label for="product_weight" class="form-label">Berat Produk (Gram) <span class="text-danger">*</span></label>
                                    <input type="number" name="product_weight" class="form-control rounded-lg"
                                        placeholder="Berat Produk" value="{{ $product->product_weight }}" aria-label="product_weight" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_stock" class="form-label">Stok Produk <span class="text-danger">*</span></label>
                                    <input type="number" name="product_stock" class="form-control rounded-lg"
                                        placeholder="Stok Produk" value="{{ $product->product_stock }}" aria-label="product_stock" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="end_user" class="form-label">Harga End User <span class="text-danger">*</span></label>
                                    <input type="number" name="end_user" class="form-control rounded-lg"
                                        placeholder="Harga End User" value="{{ $product->end_user }}" aria-label="end_user" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reseller" class="form-label">Harga Reseller <span class="text-danger">*</span></label>
                                    <input type="number" name="reseller" class="form-control rounded-lg"
                                        placeholder="Harga Reseller" value="{{ $product->reseller }}" aria-label="reseller" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="agen" class="form-label">Harga Agen <span class="text-danger">*</span></label>
                                    <input type="number" name="agen" class="form-control rounded-lg"
                                        placeholder="Harga Agen" value="{{ $product->agen }}" aria-label="agen" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_status" class="form-label">Status Produk</label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="product_status">
                                        <option value="1" {{ $product->product_status == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $product->product_status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex justify-between mb-3">
                                    <div class="flex">
                                        <div class="shrink-0 flex items-center">
                                            <p class="mt-1 text-sm text-danger" id="file_input_help">* Wajib diisi.</p>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <button class="btn btn-primary text-gray-800" type="submit">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
