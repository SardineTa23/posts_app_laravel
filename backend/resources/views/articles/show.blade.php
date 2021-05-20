@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Article Show</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <p>{{ $article->title }}</p>
                            </div>
                            <div class="card-body">
                                <div>
                                    <label for="">Body</label>
                                    <p>{{ $article->body }}</p><br>
                                </div><br>
                                <div>
                                    <label for="">Images</label><br>
                                    @foreach ($article->images as $image)
                                        <img style="width: 200px" src="/storage/{{ $article->id }}/{{ $image->url }}" alt="">
                                    @endforeach
                                </div><br>
                                <div>
                                    <label for="">User</label><br>
                                    <p>{{ $article->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
