@extends('layouts.app')

@section('content')

@can('isAdmin')

<div class="row justify-content-center">
    <h2>管理者ページ</h2>
</div>

<div class="row justify-content-center">
    <div>
        <div class="row justify-content-center mt-4">
            <h5>【ユーザーリスト】</h5>
        </div>
        @foreach($users as $user)
            <div class="col-6 mt-4">
                <div class="card" style="width: 24rem;">
                    <a href="{{ route('users.show', $user->id) }}" class="card-text">{{$user->name}}</a>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        <div class="row justify-content-center mt-4">
            <h5>【投稿リスト】</h5>
        </div>
        @foreach($violation_posts as $post)
            <div class="col-4 mt-4">
                <div class="card" style="width: 20rem;">
                    <img src="{{ Storage::url($post->image) }}" class="card-img-top" alt="">
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




@else
<div class="container">
    <div class="row justify-content-between">
        <div class="col-4">
            <a href="{{route('posts.create')}}" class="btn btn-primary">新規投稿</a>
        </div>
        <div class="col-auto">
            <form action="{{ route('posts.index') }}" method="GET" class="container">
            @csrf
                <div class="form-group row">
                    <label for="inputEmail3" class="col-6 col-form-label">検索ワード</label>
                    <div class="col-6">
                        <input type="text" id="search" name="search" value="@if (isset($search)) {{ $search }} @endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-4 col-form-label">金額</label>
                    <div class="col-8">
                        <select name="start" id="start">
                            <option>{{$start}}</option>
                            <option>0</option>
                            <option>1000</option>
                            <option>2000</option>
                            <option>3000</option>
                            <option>4000</option>
                            <option>5000</option>
                            </select>〜

                            <select name="end" id="end" value="@if (isset($end)) {{ $end }} @endif">
                            <option>{{$end}}</option>
                            <option>1000</option>
                            <option>2000</option>
                            <option>3000</option>
                            <option>4000</option>
                            <option>5000</option>
                            <option>6000</option>
                        </select>円
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary">検索</button>
                        <a href="/posts" class="btn btn-secondary">クリア</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


  @if(isset($posts))

   <input type="hidden" id="count" value=0>

    <div id="content" class="row justify-content-start">
        @foreach($posts as $post)
            <div class="col-4 mb-4">
                <div class="card" style="width: 23rem;">
                    <img src="{{ Storage::url($post->image) }}" style="object-fit:cover; width: 100%; height: 15rem;" class="card-img-top" alt="">
                    <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <input type="hidden" class="card-text" value="{{$post->content}}">
                    <p class="card-text">￥{{$post->price}}</p>
                    <a href="/posts/{{$post->id}}" class="btn btn-primary">詳しくみる</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

  @endif

</div>
@endcan
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(function(){
    var count = 0;
      // スクロールされた時に実行 
    $(window).on("scroll", function () {
    // スクロール位置
        var document_h = $(document).height();              
        var window_h = $(window).height() + $(window).scrollTop();    
        var scroll_pos = (document_h - window_h) / document_h ;   
            
        
        // 画面最下部にスクロールされている場合
        if (scroll_pos <= 10) {
            console.log(scroll_pos);
            // ajaxコンテンツ追加処理
            ajaxAddContent()
        }
    });
   
  // ajaxコンテンツ追加処理
    function ajaxAddContent() {
      // 追加コンテンツ
      var add_content = "";
      // コンテンツ件数           
      count = count + 1;
      var search = $("#search").val();
      var start = $("#start").val();
      var end = $("#end").val();

       
      // ajax処理
      $.post({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
          type: "post",
          datatype: "json",
          url: "/posts/more",
          data:{ count : count ,search : search , start : start , end : end }
      }).done(function(data){
          // コンテンツ生成
          console.log(data);
          $.each(data[1],function(key, val){
              add_content += 
              `<div class="col-4 mb-4">
                <div class="card" style="width: 23rem;">
                    <img src="storage/${val.image}" style="object-fit:cover; width: 100%; height: 15rem;" class="card-img-top" alt="">
                    <div class="card-body">
                    <h5 class="card-title">${val.title}</h5>
                    <input type="hidden" class="card-text" value="${val.content}">
                    <p class="card-text">￥${val.price}</p>
                    <a href="/posts/${val.id}" class="btn btn-primary">詳しくみる</a>
                    </div>
                </div>
            </div>`;


          })

          // コンテンツ追加
          $("#content").append(add_content);
          $("#count").val(data[1]);
      }).fail(function(e){
          console.log(e);
      })
    }
  
});
</script>