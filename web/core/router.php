<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

require_once 'vendor/autoload.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/MemeController.php';
require_once 'controllers/GalleryController.php';
require_once 'controllers/VotesController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/StatisticsController.php';
require_once 'controllers/AppConfigController.php';

use Respect\Rest\Router;
const BD_CONFIG = 1;
$r3 = new Router('/core');
/**
 * Memes
 */
$r3->get(
    '/memes/*/*/*',
    function ($order, $page, $user = null) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->index($order, $page, $user);
        return json_encode($resp);
    }
);

$r3->get(
    '/search/*/*/*',
    function ($searchTerm, $page, $user = null) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->search($searchTerm, $page, $user);
        return json_encode($resp);
    }
);

$r3->post(
    '/create',
    function () {
        $meme = json_decode(file_get_contents('php://input'));
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->create($meme);
        return json_encode($resp);
    }
)->by(function(){
    $session = json_decode(file_get_contents('php://input'));
    $controller = new UserController(BD_CONFIG);
    $resp = $controller->validateToken($session->user,$session->token);
    if(is_array($resp)){
        print json_encode($resp);
        return false;
    }
});

$r3->get(
    '/read/*',
    function ($id) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->read($id);
        return json_encode($resp);
    }
);

/**
 * Gallery
 */
$r3->get(
    '/gallery',
    function () {
        $controller = new GalleryController(BD_CONFIG);
        $resp = $controller->index();
        return json_encode($resp);
    }
);

$r3->post(
    '/gallery/create',
    function () {
        $gallery = json_decode(file_get_contents('php://input'));
        $controller = new GalleryController(BD_CONFIG);
        $resp = $controller->create($gallery);
        return json_encode($resp);
    }
);

$r3->delete(
    '/gallery/delete/*',
    function ($id) {
        $controller = new GalleryController(BD_CONFIG);
        $resp = $controller->delete($id);
        return json_encode($resp);
    }
);

/**
 * Users
 */
$r3->get(
    '/users',
    function () {
        $controller = new UserController(BD_CONFIG);
        $resp = $controller->index();
        return json_encode($resp);
    }
);

$r3->delete(
    '/users/delete/*',
    function ($id) {
        $controller = new UserController(BD_CONFIG);
        $resp = $controller->delete($id);
        return json_encode($resp);
    }
);

$r3->get(
    '/users/*',
    function ($id) {
        $controller = new BaseController(BD_CONFIG);
        $resp = $controller->detail($id);
        return json_encode($resp);
    }
);

$r3->post(
    '/vote',
    function(){
        $vote = json_decode(file_get_contents('php://input'));
        $controller = new VotesController(BD_CONFIG);
        $resp = $controller->vote($vote);
        return json_encode($resp);
    }
)->by(function(){
    $session = json_decode(file_get_contents('php://input'));
    $controller = new UserController(BD_CONFIG);
    $resp = $controller->validateToken($session->user,$session->token);
    if(is_array($resp)){
        print json_encode($resp);
        return false;
    }
});

$r3->post(
    '/sign/signin',
    function(){
        $data = json_decode(file_get_contents('php://input'));
        $controller = new UserController(BD_CONFIG);
        $resp = $controller->authenticate($data);
        return json_encode($resp);
    }
);

$r3->post(
    '/sign/signup',
    function(){
        $data = json_decode(file_get_contents('php://input'));
        $controller = new UserController(BD_CONFIG);
        $resp = $controller->create($data);
        return json_encode($resp);
    }
);

/**
 * Statistics
 */
$r3->get(
    '/statistics',
    function(){
        $controller = new StatisticsController(BD_CONFIG);
        $resp = $controller->getTopMemesVotedUser();
        return json_encode($resp);
    }
);

/**
 * Admin Memes
 */
$r3->get(
    '/admin/memes/*/*',
    function ($order, $page) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->indexAdmin($order, $page);
        return json_encode($resp);
    }
);

$r3->post(
    '/update',
    function () {
        $meme = json_decode(file_get_contents('php://input'));
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->update($meme);
        return json_encode($resp);
    }
);

$r3->delete(
    '/delete/*',
    function ($id) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->delete($id);
        return json_encode($resp);
    }
);

$r3->post(
    '/approve/*',
    function ($id) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->approve($id);
        return json_encode($resp);
    }
);

$r3->post(
    '/disapprove/*',
    function ($id) {
        $controller = new MemeController(BD_CONFIG);
        $resp = $controller->disapprove($id);
        return json_encode($resp);
    }
);

/**
 * Admin Settings
 */
$r3->get(
    '/admin/settings',
    function () {
        $controller = new AppConfigController(BD_CONFIG);
        $resp = $controller->index();
        return json_encode($resp);
    }
);

$r3->post(
    '/admin/settings/save',
    function () {
        $setting = json_decode(file_get_contents('php://input'));
        $controller = new AppConfigController(BD_CONFIG);
        $resp = $controller->update($setting);
        return json_encode($resp);
    }
);