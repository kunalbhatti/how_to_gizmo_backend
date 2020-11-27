<?php

namespace App\Http\Controllers;

use App\Models\Snippet;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SnippetController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $snippets = Snippet::all('id', 'name', 'status', 'image', 'updated_at AS lastUpdated', 'frontend', 'backend', 'database', 'description', 'git');

        $response = [
            'snippets'=> $snippets
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $snippet = Snippet::find($id, ['id', 'name', 'status', 'image', 'updated_at AS lastUpdated', 'frontend', 'backend', 'database', 'description', 'git', 'content']);

        $snippet['content'] = base64_decode($snippet['content']);

        $response = [
            'snippet' =>  $snippet
        ];

       return response()->json($response, 200);
    }

    public function getSnippetContent($id) {
        $snippet = Snippet::find($id, ['content']);

        $snippet['content'] = base64_decode($snippet['content']);

       return response()->json($snippet, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $snippet = new Snippet(
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
                'git' => $request->get('git')
            ]
        );

        $snippet->save();

        $snippet['content'] = $request->get('content');

        $response = [
            'snippet' => $snippet
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
    public function update(Request $request, $id)
    {
       $snippet = Snippet::find($id);
       $snippet->name = $request->get('name');
       $snippet->status = $request->get('status');
       $snippet->image = $request->get('image');
       $snippet->description = $request->get('description');
       $snippet->content = base64_encode($request->get('content'));
       $snippet->backend = $request->get('backend');
       $snippet->frontend = $request->get('frontend');
       $snippet->database = $request->get('database');
       $snippet->libraries = $request->get('libraries');
       $snippet->git = $request->get('git');

       $snippet->save();

       $snippet['content'] = $request->get('content');

       $response = [
           'snippet' => $snippet
       ];

       return response()->json($response, 200);
    }

    public function destroy($id)
    {

        Snippet::destroy($id);

        $response = [
            'deleteStatus'=> 'deleted'
        ];
        return response()->json($response, 200);
    }

    public function getLatest(){
        $response = [
            'snippet' => Snippet::select('id', 'name', 'status', 'updated_at AS lastUpdated', 'image', 'frontend', 'backend', 'database', 'libraries', 'description')->latest('updated_at')->first()
        ];

        return response()->json($response, 200);
    }

    public function getSnippetProjects($id) {
        $projects = Snippet::find($id)->projects;

        $response = [
            'projects' => $projects
        ];

        return response()->json($response, 200);
    }

    public function getSnippetArchives($id) {
        $archives = Snippet::find($id)->archives;

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

    public function linkSnippetArchive(Request $request){
        $id = DB::select('SELECT id from archive_snippet WHERE archive_id = ? AND snippet_id = ?', [$request->get('archiveId'), $request->get('snippetId')]);

       if(!$id){
            return DB::insert("INSERT INTO archive_snippet (archive_id, snippet_id) VALUES (?, ?)",
                [$request->get('archiveId'), $request->get('snippetId')]);
       } else {
           return 0;
       }
    }

    public function unlinkSnippetArchive($snippetId, $archiveId){
        return DB::delete("DELETE FROM archive_snippet WHERE archive_id = ? AND snippet_id = ?", [$archiveId, $snippetId]);
    }
}

