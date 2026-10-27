<body>
    <header class="navbar">
        <div class="nav-logo">
            <a href="index.php">
                <img src="./assets/images/BookVerse.svg" alt="Logo" class="logo-img">
                <span class="site-title">BookVerse</span>
            </a>
        </div>

        <nav aria-label="Main navigation">
            <ul class="nav-links">
                <li><a href="index.php"><img src="./assets/images/home.svg" class="nav-link-icon"
                            aria-hidden="true"></img>Home</a></li>
                <li><a href="books.php"><img src="./assets/images/browse.svg" class="nav-link-icon"
                            aria-hidden="true"></img>Browse Books</a></li>
                <li><a href="gallery.php"><img src="./assets/images/galleryIcon.svg" class="nav-link-icon"
                            aria-hidden="true"></img>Gallery</a></li>
                <li><a href="add.php"><img src="./assets/images/add.svg" class="nav-link-icon"
                            aria-hidden="true"></img>Add Book</a></li>
            </ul>
        </nav>

        <ul class="nav-account-links" aria-label="Account navigation">
            <?php if (isset($_SESSION["username"])): ?>
                <li class="dropdown">
                    <button class="nav-account-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg class="nav-account-icon" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1c-2.7 0-5 1.4-5 3.2V14h10v-1.8C13 10.4 10.7 9 8 9z"></path>
                        </svg>
                        <?php echo htmlspecialchars((string) $_SESSION["username"], ENT_QUOTES, "UTF-8"); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end nav-account-dropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <a href="login.php">
                        <svg class="nav-link-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M10 17l5-5-5-5M15 12H3m9-9h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-8"></path>
                        </svg>
                        Login
                    </a>
                </li>
                <li>
                    <a href="register.php">
                        <svg class="nav-link-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm10-4v6m-3-3h6"></path>
                        </svg>
                        Register
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </header>