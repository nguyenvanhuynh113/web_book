<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = DB::table('categories')->orderByDesc('created_at')->get();
        return view('admin/category/index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin/category/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'category_name' => $request->category_name,
            'slug' => $request->slug,
            'title' => $request->title,
            'status' => $request->status
        ]);
        return redirect()->back()->with('status', 'Add category sucess');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = DB::table('categories')->where('id', $id)->get()->first();
        return view('admin/category/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $check = DB::table('categories')->where('category_name', $request->category_name)
            ->where('id', '!=', $id)->first();
        if (is_null($check)) {
            DB::table('categories')->where('id', $id)->update([
                'category_name' => $request->category_name,
                'title' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
            return redirect()->back()->with('status', 'Updated category sucess');
        } else {
            return redirect()->back()->with('error', 'Category name is already exist');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('book_categories')->where('id_category', $id)->delete();
        Category::destroy($id);
        return redirect()->back()->with('status', 'Deleted category');
    }
}
