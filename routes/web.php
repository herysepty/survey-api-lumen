<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// $router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {
$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('questions', 'QuestionController@store');
    $router->get('questions', 'QuestionController@getAll');
    $router->post('survey', 'SurveyController@store');
    $router->post('respondents', 'RespondentController@store');
    $router->get('respondents', 'RespondentController@getAll');
    $router->get('respondents/{id}', 'RespondentController@getById');
    $router->post('respondents/{id}/family_cards', 'FamilyCardController@store');

    $router->get('answers/{id}', 'AnswerController@getById');

    $router->delete('family_cards/{id}', 'FamilyCardController@destroy');
    $router->post('respondents/{respondentId}/questions/{questionId}/answers', 'AnswerController@store');
});

$router->post('/login', 'LoginController@index');
$router->post('/register', 'UserController@register');
$router->get('/user/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@getUser']);
