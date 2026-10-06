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
Mapped the existing “Good” and “Used” options to the database's `fair` and `old` values, and the existing Reserved status to the database's `unavailable` value. The current database schema has no cover-image column, so the image is saved in the requested directory but its filename is not stored in the book row.

**Validation Performed:**  
Loaded the add page locally and confirmed an invalid file extension is blocked with an inline message. Also submitted an invalid MIME type and confirmed the server rejected it without inserting a book. PHP/JavaScript diagnostics reported no errors.

**Issues Identified:**  
The successful database insert and image write still need to be confirmed with a real valid form submission. The database schema has no column for associating a saved cover image with a book record.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
