<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Post,
    Comment
};
use Illuminate\View\View;
use storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this-> validate($request,[
            'image'     =>'required|file|image|mimes:png,jpg,jpeg,gif,webp|max:1500',
            'title'     =>'required',
            'content'   =>'required'
        ]);

        $image=$request->file('image');
        $image->storeAs('public/posts',$image->hashName());

        post::create([
            'image'=> $image->hashName(),
            'title'=> $request->title,
            'content'=> $request->content
        ]);

        return redirect('/posts')
        ->with(['succes'=>'Data Berhasil Disimpan']);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->validate($request, [
            'image'     => 'nullable|file|image|mimes:png,jpeg,jpg|max:2048',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        if (!$request->hasFile('image')) {
            $request->image = $post->image;

            $post->update([
                'title'     => $request->title,
                'image'     => $request->image,
                'content'   => $request->content
            ]);
        }else{
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
            Storage::delete('public/posts/'.$post->image);

            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }

        return redirect('/posts')
                ->with(['success' => 'Data berhasil diubah']);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comment = Comment::where('post_id',$post->id)->get();

        return view('posts.show', compact('post','comment'));
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect('/posts')
                ->with(['success' => 'Data berhasil dihapus']);
    }
    

}