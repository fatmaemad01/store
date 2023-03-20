<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth'])->only(['create','restore']);
        $this->middleware(['auth']);
    }

    
    public function index()
    {
        $products = Product::all();
        return view('dashboard.products.index', compact('products'));
    }


    public function create()
    {
        return view('dashboard.products.create', [
            'product' => new Product(),
            'status_options' => Product::statusOptions(),
            'availabilities' => Product::availabilities(),
        ]);
    }


    public function store(Request $request)
    {
        $rules = $this->rules();
        $request->validate($rules);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploads($request->file('image'));
        }

        $product = Product::create($data);

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', "product ($product->name) Created Successfully");
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.show', [
            'product' => $product,
        ]);
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('dashboard.products.edit', [
            'product' => $product,
            'status_options' => Product::statusOptions(),
            'availabilities' => Product::availabilities(),
        ]);
    }




    public function update(Request $request, $id)
    {

        $rule = $this->rules();
        $request->validate($rule);

        // $product = Product::find($id);
        // $product->update($request->all());
        $product = Product::findOrFail($id);

        // $rules = $this->rules();
        // $request->validate($rules);


        $data = $request->except('image');

        $old_image = $product->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $this->uploads($file);
        }

        $product->update($data);

        if ($old_image && $old_image != $product->image) {
            Storage::disk('public')->delete($old_image);
        }


        return redirect()
            ->route('dashboard.products.index')
            ->with('success', "Product $product->name Updated");
    }



    public function destroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->trashed()) {
            $product->forceDelete();
        } else {
            $product->delete();
        }

        // Product::destroy($id);

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', "Product $product->name Deleted ");
    }



    public function trash()
    {
        $products = Product::onlyTrashed()->get();

        return view('dashboard.products.trash', compact('products'));
    }



    public function restore(Request $request, $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', "Product $product->name Restored");
    }



    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|int|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'status' => 'in:active,draft,archived',
            'availability' => 'in:in-stock,out-of-stock,back-order',
            'quantity' => 'int|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'barcode' => 'nullable|string|unique:products,barcode',
            'image' => 'nullable|image'
        ];
    }

    protected function uploads(UploadedFile $file)
    {
        if ($file->isValid()) {
            return $data['image'] = $file->store(
                'thumbnails',
                [
                    'disk' => 'public'
                ]
            );
        } else {
            throw ValidationException::withMessages([
                'image' => 'File Corrupted',
            ]);
        }
    }
}
