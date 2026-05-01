# Passport Photo Sheet Generator

Simple single-page tool for converting one uploaded photo into passport-sized printable sheets.

## Features
- Upload one image.
- Select passport size: `35x45mm` or `2x2in`.
- Choose paper size: `4x6` or `A4`.
- Set copy count (`3`, `5`, `6`, or custom).
- Set spacing gap for cutting.
- Generate 300 DPI sheet.
- Download as PNG or JPG.

## Usage
1. Open `index.html` in a browser.
2. Upload an image.
3. Choose size, copies, and paper.
4. Click **Generate sheet**.
5. Download and print.

## Notes
- Current version uses center-crop as a practical fallback.
- Face detection/background replacement can be integrated later using browser APIs or CV libraries.
