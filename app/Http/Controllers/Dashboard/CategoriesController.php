<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth'])->only(['create','restore']);
        $this->middleware(['auth']);
    }
    
    // action for Read ...
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->search($search)
            ->orderBy('name')
            ->get(); // Return a Collection  

        // $categories = DB::table('categories')->get();
        // dd(compact('categories'));  // var_dump();

        $title = 'Categories';
        return view('dashboard.categories.index', compact('title', 'categories'));
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('dashboard.categories.trash', compact('categories'));
    }


    // 2 Action for Create ...
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('dashboard.categories.create', [
            'parents' => $categories,
            'category' => new Category(),
        ]);
    }




    public function store(Request $request)
    {
        // All rules we need to achieve it in the form 
        $rules = $this->rules();
        // First Way to validate
        $request->validate(
            $rules,
            [
                // Here we can re-write the errors messages : rule => message we need
                'required' => 'Required!',
                // and we can define message just for selected field : filed.rules => :attribute Message
                'name.required' => ':attribute Required!'
            ]
        );

        /*   Second Way to validate
        $this->validate($request, $rules);
        */
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $this->upload($file);
        }

        /*
        First Way to store data that come by form
        $category = new Category();
        $category->name = $request->post('name');
        $category->slug = Str::slug($category->name);
        $category->parent_id = $request->input('parent_id');
        $category->description = $request->description;
        $category->save();
       */

        //  Mass Assignment 

        $category = Category::create($data);


        // $category = Category::create([
        //     'name' => $request->post('name'),
        //     'slug' => Str::slug($request->post('name')),
        //     'parent_id' => $request->post('parent_id'),
        //     'description' => $request->post('description'),
        // ]);


        // PRG : Post Redirect Get
        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category $category->name Created");  // flash message
        // return redirect()->back();

    }


    // 2 Action for Update ...
    public function edit($id)
    {
        // First Way
        $category = Category::findOrFail($id);

        // Second Way
        /* $category = Category::where('id','=',$id)->first();
        if ($category == null) {
            abort(404);
        } */

        $parents = Category::where('id', '<>', $id)
            ->orderBy('name')
            ->get();
        return view(
            'dashboard.categories.edit',
            compact('category', 'parents')
        );
    }




    public function update(Request $request, $id)
    {
        $rules = $this->rules($id);
        $request->validate($rules);
        // Method 1
        // $category = Category::find($id);
        // $category->name = $request->post('name');
        // $category->parent_id = $request->post('parent_id');
        // $category->description = $request->post('description');
        // $category->save();


        // Method 2 
        $category = Category::find($id);


        $data = $request->except('image');

        $old_image = $category->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $this->upload($file);

            /* Some Method We can use it to get info about file or to store the file
                $filename = uniqid().'_'.$file->getClientOriginalName();  // to give file unique name
                $file->getSize();       // to Know the size of the file   
                $file->getMimeType();   // to know the type of the file 
                $file->storeAs('thumbnails' , $filename , [
                    'disk' => 'public'
                ]); // to store the image in folder we need
                */
        }


        $category->update($data);

        if ($old_image && $old_image != $category->image) {
            Storage::disk('public')->delete($old_image);
        }
        // Method 3
        // $category->forceFill($request->all)->save();

        // Method 4
        // Category::where('id','=',$id)->update($request->except('_token','_method'));


        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category $category->name Updated");
    }

    // Action for Delete
    public function destroy($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        if ($category->trashed()) {
            $category->forceDelete();

            /* If we need to delete the image from database when we delete the category 
             --- but if we we use soft delete , we don't need it
                => we define it as model event
             */
        
        } else {
            $category->delete();
        }
        /* another way to delete data from database
        Category::where('id','=', $id)->delete();
        Category::destroy($id);
        */



        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category $category->name Deleted");
    }

    private function rules($id = 0)
    {
        return [
            // We can define rules by using array
            'name' => [
                'required',
                'string',
                'max:255',
                // Three way to define unique value (tablename , fieldname , condition)
                // 'unique:categories,name,' . $id,
                Rule::unique('categories', 'name')->ignore($id, 'id'),
                // (new Unique('categories', 'name'))->ignore($id),
            ],
            // Or define it by single string
            'parent_id' => 'nullable|int|exists:categories,id',         //هان لازم يكون الرقم موجود جوا حقل الاي دي في جدول الكاتيجوري 
            'description' => 'nullable|string|min:5',
            'image' => 'nullable|mimes:jpg,png'  // 70KB
        ];
    }

    protected function upload(UploadedFile $file)
    {
        if ($file->isValid()) {
            return $data['image'] = $file->store('thumbnails', [
                'disk' => 'public',
            ]);
        } else {
            throw ValidationException::withMessages([
                'image' => 'File Corrupted',
            ]);
        }
    }


    public function restore(Request $request, $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();


        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', "Category $category->name Restored");
    }
}
