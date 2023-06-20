@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="mb-3"><h3>違反報告</h3></div>
    </div>
    <div class ='panel-body'>
      @if($errors->any())
        <div class='alert alert-danger'>
          <ul>
            @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <form action="{{ route('violations.store')}}" method="POST">
      @csrf
      <input type="hidden" name="post_id" value="{{$post}}">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">違反内容</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-primary mb-3">報告する</button>
        </div>
    </form>
</div>
@endsection
