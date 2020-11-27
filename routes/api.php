<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;


//.........Authentication.........//
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:api');
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:api');


//.........Projects.........//
Route::get('/get-projects', [ProjectController::class, 'index']);
Route::get('/get-project/{id}', [ProjectController::class, 'show']); // called only when for fresh call
Route::get('/get-project-content/{id}', [ProjectController::class, 'getProjectContent']);
Route::get('/get-latest-project', [ProjectController::class, 'getLatest']);
Route::get('/get-project-snippets/{id}', [ProjectController::class, 'getProjectSnippets']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/create-project', [ProjectController::class, 'store']);
    Route::delete('/delete-project/{id}', [ProjectController::class, 'destroy']);
    Route::put('/update-project/{id}', [ProjectController::class, 'update']);
    Route::post('/link-project-snippet', [ProjectController::class, 'linkProjectSnippet']);
    Route::delete('/unlink-project-snippet/{snippetId}/{projectId}', [ProjectController::class, 'unlinkProjectSnippet']);
});

//.........Snippets.........//
Route::get('/get-snippets', [SnippetController::class, 'index']);
Route::get('/get-snippet/{id}', [SnippetController::class, 'show']);
Route::get('/get-snippet-content/{id}', [SnippetController::class, 'getSnippetContent']);
Route::get('/get-latest-snippet', [SnippetController::class, 'getLatest']);
Route::get('/get-snippet-projects/{id}', [SnippetController::class, 'getSnippetProjects']);
Route::get('/get-snippet-archives/{id}', [SnippetController::class, 'getSnippetArchives']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/create-snippet', [SnippetController::class, 'store']);
    Route::delete('/delete-snippet/{id}', [SnippetController::class, 'destroy']);
    Route::put('/update-snippet/{id}', [SnippetController::class, 'update']);
    Route::post('/link-snippet-archive', [SnippetController::class, 'linkSnippetArchive']);
    Route::delete('/unlink-snippet-archive/{snippetId}/{archiveId}', [SnippetController::class, 'unlinkSnippetArchive']);
});

//.........Articles.........//
Route::get('/get-articles', [ArticleController::class, 'index']);
Route::get('/get-article/{id}', [ArticleController::class, 'show']); // called only when for fresh call
Route::get('/get-article-content/{id}', [ArticleController::class, 'getArticleContent']);
Route::get('/get-latest-article', [ArticleController::class, 'getLatest']);
Route::get('get-articles-by-topic/{topic}/{type}', [ArticleController::class, 'getArticlesByTopic']);
Route::get('/get-article-archives/{id}', [ArticleController::class, 'getArticleArchives']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/create-article', [ArticleController::class, 'store']);
    Route::delete('/delete-article/{id}', [ArticleController::class, 'destroy']);
    Route::put('/update-article/{id}', [ArticleController::class, 'update']);

});

//.........Archives.........//
Route::get('/get-archives', [ArchiveController::class, 'index']);
Route::get('/get-archives-by/{type}', [ArchiveController::class, 'getArchivesBy']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/create-archive', [ArchiveController::class, 'store']);
    Route::put('/update-archive/{id}', [ArchiveController::class, 'update']);
    Route::delete('/delete-archive/{id}', [ArchiveController::class, 'destroy']);
    Route::post('/link-article-archive', [ArchiveController::class, 'linkArticleArchive']);
    Route::put('/unlink-article-archive', [ArchiveController::class, 'unlinkArticleArchive']);
});



