@extends('layouts.app')

@section('content')
<div class="container">
    
    <h4 class="row justify-content-center">ユーザーページ</h4>


    <div class="row justify-content-center">
        <div class="col-4 mt-4">
          <img src="{{ Storage::url($user->image) }}" style="object-fit:cover; width: 200px; height: 200px;" class="card-img-top" alt="">
        </div>
        <div class="col-5 mt-4">
            <p class="card-text">{{$user->name}}</p>
        </div>
    </div>


    <div class="row justify-content-center mt-4">
        <h5>【投稿リスト】</h5>
    </div>

    <div class="row justify-content-start">
        @foreach($posts as $post)
            <div class="col-4 mb-4">
                <div class="card" style="width: 20rem;">
                    <img src="{{ Storage::url($post->image) }}" style="object-fit:cover; width: 100%; height: 15rem;" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">￥{{$post->price}}</p>
                        <a href="/posts/{{$post->id}}" class="btn btn-primary">詳しくみる</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @can('isAdmin')

        <table class="table table-striped">
            <thead>
                <tr>
                <th>日付</th>
                <th>内容</th>
                <th>報告ユーザー</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($violations as $violation)
                <tr>
                <td>{{ $violation->created_at }}</td>
                <td>{{ $violation->content }}</td>
                <td>{{ $violation->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @else
    @endcan

</div>
@endsection
