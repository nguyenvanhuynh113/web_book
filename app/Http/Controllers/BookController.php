<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = DB::table('books')->orderByDesc('created_at')->get();
        return view('admin/book/index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = DB::table('categories')->get();
        $type = DB::table('types')->get();
        return view('admin/book/create', compact('category', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $check = DB::table('books')->where('name', $request->name)->first();
        if (is_null($check)) {
            if ($request->hasFile('book_photo')) {
                $image = $request->file('book_photo');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $url = "http://127.0.0.1:8000/images/" . $imageName;
            }
            Book::create([
                'name' => $request->name,
                'title' => $request->title,
                'slug' => $request->slug,
                'author' => $request->author,
                'sumary' => $request->input('content'),
                'book_photo' => $url,
                'status' => $request->status,
                'id_category' => $request->id_category,
                'id_type' => $request->id_type
            ]);
            return redirect()->back()->with('status', 'Add book sucess');
        } else {
            return redirect()->back()->with('error', 'Book name already exist');
        }

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
        $book = DB::table('books')->where('id', $id)->first();
        $category = DB::table('categories')->get();
        $type = DB::table('types')->get();
        return view('admin/book/edit', compact('category', 'book', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        //
        $check = DB::table('books')->where('name', $request->name)->where('id', '!=', $id)->first();
        $book = DB::table('books')->where('id', $id)->first();
        if (is_null($check)) {
            if ($request->hasFile('book_photo')) {
                $image = $request->file('book_photo');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $url = "http://127.0.0.1:8000/images/" . $imageName;
            } else {
                $url = $book->book_photo;
            }
            DB::table('books')->where('id', $id)->update([
                'name' => $request->name,
                'title' => $request->title,
                'slug' => $request->slug,
                'author' => $request->author,
                'sumary' => $request->input('content'),
                'book_photo' => $url,
                'status' => $request->status,
                'id_category' => $request->id_category,
                'id_type' => $request->id_type
            ]);
            return redirect()->back()->with('status', 'Updated book sucess');
        } else {
            return redirect()->back()->with('error', 'Book name already exist');
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->back()->with('status', 'Deleted book sucess');
    }

    public function getchapter($id)
    {
        $chapter=DB::table('chapters')->leftJoin('books','books.id','=','chapters.id_book')
            ->select('chapters.*')
            ->where('books.id',$id)->get();
        return view('admin/chapter/index',compact('chapter'));
    }

}
