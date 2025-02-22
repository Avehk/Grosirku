<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function view_category()
    {
        $data = Category::all();

        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request)
    {
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function delete_category($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori Berhasil Dihapus');
        } else {
            toastr()->timeOut(10000)->closeButton()->addError('Kategori Tidak Ditemukan');
        }

        return redirect()->back();
    }


    public function edit_category($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Kategori Berhasil Diupdate');
        return redirect('/view_category');
    }

    public function add_product()
    {
        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request)
    {
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $image = $request->image;
        if ($image) {
            $imagename = time() . '.' . $image->getclientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }
        $data->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Produk Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function view_product()
    {
        $product = Product::paginate(10);
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);

        if ($product) {
            // Hapus entri terkait dalam tabel carts
            \App\Models\Cart::where('product_id', $id)->delete();
            
            // Hapus gambar produk dari sistem file
            $image_path = public_path('products/' . $product->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            
            // Hapus produk dari database
            $product->delete();
    
            toastr()->timeOut(10000)->closeButton()->addSuccess('Produk Berhasil Dihapus');
        } else {
            toastr()->timeOut(10000)->closeButton()->addError('Produk tidak ditemukan');
        }
    
        return redirect()->back();
    }

    public function update_product($slug)
    {
        $data = Product::where('slug',$slug)->get()->first();
        $category = Category::all();
        return view('admin.update_page',compact('data','category'));
    }

    public function edit_product(Request $request,$id)
    {
        $data = Product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }
        $data->save();
        toastr()->timeOut(10000)->closeButton()->addSuccess('Produk Berhasil Diupdate');
        return redirect('/view_product');
    }

    public function product_search(Request $request)
    {
        $search = $request->search;
        $product = Product::where('title', 'LIKE', '%'.$search.'%')->orWhere('category', 'LIKE', '%'.$search.'%')->paginate(5);
        return view('admin.view_product', compact('product'));
    }

    public function view_order()
    {
        $data = Order::all();
        return view('admin.order', compact('data'));
    }

    public function on_the_way($id)
    {
        $data = Order::find($id);
        $data->status = 'Dalam Perjalanan';
        $data->save();
        return redirect('/view_orders');
    }

    public function delivered($id)
    {
        $data = Order::find($id);
        $data->status = 'Terkirim';
        $data->save();
        return redirect('/view_orders');
    }

    public function print_pdf($id){

        $data = Order::find($id);
        $pdf = Pdf::loadView('admin.invoice', compact('data'));
        return $pdf->download('invoice.pdf');
    }

}
