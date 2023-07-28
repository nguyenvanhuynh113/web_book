<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use GuzzleHttp\Client;
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
            $audioUrl = $this->convertTextToSpeech($request->input('content'));
            dd($audioUrl);
            if ($request->hasFile('book_photo')) {
                $image = $request->file('book_photo');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $url = "http://127.0.0.1:8000/images/" . $imageName;
            }
            $book = Book::create([
                'name' => $request->name,
                'title' => $request->title,
                'slug' => $request->slug,
                'author' => $request->author,
                'sumary' => $request->input('content'),
                'book_photo' => $url,
                'audio' => $audioUrl,
                'status' => $request->status,
            ]);
            $book->categories()->attach($request->category);
            $book->types()->attach($request->type);
            return redirect()->back()->with('status', 'Add book sucess');
        } else {
            return redirect()->back()->with('error', 'Book name already exist');
        }
    }

    private function convertTextToSpeech($text)
    {
        // Gọi MaryTTS API (hoặc dịch vụ Text-to-Speech khác)
        // Giả sử hàm này chuyển đổi văn bản thành giọng nói tiếng Việt và trả về URL tệp audio
        // Ví dụ:
        $apiEndpoint = "https://mary.dfki.de:59125/process?INPUT_TYPE=TEXT&AUDIO=WAVE_FILE&LOCALE=vi_VN&INPUT_TEXT=" . urlencode($text);
        $client = new Client();
        $response = $client->get($apiEndpoint);
        $audioData = $response->getBody()->getContents();
        $tempFileName = time() . '_speech.wav';
        file_put_contents(public_path($tempFileName), $audioData);
        $audioUrl = asset($tempFileName);
        // Trong ví dụ này, hãy giả sử chúng ta trả về URL giả lập để không thực hiện thực tế
        return 'http://example.com/audio/' . $audioUrl . '.wav';
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
        $id = Book::find($id);
        $categories = $id->categories;
        $types = $id->types;
        $category = DB::table('categories')->get();
        $type = DB::table('types')->get();
        return view('admin/book/edit', compact('category', 'book', 'type', 'categories', 'types'));
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
        $books = DB::table('books')->where('id', $id)->first();
        if (is_null($check)) {
            if ($request->hasFile('book_photo')) {
                $image = $request->file('book_photo');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $url = "http://127.0.0.1:8000/images/" . $imageName;
            } else {
                $url = $books->book_photo;
            }
            $book = Book::find($id);
            DB::table('books')->where('id', $id)->update([
                'name' => $request->name,
                'title' => $request->title,
                'slug' => $request->slug,
                'author' => $request->author,
                'sumary' => $request->input('content'),
                'book_photo' => $url,
                'status' => $request->status,
            ]);
            $book->categories()->sync($request->category);
            $book->types()->sync($request->type);
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
        $book = Book::with('chapter')->find($id);
        if ($book) {
            return redirect()->back()->with('error', 'Sách đang hoạt động, Không thể xóa');
        }
        $book->types()->detach();
        $book->categories()->detach();
        $book->delete();
        return redirect()->back()->with('status', 'Deleted book sucess');
    }

    public function getchapter($id)
    {
        $chapter = DB::table('chapters')->leftJoin('books', 'books.id', '=', 'chapters.id_book')
            ->select('chapters.*')
            ->where('books.id', $id)->get();
        return view('admin/chapter/index', compact('chapter'));
    }

}
