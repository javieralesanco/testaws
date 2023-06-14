<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostContoller extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return view('post.index', compact('posts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|mimes:jpg,png,jpeg|max:1024'
        ]);
        try {
            $folder = 'imagenes';
            $post = new Post;
            $post->name = $request->name;
            $post->description = $request->description;
            $image_path = Storage::disk('s3')->put($folder, $request->image, 'public');
            $post->image_path = $image_path;
            $post->save();
            return redirect(route('posts.index'))
                ->with('success', 'Post registrado correctamente!');
        } catch (\Throwable $th) {
            return redirect(route('posts.index'))
                ->with('error', 'No se pudo registrar el post. Error: ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            Storage::disk('s3')->delete($post->image_path);
            $post->delete();
            return redirect()->route('posts.index')
                ->with('success', 'Post eliminado correctamente!');
        } catch (\Throwable $th) {
            return redirect(route('posts.index'))
                ->with('error', 'No se pudo eliminar el post. Error: ' . $th->getMessage());
        }
    }
}
