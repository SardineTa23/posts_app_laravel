@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Article Edit</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ Form::Model($article, ['route' => ['articles.update', $article->id]]) }}
                        {{ Form::hidden('_method', 'PATCH') }}
                        
                        {{ Form::label('title', 'タイトル') }}<br>
                        {{ Form::text('title') }}<br>

                        {{ Form::label('body', '本文') }}<br>
                        {{ Form::textarea('body') }}<br>

                        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
