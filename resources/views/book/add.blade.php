@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('book.index')}}">Livros</a></li>
                	<li class="active">Adicionar</li>
                </ol>
                <div class="panel-body">
	                <form action="{{ route('book.save') }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="title">Título</label>
						    <input type="text" class="form-control" name="title" id="title" placeholder="Título">
						</div>
                        <div class="form-group">
                            <label for="quantity">Quantidade</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantidade" min="1" max="99999">
                        </div>                        
                        <div class="form-group">
                            <label for="name">Autores</label>
                            <select name="author[]" class="form-control " multiple="" data-live-search="true" title="Autores">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach()
                            </select>
                            <p class="help-block">Use Crtl para selecionar.</p>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input name="image" type="file">
                            </div>
                        </div>
                        <br />
						<button type="submit" class="btn btn-primary">Salvar</button>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
