<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function search()
    {
        $tukhoa = $_GET['tukhoa'];
        // Lấy giá trị từ tham số 'tukhoa' được gửi đến trong yêu cầu HTTP GET
        if ($tukhoa == '') {
            return redirect()->back();
        }
        // Kiểm tra nếu từ khóa tìm kiếm (tukhoa) rỗng, thì quay trở lại trang trước đó (back)
        // Lấy danh sách các sách từ cơ sở dữ liệu, chỉ lấy các sách có trạng thái 'active' và sắp xếp theo thời gian tạo giảm dần (mới nhất trước), giới hạn lấy 12 cuốn sách
        $results = DB::table('books')
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
            ->select(['books.id', DB::raw('MAX(books.book_photo) as book_photo'), 'books.name', 'books.view',
                'books.like','books.slug','books.title','books.author','books.sumary','books.status'])
            // Chọn các cột cần lấy từ bảng 'books', và sử dụng hàm MAX để lấy giá trị lớn nhất của cột 'book_photo'
            // (giả định rằng các bản ghi có cùng id sẽ có cùng giá trị 'book_photo')
            ->distinct()
            ->groupBy('books.id', 'books.book_photo', 'books.name', 'books.view', 'books.like','books.slug',
                'books.title','books.author','books.sumary','books.status')
            // Nhóm kết quả dựa trên các cột 'books.id', 'books.book_photo', 'books.name', 'books.view', 'books.like'
            // để loại bỏ các kết quả trùng lặp
            ->paginate(12);
        // Thực hiện truy vấn và lấy kết quả phù hợp với từ khóa, chia thành các trang với mỗi trang có tối đa 12 cuốn sách

        // Lấy danh sách các thể loại từ cơ sở dữ liệu, chỉ lấy các thể loại có trạng thái 'active' và sắp xếp theo thời gian tạo giảm dần (mới nhất trước)
        return view('admin/search/search', compact('results','tukhoa'));
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
}
