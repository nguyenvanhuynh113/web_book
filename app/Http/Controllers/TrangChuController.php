<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrangChuController extends Controller
{
    //    Trang chủ
    public function index()
    {
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        $book = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->paginate('6');
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $new = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(6)->get();
        $view = DB::table('books')->where('status', 'active')->orderByDesc('view')->take(6)->get();
        return view('client/home/trangchu', compact('book', 'carousel', 'new', 'view', 'type'));
    }

//    Xem sản phẩm trong một danh mục
    public function getbookbyId($id)
    {
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $cat = Category::find($id);
        $book = $cat->bookcategory()->where('status', 'active')->paginate(12);
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/category/index', compact('book', 'carousel', 'type', 'cat'));
    }

//    Xem sản phẩm trong một thể loại
    public function getbookbytype($id)
    {
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $types = Type::find($id);
        $book = $types->books()->where('status', 'active')->paginate(12);
        $typename = DB::table('types')->where('id', '=', $id)->first();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/type/index', compact('carousel', 'type', 'typename', 'book'));
    }

//Xem chi tiết sản phẩm
    public function bookdetail($id)
    {
        $books = Book::find($id);
        $typeofbook = $books->types;
        foreach ($typeofbook as $value) {
            $idtype = $value->id;
            $types = Type::find($idtype);
            $bookoftypes = $types->books()->where('status', 'active')->paginate(12);
        }
        $lasted_chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderBy('id', 'DESC')->first();
        $first_chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderBy('id', 'ASC')->first();
        $book = DB::table('books')->where('id', '=', $id)->where('status', 'active')->first();
        $chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderByDesc('created_at')->get();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/book/index', compact('type', 'book', 'chapter', 'lasted_chapter', 'first_chapter', 'bookoftypes', 'idtype'));
    }

//    Xem chi tiết nội dung một chương
    public function chapterdetail($id)
    {
        $chapter = DB::table('chapters')->where('id', $id)->where('status', '=', 'active')->first();
        $id_book = $chapter->id_book;
        $book = DB::table('books')->where('id', '=', $id_book)->where('status', 'active')->first();
        $currentChapter = DB::table('chapters')->where('id_book', $id_book)->first(); // Lấy thông tin chương hiện tại
        $nextChapter = DB::table('chapters')->where('id_book', $id_book)
            ->where('id', '>', $id)
            ->orderBy('id')
            ->first();
        $preChapter = DB::table('chapters')->where('id_book', $id_book)
            ->where('id', '<', $id)
            ->orderBy('id')
            ->first();
        $listchap = DB::table('chapters')->where('id_book', $id_book)->where('status', '=', 'active')->get();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        DB::table('books')->where('id', '=', $id_book)->update([
            'view' => $book->view + '1'
        ]);
        return view('client/book/viewchap', compact('chapter', 'book', 'listchap', 'type', 'currentChapter', 'nextChapter', 'preChapter'));
    }

//    Tìm kiếm sách truyện trong thể loại danh mục tên tác giả tác phẩm
    public function search()
    {
        $tukhoa = $_GET['tukhoa'];
        if ($tukhoa == '') {
            return redirect()->back();
        }
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $book = DB::table('books')->join('book_categories', 'books.id', '=', 'book_categories.id_book')
            ->join('categories', 'book_categories.id_category', '=', 'categories.id')
            ->join('book_types', 'books.id', '=', 'book_types.id_book')
            ->join('types', 'book_types.id_type', '=', 'types.id')
            ->where(function ($query) use ($tukhoa) {
                $query->where('books.name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('categories.category_name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('types.type_name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('books.author', 'LIKE', '%' . $tukhoa . '%');
            })
            ->select(['books.id', 'books.book_photo', 'books.name', 'books.view', 'books.like'])
            ->distinct()
            ->paginate(12);
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/home/search', compact('type', 'book', 'carousel'));
    }

    // Tìm kiếm thông minh bằng ajax query
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        $suggestions = DB::table('books')->join('categories', 'categories.id', '=', 'books.id_category')
            ->join('types', 'types.id', '=', 'books.id_type')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('category_name', 'LIKE', '%' . $query . '%')
            ->orWhere('type_name', 'LIKE', '%' . $query . '%')
            ->orWhere('author', 'LIKE', '%' . $query . '%')
            ->pluck('books.name'); // Lấy tên các sản phẩm phù hợp để gợi ý
        return response()->json($suggestions);
    }

    public function like($id)
    {
        $book = DB::table('books')->where('id', '=', $id)->where('status', 'active')->first();
        DB::table('books')->where('id', '=', $id)->update([
            'like' => $book->like + '1'
        ]);
        return redirect()->back()->with('status', 'Liked');
    }

    public function profile($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        return view('client/user/profile', compact('users'));
    }

    public function capnhatuser(Request $request, $id)
    {
        $data=DB::table('users')->where('id',$id)->first();
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $url = "http://127.0.0.1:8000/images/" . $imageName;
        }
        else{
            $url=$data->user_photo;
        }
        DB::table('users')->where('id', $id)->update([
            'user_photo' => $url
        ]);
        return redirect()->back()->with('status', 'Cập nhật ảnh đại diện thành công');
    }

}
