@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-between">
        <div class="col-md-6">
          <img src="{{ Storage::url($post->image) }}" style="object-fit:cover; width: 100%; height: 400px;" class="card-img-top" alt="">
        </div>
        <div class="col-md-5">
            <h4 class="card-title">{{$post->title}}</h4>
            <div class="row justify-content-start">
                <img src="{{ Storage::url($post->user['image']) }}" style="object-fit:cover; width: 40px; height: 40px;" class="card-img-top ml-3" alt="">
                <a href="{{ route('users.show', $post->user['id']) }}" class="card-text mt-2 ml-3">{{$post->user['name']}}</a>
            </div>
            <p class="card-text">{{$post->content}}</p>
            <p class="card-text">￥{{$post->price}}</p>
        </div>
    </div>


    <!-- いふぶん作る -->
    @can('isAdmin')
    <form action="/posts/{{$post->id}}" method="POST">
    @method('DELETE')
    @csrf
        <div class="row justify-content-center">
            <input type="submit" class="btn btn-danger mt-3" value="削除する">
        </div>
    </form>


    @else
    @if($post->user_id == auth()->id())
        <div class="row justify-content-end">
        <button type="submit" class="btn btn-outline-primary mb-3"><a href="{{ route('posts.edit', $post->id) }}">編集</a></button>
        </div>
    @elseif(auth()->id() == null)
        <div class="row justify-content-between">
            <a href="{{ route('login') }}" class="btn btn-danger">違反報告</a>
            <div>
                <a href="{{ route('login') }}" class="btn btn-primary">依頼する</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">依頼取消</a>
            </div>
        </div>
    @else
        <div class="row justify-content-between">
            <a href="{{route('violations.create', $post->id)}}" class="btn btn-danger">違反報告</a>
            <div>
                <a href="{{route('offers.create', $post->id)}}" class="btn btn-primary">依頼する</a>
                <a href="" class="btn btn-secondary">依頼取消</a>
            </div>
        </div>
    @endif
    @endcan

    <div class="row justify-content-center">
        <input value="もどる" type="button" onClick="location.href='/posts';">
    </div>

</div>
@endsection
