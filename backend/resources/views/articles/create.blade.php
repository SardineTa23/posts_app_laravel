@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Article New</div>

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

                        {{ Form::open(['url' => '/articles', 'method' => 'POST', 'files' => true]) }}
                        {{ Form::hidden('user_id', auth()->id()) }}

                        {{ Form::label('title', 'タイトル') }}<br>
                        {{ Form::text('title', '') }}<br>

                        {{ Form::label('body', '本文') }}<br>
                        {{ Form::textarea('body', '') }}<br>

                        {{ Form::label('image1', 'サムネイル') }}<br>
                        {{ Form::file('image1') }}<br><br>

                        {{ Form::label('その他の画像') }}
                        {{ Form::file('image2') }}
                        {{ Form::file('image3') }}<br><br>
                        
                        {{ Form::label('タグの選択（複数選択可、Macの方はCommandキーを押しながら、WindowsのかたはCtrlキーを押しながらクリックしてください）') }}<br>
                        {{ Form::select('tag_id[]', array_pluck($tags, 'name', 'id'), old('user_id'), ['multiple' => 'multiple']) }}<br>

                        {{ Form::submit('送信ボタン', ['class' => 'btn btn-info']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
