<?php
require_once('/opt/lampp/htdocs/kyles_portfolio/admin/google-api-php-client-2.1.0/vendor/autoload.php');
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 05/11/16
 * Time: 13:08
 */
    function getUserFromToken($token) {
        $client = new Google_Client();
        $client->setApplicationName("My Application");
        $client->setDeveloperKey("AIzaSyAu6V7NEYZUjLdVbZAW9m0aEAkhUSR5Qvc");
        $ticket = $client->verifyIdToken($token);
        //readable_var_dump($ticket);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }
    //readable_var_dump(getUserFromToken($_GET["id"])["picture"]);
    $user = getUserFromToken($_GET["id"]);

    function readable_var_dump($var){
        echo("<details><pre>");
        var_dump($var);
        echo("</pre></details>");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Kyle Watson's Portfolio - Admin </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
<header id="branding">
    <h1>A casual portfolio for Kyle Watson</h1>
</header>
<nav id="navigation">
    <h2> Navigation </h2>
    <ul>
        <li><a href="../index.html"> Home </a></li>
        <li><a href="../personal.html"> Personal Bio </a></li>
        <li class="title-nested"> <a> Projects </a>
            <ol>
                <li class="nested-item"><a href="../projects/project1/proj1.html"> <abbr title="Universal Serial Bus">USB</abbr> Backup </a></li>
                <li class="nested-item"><a href="../projects/project2/proj2.html"> <abbr title="Grand Theft Auto">GTA</abbr> Graphics Fix </a></li>
                <li class="nested-item"> More Coming Soon! </li>
            </ol>
        </li>
        <li><a href="../contact.html"> Contact me </a></li>
    </ul>
</nav>
<!-- Content starts here -->
<main>
    <h2>Admin - Log in</h2>
    <?php
        if($user["sub"] == "110576097093430616539") {
            echo("<h3> Welcome " . $user["name"] . "</h3> \n");
            echo("<img src='" . $user["picture"] . "'/> \n");
        }else{
            echo("<h3>" . $user["name"] . "</h3> \n <p> You do not have access to this page, sorry.</p> \n");
        }
    ?>
</main>
<!-- Content ends here -->
<footer id="contact">
    <address>
        Created by some <a href="mailto:k.j.watson1@edu.salford.ac.uk">guy</a>
        .
    </address>
    <p>Last Modified: 30/09/16 12:37</p>
</footer>
</body>
</html>