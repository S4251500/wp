<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userId = filter_var($_SESSION["user_id"] ?? null, FILTER_VALIDATE_INT);
if ($userId === false || $userId < 1) {
    header("Location: login.php");
    exit;
}

$bookId = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);
if ($bookId === false || $bookId < 1) {
    header("Location: books.php");
    exit;
}

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

include __DIR__ . "/assets/includes/database_connectivity.inc";

$book = null;
$errors = [];
$stmt = mysqli_prepare(
    $conn,
    "SELECT title, author, genre, publication_year, price, isbn, book_condition, description, status, image_path
    FROM books
    WHERE book_id = ? AND user_ID = ?
    LIMIT 1"
);

if ($stmt === false) {
    error_log("Unable to prepare owned book query: " . mysqli_error($conn));
    $errors[] = "This book could not be loaded right now. Please try again later.";
} elseif (
    !mysqli_stmt_bind_param($stmt, "ii", $bookId, $userId)
    || !mysqli_stmt_execute($stmt)
    || !mysqli_stmt_bind_result(
        $stmt,
        $title,
        $author,
        $genre,
        $publicationYear,
        $price,
        $isbn,
        $bookCondition,
        $description,
        $status,
        $imagePath
    )
) {
    error_log("Unable to retrieve owned book: " . mysqli_stmt_error($stmt));
    $errors[] = "This book could not be loaded right now. Please try again later.";
    mysqli_stmt_close($stmt);
} else {
    if (mysqli_stmt_fetch($stmt)) {
        $book = [
            "title" => $title,
            "author" => $author,
            "genre" => $genre,
            "publication_year" => (string)$publicationYear,
            "price" => (string)$price,
            "isbn" => $isbn,
            "book_condition" => $bookCondition,
            "description" => $description,
            "status" => $status,
            "image_path" => (int)$imagePath
        ];
    }
    mysqli_stmt_close($stmt);
}

if ($book === null && !$errors) {
    http_response_code(404);
    $errors[] = "This book was not found or you do not have permission to edit it.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $book !== null) {
    $postedToken = $_POST["csrf_token"] ?? "";
    if (
        !is_string($postedToken)
        || !hash_equals($_SESSION["csrf_token"], $postedToken)
    ) {
        $errors[] = "Your session expired. Refresh the page and try again.";
    }

    foreach (["title", "author", "genre", "publication_year", "price", "isbn", "book_condition", "description", "status"] as $field) {
        $value = $_POST[$field] ?? "";
        $book[$field] = is_string($value) ? trim($value) : "";
    }

    foreach (["title", "author", "genre", "publication_year", "price", "isbn", "book_condition", "description", "status"] as $field) {
        if ($book[$field] === "") {
            $errors[] = "Please complete all book details.";
            break;
        }
    }

    $publicationYearValue = filter_var($book["publication_year"], FILTER_VALIDATE_INT);
    if (
        $publicationYearValue === false
        || $publicationYearValue < 1
        || $publicationYearValue > 2147483647
    ) {
        $errors[] = "Enter a valid publication year.";
    }
    if (
        !preg_match('/^\d+(?:\.\d{1,2})?$/D', $book["price"])
        || (float)$book["price"] > 999999.99
    ) {
        $errors[] = "Enter a valid price with up to two decimal places.";
    }
    if (
        strlen($book["title"]) > 255
        || strlen($book["author"]) > 255
        || strlen($book["genre"]) > 255
    ) {
        $errors[] = "Title, author, and genre must be 255 characters or fewer.";
    }
    if (strlen($book["isbn"]) > 17) {
        $errors[] = "ISBN must be 17 characters or fewer.";
    }
    if (!in_array($book["book_condition"], ["new", "fair", "old"], true)) {
        $errors[] = "Select a valid book condition.";
    }
    if (!in_array($book["status"], ["available", "unavailable", "sold"], true)) {
        $errors[] = "Select a valid availability status.";
    }

    $replaceCover = false;
    $coverExtension = "";
    $coverUploadError = $_FILES["cover"]["error"] ?? UPLOAD_ERR_NO_FILE;
    if ($coverUploadError !== UPLOAD_ERR_NO_FILE) {
        if ($coverUploadError !== UPLOAD_ERR_OK) {
            $errors[] = "The new cover image could not be uploaded.";
        } elseif ($_FILES["cover"]["size"] > 5 * 1024 * 1024) {
            $errors[] = "The cover image must be 5 MB or smaller.";
        } else {
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($fileInfo === false) {
                error_log("Unable to initialise file type validation for edited book cover.");
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
                    $replaceCover = true;
                }
            }
        }
    }

    if (!$errors) {
        $imagePathValue = $book["image_path"];
        $newCoverPath = null;
        $coverDirectory = __DIR__ . "/assets/images/covers";

        if ($replaceCover) {
            if (!is_dir($coverDirectory) || !is_writable($coverDirectory)) {
                error_log("Book cover directory is missing or not writable: " . $coverDirectory);
                $errors[] = "The cover image could not be saved. Please try again later.";
            } else {
                try {
                    $imagePathAvailable = false;
                    for ($attempt = 0; $attempt < 10; $attempt++) {
                        $candidateImagePath = random_int(1, 2147483647);
                        $candidateCoverPath = $coverDirectory . "/" . $candidateImagePath . "." . $coverExtension;
                        if (
                            is_file($coverDirectory . "/" . $candidateImagePath . ".jpg")
                            || is_file($coverDirectory . "/" . $candidateImagePath . ".png")
                        ) {
                            continue;
                        }

                        $coverCheckStmt = mysqli_prepare(
                            $conn,
                            "SELECT image_path FROM books WHERE image_path = ? LIMIT 1"
                        );
                        if ($coverCheckStmt === false) {
                            error_log("Unable to prepare edited cover path check: " . mysqli_error($conn));
                            $errors[] = "The cover image could not be saved. Please try again later.";
                            break;
                        }
                        if (
                            !mysqli_stmt_bind_param($coverCheckStmt, "i", $candidateImagePath)
                            || !mysqli_stmt_execute($coverCheckStmt)
                            || !mysqli_stmt_store_result($coverCheckStmt)
                        ) {
                            error_log("Unable to check edited cover path: " . mysqli_stmt_error($coverCheckStmt));
                            $errors[] = "The cover image could not be saved. Please try again later.";
                            mysqli_stmt_close($coverCheckStmt);
                            break;
                        }

                        $candidateInUse = mysqli_stmt_num_rows($coverCheckStmt) > 0;
                        mysqli_stmt_close($coverCheckStmt);
                        if (!$candidateInUse) {
                            $imagePathAvailable = true;
                            $imagePathValue = $candidateImagePath;
                            $newCoverPath = $candidateCoverPath;
                            break;
                        }
                    }
                    if (!$errors && !$imagePathAvailable) {
                        error_log("Unable to find an unused edited cover image path after 10 attempts.");
                        $errors[] = "A cover image filename could not be generated. Please try again.";
                    }
                } catch (Exception $exception) {
                    error_log("Unable to generate an edited book cover ID: " . $exception->getMessage());
                    $errors[] = "The cover image could not be saved. Please try again later.";
                }
            }
        }

        $newCoverSaved = false;
        if (!$errors && $replaceCover) {
            if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $newCoverPath)) {
                error_log("Unable to save edited book cover to: " . $newCoverPath);
                $errors[] = "The cover image could not be saved. Please try again later.";
            } else {
                $newCoverSaved = true;
            }
        }

        if (!$errors) {
            $priceValue = (float)$book["price"];
            $stmt = mysqli_prepare(
                $conn,
                "UPDATE books
                SET title = ?, author = ?, genre = ?, publication_year = ?, price = ?, isbn = ?,
                    book_condition = ?, description = ?, status = ?, image_path = ?
                WHERE book_id = ? AND user_ID = ?"
            );
            if ($stmt === false) {
                error_log("Unable to prepare book update: " . mysqli_error($conn));
                $errors[] = "The book could not be updated. Please try again later.";
            } elseif (
                !mysqli_stmt_bind_param(
                    $stmt,
                    "sssidssssiii",
                    $book["title"],
                    $book["author"],
                    $book["genre"],
                    $publicationYearValue,
                    $priceValue,
                    $book["isbn"],
                    $book["book_condition"],
                    $book["description"],
                    $book["status"],
                    $imagePathValue,
                    $bookId,
                    $userId
                )
                || !mysqli_stmt_execute($stmt)
            ) {
                error_log("Unable to update book: " . mysqli_stmt_error($stmt));
                $errors[] = "The book could not be updated. Please try again later.";
                mysqli_stmt_close($stmt);
            } else {
                mysqli_stmt_close($stmt);
                $notice = "Book updated successfully.";
                if ($replaceCover) {
                    $oldImagePath = $book["image_path"];
                    $oldImageNumber = filter_var($oldImagePath, FILTER_VALIDATE_INT);
                    if ($oldImageNumber !== false && $oldImageNumber > 0) {
                        $referenceStmt = mysqli_prepare(
                            $conn,
                            "SELECT image_path FROM books WHERE image_path = ? LIMIT 1"
                        );
                        if (
                            $referenceStmt === false
                            || !mysqli_stmt_bind_param($referenceStmt, "i", $oldImageNumber)
                            || !mysqli_stmt_execute($referenceStmt)
                            || !mysqli_stmt_store_result($referenceStmt)
                        ) {
                            error_log("Unable to check old cover references: " . mysqli_error($conn));
                            $notice = "Book updated, but the old cover image could not be checked for cleanup.";
                            if ($referenceStmt !== false) {
                                mysqli_stmt_close($referenceStmt);
                            }
                        } else {
                            $oldCoverStillUsed = mysqli_stmt_num_rows($referenceStmt) > 0;
                            mysqli_stmt_close($referenceStmt);
                            if (!$oldCoverStillUsed) {
                                $oldCoverFound = false;
                                foreach (["jpg", "png"] as $extension) {
                                    $oldCoverPath = $coverDirectory . "/" . $oldImageNumber . "." . $extension;
                                    if (is_file($oldCoverPath)) {
                                        $oldCoverFound = true;
                                        if (!unlink($oldCoverPath)) {
                                            error_log("Unable to remove replaced book cover: " . $oldCoverPath);
                                            $notice = "Book updated, but the old cover image could not be removed.";
                                        }
                                    }
                                }
                                if (!$oldCoverFound) {
                                    error_log("Replaced book cover file was not found for image path " . $oldImageNumber);
                                }
                            }
                        }
                    }
                }
                $_SESSION["book_notice"] = $notice;
                header("Location: details.php?isbn=" . rawurlencode($book["isbn"]));
                exit;
            }
        }

        if ($errors && $newCoverSaved && is_file($newCoverPath)) {
            if (!unlink($newCoverPath)) {
                error_log("Unable to remove unused uploaded cover: " . $newCoverPath);
            }
        }
    }
}

$pageTitle = "Edit Book - BookVerse";
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";

$currentCover = null;
$currentCoverNumber = filter_var($book["image_path"] ?? null, FILTER_VALIDATE_INT);
if ($currentCoverNumber !== false && $currentCoverNumber > 0) {
    foreach (["jpg", "png"] as $extension) {
        $coverPath = __DIR__ . "/assets/images/covers/" . $currentCoverNumber . "." . $extension;
        if (is_file($coverPath)) {
            $currentCover = "./assets/images/covers/" . $currentCoverNumber . "." . $extension;
            break;
        }
    }
}
?>
<main class="container content edit-content">
    <h1 class="add-title"><span aria-hidden="true">&#9998;</span>Edit Book</h1>
    <?php if ($errors): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach (array_unique($errors) as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($book !== null): ?>
        <form class="add-form edit-form" method="post" enctype="multipart/form-data"
            action="edit.php?id=<?php echo (int)$bookId; ?>">
            <input type="hidden" name="csrf_token"
                value="<?php echo htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8"); ?>">

            <div class="form-field full-width">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" maxlength="255" required
                    value="<?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="form-field full-width">
                <label for="author">Author *</label>
                <input type="text" id="author" name="author" maxlength="255" required
                    value="<?php echo htmlspecialchars($book["author"], ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="form-field full-width">
                <label for="genre">Genre *</label>
                <select id="genre" name="genre" required>
                    <option value="">Select a genre</option>
                    <?php foreach (["Fiction", "Non-Fiction", "Science Fiction", "Fantasy"] as $genreOption): ?>
                        <option value="<?php echo htmlspecialchars($genreOption, ENT_QUOTES, "UTF-8"); ?>"
                            <?php echo $book["genre"] === $genreOption ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($genreOption, ENT_QUOTES, "UTF-8"); ?>
                        </option>
                    <?php endforeach; ?>
                    <?php if (!in_array($book["genre"], ["Fiction", "Non-Fiction", "Science Fiction", "Fantasy"], true)): ?>
                        <option value="<?php echo htmlspecialchars($book["genre"], ENT_QUOTES, "UTF-8"); ?>" selected>
                            <?php echo htmlspecialchars($book["genre"], ENT_QUOTES, "UTF-8"); ?>
                        </option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-field edit-inline-field">
                <label for="publication-year">Publication Year *</label>
                <input type="number" id="publication-year" name="publication_year" min="1" step="1" required
                    value="<?php echo htmlspecialchars($book["publication_year"], ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="form-field edit-inline-field">
                <label for="price">Price *</label>
                <input type="number" id="price" name="price" min="0" step="0.01" required
                    value="<?php echo htmlspecialchars($book["price"], ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="form-field full-width">
                <label for="isbn">ISBN *</label>
                <input type="text" id="isbn" name="isbn" maxlength="17" required
                    value="<?php echo htmlspecialchars($book["isbn"], ENT_QUOTES, "UTF-8"); ?>">
            </div>
            <div class="form-field edit-inline-field">
                <label for="book-condition">Condition *</label>
                <select id="book-condition" name="book_condition" required>
                    <option value="new" <?php echo $book["book_condition"] === "new" ? "selected" : ""; ?>>New</option>
                    <option value="fair" <?php echo $book["book_condition"] === "fair" ? "selected" : ""; ?>>Fair</option>
                    <option value="old" <?php echo $book["book_condition"] === "old" ? "selected" : ""; ?>>Old</option>
                </select>
            </div>
            <div class="form-field full-width">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($book["description"], ENT_QUOTES, "UTF-8"); ?></textarea>
            </div>
            <div class="form-field full-width">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="available" <?php echo $book["status"] === "available" ? "selected" : ""; ?>>Available</option>
                    <option value="unavailable" <?php echo $book["status"] === "unavailable" ? "selected" : ""; ?>>Unavailable</option>
                    <option value="sold" <?php echo $book["status"] === "sold" ? "selected" : ""; ?>>Sold</option>
                </select>
            </div>
            <div class="form-field full-width">
                <label for="cover">Cover Image (optional)</label>
                <?php if ($currentCover !== null): ?>
                    <img class="edit-cover-preview" src="<?php echo htmlspecialchars($currentCover, ENT_QUOTES, "UTF-8"); ?>"
                        alt="Current cover of <?php echo htmlspecialchars($book["title"], ENT_QUOTES, "UTF-8"); ?>">
                <?php else: ?>
                    <p class="edit-cover-missing">No current cover image is available.</p>
                <?php endif; ?>
                <input type="file" id="cover" name="cover" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <small>Leave this empty to keep the current cover. JPG or PNG, up to 5 MB.</small>
            </div>
            <button type="submit" class="btn add-submit edit-submit">Save Changes</button>
        </form>
    <?php endif; ?>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
