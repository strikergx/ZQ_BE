<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/carousel/add','CarouselController@add')->middleware('domain');
Route::get('/carousel/del','CarouselController@del')->middleware('domain');
Route::post('/carousel/edit','CarouselController@edit')->middleware('domain');
Route::get('/carousel/show','CarouselController@show')->middleware('domain');

Route::get('/indexcarousel','CarouselController@index')->middleware('islogin');
Route::get('/getSon','CarouselController@getSon')->middleware('islogin');
Route::get('/getArt','CarouselController@getArt')->middleware('islogin');



Route::post('/poetrysociety/add','PoetrySocietyController@add')->middleware('domain');
Route::delete('/poetrysociety/del','PoetrySocietyController@del')->middleware('domain');
Route::post('/poetrysociety/edit','PoetrySocietyController@edit')->middleware('domain');
Route::get('/poetrysociety/show','PoetrySocietyController@show')->middleware('domain');




Route::post('/register','Auth\RegisterController@register')->middleware('domain');
Route::post('/admin/register','Auth\RegisterController@adminRegister')->middleware('domain');
Route::post('/email','\App\Mail\Email@email')->middleware('domain');
Route::post('/forgot/email','\App\Mail\ForgotPasswordEmail@email')->middleware('domain');
Route::post('/forgot/password','Auth\ForgotPasswordController@forgotPassword')->middleware('domain');
Route::post('/login','Auth\LoginController@login')->middleware('domain');
Route::get('/check','Auth\LoginController@check')->middleware('domain');
Route::get('/logout','Auth\LoginController@logout')->middleware('domain');
Route::post('/user', 'Auth\LoginController@UserDetail') -> middleware('domain');




Route::get('/showlists','ListController@showLists')->middleware('domain');


Route::post('/addlists','ListController@addLists')->middleware('islogin');
Route::get('/dellists','ListController@delLists')->middleware('islogin');
Route::get('/editlists','ListController@editLists')->middleware('islogin');

Route::get('/indexlists','ListController@index')->middleware('islogin');
Route::get('/createlists','ListController@create')->middleware('islogin');
Route::get('/editpage','ListController@editPage')->middleware('islogin');



Route::post('/addart','ArticleController@addArt')->middleware('domain');
Route::post('/editart','ArticleController@editArt')->middleware('domain');
Route::get('/delart','ArticleController@delArt')->middleware('domain');
Route::get('/showart','ArticleController@showArt')->middleware('domain');
Route::get('/showtitle','ArticleController@showTitle')->middleware('domain');
Route::get('/showmore','ArticleController@showMore')->middleware('domain');
Route::get('/editit','ArticleController@editIt')->middleware('domain');

Route::get('/bread/{cid}', 'BreadController@Bread2') -> middleware('domain');
Route::get('/breadfather/{cid}', 'BreadController@FetFather') -> middleware('domain');


Route::get('/indexart','ArticleController@index')->middleware('islogin');
Route::get('/storeart','ArticleController@store')->middleware('islogin');
Route::get('/indexbin','ArticleController@indexbin')->middleware('islogin');
Route::get('/delforever','ArticleController@delforever')->middleware('islogin');

Route::post('/addcomment','CommentController@addComment')->middleware('domain');
Route::get('/showcomment/{id}','CommentController@showComment')->middleware('domain');
Route::get('/morecomment','CommentController@moreComment')->middleware('domain');


Route::get('/loginpage','Auth\RootController@login');
Route::get('/index','Auth\RootController@index')->middleware('islogin');
Route::post('/loginadmin','Auth\LoginController@loginAdmin')->middleware('domain');
Route::get('/addcarousel','CarouselController@addcarousel')->middleware('islogin');
Route::get('/up','CarouselController@up')->middleware('islogin');
Route::get('/down','CarouselController@down')->middleware('islogin');
Route::get('/loginout','Auth\LoginController@loginout')->middleware('islogin');

/**链接*/
Route::get('/links/show', 'LinksController@showLinks') -> middleware('domain');
Route::post('/links/edit', 'LinksController@editLinks') -> middleware('domain');
Route::get('/links/index', 'LinksController@index') -> middleware('domain');
Route::get('/links/editpage', 'LinksController@editPage') -> middleware('domain');
Route::post('/links/add', 'LinksController@addLinks') -> middleware('domain');
Route::get('/links/del', 'LinksController@delLinks') -> middleware('domain');
Route::get('/links/addpage', 'LinksController@addPage') -> middleware('domain');


/** 本站动态.新闻速递 */
Route::get('/sitemov','ArticleController@SiteMovition')->middleware('domain');
Route::get('/newsexp','ArticleController@NewsExpress')->middleware('domain');
/** 按照分类查询文章 */
Route::get('/artlist/{id}', 'ArticleController@CateArticle') -> middleware('domain');

/** 测试接口 */
Route::post('/testform', 'TestController@TestForm') -> middleware('domain');
Route::get('/testhash', 'TestController@hashtest') -> middleware('domain');
/** 前端用户登录注册 */
Route::post('/frontreg', 'UserController@Reg') -> middleware('domain');
Route::post('/frontlogin', 'UserController@Login') -> middleware('domain');
Route::post('/frontlogout', 'UserController@Logout') -> middleware('domain');
Route::post('/logintest', 'UserController@Ht') -> middleware('domain');

Route::get('/test',function (){
    print_r(app_path(''));
    return  '';
    //return view('test');
});
