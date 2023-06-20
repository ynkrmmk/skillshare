@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="mb-3"><h3>スキル投稿</h3></div>

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

    <form action="/posts" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">画像</label>
                    <input class="form-control" type="file" id="formFileMultiple" name="image" accept="image/*" onchange="previewImage(this);">
                    <p>
                    プレビュー<br>
                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:400px; max-height:300px;">
                    </p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">タイトル</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="title" value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">内容</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3">{{ old('content') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">金額</label>
                    <input type="number" class="form-control" id="exampleFormControlInput1" name="price" value="{{ old('price') }}">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-primary mb-3">投稿する</button>
        </div>
    </form>
</div>
<script>
function previewImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function() {
		document.getElementById('preview').src = fileReader.result;
	});
	fileReader.readAsDataURL(obj.files[0]);
}
</script>
@endsection
