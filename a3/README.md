# COSC2446 Web Programming — Assessment 3
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | Not provided in the project workspace |
| Student ID | S4251500 |
| GitHub repository | [S4251500/wp](https://github.com/S4251500/wp) |
| Deployed website URL | Not provided |

## 1. Project Overview

BookVerse is a PHP and MySQL bookstore where visitors can browse book listings, view details, and explore cover images. 

Registered users can add books, view their own profile and listings, and edit or delete books they own. 

Password hashes and session authentication protect users'actions when using the website. 

## 2. Development Instructions and Constraints

- Use the Assessment 3 brief as the source of truth for required features and technologies.
- Keep PHP, HTML, CSS, JavaScript, MySQL, and procedural MySQLi code beginner-friendly and explainable.
- Use the existing `assets/includes/` files for the database connection and shared page layout.
- Use prepared statements for SQL queries that include user input.
- Validate submitted data on the server and escape rendered database content with `htmlspecialchars()`.
- Protect authenticated pages with a validated session `user_id`. Check ownership on the server for every edit or delete action.
- Hash passwords with PHP's password hashing functions; never store plain-text passwords.
- Validate uploads by file size and detected MIME type. Do not trust the original uploaded filename.
- Keep the existing Bootstrap 5 integration and styles in `assets/css/style.css`; do not add an unapproved framework.
- Keep client-side behavior in `assets/js/scripts.js` and preserve accessible labels, alt text, and responsive layouts.
- Record AI assistance and debugging honestly in `process-evidence.md`; personally review and test generated changes before submission.
- Do not put database credentials, private data, or test credentials in documentation.

## 3. Website Structure

| File | Purpose |
|---|---|
| `index.php` | Home page with a static three-slide cover carousel and up to four latest database books. |
| `books.php` | Lists all books and provides a client-side availability filter. |
| `gallery.php` | Shows recent book covers in a Bootstrap modal gallery. |
| `details.php` | Looks up a book by ISBN and displays its information; owners see edit and delete controls. |
| `seller.php` | Authenticated user's profile and books, selected using the session user ID. |
| `register.php` | Validates and creates an account with a bcrypt password hash. |
| `login.php` | Verifies the account password and establishes an authenticated session. |
| `logout.php` | Clears the session and returns the visitor to the home page. |
| `add.php` | Authenticated book creation form and cover upload handler. |
| `edit.php` | Owner-only book editing form and optional cover replacement handler. |
| `delete.php` | POST-only, owner-checked book deletion handler. |
| `process-evidence.md` | AI usage log and debugging/process evidence. |
| `search.php` | Not present in the current project; keyword search is not implemented. |

## 4. Project Folder Structure

```text
a3/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── images/
│   │   └── covers/                 Static 
│   │       └── <numeric-id>.jpg|png    Uploaded covers
│   ├── includes/
│   │   ├── database_connectivity.inc
│   │   ├── footer.inc
│   │   ├── header.inc
│   │   └── nav.inc
│   └── js/
│       └── scripts.js
├── add.php
├── books.php
├── delete.php
├── details.php
├── edit.php
├── gallery.php
├── index.php
├── login.php
├── logout.php
├── process-evidence.md
├── README.md
├── register.php
└── seller.php
```

## 5. Technologies

| Technology | Use in BookVerse |
|---|---|
| HTML5 | Semantic page structure, forms, and accessible content. |
| CSS3 | Responsive layout, colors, navigation, cards, and page styling in `assets/css/style.css`. |
| Bootstrap 5 | Grid/utilities, alerts, dropdowns, carousel, and gallery modal. CSS and JavaScript are loaded from the Bootstrap CDN. |
| JavaScript | Gallery modal navigation, book status filtering, and add-form file-extension validation. |
| PHP | Server-rendered pages, form validation, sessions, uploads, and database operations. |
| MySQL | Stores accounts and book records. |
| Procedural MySQLi | Opens the database connection and executes prepared statements. |
| PHP sessions | Stores the authenticated account ID/name and one-time notices. |
| Google Fonts | `Righteous` and `Elms Sans` are imported by the stylesheet. |
| Icons | The current interface uses supplied SVG assets, inline SVG, and a few text glyphs; Material Icons are not included. |
| Git/GitHub | Version control; repository remote is `S4251500/wp`. |
| RMIT Jacob 5/Coreteaching | Production database host configuration is in `database_connectivity.inc`; deployment URL and folder were not provided. |
| AI tools | Copilot assistance is recorded in `process-evidence.md`. |

## 6. Design and Layout

The site uses a dark navy background, teal accents, and light text with the supplied book-cover artwork. `Righteous` is used for display headings and `Elms Sans` for body text. 

Bootstrap was used for responsive layouts and interactive components.

The project stylesheet supplies the BookVerse colors and page-specific styling. 

Using a shared header, navigation bar, and footer includes keep page framing consistent. 

The main navigation shows Add Book only to signed-in users; the signed-in account dropdown contains My Profile & Books and Logout.

## 7. Features and Current Behavior

| Feature | Page/File | Current implementation |
|---|---|---|
| Cover carousel | `index.php` | Static three-slide carousel using files in `assets/images/covers/`; it is not populated from the database. |
| Latest books | `index.php` | Prepared query selects up to four records ordered by descending `book_id`. |
| Browse books | `books.php` | Displays book title, author, publication year, and status in a list. |
| Status filter | `books.php`, `scripts.js` | Client-side filter uses each book's `data-status`. |
| Book details | `details.php` | Looks up one book using the `isbn` query parameter. |
| Owner controls | `details.php` | Edit and Delete appear only when the session user ID equals the book's `user_ID`. |
| My Profile & Books | `seller.php`, `nav.inc` | Authenticated-only account dropdown link; profile and listings are fetched for the current session user. |
| Cover gallery | `gallery.php`, `scripts.js` | Displays up to 12 recent covers and opens a Bootstrap modal with previous/next controls. |
| Search | — | No `search.php` or keyword-search form/query exists in the current project. |
| Registration | `register.php` | Requires a username, valid email, password, and matching confirmation; unique database keys reject duplicate usernames/emails. |
| Login and logout | `login.php`, `logout.php` | Password hash verification creates the session; logout clears it. |
| Add book | `add.php` | Authenticated users can add book information and a required JPG/PNG cover. |
| Edit book | `edit.php` | Only the owner can edit; a replacement cover is optional. |
| Delete book | `delete.php` | POST-only deletion with session, ownership, and CSRF-token checks; browser confirmation is shown on the details page. |
| User feedback | `index.php`, `details.php`, `books.php`, forms | Login and book actions use session notices; registration success is indicated by the `registered` query parameter. |

## 8. Database Design and Use

The connection include selects the local `bookverse` database for localhost and the configured student database on jacob 5. 
 
The tables have the following structure:

1. Table: users 
`user_id`, `username`, `email`, `password`, `phone`, `location`, `bio`, `joined_at` 

Username and email are unique.

`password` contains a password hash. 

2. Table: books 

`book_id`, `user_ID`, `title`, `author`, `genre`, `publication_year`, `isbn`, `description`, `price`, `book_condition`, `status`, `image_path`, `created_at` 

The books schema uses the condition values `new`, `fair`, and `old`, and status values `available`,`reserved`, `unavailable`, and `sold`. 

`image_path` stores a numeric image identifier that corresponds to a JPG or PNG file in `assets/images/`. 

The `user_ID` field links a book to `users.user_id`.

Pages use prepared statements for database queries. 

`details.php` selects by ISBN; 

`seller.php` selects the profile and books for the authenticated session user. 

Add and edit write the session user's ID to `books.user_ID`; edit and delete queries also require that owner ID.

## 9. Shared PHP Includes


1. `assets/includes/database_connectivity.inc` 
Selects the configured database, opens the MySQLi connection, and sets UTF-8 character encoding.

2. `assets/includes/header.inc` 
Starts a session if needed, sets no-cache headers, and includes the document head, stylesheet, and Bootstrap bundle.

3. `assets/includes/nav.inc` 
Renders the shared navigation and session-aware account dropdown. 

4. `assets/includes/footer.inc` 
Renders the shared footer.

## 10. Authentication and Access Control

Registration validates the email with `FILTER_VALIDATE_EMAIL` and requires an `@`, hashes the password using bcrypt, and inserts into `users`. 

Database unique constraints prevent duplicate usernames and emails. 

Login looks up the username with a prepared statement, verifies the hash using `password_verify()`, regenerates the session ID, and stores `user_id` and `username`. 

Logout clears the session and expires its cookie.

Browse, gallery, details, and home require no login and are public to view information from. 

Add book requires the user to be in a session to access. (correct user_id)

My Profile & Books require an authenticated user with the correct session ID; both profile and listing queries are scoped to that ID.

Edit book can only be accessed by the book owner requiring matching `book_id` and `user_ID`.

Delete book is only allowed by book owner.

## 11. CRUD, Forms, and Uploads


1. Record Creation - `add.php`  Validates required details and status/condition, validates a required JPG/PNG upload, and inserts the book with the session owner ID. 

2. Read Database - `index.php`, `books.php`, `details.php`, `seller.php`, `gallery.php` Use data retrieval in multiple ways such as: by retrieving all, selected, owner-specific, or recent gallery records. 

3. Update Record - `edit.php` Validates submitted fields and optional replacement image, saves only when the current user owns the book. 

4. Delete Record - `delete.php` Deletes a matching owner record after a POST and CSRF check.

Uploads are stored under `assets/images/` with a generated positive numeric filename; the original filename is not used. 

A replaced or deleted image file is removed only after the database operation succeeds and the code finds no remaining book referencing that image. The upload directory must be writable by PHP. 

When editing without an upload, the existing `image_path` remains unchanged.

The add form has client-side extension validation in `scripts.js`; The edit form currently relies on server-side validation and does not have a client-side image preview. 

Delete confirmation uses the browser's built-in `confirm()` dialog, not a Bootstrap modal.

## 12. JavaScript

`assets/js/scripts.js` handles the gallery modal's image navigation, the Browse Books status filter, and extension validation for the add-book form. 

The edit form has no JavaScript preview/extension checker. Bootstrap's JavaScript bundle provides the carousel, dropdowns, and modal behavior.

## 13. Security and Accessibility

- SQL containing user input uses prepared statements.
- Database output is escaped with `htmlspecialchars()` before rendering.
- Query-string and form values are validated before use.
- Upload names are generated by the application; file size and detected MIME type are checked.
- Edit/delete ownership is checked server-side; delete requests also use a session CSRF token.
- Passwords are stored as hashes and checked with `password_verify()`.
- Pages use labelled form controls, semantic landmarks, useful image alt text, and responsive CSS.
- Page-level query errors are logged and forms generally show generic messages. The shared connection include currently prints a connection error if MySQL cannot connect; review that behavior before public deployment.

## 14. Validation and Testing Performed

1. 
PHP syntax for all existing Assessment 3 PHP pages Passed with XAMPP `php -l`. 

`git diff --check` Passed after the recent page and navigation changes.

2. 
Anonymous access to `add.php`, `edit.php`, `delete.php`, and `seller.php` 

Redirected to `login.php` in local HTTP checks.

3. 
Local book details rendering 

A local book details request returned HTTP 200.

4. 
Authenticated local seller page 

Temporary local session returned HTTP 200 and rendered the profile layout. 

5. 
Registration/login database operations 

Not verified as part of this README update. 

6. 
Authenticated edit/delete and image replacement/deletion 

Not verified end-to-end. 

7. 
Full CSS conformance/accessibility audit 

Not run. 

8. 
Deployed pages, database, and upload permissions 

Not verified; deployment URL was not provided.


Some template features are incomplete: `search.php` is absent, carousel slides use fixed images rather than latest database covers, public seller links/pages are absent, and the edit form has no image preview.

## 15. Deployment

Website: idk 
Jacob 5 database name: `S4251500_159009`
Deployment folder: a3
Upload directory: WebProgAssignment

## 16. Git and Development Process

The project is in the `S4251500/wp` GitHub repository and has a history of Assessment 3 development commits.

## 17. AI Use Declaration

AI assistance was used for implementation and debugging, with task summaries recorded in `process-evidence.md`. The PHP syntax checks and route checks listed above were run during development. The student must review the final code, run the remaining manual tests, and personally confirm that they can explain the submitted work.

- [x] AI tools were used during this assessment.
- [x] AI usage summaries are present in `process-evidence.md`.
- [ ] Student has personally reviewed and tested all AI-assisted code.
- [ ] Student can explain all AI-assisted code submitted.

## 18. Process Evidence Status

`process-evidence.md` contains 17 completed AI task records and five completed debugging records, each with a related commit link. The final reflection is still blank and should be completed by the student before submission.

- `process-evidence.md` included: Yes
- At least five AI usage records: Yes
- At least five completed debugging records: Yes
- Related commit links in debugging records: Yes

## 19. Known Limitations

Search - `search.php` and keyword search are not implemented. 

Seller discovery - The seller page is restricted to the signed-in user's own profile/listings; public seller pages and seller links are not implemented.

Home carousel - Uses fixed image files and captions rather than database records.

Edit image preview - The edit form displays the current cover but has no JavaScript preview for a newly selected image.
