<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <title><?php
            switch($controller) {
                case 'pages':
                    echo "Home";
                    break;
                case 'search':
                    echo "Search";
                    break;
            }
            ?></title>
    </head>
    <body>
        <?php require_once('header.php'); require_once('routes.php');?>
    </body>
</html>
