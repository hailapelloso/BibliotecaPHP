<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use DB;

class BookController extends Controller
{

    private $path = 'images/book';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		$books = Book::paginate(10);
        $authors = Author::where('active', 1)->get();
        $selected_authors = [];

        return view('book.index', compact('books', 'authors', 'selected_authors'));
    }

    public function add()
    {
        $authors = Author::where('active', 1)->get();
        return view('book.add', compact('authors'));
    }

    public function save(Request $request)
    {

		if (!empty($request->file('image')) && $request->file('image')->isValid()) {
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($this->path, $fileName);
        }

    	$book = Book::create([
    		'title' => $request->input('title'), 
            'quantity' => $request->input('quantity'), 
    		'image' => $fileName
		]);

        if($book){
            $book->authors()->sync($request->input('author'));
        }        

    	return redirect()->route('book.index');	
    }

    public function edit($id)
    {
        $book = Book::find($id);

        if(!empty($book)){
            $authors = Author::where('active', 1)->get();
            $selected_authors = array();

            foreach ($book->authors as $author) {
                $selected_authors[] = $author->pivot->author_id;
            }
            return view('book.edit', compact('book', 'authors', 'selected_authors'));
        }

        return redirect()->route('book.index');
    }

    public function update(Request $request, $id)
    {
        $fileName = NULL;
        $author = $request->input('author');

        $book = Book::find($id);

        if(!empty($book)){

            if (!empty($request->file('image')) && $request->file('image')->isValid()) {
                if(!empty($request->input('deleteimage')) && file_exists($this->path . '/' . $request->input('deleteimage'))){
                    unlink($this->path . '/' . $request->input('deleteimage'));
                }
                $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move($this->path, $fileName);
            }

            if(!empty($author)){
                    $book->authors()->sync($author);
                }

            if(!$fileName){
                $book->update([
                    'title' => $request->input('title'), 
                    'quantity' => $request->input('quantity')
                ]);
            }else{
                $book->update([
                    'title' => $request->input('title'), 
                    'quantity' => $request->input('quantity'), 
                    'image' => $fileName
                ]);
            }
        }

        return redirect()->route('book.index');
    }

    public function delete($id)
    {
        $book = Book::find($id);

        if($book){
            $book->authors()->detach();
            $result = $book->delete();
        }

        return redirect()->route('book.index');        
    }

    public function search(Request $request)
    {
        $title = $request->input('title');
        $selected_authors = $request->input('author');

        $search = TRUE;

        $query = DB::table('books')
                    ->join('books_authors', 'books.id', '=', 'books_authors.book_id')
                    ->join('authors', 'books_authors.author_id', '=', 'authors.id')
                    ->select('books.id', 'books.title', 'books.image')
                    ->where('books.active', '=', 1)
                    ->groupBy('books.id', 'books.title', 'books.image');

        if(!empty($title) && !empty($selected_authors)){
            $query->where('books.title', 'like', '%' . $title . '%');
            $query->whereIn('authors.id', $selected_authors);
        }else if(!empty($title)){
            $query->where('books.title', 'like', '%' . $title . '%');
        }else if(!empty($selected_authors)){
            $query->whereIn('authors.id', $selected_authors);
        }

        $authors = Author::where('active', 1)->get();
        $books = $query->get();

        if(empty($selected_authors)){
            $selected_authors = [];
        }

        return view('book.index', compact('books', 'authors', 'selected_authors', 'search'));
    }
}
