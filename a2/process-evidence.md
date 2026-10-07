# Process Evidence Log

This file combines:
1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

You must maintain this file throughout development.

---

## General Instructions
- Record entries as you work (not at the end)
- Be honest and specific
- Link to commits.Each debugging record must include at least one related GitHub commit 
(using commit hash and URL).
- Superficial or fabricated entries will not receive marks

---

# 🔧 Section 1: Debugging Records

## Bug 1

**Date Identified:**  
28/09/2026

**Date Fixed:**  
28/09/2026

**File:**  
assets/includes/nav.inc

**Related Commit:**  
Commit 1

**Symptom:**  
Clicking the BookVerse logo in the navigation caused an error because the link pointed to a page that did not exist in the project.

**Steps to Reproduce:**  
1. Open any page in the `a2` project.
2. Click the BookVerse logo in the navigation bar.
3. Observe that the link attempts to open `index.html` and produces an error because that file is not present.

**Root Cause:**  
The navigation logo still referenced `index.html`, but the project uses `index.php` as its home page and no longer contained `index.html`.

**Fix:**  
Changed the logo link in `assets/includes/nav.inc` from `index.html` to `index.php`.

**Verification:**  
Opened the navigation on the PHP pages and clicked the BookVerse logo. It now navigates to `index.php` without an error.

---

## Bug 2

**Date Identified:**  

**Date Fixed:**  

**File:**  

**Related Commit:**  

**Symptom:**  

**Steps to Reproduce:**  

**Root Cause:**  

**Fix:**  

**Verification:**  

---

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**  
06/10/2026

**Task Description:**  
Make `books.php` display book records dynamically from the local database without changing the existing list presentation.

**Tool Used:**  
GitHub Copilot in VS Code

**Prompt / Input:**  
“make books.php dynamically show books using the db localhost. Ensure the format they are shown remains the same”

**AI Output Summary:**  
Added a procedural MySQLi prepared SELECT query to retrieve book details, then rendered the records using the existing list CSS classes and status-filter attributes. Database values are HTML-escaped.

**What You Accepted:**  
The database-backed book query, matching list markup, empty-list message, and escaped output.

**What You Changed:**  
The page now includes the existing database connectivity include and generates the list from rows returned by the `books` table instead of leaving it empty.

**Validation Performed:**  
Checked the local `bookverse.books` table in phpMyAdmin and loaded `books.php` through localhost. The page displays the database record for The Midnight Library, including its title, author, publication year, and availability. PHP diagnostics reported no errors.

**Issues Identified:**  
The first query used a `year` column that does not exist in the local schema; its year field is named `publication`. Updated the query to use that column.

---

## AI Task 2

**Date:**  
06/10/2026

**Task Description:**  
Align the books-page status filter with the availability values in the local database.

**Tool Used:**  
GitHub Copilot in VS Code

**Prompt / Input:**  
“align them”

**AI Output Summary:**  
Updated the status filter to use the database's `unavailable` value and label, so the JavaScript filter matches the rendered records. Kept the existing status-badge appearance for unavailable books.

**What You Accepted:**  
The filter value now matches the database enum instead of using `reserved`.

**What You Changed:**  
Changed the filter label and `data-status` value in `books.php`, and applied the existing reserved-status badge styling to unavailable badges in the stylesheet.

**Validation Performed:**  
Confirmed PHP and CSS diagnostics report no errors and tested the Unavailable filter in the local browser. The filter selects `unavailable` records and shows the empty-state message when none are present in the local data.

**Issues Identified:**  
None.

---

## AI Task 3

**Date:**  
06/10/2026

**Task Description:**  
Connect the Add Book form to the `bookverse` database and save uploaded cover images under the covers directory with unique filenames.

**Tool Used:**  
GitHub Copilot in VS Code

**Prompt / Input:**  
“sync add.php to the database allowing users to add a book to the database, for the images save them to images/covers with a uniqid()”

**AI Output Summary:**  
Added server-side form validation, a prepared insert using the local books table fields, enum mappings for condition and availability, and validated JPG/PNG upload handling that saves the image with a `uniqid()` filename.

**What You Accepted:**  
The form now submits using POST and multipart encoding, the database insert uses a procedural MySQLi prepared statement, and uploaded images are stored in `assets/images/covers`.

**What You Changed:**  
Mapped the existing “Good” and “Used” options to the database's `fair` and `old` values, and the existing Reserved status to the database's `unavailable` value. At this stage the image file was saved without its ID being associated with the database row; a later change connected the image ID to each book record.

**Validation Performed:**  
Loaded the add page locally and confirmed an invalid file extension is blocked with an inline message. Also submitted an invalid MIME type and confirmed the server rejected it without inserting a book. PHP/JavaScript diagnostics reported no errors.

**Issues Identified:**  
At this stage, the successful database insert and image write still needed to be confirmed with a real valid form submission, and the cover ID was not yet stored in the book record. These items were addressed in a later change.

---

## AI Task 4

**Date:** 07/10/2026

**Task Description:** Create a query-string-driven book details page that retrieves one book from the database and matches the existing BookVerse design.

**Tool Used:** GitHub Copilot in VS Code

**Prompt / Input:** “make a details.php that looks like this image, try and use the colours already being used in the project use a query string to display information from the database”

**AI Output Summary:** Added a `details.php` page that retrieves a book using a prepared MySQLi query keyed by ISBN, styled the details layout with the existing project colours, and linked book titles on `books.php` to their details.

**What You Accepted:** The details page displays each selected book's title, author, availability, genre, publication year, ISBN, condition, price, and description. Missing ISBNs, unknown books, and database query failures receive clear messages.

**What You Changed:** Used ISBN as the query-string key. At this stage the database cover ID was not yet connected to the uploaded file, so the details page used a cover-unavailable placeholder until the cover ID storage was wired in a later change.

**Validation Performed:** PHP syntax checks passed for `details.php` and `books.php`, and editor diagnostics reported no errors in the changed PHP and CSS files. Opened the local browse page and confirmed a book's details link loaded the matching database record.

**Issues Identified:** At this stage, uploaded cover images could not be shown for individual database records because the upload ID was not yet stored and retrieved.

---

## AI Task 5

**Date:** 07/10/2026

**Task Description:** Store each uploaded cover image's unique ID in `books.coverID` and display that book's matching image on the details page, limiting the ID to 13 characters.

**Tool Used:** GitHub Copilot in VS Code

**Prompt / Input:** “ensure that when an image is added, the unique id given to the image's name is used to be displayed in details.php so that the correct image is displayed based on the correct book, do this by adding the unqiue image name as a new variable being stored into the database. the new variable is called coverID, the image unique ID lengths must not exceed 13 characters long”

**AI Output Summary:** Updated the add-book insert to persist `coverID`, made the uploaded image filename use that same ID, and updated the details page to load the matching JPG or PNG cover by the stored ID.

**What You Accepted:** The upload creates a 12-character random hexadecimal ID, stores it in the existing `coverID` column, and the details page displays the file with that exact ID.

**What You Changed:** The local `books` table already contains `coverID VARCHAR(13)`. Added `coverID` to the prepared insert and details query; invalid or missing IDs and missing files still show the placeholder rather than constructing an unsafe file path.

**Validation Performed:** Successfully submitted a book and PNG cover through the local add form, confirmed the database row held a 12-character ID, and confirmed the details page loaded the corresponding image (natural dimensions 334 × 200). Removed the temporary test record and uploaded image after verification. PHP syntax checks, editor diagnostics, and `git diff --check` passed.

**Issues Identified:** Confirm the deployed database also has a `coverID` column with capacity for up to 13 characters before deploying this code.

---

## AI Task 6

**Date:** 07/10/2026

**Task Description:** Ensure browsers fetch the latest details page styling instead of showing a cached, old layout.

**Tool Used:** GitHub Copilot in VS Code

**Prompt / Input:** “its still showing this in my search engine” (with a screenshot showing the old stacked details layout and a tiny cover image)

**AI Output Summary:** Updated the shared header's stylesheet URL with the CSS file modification time, so a changed stylesheet receives a new URL and the browser requests the latest version.

**What You Accepted:** The stylesheet version is generated from `assets/css/style.css`'s file modification time and applies to all pages using the shared header.

**What You Changed:** The screenshot's stacked layout and tiny image indicated stale or different page assets. This cache-busting change addresses browser caching when the updated header and stylesheet are deployed; the server still needs the current `details.php` and `style.css` files uploaded.

**Validation Performed:** TODO: Confirm the stylesheet URL includes its modification time and test the deployed details page after uploading the updated files.

**Issues Identified:** Changes made locally do not automatically update the deployed website. Ensure `details.php`, `assets/includes/header.inc`, and `assets/css/style.css` are uploaded to the same deployed project folder.

---

## AI Task 7

**Date:** 07/10/2026

**Task Description:** Display the 12 newest book cover entries in the database in the existing gallery, using a no-image icon when a cover is unavailable.

**Tool Used:** GitHub Copilot in VS Code

**Prompt / Input:** “make the gallery show the twelve latest image entries in the database, ensure to keep formatting the same, and ensure that if no images are available a substatute (no image icon) is used instead.”

**AI Output Summary:** Replaced the gallery's hard-coded cover tiles with the 12 most recently added book rows and made the modal navigation use that same dynamic list.

**What You Accepted:** The page keeps the existing six-column tile layout and modal. A missing or unresolvable cover ID shows the existing books icon, and an empty database shows a placeholder tile.

**What You Changed:** Gallery covers are resolved from each row's `coverID` using the JPG/PNG files in `assets/images/covers`. Added a cache-busting URL for the gallery JavaScript so browsers receive the dynamic modal code after deployment.

**Validation Performed:** Opened the local gallery and confirmed it displayed the two current database rows in descending ID order, showed a placeholder icon for the row without an image, and opened the correct cover and title in the modal. Tested Next to confirm the modal advances to the next database entry. PHP checks and editor diagnostics passed; `node --check` could not run because Node.js is not installed in the environment.

**Issues Identified:** Upload `gallery.php`, `assets/js/scripts.js`, `assets/includes/header.inc`, and `assets/css/style.css` to the deployed project folder for the updated gallery to appear there.

---

## AI Task 8

**Date:** 07/10/2026

**Task Description:** Display the four newest books from the database on the home page, enlarge the cards to match the supplied design, and leave the carousel unchanged.

**Tool Used:** GitHub Copilot in VS Code

**Prompt / Input:** “make the index.php page show the 4 latest added entries, ensure to keep the format similar, increase the size of the cards. Make it look like the image. Don't change anything about the carousel”

**AI Output Summary:** Replaced the static featured cards with the four newest database books, linked cards to their details pages, used stored cover IDs with a placeholder icon for missing covers, and enlarged/reflowed the cards.

**What You Accepted:** The home page queries the latest four books by descending ID and renders the existing BookVerse featured-books section using database content.

**What You Changed:** The carousel markup was left unchanged. Cards use a responsive four-column grid on wider screens, three columns at medium widths, and two on narrow screens.

**Validation Performed:** PHP syntax and editor diagnostics passed. Confirmed the local homepage renders records in descending ID order with correct cover images or a placeholder. The local database currently contains three book records, so it displays three cards; when there are at least four records it displays the latest four.

**Issues Identified:** The local database has fewer than four entries at validation time; upload the updated `index.php` and `assets/css/style.css` to deploy the homepage changes.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
