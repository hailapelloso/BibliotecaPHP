@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ol class="breadcrumb panel-heading">
                    <li class="active">Empréstimo</li>
                </ol>
                <div class="panel-body">
                    <form class="form-inline" action="{{ route('loan.search') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="{{route('loan.add')}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Realizar novo empréstimo</a></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Livro">
                        </div>
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Título</th>
                                <th>Imagem</th>
                                <th>Data Inicial</th>
                                <th>Data Final</th>                                
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <th scope="row" class="text-center">{{ $loan->id }}</th>
                                    <td>{{ $loan->title }}</td>
                                    <td class="center">
                                        <img src="http://localhost/images/book/{{ $loan->image }}"  width="10%" />
                                    </td>
                                    <td>{{ $loan->start_date }}</td>
                                    <td>{{ $loan->end_date }}</font></td>
                                    <td class="text-center">
                                        <a href="{{route('loan.devolve', $loan->id)}}" class="btn btn-primary btn-sm">Devolver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection