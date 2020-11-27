<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Archive;

class ArchiveController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        $archives = Archive::all();
        foreach($archives as $archive) {
            $archive['answer'] = base64_decode($archive['answer']);
            $archive['html'] = base64_decode($archive['html']);
            $archive['css'] = base64_decode($archive['css']);
            $archive['frontend'] = base64_decode($archive['frontend']);
            $archive['backend'] = base64_decode($archive['backend']);
            $archive['database'] = base64_decode($archive['database']);
        }

        $response = [
            'archives'=> $archives
        ];

        return response()->json($response, 200);
    }

    public function getArchivesBy($type){
        if($type === 'snippet') {
            $archives = Archive::where('type',  $type)->get();
        } else if($type === 'question') {
            $archives = Archive::where('type', $type)->where('article_id', NULL)->get();
        }

        foreach($archives as $archive) {
            $archive['answer'] = base64_decode($archive['answer']);
            $archive['html'] = base64_decode($archive['html']);
            $archive['css'] = base64_decode($archive['css']);
            $archive['frontend'] = base64_decode($archive['frontend']);
            $archive['backend'] = base64_decode($archive['backend']);
            $archive['database'] = base64_decode($archive['database']);
        }

        $response = [
            'archives'=> $archives
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
        $archive = new Archive(
            [
                'id' =>  md5($request->get('question').time().uniqid()),
                'question' => $request->get('question'),
                'answer' => base64_encode($request->get('answer')),
                'html' => base64_encode($request->get('html')),
                'css' => base64_encode($request->get('css')),
                'frontend' => base64_encode($request->get('frontend')),
                'backend' => base64_encode($request->get('backend')),
                'database' => base64_encode($request->get('database')),
                'type' => $request->get('type')
            ]
        );

        $archive->save();

        $archive['answer'] = $request->get('answer');
        $archive['html'] = $request->get('html');
        $archive['css'] = $request->get('css');
        $archive['frontend'] = $request->get('frontend');
        $archive['backend'] = $request->get('backend');
        $archive['database'] = $request->get('database');

        $response = [
            'archive' => $archive
        ];

        return response()->json($response, 200);

        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $archive = Archive::find($id);
        $archive->question = $request->get('question');
        $archive->answer = base64_encode($request->get('answer'));
        $archive->html = base64_encode($request->get('html'));
        $archive->css = base64_encode($request->get('css'));
        $archive->frontend = base64_encode($request->get('frontend'));
        $archive->backend = base64_encode($request->get('backend'));
        $archive->database = base64_encode($request->get('database'));
        $archive->type = $request->get('type');

        $archive->save();

        $archive['answer'] = $request->get('answer');
        $archive['html'] = $request->get('html');
        $archive['css'] = $request->get('css');
        $archive['frontend'] = $request->get('frontend');
        $archive['backend'] = $request->get('backend');
        $archive['database'] = $request->get('database');

        $response = [
            'archive' => $archive
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
       Archive::destroy($id);

       $response = [
        'deleteStatus'=> 'deleted'
       ];

        return response()->json($response, 200);
    }

    public function linkArticleArchive(Request $request){

        $archive = Archive::find($request->get('archiveId'));
        $archive->article_id = $request->get('articleId');

        return $archive->save();
    }

    public function unlinkArticleArchive(Request $request){
        $archive = Archive::find($request->get('archiveId'));
        $archive->article_id = NULL;

        return $archive->save();
    }

}
