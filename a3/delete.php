<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userId = filter_var($_SESSION["user_id"] ?? null, FILTER_VALIDATE_INT);
if ($userId === false || $userId < 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: books.php");
    exit;
}

$bookId = filter_var($_POST["book_id"] ?? null, FILTER_VALIDATE_INT);
$postedToken = $_POST["csrf_token"] ?? "";
if ($bookId === false || $bookId < 1) {
    http_response_code(400);
    $deleteError = "Invalid book record.";
} elseif (
    !is_string($postedToken)
    || !isset($_SESSION["csrf_token"])
    || !hash_equals($_SESSION["csrf_token"], $postedToken)
) {
    http_response_code(403);
    $deleteError = "Your session expired. Return to the book details and try again.";
} else {
    include __DIR__ . "/assets/includes/database_connectivity.inc";

    $imagePath = null;
    $stmt = mysqli_prepare(
        $conn,
        "SELECT image_path FROM books WHERE book_id = ? AND user_ID = ? LIMIT 1"
    );
    if ($stmt === false) {
        error_log("Unable to prepare owned book delete lookup: " . mysqli_error($conn));
        $deleteError = "The book could not be deleted. Please try again later.";
    } elseif (
        !mysqli_stmt_bind_param($stmt, "ii", $bookId, $userId)
        || !mysqli_stmt_execute($stmt)
        || !mysqli_stmt_bind_result($stmt, $imagePath)
    ) {
        error_log("Unable to retrieve owned book for deletion: " . mysqli_stmt_error($stmt));
        $deleteError = "The book could not be deleted. Please try again later.";
        mysqli_stmt_close($stmt);
    } else {
        $bookFound = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if (!$bookFound) {
            http_response_code(404);
            $deleteError = "This book was not found or you do not have permission to delete it.";
        } else {
            $deleteStmt = mysqli_prepare(
                $conn,
                "DELETE FROM books WHERE book_id = ? AND user_ID = ?"
            );
            if ($deleteStmt === false) {
                error_log("Unable to prepare owned book deletion: " . mysqli_error($conn));
                $deleteError = "The book could not be deleted. Please try again later.";
            } elseif (
                !mysqli_stmt_bind_param($deleteStmt, "ii", $bookId, $userId)
                || !mysqli_stmt_execute($deleteStmt)
            ) {
                error_log("Unable to delete owned book: " . mysqli_stmt_error($deleteStmt));
                $deleteError = "The book could not be deleted. Please try again later.";
                mysqli_stmt_close($deleteStmt);
            } else {
                $deletedRows = mysqli_stmt_affected_rows($deleteStmt);
                mysqli_stmt_close($deleteStmt);
                if ($deletedRows !== 1) {
                    http_response_code(404);
                    $deleteError = "This book was not found or you do not have permission to delete it.";
                } else {
                    $notice = "Book deleted successfully.";
                    $imageNumber = filter_var($imagePath, FILTER_VALIDATE_INT);
                    if ($imageNumber !== false && $imageNumber > 0) {
                        $referenceStmt = mysqli_prepare(
                            $conn,
                            "SELECT image_path FROM books WHERE image_path = ? LIMIT 1"
                        );
                        if (
                            $referenceStmt === false
                            || !mysqli_stmt_bind_param($referenceStmt, "i", $imageNumber)
                            || !mysqli_stmt_execute($referenceStmt)
                            || !mysqli_stmt_store_result($referenceStmt)
                        ) {
                            error_log("Unable to check deleted book cover references: " . mysqli_error($conn));
                            $notice = "Book deleted, but its cover image could not be checked for cleanup.";
                            if ($referenceStmt !== false) {
                                mysqli_stmt_close($referenceStmt);
                            }
                        } else {
                            $coverStillUsed = mysqli_stmt_num_rows($referenceStmt) > 0;
                            mysqli_stmt_close($referenceStmt);
                            if (!$coverStillUsed) {
                                $coverFound = false;
                                foreach (["jpg", "png"] as $extension) {
                                    $coverPath = __DIR__ . "/assets/images/covers/" . $imageNumber . "." . $extension;
                                    if (is_file($coverPath)) {
                                        $coverFound = true;
                                        if (!unlink($coverPath)) {
                                            error_log("Unable to remove deleted book cover: " . $coverPath);
                                            $notice = "Book deleted, but its cover image could not be removed.";
                                        }
                                    }
                                }
                                if (!$coverFound) {
                                    error_log("Deleted book cover file was not found for image path " . $imageNumber);
                                }
                            }
                        }
                    }

                    $_SESSION["book_notice"] = $notice;
                    header("Location: books.php");
                    exit;
                }
            }
        }
    }
}

$pageTitle = "Delete Book - BookVerse";
include __DIR__ . "/assets/includes/header.inc";
include __DIR__ . "/assets/includes/nav.inc";
?>
<main class="container content">
    <div class="details-message" role="alert">
        <h1>Book not deleted</h1>
        <p><?php echo htmlspecialchars($deleteError, ENT_QUOTES, "UTF-8"); ?></p>
        <a class="btn details-back" href="books.php">&larr; Back to Books</a>
    </div>
</main>
<?php
include __DIR__ . "/assets/includes/footer.inc";
?>
