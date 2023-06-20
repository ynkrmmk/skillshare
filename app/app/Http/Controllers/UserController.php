<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\userCreate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = DB::table('posts')
        ->select('posts.*')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->where('posts.user_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();

        $myPosts = DB::table('posts')
        ->select('posts.*')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->join('requests', 'posts.id', '=', 'requests.post_id')
        ->where('posts.user_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();

        $toPosts = DB::table('posts')
        ->select('posts.*')
        ->join('requests', 'posts.id', '=', 'requests.post_id')
        ->join('users', 'requests.request_id', '=', 'users.id')
        ->where('requests.request_id', Auth::id())
        ->orderBy('created_at','desc')
        ->get();

        return view('users.index')->with([
            'posts'=> $posts,
            'myPosts'=> $myPosts,
            'toPosts'=> $toPosts,
        ]);    

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
        $posts = DB::table('posts')
        ->select('posts.*')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->where('posts.user_id', $user->id)
        ->orderBy('created_at','desc')
        ->get();

        $myPosts = DB::table('posts')
        ->select('posts.*')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->join('requests', 'posts.id', '=', 'requests.post_id')
        ->where('posts.user_id', $user->id)
        ->orderBy('created_at','desc')
        ->get();

        $toPosts = DB::table('posts')
        ->select('posts.*')
        ->join('requests', 'posts.id', '=', 'requests.post_id')
        ->join('users', 'requests.request_id', '=', 'users.id')
        ->where('requests.request_id', $user->id)
        ->orderBy('created_at','desc')
        ->get();

        $violations = DB::table('violations')
        ->select('violations.*', 'users.name')
        ->join('users', 'violations.report_id', '=', 'users.id')
        ->join('posts', 'violations.post_id', '=', 'posts.id')
        ->where('posts.user_id', $user->id)
        ->orderBy('created_at','desc')
        ->get();

        return view('users.show')->with([
            'posts'=> $posts,
            'myPosts'=> $myPosts,
            'toPosts'=> $toPosts,
            'user'=> $user,
            'violations'=> $violations,
        ]);    


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(userCreate $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;


        if(!empty($request->image)) {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/img' , $file_name);
            $user->image = 'img/'.$file_name;
        }

        $user->save();
        return redirect("/users");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/posts');
    }
}
