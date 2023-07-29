<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $book = $cat->books()->where('status', 'active')->paginate(12);
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/category/index', compact('book', 'carousel', 'type', 'cat'));
    }

    //Xem sản phẩm trong một thể loại
    public function getbookbytype($id)
    {
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        $types = Type::find($id);
        $book = $types->books()->where('status', 'active')->paginate(12);
        $typename = DB::table('types')->where('id', '=', $id)->first();
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        return view('client/type/index', compact('carousel', 'type', 'typename', 'book'));
    }

    //Xem chi chiet sach -- Tom tat tac gia tac pham --- Danh sach chuong
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
        // Lấy giá trị từ tham số 'tukhoa' được gửi đến trong yêu cầu HTTP GET
        if ($tukhoa == '') {
            return redirect()->back();
        }
        // Kiểm tra nếu từ khóa tìm kiếm (tukhoa) rỗng, thì quay trở lại trang trước đó (back)
        $carousel = DB::table('books')->where('status', 'active')->orderByDesc('created_at')->take(12)->get();
        // Lấy danh sách các sách từ cơ sở dữ liệu, chỉ lấy các sách có trạng thái 'active' và sắp xếp theo thời gian tạo giảm dần (mới nhất trước), giới hạn lấy 12 cuốn sách
        $book = DB::table('books')
            ->join('book_categories', 'books.id', '=', 'book_categories.id_book')
            ->join('categories', 'book_categories.id_category', '=', 'categories.id')
            ->join('book_types', 'books.id', '=', 'book_types.id_book')
            ->join('types', 'book_types.id_type', '=', 'types.id')
            // Thực hiện các liên kết giữa các bảng để lấy thông tin sách, danh mục, thể loại và tác giả
            ->where(function ($query) use ($tukhoa) {
                // Sử dụng hàm where để thực hiện các điều kiện tìm kiếm phù hợp với từ khóa
                // Kiểm tra nếu 'tên sách', 'tên danh mục', 'tên thể loại' hoặc 'tên tác giả' có chứa từ khóa
                $query->where('books.name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('categories.category_name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('types.type_name', 'LIKE', '%' . $tukhoa . '%')
                    ->orWhere('books.author', 'LIKE', '%' . $tukhoa . '%');
            })
            ->select(['books.id', DB::raw('MAX(books.book_photo) as book_photo'), 'books.name', 'books.view', 'books.like'])
            // Chọn các cột cần lấy từ bảng 'books', và sử dụng hàm MAX để lấy giá trị lớn nhất của cột 'book_photo'
            // (giả định rằng các bản ghi có cùng id sẽ có cùng giá trị 'book_photo')
            ->distinct()
            ->groupBy('books.id', 'books.book_photo', 'books.name', 'books.view', 'books.like')
            // Nhóm kết quả dựa trên các cột 'books.id', 'books.book_photo', 'books.name', 'books.view', 'books.like'
            // để loại bỏ các kết quả trùng lặp
            ->paginate(12);
        // Thực hiện truy vấn và lấy kết quả phù hợp với từ khóa, chia thành các trang với mỗi trang có tối đa 12 cuốn sách
        $type = DB::table('types')->where('status', 'active')->orderByDesc('created_at')->get();
        // Lấy danh sách các thể loại từ cơ sở dữ liệu, chỉ lấy các thể loại có trạng thái 'active' và sắp xếp theo thời gian tạo giảm dần (mới nhất trước)
        return view('client/home/search', compact('type', 'book', 'carousel'));
        // Trả về view 'client/home/search' với các dữ liệu được gửi đến là 'type', 'book', 'carousel' để hiển thị trong giao diện tìm kiếm sách.
    }

    // Tìm kiếm thông minh bằng ajax query
    public function searchSuggestions(Request $request)
    {
        $tukhoa = $request->get('query');
        // Lấy giá trị của tham số 'query' từ yêu cầu HTTP gửi đến, là từ khóa tìm kiếm nhập bởi người dùng
        $suggestions = DB::table('books')
            ->join('book_categories', 'books.id', '=', 'book_categories.id_book')
            ->join('categories', 'book_categories.id_category', '=', 'categories.id')
            ->join('book_types', 'books.id', '=', 'book_types.id_book')
            ->join('types', 'book_types.id_type', '=', 'types.id')
            // Thực hiện các liên kết giữa các bảng để tìm kiếm thông tin phù hợp

            ->where(function ($query) use ($tukhoa) {
                // Sử dụng hàm where để thực hiện các điều kiện tìm kiếm phù hợp với từ khóa

                // Kiểm tra nếu 'tên sách', 'tên danh mục', 'tên thể loại' hoặc 'tên tác giả' có chứa từ khóa
                $query->whereRaw('LOWER(books.name) LIKE ?', ['%' . strtolower($tukhoa) . '%'])
                    ->orWhereRaw('LOWER(categories.category_name) LIKE ?', ['%' . strtolower($tukhoa) . '%'])
                    ->orWhereRaw('LOWER(types.type_name) LIKE ?', ['%' . strtolower($tukhoa) . '%'])
                    ->orWhereRaw('LOWER(books.author) LIKE ?', ['%' . strtolower($tukhoa) . '%']);
            })
            ->selectRaw('LOWER(categories.category_name) as category_name, LOWER(types.type_name) as type_name, LOWER(books.name) as name, LOWER(books.author) as author')
            // Chọn các cột cần lấy từ các bảng, và chuyển đổi chúng về dạng chữ thường (lowercase)

            ->groupBy('category_name', 'type_name', 'name', 'author')
            // Nhóm kết quả dựa trên các cột 'category_name', 'type_name', 'name', 'author' để loại bỏ các kết quả trùng lặp

            ->distinct() // Loại bỏ những kết quả trùng lặp

            ->get();
        // Thực hiện truy vấn và lấy kết quả phù hợp với từ khóa

        return response()->json($suggestions);
        // Trả về kết quả dạng JSON chứa các gợi ý tìm kiếm phù hợp với từ khóa nhập bởi người dùng
    }

    //Xem thong tin nguoi dung
    public function profile($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        return view('client/user/profile', compact('users'));
    }

    // Cap nhat hinh anh cua nguoi dung
    public function capnhatuser(Request $request, $id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $url = "http://127.0.0.1:8000/images/" . $imageName;
        } else {
            $url = $data->user_photo;
        }
        DB::table('users')->where('id', $id)->update([
            'user_photo' => $url
        ]);
        return redirect()->back()->with('status', 'Cập nhật ảnh đại diện thành công');
    }

    // Theo doi truyen sach
    public function theodoi($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('status', 'Register or Login now !!');
        } else {
            $user = User::find(Auth::user()->id);
            $user->likes()->attach($id);
            return redirect()->back()->with('status', 'Followed books success !!');
        }
    }

    // Bo theo doi truyen sach
    public function botheodoi($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('status', 'Register or Login now !!');
        } else {
            $user = User::find(Auth::user()->id);
            $user->likes()->detach($id);
            return redirect()->back()->with('status', 'Unfollowed books success !!');
        }
    }
}
