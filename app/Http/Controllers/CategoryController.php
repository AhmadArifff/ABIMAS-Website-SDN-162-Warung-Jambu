<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();

        $menu = 'Category';
        $categories = \App\Category::paginate(10);
        return view('categories.index', ['categories'=>$categories, 'menu'=>$menu, 'pembiasaan_all'=>$pembiasaan_all, 'kesiswaa_all'=>$kesiswaa_all, 'ekstrakurikuler_all'=>$ekstrakurikuler_all, 'penghargaan_all'=>$penghargaan_all, 'tatatertib_all'=>$tatatertib_all, 'user_all'=>$user_all]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'name'          => 'required|min:2|max:20|unique:categories',
            'description'   => 'required',
            'image'         => 'required',
        ])->validate();

        $new_category = new \App\Category;
        $new_category->name         = strtoupper($request->get('name'));
        $new_category->description  = $request->get('description');
        $new_category->create_by    = \Auth::user()->id;
        $new_category->slug         = \Str::slug($request->get('name'), '-');

        if($request->file('image')){
            // $image_path = $request->file('image')->store('category_image', 'public');
            $nama_file = time()."_".$request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->move('category_image', $nama_file);
            $new_category->image = $nama_file;
        }

        $new_category->save();
        return redirect()->route('categories.index')->with('success', 'Category successfully created');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();

        $menu = 'Category';
        $category = \App\Category::findOrFail($id);
        return view('categories.edit', ['category'=>$category, 'menu'=>$menu, 'pembiasaan_all'=>$pembiasaan_all, 'kesiswaa_all'=>$kesiswaa_all, 'ekstrakurikuler_all'=>$ekstrakurikuler_all, 'penghargaan_all'=>$penghargaan_all, 'tatatertib_all'=>$tatatertib_all, 'user_all'=>$user_all]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = \App\Category::findOrFail($id);

        \Validator::make($request->all(),[
            'name'          => 'required|min:2|max:20',
            'description'   => 'required',
            'slug'          => 'required',
        ])->validate();
        
        $category->name         = $request->get('name');
        $category->description  = $request->get('description');
        $category->slug         = $request->get('slug');
        

        if($request->file('image')){
            // ebook
            // if($category->image && file_exists(storage_path('app/public/'.$category->image))){
            //     \Storage::delete('public/'.$category->image);
            // }
            // $new_image = $request->file('image')->store('category_image', 'public');
            
            if($category->image){
                File::delete('category_image/'.$category->image);
            }
            // $new_image = $request->file('image')->store('category_image', 'public');
            $nama_file = time()."_".$request->file('image')->getClientOriginalName();
            $new_image = $request->file('image')->move('category_image', $nama_file);

            $category->image = $nama_file;
        }

        $category->update_by    = \Auth::user()->id;
        $category->slug         = \Str::slug($request->get('name'));

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\Category::findOrFail($id);
        $category->articles()->sync([]);
        if($category->image){
            File::delete('category_image/'.$category->image);
        }
        $category->forceDelete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted.');
    }

    public function restore($id){
        $category = \App\Category::withTrashed()->findOrFail($id);
        $category->restore();
    }

    public function deletePermanent($id){
        $category = \App\Category::withTrashed()->findOrFail($id);
        $category->articles()->sync([]);

        // if($category->image && file_exist(storage_path('app/public/'.$category->image))){
        //     \Storage::delete('public/'.$category->image);
        // }
        if($category->image){
            File::delete('category_image/'.$category->image);
        }
        $category->forceDelete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted.');
    }



    // ajax select2
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = \App\Category::where('name', 'Like', "%$keyword%")->get();
        return $categories;
    }

}
