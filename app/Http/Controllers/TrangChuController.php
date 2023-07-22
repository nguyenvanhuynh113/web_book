<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
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
        $book = DB::table('books')->where('id_category', '=', $id)->where('status', 'active')->paginate(12);
        $cat = DB::table('categories')->where('id', '=', $id)->first();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/category/index', compact('book', 'carousel', 'type', 'cat'));
    }

//    Xem sản phẩm trong một thể loại
    public function getbookbytype($id)
    {
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $book = DB::table('books')->where('id_type', '=', $id)->where('status', 'active')->paginate(12);
        $typename = DB::table('types')->where('id', '=', $id)->first();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/type/index', compact('carousel', 'type', 'typename', 'book'));
    }

//Xem chi tiết sản phẩm
    public function bookdetail($id)
    {
        $lasted_chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderBy('id', 'DESC')->first();
        $first_chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderBy('id', 'ASC')->first();
        $book = DB::table('books')->where('id', '=', $id)->where('status', 'active')->first();
        $chapter = DB::table('chapters')->where('id_book', $id)->where('status', '=', 'active')->orderByDesc('created_at')->get();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        $bookofcat = DB::table('books')->where('id_category', '=', $book->id_category)->where('status', 'active')->take('12')->get();
        return view('client/book/index', compact('type', 'book', 'chapter', 'lasted_chapter', 'first_chapter', 'bookofcat'));
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
            'view'=>$book->view + '1'
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
        $book = DB::table('books')->join('categories', 'categories.id', '=', 'books.id_category')
            ->join('types', 'types.id', '=', 'books.id_type')
            ->where('name', 'LIKE', '%' . $tukhoa . '%')
            ->orWhere('category_name', 'LIKE', '%' . $tukhoa . '%')
            ->orWhere('type_name', 'LIKE', '%' . $tukhoa . '%')
            ->orWhere('author', 'LIKE', '%' . $tukhoa . '%')->select(['books.id','books.book_photo','books.name'])
            ->paginate('12');
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/home/search', compact('type', 'book', 'carousel'));
    }

    // Tìm kiếm thông minh bằng ajax query
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        $suggestions =DB::table('books')->join('categories', 'categories.id', '=', 'books.id_category')
            ->join('types', 'types.id', '=', 'books.id_type')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('category_name', 'LIKE', '%' . $query . '%')
            ->orWhere('type_name', 'LIKE', '%' . $query . '%')
            ->orWhere('author', 'LIKE', '%' . $query . '%')
            ->pluck('books.name'); // Lấy tên các sản phẩm phù hợp để gợi ý
        return response()->json($suggestions);
    }
    public function like($id){
        $book = DB::table('books')->where('id', '=', $id)->where('status', 'active')->first();
        DB::table('books')->where('id', '=', $id)->update([
            'like'=>$book->like + '1'
        ]);
        return redirect()->back()->with('status','Liked');
    }
}
