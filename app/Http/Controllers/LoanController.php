<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use DB;
use Auth;

class LoanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search = TRUE;

        $sql = DB::table('books')
                    ->join('books_loans', 'books.id', '=', 'books_loans.book_id')
                    ->join('loans', 'books_loans.loan_id', '=', 'loans.id')
                    ->select('loans.id', 'books.image', 'books.title', 'loans.start_date', 'loans.end_date');
        $sql->where('loans.user_id', '=', Auth::user()->id);
        $sql->where('loans.devolution_date', '=', null);

        $books = Book::get();
        $loans = $sql->get();

        if(empty($selected_book)){
            $selected_book = [];
        }

        return view('loan.index', compact('loans', 'books', 'selected_book', 'search'));
    }

    public function add()
    {
        $books = Book::get();
        return view('loan.add', compact('books'));
    }

    public function save(Request $request)
    {
        $books = $request->input('book');

        foreach ($books as $book) {

            $loan = Loan::create([
                'start_date' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'end_date' => Carbon::now()->addDays(7),
                'devolution_date' => null
            ]);

            $loan->books()->sync($book);
        }

        return redirect()->route('loan.index');
    }

    public function devolve($id)
    {
        $update =[
            'devolution_date' => Carbon::now()
        ];

        $result = Loan::find($id)->update($update);

        return redirect()->route('loan.index');
    }

    public function search(Request $request)
    {
        $title = $request->input('title');

        $search = TRUE;

        $query = DB::table('books')
                    ->join('books_loans', 'books.id', '=', 'books_loans.book_id')
                    ->join('loans', 'books_loans.loan_id', '=', 'loans.id')
                    ->select('loans.id', 'books.image', 'books.title', 'loans.start_date', 'loans.end_date');
        $query->where('loans.user_id', '=', Auth::user()->id);
        $query->where('loans.devolution_date', '=', null);

        if(!empty($title)){
            $query->where('books.title', 'like', '%' . $title . '%');
        }

        $loans = $query->get();

        return view('loan.index', compact('loans', 'search'));
    }

}