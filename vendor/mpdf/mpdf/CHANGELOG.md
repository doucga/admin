mPDF 7.0.x
===========================

* Allow passing file content or file path to `SetAssociatedFiles` (#558)
* Allowed ^1.4 and ^2.0 of paragon/random_compat to allow wider usage
* Fix of undefined _getImage function (#539)
* Code cleanup
* Better writable rights for temp dir validation (#534)
* Fix displaying dollar character in footer with core fonts (#520)
* Fixed missed code2utf call (#531)
* Refactored and cleaned-up classes and subnamespaces


mPDF 7.0.0
===========================

### 19/10/2017

Backward incompatible changes
-----------------------------

- PHP `^5.6 || ~7.0.0 || ~7.1.0 || ~7.2.0` is required.
- Entire project moved under `Mpdf` namespace
    - Practically all classes renamed to use `PascalCase` and named to be more verbose
    - Changed directory structure to comply to `PSR-4`
- Removed explicit require calls, replaced with Composer autoloading
- Removed configuration files
    - All configuration now done via `__construct` parameter (see below)
- Changed `\Mpdf\Mpdf` constructor signature
    - Class now accepts only single array `$config` parameter
    - Array keys are former `config.php` and `config_fonts.php` properties
    - Additionally, former constructor parameters can be used as keys
- `tempDir` directory now must be writable, otherwise an exception is thrown
- ICC profile is loaded as entire path to file (to prevent a need to write inside vendor directory)
- Moved examples to separate repository
- Moved `TextVars` constants to separate class
- Moved border constants to separate class
- `scriptToLang` and `langToFont` in separate interfaced class methods
- Will now throw an exception when `mbstring.func_overload` is set
- Moved Glyph operator `GF_` constants in separate `\Mpdf\Fonts\GlyphOperator` class
- All methods in Barcode class renamed to camelCase including public `dec_to_hex` and `hex_to_dec`
- Decimal conversion methods (to roman, cjk, etc.) were moved to classes in `\Mpdf\Conversion` namespace
- Images in PHP variables (`<img src="var:smileyface">`) were moved from direct Mpdf properties to `Mpdf::$imageVars` public property array
- Removed global `_SVG_AUTOFONT` and `_SVG_CLASSES` constants in favor of `svgAutoFont` and `svgClasses` configuration keys
- Moved global `_testIntersect`, `_testIntersectCircle` and `calc_bezier_bbox` fucntions inside `Svg` class as private methods.
    - Changed names to camelCase without underscores and to `computeBezierBoundingBox`
- Security: Embedded files via `<annotation>` custom tag must be explicitly allowed via `allowAnnotationFiles` configuration key
- `fontDir` property of Mpdf class is private and must be accessed via configuration variable with array of paths or `AddFontDirectory` method
- QR code `<barcode>` element now treats `\r\n` and `\n` as actual line breaks
- cURL is prefered over socket when downloading images.
- Removed globally defined functions from `functions.php` in favor of `\Mpdf\Utils` classes `PdfDate` and `UtfString`.
    - Unused global functions were removed entirely.


Removed features
----------------

- Progressbar support
- JpGraph support
- `error_reporting` changes
- Timezone changes
- `compress.php` utility
- `_MPDF_PATH` and `_MPDF_URI` constants
- `_MPDF_TEMP_PATH` constant in favor of `tempDir` configuration variable
- `_MPDF_TTFONTDATAPATH` in  favor of `tempDir` configuration variable
- `_MPDFK` constant in favor of `\Mpdf\Mpdf::SCALE` class constant
- `FONT_DESCRIPTOR` constant in favor of `fontDescriptor` configuration variable
- `_MPDF_SYSTEM_TTFONTS` constant in favor of `fontDir` configuration variable with array of paths or `AddFontDirectory` method
- HTML output of error messages and debugs
- Formerly deprecated methods


Fixes and code enhancements
----------------------------

- Fixed joining arab letters
- Fixed redeclared `unicode_hex` function
- Converted arrays to short syntax
- Refactored and tested color handling with potential conversion fixes in `hsl*()` color definitions
- Refactored `Barcode` class with separate class in `Mpdf\Barcode` namespace for each barcode type
- Fixed colsum calculation for different locales (by @flow-control in #491)
- Image type guessing from content separated to its own class


New features
------------

- Refactored caching (custom `Cache` and `FontCache` classes)
- Implemented `Psr\Log\LoggerAware` interface
    - All debug and additional messages are now sent to the logger
    - Messages can be filtered based on `\Mpdf\Log\Context` class constants
- `FontFileFinder` class allowing to specify multiple paths to search for fonts
- `MpdfException` now extends `ErrorException` to allow specifying place in code where error occured
- Generating font metrics moved to separate class
- Added `\Mpdf\Output\Destination` class with verbose output destination constants
- Availability to set custom default CSS file
- Availability to set custom hyphenation dictionary file
- Refactored code portions to new "separate" classes:
    - `Mpdf\Color\*` classes
        - `ColorConvertor`
        - `ColorModeConvertor`
        - `ColorSpaceRestrictor`
    - `Mpdf\SizeConvertor`
    - `Mpdf\Hyphenator`
    - `Mpdf\Image\ImageProcessor`
    - `Mpdf\Image\ImageTypeGuesser`
    - `Mpdf\Conversion\*` classes
- Custom watermark angle with `watermarkAngle` configuration variable
- Custom document properties (idea by @zarubik in #142)
- PDF/A-3 associated files + additional xmp rdf (by @chab in #130)
- Additional font directories can be added via `addFontDir` method
- Introduced `cleanup` method which restores original `mb_` encoding settings (see #421)
- QR code `<barcode>` element now treats `\r\n` and `\n` as actual line breaks
- Customizable following of 3xx HTTP redirects, validation of SSL certificates, cURL timeout.
    - `curlFollowLocation`
    - `curlAllowUnsafeSslRequests`
    - `curlTimeout`
- QR codes can be generated without a border using `disableborder="1"` HTML attribute in `<barcode>` tag


Git repository enhancements
---------------------------

- Added contributing guidelines
- Added Issue template


mPDF 6.1.0
===========================

### 26/04/2016

- Composer updates
    - First release officially supporting Composer
    - Updated license in composer.json
    - Chmod 777 on dirs `ttfontdata`, `tmp`, `graph_cache` after composer install
- Requiring PHP 5.4.0+ with Composer
- Code style
    - Reformated (almost) all PHP files to keep basic code style
    - Removed trailing whitespaces
    - Converted all txt, php, css, and htm files to utf8
    - Removed closing PHP tags
    - Change all else if calls to elseif
- Added base PHPUnit tests
- Added Travis CI integration with unit tests
- Changed all `mPDF::Error` and `die()` calls to throwing `MpdfException`
- PDF Import changes
    - FPDI updated to 1.6.0 to fix incompatible licenses
    - FPDI loaded from Composer or manually only
- Removed iccprofiles/CMYK directory
- Renamed example files: change spaces to underscores to make scripting easier
- Fixed `LEDGER` and `TABLOID` paper sizes
- Implemented static cache for mpdf function `ConvertColor`.
- Removed PHP4 style constructors
- Work with HTML tags separated to `Tag` class
- Fixed most Strict standards PHP errors
- Add config constant so we can define custom font data
- HTML
    - fax & tel support in href attribute
    - Check $html in `$mpdf->WriteHTML()` to see if it is an integer, float, string, boolean or
      a class with `__toString()` and cast to a string, otherwise throw exception.
- PHP 7
    - Fix getting image from internal variable in PHP7 (4dcc2b4)
    - Fix PHP7 Fatal error: `'break' not in the 'loop' or 'switch' context` (002bb8a)
- Fixed output file name for `D` and `I` output modes (issue #105, f297546)

mPDF 6.0
===========================

### 20/12/2014

New features / Improvements
---------------------------
- Support for OpenTypeLayout tables / features for complex scripts and Advances Typography.
- Improved bidirectional text handling.
- Improved line-breaking, including for complex scripts e.g. Lao, Thai and Khmer.
- Updated page-breaking options.
- Automatic language mark-up and font selection using autoScriptToLang and autoLangToFont.
- Kashida for text-justification in arabic scripts.
- Index collation for non-ASCII characters.
- Index mark-up allowing control over layout using CSS.
- `{PAGENO}` and `{nbpg}` can use any of the number types as in list-style e.g. set in `<pagebreak>` using pagenumstyle.
- CSS support for lists.
- Default stylesheet - `mpdf.css` - updated.

Added CSS support
-----------------
- lang attribute selector e.g. :lang(fr), [lang="fr"]
- font-variant-position
- font-variant-caps
- font-variant-ligatures
- font-variant-numeric
- font-variant-alternates - Only [normal | historical-forms] supported (i.e. most are NOT supported)
- font-variant - as above, and except for: east-asian-variant-values, east-asian-width-values, ruby
- font-language-override
- font-feature-settings
- text-outline is now supported on TD/TH tags
- hebrew, khmer, cambodian, lao, and cjk-decimal recognised as values for "list-style-type" in numbered lists and page numbering.
- list-style-image and list-style-position
- transform (on `<img>` only)
- text-decoration:overline
- image-rendering
- unicode-bidi (also `<bdi>` tag)
- vertical-align can use lengths e.g. 0.5em
- line-stacking-strategy
- line-stacking-shift

mPDF 5.7.4
================

### 15/12/2014

Bug Fixes & Minor Additions
---------------------------
- SVG images now support embedded images e.g. `<image xlink:href="image.png" width="100px" height="100px" />`
- SVG images now supports `<tspan>` element e.g. `<tspan x,y,dx,dy,text-anchor >`, and also `<tref>`
- SVG images now can use Autofont (see top of `classes/svg.php` file)
- SVG images now has limited support for CSS classes (see top of `classes/svg.php` file)
- SVG images - style inheritance improved
- SVG images - improved handling of comments and other extraneous code
- SVG images - fix to ensure opacity is reset before another element
- SVG images - font-size not resetting after a `<text>` element
- SVG radial gradients bug (if the focus [fx,fy] lies outside circle defined by [cx,cy] and r) cf. pservers-grad-15-b.svg
- SVG allows spaces in attribute definitions in `<use>` or `<defs>` e.g. `<use x = "0" y = "0" xlink:href = "#s3" />`
- SVG text which contains a `<` sign, it will break the text - now processed as `&lt;` (despite the fact that this does not conform to XML spec)
- SVG images - support automatic font selection and (minimal) use of CSS classes - cf. the defined constants at top of svg.php file
- SVG images - text-anchor now supported as a CSS style, as well as an HTML attribute
- CSS support for :nth-child() selector improved to fully support the draft CSS3 spec - http://www.w3.org/TR/selectors/#nth-child-pseudo
    [NB only works on table columns or rows]
- text-indent when set as "em" - incorrectly calculated if last text in line in different font size than for block
- CSS not applying cascaded styles on `<A>` elements - [changed MergeCSS() type to INLINE for 'A', LEGEND, METER and PROGRESS]
- fix for underline/strikethrough/overline so that line position(s) are based correctly on font-size/font in nested situations
- Error: Strict warning: Only variables should be passed by reference - in PHP5.5.9
- bug accessing images from some servers (HTTP 403 Forbidden whn accessed using fopen etc.)
- Setting page format incorrectly set default twice and missed some options
- bug fixed in Overwrite() when specifying replacement as a string
- barcode C93 - updated C93 code from TCPDF because of bug - incorrect checksum character for "153-2-4"
- Tables - bug when using colspan across columns which may have a cell width specified
    cf. http://www.mpdf1.com/forum/discussion/2221/colspan-bug
- Tables - cell height (when specified) is not resized when table is shrunk
- Tables - if table width specified, but narrower than minimum cell wdith, and less than page width - table will expand to
    minimum cell width(s) as long as $keep_table_proportions = true
- Tables - if using packTableData, and borders-collapse, wider border is overwriting content of adjacent cell
    Test case:
    ```
    <table style="border-collapse: collapse;">
    <tr><td style="border-bottom: 42px solid #0FF; "> Hallo world </td></tr>
    <tr><td style="border-top: 14px solid #0F0; "> Hallo world </td></tr>
    </table>
    ```
- Images - image height is reset proportional to original if width is set to maximum e.g. `<img width="100%" height="20mm">`
- URL handling changed to work with special characters in path fragments; affects `<a>` links, `<img>` images and
    CSS url() e.g background-image
    - also to ignore `../` included as a query value
- Barcodes with bottom numerals e.g. EAN-13 - incorrect numeral size when using core fonts

--------------------------------

NB Spec. for embedded SVG images:
as per http://www.w3.org/TR/2003/REC-SVG11-20030114/struct.html#ImageElement
Attributes supported:
- x
- y
- xlink:href (required) - can be jpeg, png or gif image - not vector (SVG or WMF) image
- width (required)
- height (required)
- preserveAspectRatio

Note: all attribute names and values are case-sensitive
width and height cannot be assigned by CSS - must be attributes

mPDF 5.7.3
================

### 24/8/2014

Bug Fixes & Minor Additions
---------------------------

- Tables - cellSpacing and cellPadding taking preference over CSS stylesheet
- Tables - background images in table inside HTML Footer incorrectly positioned
- Tables - cell in a nested table with a specified width, should determine width of parent table cell
    (cf. http://www.mpdf1.com/forum/discussion/1648/nested-table-bug-)
- Tables - colspan (on a row after first row) exceeds number of columns in table
- Gradients in Imported documents (mPDFI) causing error in some browsers
- Fatal error after page-break-after:always on root level block element
- Support for 'https/SSL' if file_get_contents_by_socket required (e.g. getting images with allow_url_fopen turned off)
- Improved support for specified ports when getting external CSS stylesheets e.g. www.domain.com:80
- error accessing local .css files with dummy queries (cache-busting) e.g. mpdfstyleA4.css?v=2.0.18.9
- start of end tag in PRE incorrectly changed to &lt;
- error thrown when open.basedir restriction in effect (deleting temporary files)
- image which forces pagebreak incorrectly positioned at top of page
- [changes to avoid warning notices by checking if (isset(x)) before referencing it]
- text with letter-spacing set inside table which needs to be resixed (shrunk) - letter-spacing was not adjusted
- nested table incorrectly calculating width and unnecessarily wrapping text
- vertical-align:super|sub can be nested using `<span>` elements
- inline elements can be nested e.g. text `<sup>text<sup>13</sup>text</sup>` text
- CSS vertical-align:0.5em (or %) now supported
- underline and strikethrough now use the parent inline block baseline/fontsize/color for child inline elements *** change in behaviour
    (Adjusts line height to take account of superscript and subscript except in tables)
- nested table incorrectly calculating width and unnecessarily wrapping text
- tables - font size carrying over from one nested table to the next nested table
- tables - border set as attribute on `<TABLE>` overrides border set as CSS on `<TD>`
- tables - if table width set to 100% and one cell/column is empty with no padding/border, sizing incorrectly
    (http://www.mpdf1.com/forum/discussion/1886/td-fontsize-in-nested-table-bug-#Item_5)
- `<main>` added as recognised tag
- CSS style transform supported on `<img>` element (only)
    All transform functions are supported except matrix() i.e. translate(), translateX(), translateY(), skew(), skewX(), skewY(),
    scale(), scaleX(), scaleY(), rotate()
    NB When using Columns or Keep-with-table (use_kwt), cannot use transform
- CSS background-color now supported on `<img>` element
- @page :first not recognised unless @page {} has styles set
- left/right margins not allowed on @page :first

mPDF 5.7.2
================

### 28/12/2013

Bug Fixes
---------

- `<tfoot>` not printing at all (since v5.7)
- list-style incorrectly overriding list-style-type in cascading CSS
- page-break-after:avoid not taking into account bottom padding and margin when estimating if next line can fit on page
- images not displayed when using "https://" if images are referenced by src="//domain.com/image"
- +aCJK incorrectly parsed when instantiating class e.g. new mpDF('ja+aCJK')
- line-breaking - zero-width object at end of line (e.g. index entry) causing a space left untrimmed at end of line
- ToC since v5.7 incorrectly handling non-ascii characters, entities or tags
- cell height miscalculated when using hard-hyphenate
- border colors set with transparency not working
- transparency settings for stroke and fill interfering with one another
- 'float' inside a HTML header/footer - not clearing the float before first line of text
- error if script run across date change at midnight
- temporary file name collisions (e.g. when processing images) if numerous users
- `<watermarkimage>` position attribute not working
- `<` (less-than sign) inside a PRE element, and NOT start of a valid tag, was incorrectly removed
- file attachments not opening in Reader XI
- JPG images not recognised if not containing JFIF or Exif markers
- instance of preg_replace with /e modifier causing error in PHP 5.5
- correctly handle CSS URLs with no scheme
- Index entries causing errors when repeat entries are used within page-break-inside:avoid, rotated tables etc.
- table with fixed width column and long word in cell set to colspan across this column (adding spare width to all columns)
- incorrect hyphenation if multiple soft-hyphens on line before break
- SVG images - objects contained in `<defs>` being displayed
- SVG images - multiple, or quoted fonts e.g. style="font-family:'lucida grande', verdana" not recognised
- SVG images - line with opacity=0 still visible (only in some PDF viewers/browsers)
- text in an SVG image displaying with incorrect font in some PDF viewers/browsers
- SVG images - fill:RGB(0,0,0) not recognised when uppercase
- background images using data:image\/(jpeg|gif|png);base64 format - error when reading in stylesheet

New CSS support
---------------

- added support for style="opacity:0.6;" in SVG images - previously only supported style="fill-opacity:0.6; stroke-opacity: 0.6;"
- improved PNG image handling for some cases of alpha channel transparency
- khmer, cambodian and lao recognised as list-style-type for numbered lists

SVG Images
----------

- Limited support for `<use>` and `<defs>`

mPDF 5.7.1
================
## 01/09/2013

1) FILES: mpdf.php

Bug fix; Dollar sign enclosed by `<pre>` tag causing error.
Test e.g.: `<pre>Test $1.00 Test</pre> <pre>Test $2.00 Test</pre> <pre>Test $3.00 Test</pre> <pre>Test $4.00 Test</pre>`

-----------------------------

2) FILES: includes/functions.php AND mpdf.php

Changes to `preg_replace` with `/e` modifier to use `preg_replace_callback`
(/e depracated from PHP 5.5)

-----------------------------

3) FILES: classes/barcode.php

Small change to function `barcode_c128()` which allows ASCII 0 - 31 to be used in C128A e.g. chr(13) in:
`<barcode code="5432&#013;1068" type="C128A" />`

-----------------------------

4) FILES: mpdf.php

Using $use_kwt ("keep-[heading]-with-table") if `<h4></h4>` before table is on 2 lines and pagebreak occurs after first line
the first line is displayed at the bottom of the 2nd page.
Edited so that $use_kwt only works if the HEADING is only one line. Else ignores (but prints correctly)

-----------------------------

5) FILES: mpdf.php

Clearing old temporary files from `_MPDF_TEMP_PATH` will now ignore "hidden" files e.g. starting with a "`.`" `.htaccess`, `.gitignore` etc.
and also leave `dummy.txt` alone


mPDF 5.7
===========================

### 14/07/2013

Files changed
-------------
- config.php
- mpdf.php
- classes/tocontents.php
- classes/cssmgr.php
- classes/svg.php
- includes/functions.php
- includes/out.php
- examples/formsubmit.php [Important - Security update]

Updated Example Files in /examples/
-----------------------------------

- All example files
- mpdfstyleA4.css

config.php
----------

Removed:
- $this->hyphenateTables
- $this->hyphenate
