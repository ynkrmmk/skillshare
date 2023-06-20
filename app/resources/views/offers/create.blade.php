@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="mb-3"><h3>依頼</h3></div>
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

    <form action="{{ route('offers.store')}}" method="POST">
      @csrf
      <input type="hidden" name="post_id" value="{{$post}}">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">内容</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3">{{ old('content') }}</textarea>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">電話</label>
                  <input type="tel" class="form-control" id="exampleFormControlInput1" name="tel" value="{{ old('tel') }}">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">メールアドレス</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" name="email" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">希望納期</label>
                  <input type="date" class="form-control" id="exampleFormControlInput1" name="date" value="{{ old('date') }}">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-primary mb-3">依頼する</button>
        </div>
    </form>
</div>
@endsection
