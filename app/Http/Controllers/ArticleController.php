<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Archive;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class ArticleController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $articles = Article::all();

        foreach($articles as $article) {
            $article['content'] = base64_decode($article['content']);
        }

        $response = [
            'articles'=> $articles
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $article = new Article(
            [
                'id' =>  md5($request->get('image').time().uniqid()),
                'name' => $request->get('name'),
                'status' => $request->get('status'),
                'image' => $request->get('image'),
                'description' => $request->get('description'),
                'content' => base64_encode($request->get('content')),
                'backend' => $request->get('backend'),
                'frontend' => $request->get('frontend'),
                'database' => $request->get('database'),
                'libraries' => $request->get('libraries'),
            ]
        );

        $article->save();

        $article['content'] = base64_decode($article['content']);
       
        $response = [
            'article' => $article
        ];

        return response()->json($response, 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $article = Article::find($id, ['id', 'name', 'status', 'updated_at AS lastUpdated', 'image', 'frontend', 'backend', 'database', 'libraries','description']);

        $response = [
            'article' =>  $article
        ];

       return response()->json($response, 200);
    }

    public function getArticleContent($id) {
        $article = Article::find($id, ['content']);

        $article['content'] = base64_decode($article['content']);

       return response()->json($article, 200);
    }

    public function getArticlesByTopic($topic, $type) {
        $articles = Article::select('id', 'name', 'status', 'updated_at AS lastUpdated', 'image', 'frontend', 'backend', 'database', 'libraries', 'description')->where($type, $topic)->get();

        $response = [
            'articles' => $articles
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
       $article = Article::find($id);
       $article->name = $request->get('name');
       $article->status = $request->get('status');
       $article->image = $request->get('image');
       $article->description = $request->get('description');
       $article->content = base64_encode($request->get('content'));
       $article->backend = $request->get('backend');
       $article->frontend = $request->get('frontend');
       $article->database = $request->get('database');
       $article->libraries = $request->get('libraries');

       $article->save();

       $article['content'] = base64_decode($article['content']);

       $response = [
           'article' => $article
       ];

       return response()->json($response, 200);
    }

    public function destroy($id){
        Article::destroy($id);
        $response = [
            'deleteStatus'=> 'deleted'
        ];
        return response()->json($response, 200);
    }

    public function getLatest(){
        $response = [
            'article' => Article::select('id', 'name', 'status', 'updated_at AS lastUpdated', 'image', 'frontend', 'backend', 'database', 'libraries', 'description')->latest('updated_at')->first()
        ];        

        return response()->json($response, 200);
    }

    public function getArticleArchives($id) {
        $archives = Article::find($id)->archives;

        foreach($archives as $archive) {
            $archive['answer'] = base64_decode($archive['answer']);
            $archive['html'] = base64_decode($archive['html']);
            $archive['css'] = base64_decode($archive['css']);
            $archive['frontend'] = base64_decode($archive['frontend']);
            $archive['backend'] = base64_decode($archive['backend']);
            $archive['database'] = base64_decode($archive['database']);
        }

        $response = [
            'archives' => $archives
        ];

        return response()->json($response, 200);

    }
}
