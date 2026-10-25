<?php
$formData = [
    "title" => "",
    "author" => "",
    "genre" => "",
    "year" => "",
    "price" => "",
    "isbn" => "",
    "condition" => "",
    "description" => "",
    "availability" => "available"
];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (array_keys($formData) as $field) {
        if ($field !== "availability") {
            $value = $_POST[$field] ?? "";
            $formData[$field] = is_string($value) ? trim($value) : "";
        }
    }
    $availability = $_POST["availability"] ?? "";
    $formData["availability"] = is_string($availability) ? $availability : "";

    foreach (["title", "author", "genre", "year", "price", "isbn", "condition", "description"] as $field) {
        if ($formData[$field] === "") {
            $errors[] = "Please complete all book details.";
            break;
        }
    }

    if (!filter_var($formData["year"], FILTER_VALIDATE_INT) || (int)$formData["year"] < 1) {
        $errors[] = "Enter a valid publication year.";
    }
    if (
        !preg_match('/^\d+(?:\.\d{1,2})?$/D', $formData["price"])
        || (float)$formData["price"] > 99999999.99
    ) {
        $errors[] = "Enter a valid price with up to two decimal places.";
    }
    if (strlen($formData["title"]) > 255 || strlen($formData["author"]) > 255 || strlen($formData["genre"]) > 255) {
        $errors[] = "Title, author, and genre must each be 255 characters or fewer.";
    }
    if (strlen($formData["isbn"]) > 17) {
        $errors[] = "ISBN must be 17 characters or fewer.";
    }
    if (!in_array($formData["condition"], ["new", "fair", "old"], true)) {
        $errors[] = "Select a valid book condition.";
    }
    if (!in_array($formData["availability"], ["available", "unavailable", "sold"], true)) {
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

        $coverDirectory = __DIR__ . "/assets/images/covers";
        if (!is_dir($coverDirectory) || !is_writable($coverDirectory)) {
            error_log("Book cover directory is missing or not writable: " . $coverDirectory);
            $errors[] = "The cover image could not be saved. Please try again later.";
        } else {
            try {
                $coverID = bin2hex(random_bytes(6));
            } catch (Exception $exception) {
                error_log("Unable to generate a unique book cover ID: " . $exception->getMessage());
                $errors[] = "The cover image could not be saved. Please try again later.";
            }

            if (!$errors) {
                $coverFilename = $coverID . "." . $coverExtension;
                $coverPath = $coverDirectory . "/" . $coverFilename;
            }

            if (!$errors && !move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
                error_log("Unable to save uploaded book cover to: " . $coverPath);
                $errors[] = "The cover image could not be saved. Please try again.";
            } elseif (!$errors) {
                $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO books (title, author, genre, publication, price, isbn, `condition`, description, availability, coverID)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if ($stmt === false) {
                    error_log("Unable to prepare book insert: " . mysqli_error($conn));
                    $errors[] = "The book could not be added. Please try again later.";
                    unlink($coverPath);
                } else {
                    $publication = (int)$formData["year"];
                    $price = (float)$formData["price"];
                    if (
                        !mysqli_stmt_bind_param(
                            $stmt,
                            "sssidsssss",
                            $formData["title"],
                            $formData["author"],
                            $formData["genre"],
                            $publication,
                            $price,
                            $formData["isbn"],
                            $formData["condition"],
                            $formData["description"],
                            $formData["availability"],
                            $coverID
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
            <input type="number" id="publication-year" name="year" placeholder="2024" min="1" step="1" required
                value="<?php echo htmlspecialchars($formData["year"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="price"><img src="./assets/images/money.svg" alt="" aria-hidden="true">Price ($)</label>
            <input type="number" id="price" name="price" placeholder="19.99" min="0" step="0.01" required
                value="<?php echo htmlspecialchars($formData["price"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="978-1-234567-89-0" maxlength="17" required
                value="<?php echo htmlspecialchars($formData["isbn"], ENT_QUOTES, "UTF-8"); ?>">
        </div>

        <div class="form-field">
            <label for="condition"><img src="./assets/images/bookCondition.svg" alt="" aria-hidden="true">Book
                Condition</label>
            <select id="condition" name="condition" required>
                <option value="" <?php echo $formData["condition"] === "" ? "selected" : ""; ?>>Select condition</option>
                <option value="new" <?php echo $formData["condition"] === "new" ? "selected" : ""; ?>>New</option>
                <option value="fair" <?php echo $formData["condition"] === "fair" ? "selected" : ""; ?>>Good</option>
                <option value="old" <?php echo $formData["condition"] === "old" ? "selected" : ""; ?>>Used</option>
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
            <label for="availability"><img src="./assets/images/availability.svg" alt=""
                    aria-hidden="true">Availability Status</label>
            <select id="availability" name="availability" required>
                <option value="available" <?php echo $formData["availability"] === "available" ? "selected" : ""; ?>>Available</option>
                <option value="unavailable" <?php echo $formData["availability"] === "unavailable" ? "selected" : ""; ?>>Unavailable</option>
                <option value="sold" <?php echo $formData["availability"] === "sold" ? "selected" : ""; ?>>Sold</option>
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
