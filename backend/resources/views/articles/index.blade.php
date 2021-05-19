@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Post Index</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('articles.create') }}" class='btn btn-primary'>新規作成</a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>img</th>
                                <th>title</th>
                                <th>date</th>
                                <th></th>
                            </tr>
                            </thead>
                            @foreach ($articles as $article)
                                <tbody>
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>{{ $article->thumbnail_id }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->created_at }}</td>
                                    <th><a href="{{ route('articles.show', ['article'=> $article->id ]) }}">show</a></th>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection