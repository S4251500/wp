<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userId = filter_var($_SESSION["user_id"] ?? null, FILTER_VALIDATE_INT);
if ($userId === false || $userId < 1) {
    header("Location: login.php");
    exit;
}

$formData = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "publication_year" => "",
    "price" => "",
    "isbn" => "",
    "book_condition" => "",
    "description" => "",
    "status" => "available"
];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (array_keys($formData) as $field) {
        if ($field !== "status") {
            $value = $_POST[$field] ?? "";
            $formData[$field] = is_string($value) ? trim($value) : "";
        }
    }
    $status = $_POST["status"] ?? "";
    $formData["status"] = is_string($status) ? $status : "";

    foreach (["title", "author", "genre", "publication_year", "price", "isbn", "book_condition", "description"] as $field) {
        if ($formData[$field] === "") {
            $errors[] = "Please complete all book details.";
            break;
        }
    }

    $publication_year = filter_var($formData["publication_year"], FILTER_VALIDATE_INT);
    if ($publication_year === false || $publication_year < 1 || $publication_year > 2147483647) {
        $errors[] = "Enter a valid publication year.";
    }
    if (
        !preg_match('/^\d+(?:\.\d{1,2})?$/D', $formData["price"])
        || (float)$formData["price"] > 999999.99
    ) {
        $errors[] = "Enter a valid price with up to two decimal places.";
    }
    if (strlen($formData["title"]) > 255 || strlen($formData["author"]) > 255 || strlen($formData["genre"]) > 100) {
        $errors[] = "Title and author must be 255 characters or fewer, and genre must be 100 characters or fewer.";
    }
    if (strlen($formData["isbn"]) > 20) {
        $errors[] = "ISBN must be 20 characters or fewer.";
    }
    if (!in_array($formData["book_condition"], ["new", "fair", "old"], true)) {
        $errors[] = "Select a valid book condition.";
    }
    if (!in_array($formData["status"], ["available", "unavailable", "sold"], true)) {
        $errors[] = "Select a valid availability status.";
    }
    if (!isset($_POST["agreement"])) {
        $errors[] = "Please confirm that the book information is accurate.";
    }

    $coverExtension = "";
    if (!isset($_FILES["cover"]) || $_FILES["cover"]["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "Choose a cover image to upload.";
    } elseif ($_FILES["cover"]["size"] > 5 * 1024 * 1024) {
        $errors[] = "The cover image must be 5 MB or smaller.";
    } else {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($fileInfo === false) {
            error_log("Unable to initialise file type validation for book cover upload.");
            $errors[] = "The cover image could not be validated. Please try again.";
        } else {
            $mimeType = finfo_file($fileInfo, $_FILES["cover"]["tmp_name"]);
            finfo_close($fileInfo);
            $allowedMimeTypes = [
                "image/jpeg" => "jpg",
                "image/png" => "png"
            ];
            if ($mimeType === false || !isset($allowedMimeTypes[$mimeType])) {
                $errors[] = "Upload a valid JPG or PNG cover image.";
            } else {
                $coverExtension = $allowedMimeTypes[$mimeType];
            }
        }
    }

    if (!$errors) {
        include __DIR__ . "/assets/includes/database_connectivity.inc";

        $coverDirectory = __DIR__ . "/assets/images";
        if (!is_dir($coverDirectory) || !is_writable($coverDirectory)) {
            error_log("Book cover directory is missing or not writable: " . $coverDirectory);
            $errors[] = "The cover image could not be saved. Please try again later.";
        } else {
            try {
                $imagePathAvailable = false;
                for ($attempt = 0; $attempt < 10; $attempt++) {
                    $imageNumber = random_int(1, 2147483647);
                    $coverPath = $coverDirectory . "/" . $imageNumber . "." . $coverExtension;
                    $image_path = $imageNumber;

                    if (
                        is_file($coverDirectory . "/" . $imageNumber . ".jpg")
                        || is_file($coverDirectory . "/" . $imageNumber . ".png")
                    ) {
                        continue;
                    }

                    $coverCheckStmt = mysqli_prepare(
                        $conn,
                        "SELECT image_path FROM books WHERE image_path = ? LIMIT 1"
                    );
                    if ($coverCheckStmt === false) {
                        error_log("Unable to prepare book image path check: " . mysqli_error($conn));
                        $errors[] = "The cover image could not be saved. Please try again later.";
                        break;
                    }

                    if (
                        !mysqli_stmt_bind_param($coverCheckStmt, "i", $image_path)
                        || !mysqli_stmt_execute($coverCheckStmt)
                        || !mysqli_stmt_store_result($coverCheckStmt)
                    ) {
                        error_log("Unable to check book image path: " . mysqli_stmt_error($coverCheckStmt));
                        $errors[] = "The cover image could not be saved. Please try again later.";
                        mysqli_stmt_close($coverCheckStmt);
                        break;
                    }

                    $image_path_exists = mysqli_stmt_num_rows($coverCheckStmt) > 0;
                    mysqli_stmt_close($coverCheckStmt);
                    if (!$image_path_exists) {
                        $imagePathAvailable = true;
                        break;
                    }
                }

                if (!$errors && !$imagePathAvailable) {
                    error_log("Unable to find an unused book image path after 10 attempts.");
                    $errors[] = "A cover image filename could not be generated. Please try again.";
                }
            } catch (Exception $exception) {
                error_log("Unable to generate a unique book cover ID: " . $exception->getMessage());
                $errors[] = "The cover image could not be saved. Please try again later.";
            }

            if (!$errors && !move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
                error_log("Unable to save uploaded book cover to: " . $coverPath);
                $errors[] = "The cover image could not be saved. Please try again.";
            } elseif (!$errors) {
                $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO books (title, author, genre, publication_year, price, isbn, book_condition, description, status, image_path, user_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if ($stmt === false) {
                    error_log("Unable to prepare book insert: " . mysqli_error($conn));
                    $errors[] = "The book could not be added. Please try again later.";
                    unlink($coverPath);
                } else {
                    $price = (float)$formData["price"];
                    if (
                        !mysqli_stmt_bind_param(
                            $stmt,
                            "sssidssssii",
                            $formData["title"],
                            $formData["author"],
                            $formData["genre"],
                            $publication_year,
                            $price,
                            $formData["isbn"],
                            $formData["book_condition"],
                            $formData["description"],
                            $formData["status"],
                            $image_path,
                            $userId
                        ) || !mysqli_stmt_execute($stmt)
                    ) {
                        error_log("Unable to add book: " . mysqli_stmt_error($stmt));
                        $errors[] = "The book could not be added. Please try again later.";
                        unlink($coverPath);
                    } else {
                        mysqli_stmt_close($stmt);
                        header("Location: add.php?added=1");
                        exit;
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>

<main class="container content add-content">
    <h1 class="add-title"><img src="./assets/images/addIcon.svg" alt="">Add New Book</h1>
    <?php if (isset($_GET["added"])): ?>
        <p class="alert alert-success" role="status">Book added successfully.</p>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach (array_unique($errors) as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form class="add-form" id="addBookForm" method="post" enctype="multipart/form-data">
        <div class="form-field full-width">
            <label for="book-title"><img src="./assets/images/title.svg" alt="" aria-hidden="true">Book
                Title</label>
            <input type="text" id="book-title" name="title" placeholder="Enter book title" maxlength="255" required
                value="<?php echo htmlspecialchars($formData["title"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field full-width">
            <label for="author-name"><img src="./assets/images/author.svg" alt="" aria-hidden="true">Author
                Name</label>
            <input type="text" id="author-name" name="author" placeholder="Enter author name" maxlength="255" required
                value="<?php echo htmlspecialchars($formData["author"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field full-width">
            <label for="genre"><img src="./assets/images/genre.svg" alt="" aria-hidden="true">Genre</label>
            <select id="genre" name="genre" required>
                <option value="" <?php echo $formData["genre"] === "" ? "selected" : ""; ?>>Select a genre</option>
                <?php foreach (["Fiction", "Non-Fiction", "Science Fiction", "Fantasy"] as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre, ENT_QUOTES, "UTF-8"); ?>"
                        <?php echo $formData["genre"] === $genre ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($genre, ENT_QUOTES, "UTF-8"); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-field">
            <label for="publication-year"><img src="./assets/images/year.svg" alt="" aria-hidden="true">Publication
                Year</label>
            <input type="number" id="publication-year" name="publication_year" placeholder="2024" min="1" step="1" required
                value="<?php echo htmlspecialchars($formData["publication_year"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="price"><img src="./assets/images/money.svg" alt="" aria-hidden="true">Price ($)</label>
            <input type="number" id="price" name="price" placeholder="19.99" min="0" step="0.01" required
                value="<?php echo htmlspecialchars($formData["price"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="978-1-234567-89-0" maxlength="20" required
                value="<?php echo htmlspecialchars($formData["isbn"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="book-condition"><img src="./assets/images/bookCondition.svg" alt="" aria-hidden="true">Book
                Condition</label>
            <select id="book-condition" name="book_condition" required>
                <option value="" <?php echo $formData["book_condition"] === "" ? "selected" : ""; ?>>Select condition</option>
                <option value="new" <?php echo $formData["book_condition"] === "new" ? "selected" : ""; ?>>New</option>
                <option value="fair" <?php echo $formData["book_condition"] === "fair" ? "selected" : ""; ?>>Fair</option>
                <option value="old" <?php echo $formData["book_condition"] === "old" ? "selected" : ""; ?>>Old</option>
            </select>
        </div>

        <div class="form-field full-width">
            <label for="description"><img src="./assets/images/writeDescription.svg" alt=""
                    aria-hidden="true">Description</label>
            <textarea id="description" name="description" placeholder="Describe the book..." required><?php echo htmlspecialchars($formData["description"], ENT_QUOTES, "UTF-8"); ?></textarea>
        </div>

        <div class="form-field full-width">
            <label for="cover"><img src="./assets/images/uploadImage.svg" alt="" aria-hidden="true">Upload Cover
                Image</label>
            <input type="file" id="cover" name="cover" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>
            <p id="coverValidationMessage" class="mb-0" aria-live="polite"></p>
        </div>

        <div class="form-field full-width">
            <label for="status"><img src="./assets/images/availability.svg" alt=""
                    aria-hidden="true">Availability Status</label>
            <select id="status" name="status" required>
                <option value="available" <?php echo $formData["status"] === "available" ? "selected" : ""; ?>>Available</option>
                <option value="unavailable" <?php echo $formData["status"] === "unavailable" ? "selected" : ""; ?>>Unavailable</option>
                <option value="sold" <?php echo $formData["status"] === "sold" ? "selected" : ""; ?>>Sold</option>
            </select>
        </div>

        <label class="agreement" for="agreement">
            <input type="checkbox" id="agreement" name="agreement" required>
            <span>I agree that this book information
                is accurate and complete</span>
        </label>

        <button type="submit" class="btn add-submit">Add Book to Collection</button>
    </form>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
