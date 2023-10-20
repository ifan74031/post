@extends('layouts.app')

@section('title','Edit Post')
@section('content')

        <div class="row">
             <div class="col-md-12">
                 <div class="card bg-info border-0 shadow-sm rounded">
                    <div class="card-body">
                        <ul>
                            <h4 class="text-center">{{$post->title}}</h4>
                        </ul>
                        <ul>
                            <img src="{{asset('storage/posts/'.$post->image)}}" class="rounded mx-auto d-block" style="width: 250px"> 
                       </ul>
                        <ul>
                            <h4 class="text-center">{{$post->content}}</h4>
                        </ul>
                    </div>      

                    @include('posts.komentar.show-komentar')

                        <div class="mt-4">
                            <form action="{{url('/posts/comment/store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" id="post_id" value="{{$post->id}}">
                                <div class="form-group">
                                <label class="font-weight-bold">KOMENTAR:</label>
                                <input type="text" class="form-control
                                @error('komentar')
                                is-invalid @enderror"
                                name="komentar" 
                                placeholder="Masukkan Komentar Post">
                            @error('komentar')
                            <div class="alert alert-danger mt-2">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-md btn-success mb4">SIMPAN</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form>
                        </div>
                        <div>
                            <a href="{{url('/posts')}}" class="btn btn-md btn-primary">KEMBALI</a>
                            <h6 class="text-right">{{$post->created_at}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection