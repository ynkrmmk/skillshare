@extends('layouts.app')

@section('content')
<div class="container">
    
    <h4 class="row justify-content-center">マイページ</h4>


    <div class="row justify-content-center">
        <div class="col-4 mt-4">
          <img src="{{ Storage::url(Auth::user()->image) }}" style="object-fit:cover; width: 200px; height: 200px;" class="card-img-top" alt="">
        </div>
        <div class="col-5 mt-4">
            <p class="card-text">{{Auth::user()->name}}</p>
            <p class="card-text">{{Auth::user()->email}}</p>
        </div>
    </div>

    <div class="row justify-content-end">
        <div>
            <div class="row justify-content-center">
                <a href="users/{{Auth::id()}}/edit" class="btn btn-primary mt-3">編集</a>
            </div>
            
            <form action="/users/{{Auth::id()}}" method="POST">
            @method('DELETE')
            @csrf
                <div class="row justify-content-center">
                    <input type="submit" class="btn btn-danger mt-3" value="削除する">
                </div>
            </form>
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

    <div class="row justify-content-center mt-4">
        <h5>【依頼されたもの】</h5>
    </div>

    <div class="row justify-content-start">
        @foreach($myPosts as $post)
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

    <div class="row justify-content-center mt-4">
        <h5>【依頼したもの】</h5>
    </div>

    <div class="row justify-content-start">
        @foreach($toPosts as $post)
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



</div>
@endsection
