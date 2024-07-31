<!DOCTYPE html>
<html>
<head>
    <title>Jessica Wang</title>
    <link rel="stylesheet" href="../edit_comment.css">
    <link rel="stylesheet" href="https://use.typekit.net/ufg7hqz.css">
</head>
<body>

<!-- navigation bar -->
<div id="navbar">
        <div id="nav">
            <ul>
                <li><a href="../main.php#home">Jessica Wang</a></li>
                <li class="right-items">
                    <ul>
                        <li><a href="../main.php#aboutme-section">about</a></li>
				        <li><a href="../main.php#project-section">projects</a></li>
                        <li><a href="../main.php#blog-section">blog</a></li>
                        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) : ?>
                            <li><a href="../login/login.php">login</a></li>
                        <?php else : ?>
                            <li><a href="../login/logout.php">logout</a></li>
                        <?php endif ; ?>
                    </ul>
                </li>
			</ul>
        </div> <!-- #nav -->
    </div> <!-- #navbar -->

    <div class="content">
        <h1>My Educational Journey</h1>
        <p>Hello, everyone! I'm currently a sophomore studying Computer Science at the University of Southern California, but my journey into the tech world began back in Cherry Hill, NJ—a place not as synonymous with tech as the Bay Area. Transitioning from a town with limited tech exposure to one of the most vibrant tech hubs in the country has been both exhilarating and enlightening.</p>
        <h4>Embracing the Challenge</h4>
        <p>Arriving at USC, I was both excited and intimidated by the bustling tech scene. The energy is contagious, and the opportunities are abundant, but diving in wasn't without its challenges. I quickly realized that to thrive here, I needed to step out of my comfort zone and immerse myself fully in what USC and Los Angeles have to offer.</p>
        <h4>Advice for Aspiring SWE Interns</h4>
        For those of you preparing to find a software engineering (SWE) internship, here are some succinct tips based on my experiences so far:

        Build a Solid Foundation: Focus on your CS fundamentals. Classes on data structures, algorithms, and systems programming are your bread and butter. Understand them well!
        Engage in Projects: Whether it's through clubs, personal projects, or school assignments, practical experience will not only solidify your learning but also enrich your resume.
        Network Effectively: Attend tech talks, career fairs, and workshops. USC offers numerous opportunities to meet industry professionals. Don’t hesitate to reach out to alumni; most are willing to offer advice and help you navigate your career path.
        Prepare for Interviews: Start early with mock interviews. Utilize platforms like LeetCode and HackerRank to practice coding problems. Don’t just aim for correct answers; focus on optimizing your solutions.
        Stay Curious and Flexible: Technology evolves rapidly. Keep learning new languages and technologies. Follow tech blogs, subscribe to newsletters, and stay informed about industry trends.</p>
    </div>

</body>
</html>