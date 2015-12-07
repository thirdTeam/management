<?php
    function call($controller, $action) {
        require_once('controllers/' . $controller . '_controller.php');

        switch($controller) {
            case 'pages':
                $controller = new PagesController();
                break;
            case 'search':
                $controller = new SearchController();
                break;
            case 'signin':
                $controller = new SigninController();
                break;
            case 'profile':
                $controller = new ProfileController();
                break;
            case 'create':
                $controller = new CreateController();
                break;
        }

        $controller->{ $action }();
    }

    $controllers = array('pages' => ['home', 'error', 'show'],
        'search' => ['index','result', 'signup'],
        'signin' => ['index','register', 'login'],
        'profile' => ['logout', 'index', 'changeInfo', 'changeAds', 'changeSub'],
        'create' => ['index','add']);
    if (array_key_exists($controller, $controllers)) {
        if (in_array($action, $controllers[$controller])) {
            call($controller, $action);
        } else {
            call('pages', 'error');
        }
    } else {
        call('pages', 'error');
    }

