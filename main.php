<?php

	require 'config/config.php';

	// Establish MySQL Connection.
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check for any Connection Errors.
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

    //handle user's comments input
    if (isset($_POST['submit_comment']) && isset($_POST['content'])) {
        $content = $mysqli->real_escape_string($_POST['content']);
        $user_id = 1; //change this later to dynamically set based on sessions

        $insert_sql = "INSERT INTO comments (user_id, content) VALUES ($user_id, '$content');";
        if ($mysqli->query($insert_sql)) {
            header("Location: main.php");
            exit();
        }
        else {
            echo $mysqli->error;
        }
    }

    //retrive all comments from DB
    $sql_comments = "SELECT * FROM comments ORDER BY comment_date DESC;";
    $results_comments = $mysqli->query($sql_comments);

    if (!$results_comments) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

	// Retrieve all blog posts from the DB.
	$sql_posts = "SELECT * FROM blogs ORDER BY post_date DESC;";

	$results_posts = $mysqli->query( $sql_posts);

	// Check for SQL Errors.
	if ( !$results_posts) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    //handle edit and delete comment functionality
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] == 'delete_comment' && isset($_POST['comment_id'])) {
            // SQL to delete comment
            $comment_id = $mysqli->real_escape_string($_POST['comment_id']);
            $sql = "DELETE FROM comments WHERE comment_id = $comment_id";
            if ($mysqli->query($sql)) {
                header("Location: {$_SERVER['PHP_SELF']}");
                exit;
            } else {
                echo $mysqli->error;
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'edit_comment' && isset($_POST['comment_id'])) {
            // SQL to select comment
            $comment_id = $mysqli->real_escape_string($_POST['comment_id']);
            $sql = "SELECT content FROM comments WHERE comment_id = $comment_id";
            $result = $mysqli->query($sql);
            if ($result && $result->num_rows > 0) {
                $comment = $result->fetch_assoc();
                $edit_content = $comment['content'];
                // This form can be shown in a modal or on a separate page
                echo "<form action='' method='POST'>
                          <input type='hidden' name='comment_id' value='$comment_id'>
                          <textarea name='new_content'>$edit_content</textarea>
                          <button type='submit' name='action' value='update_comment'>Update Comment</button>
                      </form>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'update_comment' && isset($_POST['comment_id'])) {
            echo 'in update section';
            // SQL to update comment
            $comment_id = $mysqli->real_escape_string($_POST['comment_id']);
            $new_content = $mysqli->real_escape_string($_POST['new_content']);
            $sql = "UPDATE comments SET content = '$new_content' WHERE comment_id = $comment_id AND user_id = {$_SESSION['user_id']}";
            if ($mysqli->query($sql)) {
                header("Location: {$_SERVER['PHP_SELF']}");
                exit;
            } else {
                echo $mysqli->error;
            }
        }
    }

    //count total number of comments
    $count_sql = "SELECT COUNT(*) AS total_comments FROM comments;";
    $count_result = $mysqli->query($count_sql);
    if ($count_result) {
        $count_row = $count_result->fetch_assoc();
        $total_comments = $count_row['total_comments']; // This holds the total number of comments
    } else {
        echo $mysqli->error;
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Jessica Wang, portfolio, USC">
    <meta name="description" content="Jessica Wang, computer science at USC, portfolio, personal projects, education, blog, hobbies">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://use.typekit.net/ufg7hqz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <title>Jessica Wang</title>

</head>
<body>
    <!-- navigation bar -->
    <div id="navbar">
        <div id="nav">
            <ul>
                <li><a href="#intro-section">Jessica Wang</a></li>
                <li class="right-items">
                    <ul>
                        <li><a href="#aboutme-section">about</a></li>
				        <li><a href="#project-section">projects</a></li>
                        <li><a href="#blog-section">blog</a></li>
                        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) : ?>
                            <li><a href="login/login.php">login</a></li>
                        <?php else : ?>
                            <li><a href="login/logout.php">logout</a></li>
                        <?php endif ; ?>
                    </ul>
                </li>
			</ul>
        </div> <!-- #nav -->
    </div> <!-- #navbar -->

    <div id="container">
        <!-- intro section  -->
        <section id="intro-section">
            <div class="container-row">
                <div class="left">
                    <h1 id="name">JESSICA WANG</h1>
                    <p id="app"></p>
                </div>
                <div id="right">
                    <img src="img/headshot.png" id="profilepic">
                    <div class="social-icons">
                        <a href="https://github.com/jessicawang1218" target="_blank" class="icon">
                            <i class="fab fa-github"></i>
                        </a>
                        <p>/</p>
                        <a href="https://www.linkedin.com/in/jessica-wang-357a331b0/" target="_blank" class="icon">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <p>/</p>
                        <a href="mailto:jmwang@usc.edu" target="_blank" class="icon">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <!-- Add more icons as needed -->
                    </div>
                </div>
            </div>
            <a href="#aboutme-section" class="arrow"></a>
        </section>


         <!-- aboutme section  -->
        <section id="aboutme-section">
            <p id="aboutme">package aboutMe;</p>
            <p class="aboutme-text">I'm a junior at the University of Southern California studying Computer Science. I am passionate about using technology
                to brainstorm solutions that drive social change. </p>
            <p class="aboutme-text">Currently, I work as an undergraduate researcher at the Interaction Lab, which focuses on conducting
                research at the intersection of computing, engineering, human subject studies to develop Socially Assistive Robotics.
                My team and I are currently working on publishing a research study that evaluates the performance of SAR Blossom guiding
                participants through cognitive behavioral therapy.
            </p>
            <p class="aboutme-text">Previously, I was also a researcher at Stanford University's Future of Digital Currency Initiative, where I assisted in creating
                a smart-contract execution engine that automates transactions and contract, eliminating the need for intermediaries. </p>
            <p class="aboutme-text">In my spare time, you can find me searching for the next best street taco in LA, playing tennis, or playing card/board games! </p>
            <p class="aboutme-text">I'm looking for opportunities where I can leverage both my technical and problem solving skills to create impactful solutions.
            Feel free to reach out via jmwang@usc.edu! </p>
        </section>

        <!-- projects section -->
        <section class="container column" id="project-section">
            <h1 class="title">PROJECTS</h1>

            <!--Filter Buttons-->
            <div class="container row" id="button-section">
                <button class="filter-button active" onclick="filterSelection('all')">All</button>
                <button class="filter-button" onclick="filterSelection('research')">Research</button>
                <button class="filter-button" onclick="filterSelection('java')">Java</button>
                <button class="filter-button" onclick="filterSelection('web')">Web Dev</button>
            </div>

            <!--Individual Projects-->
            <div class="container row" id="project-container">

                <div class="each-project research">
                    <img class="proj-img" src="img/smartcontract.png"/>
                    <div class="proj-description container column">
                    <div class="img-description">
                        <h2>Groundhog Smart Contract</h2>
                        <p>Formulated a mini version of a <b>smart-contract</b> execution engine that automates transactions using <b>C++</b></h3>
                        <br>
                        <br>
                        <i>Research</i>
                    </div>
                    </div>
                </div>

                <div class="each-project research">
                    <img class="proj-img" src="img/blossom.png"/>
                    <div class="proj-description container column">
                    <div class="img-description">
                        <h2>Socially Assistive Robots</h2>
                        <p>In the works of publishing a research study to evaluate the performance of socially assistive robot Blossom applying <b>large language model</b> concepts 
                        <b>R studio</b>, and <b>Python</b> coding skills</p>
                        <br>
                        <i>Research</i>
                    </div>
                    </div>
                </div>

                <div class="each-project java">
                    <img class="proj-img" src="img/checkerboard.png"/>
                    <div class="proj-description container column">
                    <div class="img-description">
                        <h2>Checkerboard</h2>
                        <p>Implemented checkerboard game with a <b>GUI</b>. Implemented the AI player using <b>game trees</b> and <b>alpha-beta pruning</b>.</p>
                        <br>
                        <i>Java</i>
                    </div>
                    </div>
                </div>

                <div class="each-project web">
                    <img class="proj-img" src="img/personalwebsite.png"/>
                    <div class="proj-description container column">
                    <div class="img-description">
                        <h2>Personal Website</h2>
                        <p>This website was made from pure <b>HTML/CSS</b>!</p>
                        <br>
                        <i>HTML / CSS / JavaScript</i>
                    </div>
                    </div>
                </div>

            </div>
        </section>

    <!-- blog section -->
        <section id="blog-section">
            <h1 class="title">Blog</h1>
            <div class="article-list">
                <?php while ($row = $results_posts->fetch_assoc()): ?>
                <div class="article" onclick="location.href='blog_db/article<?= $row['post_id']; ?>.php';">
                    <p class="article-number">0<?= $row['post_id']; ?></p>
                    <img class="article-image" src="<?= $row['image_url']; ?>">
                    <div class="article-content">
                        <h3 class="article-title"><?= $row['title']; ?></h3>
                        <span class="article-info"><?= date("M d, Y", strtotime($row['post_date'])); ?> · <?= $row['read_time']; ?> min read</span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>


        <section class="comment-section">
            <h1 id="comment-title">Comments (<?php echo $total_comments; ?>)</h1>
            <!-- input field to allow users to comment, anything that users comment should be stored into my php comments table -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) :?>
                <form action="" method="POST">
                    <div class="form-row">
                        <textarea name="content" required></textarea>
                        <button type="submit" name="submit_comment">Post Comment</button>
                    </div>
                </form>
            <?php endif ; ?>
            <!-- display all user comments, retrieve data from my comments table -->
            <?php while ($comment = $results_comments->fetch_assoc()): ?>
                <div class="comment">
                    <p class="comment-content"><?= htmlspecialchars($comment['content']); ?></p>
                    <p class="comment-date"><?= $comment['comment_date']; ?></p>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['username']) && $_SESSION['username'] == 'jessica') : ?>
                        <div class="button-container">
                            <form action="edit_comment.php" method="GET">
                                <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </form>
                            <form action="" method="POST">
                                <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                                <button type="submit" name="action" value="delete_comment">Delete</button>
                            </form>
                        </div>
                        <hr>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>

        </section>

        <?php $mysqli->close(); ?>

                        
    </div> <!-- #container -->


    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
    <script src="scripts.js"></script>


</body>
</html>


<!-- #
 <div id="console">
    <span class="first-color">public</span>
    <span class="third-color">class</span>
    <span class="fifth-color">Jessica</span>
    <span class="second-color">{</span>
    <br>
    <ul>
        <span class="first-color">public</span>
        <span class="fifth-color">Jessica</span><!-- 
        <span class="second-color">() {</span>
        <br>
        <ul>
            <span class="third-color">String</span>
            <span class="second-color">fullName = </span>
            <span class="fourth-color">"Jessica Wang"</span><span class="second-color">;</span>
            <br>
            <span class="third-color">String</span>
            <span class="second-color">identity = </span>
            <span class="fourth-color">"Taiwanese American"</span><span class="second-color">;</span>
            <br>
            <span class="third-color">String</span>
            <span class="second-color">school = </span>
            <span class="fourth-color">"USC"</span><span class="second-color">;</span>
            <br>
            <span class="third-color">String</span>
            <span class="second-color">expectedGraduation = </span>
            <span class="fourth-color">"Spring 2026"</span><span class="second-color">;</span>
            <br>
            <span class="third-color">String[]</span>
            <span class="second-color">hobbiesAndInterests = </span>
            <span class="first-color">new </span>
            <span class="third-color">String[]</span>
            <span class="second-color">{</span>
            <br>
            <ul>
                <span class="fourth-color">"tennis"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"trying new foods at night markets"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"cello"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"card/board games"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"dancing"</span>
                <br>
            </ul>
            <span class="second-color">}</span>
            <br>
            <span class="third-color">String[]</span>
            <span class="second-color">relevantCoursework = </span>
            <span class="first-color">new </span>
            <span class="third-color">String[]</span>
            <span class="second-color">{</span>
            <br>
            <ul>
                <span class="fourth-color">"data structures and algorithms"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"discrete mathematics"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"introduction to embedded systems"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"principles of software development (java and SQL)"</span><span class="second-color">,</span>
                <br>
                <span class="fourth-color">"full-stack web development"</span><span class="second-color">,</span>
                <br>
            </ul>
            <span class="second-color">}</span>
            <br>
    </ul>
    <span class="second-color">}</span>
</div>
-->
