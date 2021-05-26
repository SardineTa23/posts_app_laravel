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
                                    <h3 for="">Body</h3>
                                    <p>{{ $article->body }}</p><br>
                                </div><br>
                                <div>
                                    <h3 for="">Images</h3><br>
                                    @foreach ($article->images as $image)
                                        <img style="width: 200px" src="/storage/{{ $article->id }}/{{ $image->url }}"
                                            alt="">
                                    @endforeach
                                </div><br>
                                <div>
                                    <h3 for="">Tags</h3><br>
                                    @foreach ($article->tags as $tag)
                                        <p style="display: inline-block">{{ $tag->name }}</p>
                                    @endforeach
                                </div>
                                <div>
                                    <h3 for="">User</h3><br>
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
