<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

    public function index(){

        $articles = Article::all();
        return view('admin.articles', compact('articles'));
    }

    public function create(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token'); // data from request into mass without '_token'
            $validator = Validator::make($input, [
                'author'=>'required|max:150',
                'title'=>'required|max:150|unique:articles',//ignore the row that is being edited
                'description'=>'required',
                'text'=>'required'
            ]);
            if($validator->fails()){
                return redirect()->route('createArticle')->withErrors($validator)->withInput(); //wihErrors get all errors from $validator //withInput save entered data in session
            }
            if($request->hasFile('image')){
                $file = $request->file('image');
                $fileName = $input['image'] = $file->getClientOriginalName();
                $file->move(public_path().'/img/articles/',$fileName );
            }
            $article = new Article();
            $article->fill($input);
            if($article->save()){
                return redirect('admin')->with('status', 'Article added');
            }
        }

        return view('admin.createArticle');
    }

    public function edit(Article $article, Request $request){

        if($request->isMethod('post')){
                $input = $request->except('_token');
                $validator = Validator::make($input, [
                    'author'=>'required|max:150',
                    'title'=>'required|max:150|unique:articles,title,'.$input['id'],//ignore the row that is being edited
                    'description'=>'required',
                    'text'=>'required'
                ]);
                if($validator->fails()){
                    return redirect()->route('editArticle', ['article'=>$input['id']])->withErrors($validator);
                }
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $file->move(public_path().'/img/articles/',$file->getClientOriginalName());
                    $input['image'] = '/articles/'.$file->getClientOriginalName();
                }
                else{
                    $input['image'] = $input['old_image'];
                }
                unset($input['old_image']);
                $article->fill($input);
                if($article->save()){
                    return redirect('admin')->with('status','Article edit');
                }
        }

        return view('admin.editArticle', compact('article'));
    }

    public function delete(Request $request){

    }
}
