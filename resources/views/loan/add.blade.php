@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('book.index')}}">Livros</a></li>
                	<li class="active">Emprestar</li>
                </ol>
                <div class="panel-body">
                    <form action="{{ route('loan.save') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Livro</label>
                            <select name="book[]" class="form-control" multiple="" data-live-search="true" title="Livros">
                                @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach()
                            </select>
                            <p class="help-block">Use Crtl para selecionar mais de um livro.</p>
                        </div>
                        <br />
                        <button type="submit" class="btn btn-primary">Realizar empréstimo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
