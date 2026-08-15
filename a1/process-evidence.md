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
(e.g., 15/03/2026)

**Date Fixed:**  
(e.g., 15/03/2026)

**File:**  
(e.g., about.html)

**Related Commit:**  
(e.g., abc1234)

**Symptom:**  
What went wrong?

**Steps to Reproduce:**  
How can the issue be triggered?

**Root Cause:**  
Why did the issue occur?

**Fix:**  
What did you change?

**Verification:**  
How did you confirm the fix?

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

**Task Description:**  

**Tool Used:**  

**Prompt / Input:**  

**AI Output Summary:**  

**What You Accepted:**  

**What You Changed:**  

**Validation Performed:**  

**Issues Identified:**  

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
