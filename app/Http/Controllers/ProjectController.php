<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Project;

use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all('id', 'name', 'status', 'image', 'frontend', 'backend', 'database', 'description', 'git', 'preview', 'updated_at AS lastUpdated');
        $response = [
            'projects'=> $projects
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
        $project = Project::find($id, ['id', 'name', 'status', 'image', 'frontend', 'backend', 'database', 'description', 'content', 'git', 'preview', 'updated_at AS lastUpdated']);

        $project['content'] = base64_decode($project['content']);

        $response = [
            'project' => $project
        ];

       return response()->json($response, 200);
    }

    public function getProjectContent($id) {

        $project = Project::find($id, ['content']);

        $project['content'] = base64_decode($project['content']);

       return response()->json($project, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project(
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
                'git' => $request->get('git'),
                'preview' => $request->get('preview'),
            ]
        );

        $project->save();

        $project['content'] = $request->get('content');

        $response = [
            'project' => $project
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
       $project = Project::find($id);
       $project->name = $request->get('name');
       $project->status = $request->get('status');
       $project->image = $request->get('image');
       $project->description = $request->get('description');
       $project->content = base64_encode($request->get('content'));
       $project->backend = $request->get('backend');
       $project->frontend = $request->get('frontend');
       $project->database = $request->get('database');
       $project->libraries = $request->get('libraries');
       $project->git = $request->get('git');
       $project->preview = $request->get('preview');

       $project->save();

       $project['content'] = $request->get('content');

       $response = [
           'project' => $project
       ];

       return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Project::destroy($id);

        $response = [
            'deleteStatus'=> 'deleted'
        ];
        return response()->json($response, 200);
    }

    public function getLatest(){
        $response = [
            'project' => Project::select('id', 'name', 'status', 'updated_at AS lastUpdated', 'image', 'frontend', 'backend', 'database', 'libraries', 'description')->latest('updated_at')->first()
        ];

        return response()->json($response, 200);
    }
 
    public function getProjectSnippets($id){
       $snippets = Project::find($id)->snippets()->get(['project_id', 'snippet_id AS id', 'name', 'status', 'image', 'frontend', 'backend', 'database', 'description', 'git']);

       foreach($snippets as $snippet) {
        unset($snippet['project_id']);
        unset($snippet['pivot']);
       }
       
        $response = [
            'snippets' => $snippets
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function linkProjectSnippet(Request $request) {

        $id = DB::select('SELECT id from project_snippet WHERE project_id = ? AND snippet_id = ?', [$request->get('projectId'), $request->get('snippetId')]);

       if(!$id){
            return DB::insert("INSERT INTO project_snippet (project_id, snippet_id) VALUES (?, ?)",
                [$request->get('projectId'), $request->get('snippetId')]);
       } else {
           return 0;
       }
    }

     public function unlinkProjectSnippet($snippetId, $projectId) {
         return DB::delete("DELETE FROM project_snippet WHERE project_id = ? AND snippet_id = ?", [$projectId, $snippetId]);
     }
}
