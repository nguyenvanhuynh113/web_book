<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $statistics = DB::table('categories')
            ->select('categories.category_name', DB::raw('SUM(books.view) as total_views'))
            ->join('book_categories', 'categories.id', '=', 'book_categories.id_category')
            ->join('books', 'books.id', '=', 'book_categories.id_book')
            ->groupBy('categories.category_name')
            ->get();
        $types = DB::table('types')
            ->select('types.type_name', DB::raw('SUM(books.view) as total_views'))
            ->join('book_types', 'types.id', '=', 'book_types.id_type')
            ->join('books', 'books.id', '=', 'book_types.id_book')
            ->groupBy('types.type_name')
            ->orderBy('total_views', 'desc') // Sắp xếp theo tổng lượt xem giảm dần
            ->get();
        return view('home', compact('statistics', 'types'));
    }
}
