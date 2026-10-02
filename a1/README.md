# COSC2446 Web Programming – Assessment 1  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | TODO |
| Student ID | TODO |
| GitHub repository URL | TODO |
| Deployed website URL | TODO |

---

## 1. Purpose of This README

This README documents the Assessment 1 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document testing and deployment;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

This section must be completed by the student after reading the Assessment 1 brief.

Write clear instructions that would help GitHub Copilot or another AI tool produce code that follows the Assessment 1 requirements.

Your instructions should help the AI understand what it is allowed to generate, what it must not generate, and which assessment constraints must be followed.

TODO: Include instructions about:

- allowed technologies;
- technologies, frameworks, or tools that must not be used;
- required files and folders;
- CSS and JavaScript file requirements;
- whether inline CSS or inline JavaScript is allowed;
- Bootstrap layout requirements;
- form requirements;
- image validation requirements;
- gallery modal requirements;
- book status filtering requirements;
- accessibility and usability expectations;
- AI usage and process-evidence requirements.

### My Copilot / AI instructions

how can i change the colour of the svg image to be the amber colour in the css file 

make a modal similar to the one in the image provided using bootstrap, this is to be made in the gallery html file, do not connect it to any biutton yet, but ensure it is capable of being triggered. 

link the book array to the dropdown filter options present in books html, given the filter chosen books should de-render 

match the add book form shown in the image, ensure that functionality is not added, although typing in fields is possible

make a carousel like the one in the image () at the top below the nav in the index html page, cycle between the first 3 cover images 

make a showcase of book showing the genre, pricing, author, publication year and availability based on the data in the array in the js file.  

## 3. Project Overview

Briefly describe the purpose of the BookVerse website.

TODO: In 3–5 sentences, explain:

- what BookVerse is;
BookVerse is an online library website where users can submit their books to the BookVerse database to borrow books through the online system, see author information and look at the cover art of books. Additionally users can search by genre and availability to see if a book is available or if a book matches the user's taste.

- who the website is for;
The website is for people interested in looking for books to borrow for various reasons. additionally admins or people with books to give away can use the website to add books to the database and give them to others 

- what users can view or interact with;
Users can interact with the books.html filtering between the availability status of books stored in the BookVerse database (array). Additionally in the gallery, users are able to view the covers of books in a popup. Finally users can type book details in the add.html file allowing users to add book information such as images, author info and title information. 

- which technologies were used;
Bootstrap, html, javascript, jupiter webservers, git (and gitbash), visual studio code, copilot AI, svg files.
- whether this is a static or dynamic website.
This is a static website due to information not updating dynamically and using external databases and server side plugins.
---

## 4. Website Structure

Complete the table below by describing the purpose of each page.

| File | Purpose |
|---|---|
| `index.html` | The main page with an image carousel and small book showcase grid underneath |
| `books.html` | The filter page used to allow users to filter books by availability |
| `gallery.html` | allows users to see the cover images of books stored within the website |
| `add.html` | Has a form for users to input book information and the books cover to be added when the server is made dynamic |

---

## 5. Project Folder Structure

Show the final structure of your `a1` folder.

```text
a1/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│       └── covers/
├── index.html
├── books.html
├── gallery.html
├── add.html
├── README.md
└── process-evidence.md
```

## 6. Technologies Used

Complete the table below. Explain how each technology was used in your project.

| Technology | How it was used in this project |
|---|---|
| HTML5 | Used to create the framework of the website, used in formatting of page and elements within it |
| CSS3 | Used to change colour, size and improve formatting of webpage structure |
| Bootstrap 5 | Used to make special elements such as the modal and dropdown menu |
| JavaScript | Used to store information (Arrays) to be displayed on the server page. Used for logic such as the filter in books.html, and the gallery modal. Used for the carousel in the index.html page. It is also used in file verification when uploading for future dynamic server development |
| Google Fonts | Used to adapt fonts to different devices providing clear and concise website eligibility |
| Material Icons | Used to add affordance to buttons and functionality on the website |
| GitHub | Used for version control for development |
| Coreteaching server | Used to implement server functionality/server private access |
| AI tools | Used in development |

## 7. Design and Layout

Based on the assessment document, describe the design and layout choices.

Not sure what this is asking for tbh.

how the required colour palette should be used;
how to use the required fonts;
how to use Material Icons;
how Bootstrap should be used for layout and responsiveness.

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

Feature	Page	Explanation
Carousel	index.html	TODO
Responsive book layout	index.html	TODO
Book table	books.html	TODO
Status filter	books.html	TODO
Gallery grid	gallery.html	TODO
Bootstrap image modal	gallery.html	TODO
Add Book form	add.html	TODO
Image validation	add.html	TODO
Image preview	add.html	TODO

## 9. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

JavaScript feature	Page	How it works
Image extension validation	add.html	TODO
Image preview	add.html	DNF
Gallery modal	gallery.html	link each button with an index that when used changes the modal contents to match with the corresponding book details such as image and name.
Book status filter	books.html	link availability of books to a dropdown element that when selected hides availability status of books that do not match. 

## 10. Form Validation

Describe the validation that should be used on the Add Book form.

TODO: Explain:

which fields are required;
The following are required: Title, Author, Price, ISBN, Year, Genre, Condition, Description, Availability status, and image 
how labels are associated with form fields;
labels match the input field requirements 
which input types were used;
text (string), numbered-string inputs, file, and a checkbox
how the image file type is checked;
DNF
which image file extensions are accepted;
DNF
how the image preview works;
DNF
what feedback the user receives if the selected file is invalid.
DNF

## 11. Accessibility and Usability

Briefly describe what accessibility and usability features must be implemented.

Consistant font and colours should be used to maintain eligibility of elements within the website. 

Simple and easy to follow formatting shoud be used to allow users to navigate the website with ease.

Titles and labels should be simple describing functionality easily.

Symbols and icons should be used to match functionality, this provides users with clear functionality to the websites features.

Consistant navigation (location and functionality) should be maintained to allow users to navigate the website easily.

Semantic html ensures developers understand the functionality of specific html by its title and tags allowing for easier bugfixing and bug identification.

Image alt text ensures that if visual elements aren't rendered correctly users still know what the contents of the visual elements are to better understant the page's formatting.

## 12. Testing and Validation

Complete this section after testing your website.

HTML Validation
File	Result	Notes
index.html	issues found, when changing size of screen carousel dissapears and the showcase glitches
books.html	issues found
gallery.html	issues found
add.html	issues found

CSS Validation
File	Result	Notes
assets/css/style.css	Pass

Functionality Testing
Feature tested	Result	Notes
Navigation links	Pass
Carousel	Fail does not adapt to screen  size, instead disapears 
Gallery modal	Pass
Book status filter	Pass
Add Book form validation	Pass/Fail file validation not implemented, any file can be added to webpage 
Image preview	Fail DNF
Deployed site links/assets	Pass 

## 13. Deployment

Provide details of your deployed website.

Item	Details
Deployed website URL (http://titan.csit.rmit.edu.au/~s4251500/wp/)
Coreteaching server	Jupiter server 
Deployment folder	wp directory
.htaccess location	root directory

I pulled the github contents then checked on my own device

## 14. Git and Development Process

Briefly describe how you used Git during the project.

TODO: Explain:

how often you committed changes;
After completing a substantial feature i committed into the github, usually when I finished working on a segment of the website.

what types of changes your commits show;
formatting changes, features being added (modal, form and gallery)

how your Git history shows progressive development;
The git repository shows the contents of specific commits, the times i committed them and the description forced when committing.

how your commits relate to your process-evidence records.
They match when I completed specific specific tasks and implemented large features for the webserver.

## 15. AI Use Declaration

AI tools are required for this assessment.

Confirm the following:
- [Y] I used AI tools meaningfully during this assessment.
- [Y] I recorded meaningful AI use in `process-evidence.md`.
- [Y] I reviewed, tested, and adapted AI-assisted output.
- [Y] I can explain all AI-assisted code submitted.

## 16. Process Evidence

Confirm that your process evidence file has been completed.

Requirement	Completed?
process-evidence.md file included	Yes
At least 2 debugging records included	TODO: Yes
At least 2 meaningful AI usage records included	TODO: Yes
Relevant commit links included	TODO: Yes

## 17. Known Issues or Limitations

List any known issues or limitations in your submitted project.

Issue or limitation	Explanation
Due to mismanagement of time i did not finish some features such as the image file verification, i also couldn't implement in the carousel and book showcase size adaptability correctly.

If there are no known issues, write:

> No known issues at the time of submission.