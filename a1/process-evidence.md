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
18/8/26

**Date Fixed:**  
18/8/26

**File:**  
scripts.js and books.html

**Related Commit:**  
Was fixed before commit, should be 'Assessment 1 book browse implemention, review internal doc"

**Symptom:**  
The AI made code that worked mostly, however didn't account for all availiblity types and instead added a new one with the original being (Available, Reserved, Sold), it added Not-Available

**Steps to Reproduce:**  
When filtering by availlability some of the books would not be shown.

**Root Cause:**  
because the availability types were incorrect/didn't allign with the filter 

**Fix:**  
I removed the 'not-available' availibility type in the array and replaced it with 'sold' 

**Verification:**  
Using a five server, i checked to see if the filter worked

---

## Bug 2

**Date Identified:**  
16/8/26
**Date Fixed:**  
throughout the rest of the project (15/6/26-20/6/26)
**File:**  
gallerySearch.svg, addIcon.svg, gallery.svg, favourite.svg
**Related Commit:**  
all commits
**Symptom:**  
the icons for some reason were unable to be changed (colour and size wise)
**Steps to Reproduce:**  
loading the website?
**Root Cause:**  
the ssc wasn't able to change the (icon-name).svg properties 
**Fix:**  
manually editing specific (icon-name).svg properties to change colour and size 
**Verification:**  
loading website using 5 server 
---

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**  
15/08/2026

**Task Description:**  
Change the colour of the SVG logo image 

**Tool Used:**  
Built in GitHub Copilot agent 

**Prompt / Input:**  
how can i change the colour of the svg image to be the amber colour in the css file 

**AI Output Summary:**  
I’ll check the SVG and the CSS in your assignment so I can show the exact change to make it amber.

## Change the logo to amber

The key point is that your logo is loaded with an `<img>` in `index.html`, so CSS `fill` usually does not affect an external SVG file.

Your CSS in `style.css` already defines the amber colour:

```css
--accent-amber: #fbbf24;
```

### Option 1: easiest for your current setup
Use a CSS filter on the image:

```css
.logo-img {
    width: 36px;
    height: 36px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 0.6rem;
    display: inline-block;
    filter: brightness(0) saturate(100%) sepia(1) hue-rotate(-20deg) saturate(5) brightness(1.1);
}
```

This makes the SVG look amber without editing the image file itself.

### Option 2: best if you want the SVG itself to be amber
Open the SVG file and change the colour values inside it to:

```css
fill: #fbbf24;
```

or directly set a path fill like:

```svg
<path fill="#fbbf24" ... />
```

> If the SVG is in an `img` tag, `fill` in CSS will not work. The filter method works on external SVGs, while editing the SVG file itself is the permanent fix.

If you want, I can also tell you the exact filter value to match your site’s amber branding more closely.

**What You Accepted:**  
I had already tried the fill tag in the CSS file, so I opted to edit the SVG files manually to change the colour to the amber colour 

**What You Changed:**  
inside 'BookVerse.svg'
color: #FFFFFF > color: #fbbf24

**Validation Performed:**  
I would say it was fairly correct as in theory both options provided would have worked, however it clearly reccomended the manual editing to preform the colour change over using the fill CSS tag.

**Issues Identified:**  
I already knew the fill command didn't work however the alternative provided by Copilot did work.

---

## AI Task 2

**Date:**  
15/8/26 - 17/8/26
**Task Description:**  
Creating gallery grid and modal popup   
**Tool Used:**  
VSC AI
**Prompt / Input:**  
make a modal similar to the one in the image provided using bootstrap, this is to be made in the gallery html file, do not connect it to any biutton yet, but ensure it is capable of being triggered. 
**AI Output Summary:**  
I’m opening the gallery page and the existing Bootstrap setup so I can match the modal structure and styling to the project without changing unrelated files.

The gallery page is straightforward, so I’m adding a Bootstrap modal structure and a matching dark theme to the existing layout without wiring it to any visible button yet.

I’ve matched the modal layout, and I’m removing the temporary trigger so it stays unbound until you decide which element should open it.

## ✅ Gallery modal added

I added a Bootstrap modal to `gallery.html` and matched the styling in `style.css` to the reference design.

### Included
- Bootstrap CDN setup
- Modal markup with a dark gallery-style layout
- Caption and navigation area styled to match the mockup
- Modal is ready to trigger using:
  - `data-bs-toggle="modal"`
  - `data-bs-target="#galleryModal"`

### Not connected yet
- No button/image is wired to open it yet
- This keeps it ready for later attachment to whichever gallery item you choose

If you want, I can next connect it to one of the cover images in the gallery.

**What You Accepted:**  
Accepted all edits 

**What You Changed:**  
Nothing currently

**Validation Performed:**  
Issues with the modal position

**Issues Identified:**  
The modal popup was showing up on the right of the screen (not centered)

The visual style of the modal was a bit messed up, changing the AI's created css was easy to fix the visual differences.
---

## AI Task 3

**Date:**  
18/8/26
**Task Description:**  
Creating filter js system and html
**Tool Used:**  
VSC AI
**Prompt / Input:**  
link the book array to the dropdown filter options present in books html, given the filter chosen books should de-render 
**AI Output Summary:**  
Book Management Functions:

addBook() - Add new books to the collection
renderBooks() - Display books in the DOM
filterBooksByStatus() - Filter books by their status
Styling:

Added gray styling for the "sold" status badge
Colors: Available (green)

The books will now display on the books page and can be filtered using the dropdown menu!
**What You Accepted:**  
Accepted all edits 

**What You Changed:**  
Nothing currently

**Validation Performed:**  
content worked as intended,

**Issues Identified:**  
I had to make the array and a few colours/formatting issues were present in the html created.
---


## AI Task 4

**Date:**  
19/8/26
**Task Description:**  
creating the add book form in book.html
**Tool Used:**  
VSC AI
**Prompt / Input:**  
match the add book form shown in the image, ensure that functionality is not added, although typing in fields is possible 

**AI Output Summary:**  
I’ll inspect the current `a1` form, its stylesheet, and the assessment requirements first. Then I’ll make the smallest visual-only adjustment so every field remains a plain, typeable form control with no added behavior.

The current page is only a rough scaffold: it has duplicate `id` values, repeated fields, and an inline upload action that conflicts with the visual-only requirement. The stylesheet already has the dark BookVerse theme, so I’m checking its existing form/button rules and the script before replacing just this page’s form markup and adding scoped styling.

The cheapest discriminating check is a static DOM check: the revised page should contain one unique control per requested field, no inline handlers, and a non-submitting button. I’m now replacing the scaffold with the complete field layout from the reference and scoping the new CSS to `.add-page` so the other assessment pages keep their existing styles.

The form is now structurally complete and has no inline upload or submit behavior; the action button is explicitly non-submitting, while text, selects, checkbox, and file input remain native controls. I’m running the focused static check now for duplicate IDs, inline handlers, and the expected control count before looking at the rendered result.

The editor diagnostics are clean for both touched files. I’m doing one rendered check next because the remaining risk is visual: the two-column rows, file control, and footer spacing need to hold together at the screenshot’s desktop proportions.

Updated the add-book page to match the reference layout and styling.

- Rebuilt the form fields and two-column layout.
- Removed duplicate IDs and inline upload functionality.
- Kept all controls typeable/selectable.
- Set the button to `type="button"` so it performs no action.
- Added responsive styling scoped to the add-book page.

**What You Accepted:**  
Accepted all edits 

**What You Changed:**  
It used generated images for the form's icons for each field, i changed them manually using the svg files.

**Validation Performed:**  
content worked as intended

**Issues Identified:**  
No issues present
---

## AI Task 4

**Date:**  
20/8/26
**Task Description:**  
creating the carousel 
**Tool Used:**  
VSC AI
**Prompt / Input:**  
make a carousel like the one in the image () at the top below the nav in the index html page, cycle between the first 3 cover images  

**AI Output Summary:**  
I’ll trace the current A1 markup, styles, and script conventions first, then add the carousel at the narrowest owning surface and verify it with the existing page setup.

The current page has no carousel markup, while `scripts.js` already centralizes page behavior and the cover set is numbered `1.png` onward. I’m checking the existing asset dimensions and responsive style tail now; the cheapest disconfirming check is whether those first three files exist and can share a stable banner frame without disturbing the footer.

The first three covers are present and the stylesheet already has a full-width dark visual language, so the local hypothesis holds: a dedicated banner section immediately after the header, with one image swapped by JavaScript, will reproduce the requested behavior without touching gallery logic. I’m adding that section, its responsive frame, and auto/manual controls now.

The carousel is now in place directly below the nav, with a 5-second rotation, previous/next buttons, and three indicators. I’m running the focused editor diagnostics on the three touched files next; that will catch markup/script issues before any browser-level check.

Diagnostics are clean across the HTML, CSS, and JavaScript. I’m doing one rendered check now to confirm the banner appears under the nav and that the first three image paths resolve in the running page.

It cycles through `1.png`, `2.png`, and `3.png` every 5 seconds, with previous/next buttons and indicators. Styling is in `style.css`, and behavior is in `scripts.js`. Diagnostics report no errors.

**What You Accepted:**  
Accepted all edits 

**What You Changed:**  
The carousel originally had it's text centered to the left of the image showcase and also had a description of the book, i removed it to ensure accuracy in the original design.

**Validation Performed:**  
content worked as intended

**Issues Identified:**  
No issues present
---

## AI Task 5

**Date:**  
20/8/26
**Task Description:**  
creating the book showcase (below carousel)
**Tool Used:**  
VSC AI
**Prompt / Input:**  
make a showcase of book showing the genre, pricing, author, publication year and availability based on the data in the array in the js file.  

**AI Output Summary:**  
Now I'll update the books tab to make the card span a larger portion and display book information in a list format: 

Now I'll add CSS styling for the expanded books card and list format: 

Done! I've updated the books tab with the following changes:

**HTML Changes:**
- Replaced the placeholder text with a proper books list structure
- Added sample books displayed in list format with Title, Author, and Year information

**CSS Styling:**
- Created `.books-card` class that spans the full width of the container
- Styled `.books-list` as a vertical list with proper spacing
- Each `.book-item` displays as a grid with three columns (Title, Author, Year)
- Added hover effects and a left accent border for visual polish
- Applied appropriate typography and color scheme that matches your design

The card now takes up the full width of the books tab and displays book information in an organized list format with a professional appearance.

**What You Accepted:**  
Accepted all edits 

**What You Changed:**  
Didn't change anything.

**Validation Performed:**  
content worked as intended

**Issues Identified:**  
No issues present
---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:** 
It was quite useful for creating the functionality of most things in the website, however still needed help in correct formatting, although its incorrect formatting could be reduced with more accurate and specific formatting prompts. 

**Where AI was incorrect or misleading:**  
It was relitively good in most aspects, although it struggled with colours and correctly formatting and using them quite a bit.

**What you learned about debugging:**  
Using AI debugging isn't as difficult and is more to do with correcting the AI's mistakes if they are present. AI is also fairly good at identifying problems however not the best at fixing them without breaking other aspects of the website.

**How your approach changed over time:**  
At first i tried to do things more manually, however I tried to adapt AI into the design process more to speed up the website creation process. This worked out as AI was capable of creating a good framework that i could improve and change to fit my website's needs.