match the add book form shown in the image, ensure that functionality is not added, although typing in fields is possible 

I’ll inspect the current `a1` form, its stylesheet, and the assessment requirements first. Then I’ll make the smallest visual-only adjustment so every field remains a plain, typeable form control with no added behavior.

Read 

Read , lines 1 to 360

The current page is only a rough scaffold: it has duplicate `id` values, repeated fields, and an inline upload action that conflicts with the visual-only requirement. The stylesheet already has the dark BookVerse theme, so I’m checking its existing form/button rules and the script before replacing just this page’s form markup and adding scoped styling.

Searched for regex `form|input|textarea|select|button|footer|\.btn` (`**/a1/assets/css/style.css`), 18 results

Read 

Searched for regex `README|Assessment 1|static` (`**/*.md`), 19 results

Read 

Read , lines 400 to 548

Read 

Read 

The cheapest discriminating check is a static DOM check: the revised page should contain one unique control per requested field, no inline handlers, and a non-submitting button. I’m now replacing the scaffold with the complete field layout from the reference and scoping the new CSS to `.add-page` so the other assessment pages keep their existing styles.

Generating patch (244 lines) in , 


```

```

```

```
The form is now structurally complete and has no inline upload or submit behavior; the action button is explicitly non-submitting, while text, selects, checkbox, and file input remain native controls. I’m running the focused static check now for duplicate IDs, inline handlers, and the expected control count before looking at the rendered result.

Ran terminal command: $html = Get-Content -Raw 'a1/add.html'; $ids = [regex]::Matches($html, 'id="([^"]+)"') | ForEach-Object { $_.Groups[1].Value }; $duplicates = $ids | Group-Object | Where-Object Count -gt 1; [pscustomobject]@{ DuplicateIds = if ($duplicates) { ($duplicates.Name -join ',') } else { 'none' }; InlineHandlers = [regex]::Matches($html, '\son[a-z]+=').Count; Inputs = [regex]::Matches($html, '<input\b').Count; Selects = [regex]::Matches($html, '<select\b').Count; Textareas = [regex]::Matches($html, '<textarea\b').Count; Buttons = [regex]::Matches($html, '<button\b').Count; NonSubmittingButton = [regex]::Matches($html, '<button type="button"').Count } | Format-List

Checked , , no problems found

The editor diagnostics are clean for both touched files. I’m doing one rendered check next because the remaining risk is visual: the two-column rows, file control, and footer spacing need to hold together at the screenshot’s desktop proportions.



Opened browser page at file:///C:/Users/noaha/HTML%20Folder%20UNI/wp/a1/add.html

Updated the add-book page to match the reference layout and styling.

- Rebuilt the form fields and two-column layout.
- Removed duplicate IDs and inline upload functionality.
- Kept all controls typeable/selectable.
- Set the button to `type="button"` so it performs no action.
- Added responsive styling scoped to the add-book page.

Validation completed with no errors in `add.html` or `style.css`.

Made changes.