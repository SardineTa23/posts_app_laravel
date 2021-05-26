@extends('layouts.app')
<?php use App\Models\Image; ?>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Article Index</div>

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
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Created</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($articles as $article)   
                                <tbody>
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td><img style='height: 100px;'
                                                src="/storage/{{ $article->id }}/{{ Image::find($article->thumbnail_id)->url }}" alt=""></td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->created_at }}</td>
                                        <th><a class="btn btn-light"
                                                href="{{ route('articles.show', ['id' => $article->id]) }}">Show</a>
                                        </th>
                                        @if (auth()->id() === $article->user_id)
                                            <th><a class='btn btn-success'
                                                    href="{{ route('articles.edit', ['id' => $article->id]) }}">Edit</a>
                                            </th>
                                            <th>
                                                {{ Form::open(['url' => "/articles/$article->id", 'method' => 'POST']) }}
                                                {{ Form::token() }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Destroy', ['class' => 'btn btn-danger']) }}
                                                {{ Form::close() }}
                                            </th>
                                        @endif
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
