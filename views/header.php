<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="./css/bootstrap.min.css" rel="stylesheet"/>

        <link href="./css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>CS673: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>CS673</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="./js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="./js/bootstrap.min.js"></script>

        <script src="./js/scripts.js"></script>

    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= CS50::config()['environment']['prepend'] ?>">CS673</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <!-- <li><a href="/#!/me">My Events</a></li>
                        <li><a href="/#!/events">Global Events</a></li>-->
                        <?php if (!empty($_SESSION["cs673_id"])): ?>
                            <li><a href="search.php">
                                <span class="glyphicon glyphicon-search" style=" padding-right: 10px "></span>
                                Search
                            </a></li>
                        <?php endif ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!empty($_SESSION["cs673_id"])): ?>
                            <?php if(isset($user)): ?>
                                <li><a href="settings.php">Logged in as <?= $user["name"]; ?></a></li>
                            <?php endif ?>
                            <li><a href="dump.php">Database</a></li>
                            <li><a href="https://github.com/jayrav13/cs673-finance">Source</a></li>
                            <li><a href="logout.php"><strong>Log Out</strong></a></li>
                        <?php endif ?>
                        <?php if(CS50::config()['environment']['env'] == "local" && (empty($_SESSION["cs673_id"]))): ?>
                            <li><a href="dump.php">Database</a></li>
                        <?php endif ?>
                    </ul>
                </div><!-- /.navbar-collapse -->

            </div><!-- /.container-fluid -->
        </nav>

        <div class="container" style=" margin-top: 60px; ">

        <?php if (isset($title)): ?>
            <div class="row">
                <div class="well well-sm col-md-6 col-md-offset-3">
                    <h1 class="header"><?= htmlspecialchars($title) ?>
                        <?php if (isset($subtitle)): ?><small><?= $subtitle ?><?php endif ?>
                    </h1>
                </div>
            </div>
        <?php endif ?>

        <?php if (isset($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php
                foreach($errors as $error)
                {
                    echo($error);
                }
            ?>
        </div>
        <?php endif ?>

        <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php
                foreach($success as $message)
                {
                    echo($message);
                }
            ?>            
        </div>
        <?php endif ?>
