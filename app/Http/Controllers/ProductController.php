<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        $total = Product::count();
        return view('admin.product.home', compact(['products', 'total']));
    }

    public function create()
    {
        return view('admin.product.create');
    }
    public function save(Request $request)
    {
        $validation = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
        ]);
        $data = Product::create($validation);
        if ($data) {
            session()->flash('success', 'Product Berhasil ditambahkan');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Terdapat Masalah');
            return redirect(route('admin/products/create'));
        }
    }
    public function edit($id){
        $products = Product::findOrFail($id);
        return view('admin.product.update', compact('products')); 
    }

    public function delete($id){
        $products = Product::findOrFail($id)->delete();
        if ($products) {
            session()->flash('success', 'Product Berhasil dihapus');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Product gagal dihapus');
            return redirect(route('admin/products'));
        }
    }

    public function update(Request $request, $id){
        $products = Product::findOrFail($id);
        $nama = $request->nama;
        $kategori = $request->kategori;
        $harga = $request->harga;

        $products->nama = $nama;
        $products->kategori = $kategori;
        $products->harga = $harga;
        $data = $products->save();
        if ($data) {
            session()->flash('success', 'Product Berhasil diupdate');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Terdapat Masalah');
            return redirect(route('admin/products/update'));
        }
    }
}