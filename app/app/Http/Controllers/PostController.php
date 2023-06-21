<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Violation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\postStore;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {    
        $count = 6;
        $start = $request->start;
        $end = $request->end;

        $query = Post::orderBy('created_at', 'desc')->where('status', '=', 0);

        $violation_posts = DB::table('violations')
        ->select('posts.*')
        ->selectRaw('COUNT(post_id) as count_Id')
        ->groupBy('post_id')
        ->join('posts', 'violations.post_id', '=', 'posts.id')
        ->orderBy('count_Id','desc')
        ->limit(20)
        ->get();

        $users = DB::table('violations')
        ->select('posts.user_id','users.*')
        ->selectRaw('COUNT(violations.post_id) as count_Id')
        ->groupBy('posts.user_id')
        ->join('posts', 'violations.post_id', '=', 'posts.id')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->orderBy('count_Id','desc')
        ->limit(10)
        ->get();

        if (isset($start) && isset($end)) {
            $query = $query->whereBetween("price", [$start, $end]);
        }

         // 検索フォームで入力された値を取得する
         $search = $request->input('search');
 
        // もし検索フォームにキーワードが入力されたら
        if ($search) {
             // 全角スペースを半角に変換
             $spaceConversion = mb_convert_kana($search, 's');
             // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
             $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
             // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
             foreach($wordArraySearched as $value) {
                 $query->where('title', 'like', '%'.$value.'%')
                 ->orwhere('content', 'like', '%'.$value.'%');
             }
            // 上記で取得した$queryをページネートにし、変数に代入
        }
        
        $posts = $query->limit($count)->get();

        return view('posts.index')->with([
            'posts'=> $posts,
            'search' =>$search,
            'start'=> $start,
            'end'=> $end,
            'users'=> $users,
            'violation_posts'=>$violation_posts,
        ]);        



    }

    public function more(Request $request)
    {
        $count = $request->count * 6;
        $start = $request->start;
        $end = $request->end;
        $query = Post::orderBy('created_at', 'desc');

        if (isset($start) && isset($end)) {
            $query = $query->whereBetween("price", [$start, $end]);
        }

         // 検索フォームで入力された値を取得する
         $search = $request->search;
 
        // もし検索フォームにキーワードが入力されたら
        if ($search) {
             // 全角スペースを半角に変換
             $spaceConversion = mb_convert_kana($search, 's');
             // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
             $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
             // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
             foreach($wordArraySearched as $value) {
                 $query->where('title', 'like', '%'.$value.'%')
                 ->orwhere('content', 'like', '%'.$value.'%');
             }
            // 上記で取得した$queryをページネートにし、変数に代入
        }
        $posts = $query->offset($count)->limit(6)->get();
        $counts = $count + 6;

        return array($counts, $posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->id() == null) {
            return redirect()->route('login');
        } else {
            return view('posts.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(postStore $request)
    {
        $post = new Post;
        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->price = $request->price;

        if(!empty($request->image)) {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/img' , $file_name);
            $post->image = 'img/'.$file_name;
        } else {
            $post->image = 'img/20200502_noimage.jpg';
        }

        $post->save();
        return redirect("/posts");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post)
    {
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(postStore $request, Post $post)
    {
        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->price = $request->price;

        if(!empty($request->image)) {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/img' , $file_name);
            $post->image = 'img/'.$file_name;
        }

        $post->save();
        return redirect("/posts/{$post->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts');
    }





    public function trying(Post $post)
    {
        $post->status = 1;
        $post->save();
        
        return redirect('/users');
    }

    public function complete(Post $post)
    {

        $post->status = 2;
        $post->save();
    
        return redirect('/users');
    }


}
