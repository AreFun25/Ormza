<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Edit Product</h1>
                    <hr />
                    <form action="{{ route('admin/products/update', $products->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ $products->nama }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" name="kategori" class="form-control" placeholder="Nama" value="{{ $products->kategori }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" name="harga" class="form-control" placeholder="Nama" value="{{ $products->harga }}">
                            </div>
                        </div>
                            <div class="row">
                                <div class="d-grid">
                                    <button class="btn btn-warning">Update</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
