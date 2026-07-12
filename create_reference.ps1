# Create a custom reference DOCX with Times New Roman and 1.5 spacing
# This script extracts the pandoc default reference, modifies styles, and re-packages

param(
    [string]$outputDocx = "reference_custom.docx"
)

$ErrorActionPreference = "Stop"
Add-Type -AssemblyName System.IO.Compression

# Get default reference
& "C:\Users\kayka\AppData\Local\Pandoc\pandoc.exe" --print-default-data-file reference.docx -o "ref_temp.docx" 2>$null

# Extract to temp directory
$tempDir = "$env:TEMP\docx_ref_$(Get-Random)"
New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

# Copy the reference docx to temp zip
$zipPath = "$tempDir\ref.zip"
Copy-Item "ref_temp.docx" $zipPath -Force

# Extract using Expand-Archive
Expand-Archive -Path $zipPath -DestinationPath "$tempDir\extracted" -Force

# Read and modify styles.xml
$stylesPath = "$tempDir\extracted\word\styles.xml"
$stylesXml = Get-Content -Path $stylesPath -Raw -Encoding UTF8

# Count replacements
$count = 0
$replacements = @(
    @{old='w:asciiFont="Calibri"'; new='w:asciiFont="Times New Roman"'},
    @{old='w:hAnsiFont="Calibri"'; new='w:hAnsiFont="Times New Roman"'},
    @{old='w:asciiFont="Cambria"'; new='w:asciiFont="Times New Roman"'},
    @{old='w:hAnsiFont="Cambria"'; new='w:hAnsiFont="Times New Roman"'},
    @{old='w:asciiFont="Calibri Light"'; new='w:asciiFont="Times New Roman"'},
    @{old='w:hAnsiFont="Calibri Light"'; new='w:hAnsiFont="Times New Roman"'},
    @{old='w:asciiTheme="majorHAnsi"'; new='w:asciiFont="Times New Roman"'},
    @{old='w:hAnsiTheme="majorHAnsi"'; new='w:hAnsiFont="Times New Roman"'},
    @{old='w:asciiTheme="minorHAnsi"'; new='w:asciiFont="Times New Roman"'},
    @{old='w:hAnsiTheme="minorHAnsi"'; new='w:hAnsiFont="Times New Roman"'},
    @{old='w:csTheme="majorBidi"'; new='w:cs="Times New Roman"'},
    @{old='w:csTheme="minorBidi"'; new='w:cs="Times New Roman"'}
)

foreach ($r in $replacements) {
    $oldCount = 0
    $stylesXml = $stylesXml -replace $r.old, $r.new
    $count++
}

# Set 1.5 line spacing on Normal style and 12pt
# Normal style has styleId="Normal" and default="1"
$normalPattern = '<w:style w:type="paragraph" w:default="1" w:styleId="Normal">'
$normalReplacement = '<w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:pPr><w:spacing w:line="360" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr>'
$stylesXml = $stylesXml -replace [regex]::Escape($normalPattern), $normalReplacement

# Set Heading 1 to 16pt Bold
$h1Pattern = '<w:style w:type="paragraph" w:styleId="Heading1">'
$h1Replacement = '<w:style w:type="paragraph" w:styleId="Heading1"><w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="240" w:after="120"/></w:pPr><w:rPr><w:b/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr>'
$stylesXml = $stylesXml -replace [regex]::Escape($h1Pattern), $h1Replacement

# Set Heading 2 to 14pt Bold
$h2Pattern = '<w:style w:type="paragraph" w:styleId="Heading2">'
$h2Replacement = '<w:style w:type="paragraph" w:styleId="Heading2"><w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="200" w:after="100"/></w:pPr><w:rPr><w:b/><w:sz w:val="28"/><w:szCs w:val="28"/></w:rPr>'
$stylesXml = $stylesXml -replace [regex]::Escape($h2Pattern), $h2Replacement

# Set Heading 3 to 13pt Bold
$h3Pattern = '<w:style w:type="paragraph" w:styleId="Heading3">'
$h3Replacement = '<w:style w:type="paragraph" w:styleId="Heading3"><w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="160" w:after="80"/></w:pPr><w:rPr><w:b/><w:sz w:val="26"/><w:szCs w:val="26"/></w:rPr>'
$stylesXml = $stylesXml -replace [regex]::Escape($h3Pattern), $h3Replacement

# Save modified styles.xml
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($stylesPath, $stylesXml, $utf8NoBom)

Write-Output "Styles.xml modified successfully"

# Also modify document.xml to set default paragraph properties
$docPath = "$tempDir\extracted\word\document.xml"
$docXml = Get-Content -Path $docPath -Raw -Encoding UTF8

# Add default paragraph properties at the body level
$docXml = $docXml -replace '<w:body>', '<w:body><w:pPrDefault><w:pPr><w:spacing w:line="360" w:lineRule="auto"/></w:pPr></w:pPrDefault><w:rPrDefault><w:rPr><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:rPrDefault>'
[System.IO.File]::WriteAllText($docPath, $docXml, $utf8NoBom)

# Now re-package into DOCX
$outputZip = "$tempDir\output.zip"
Compress-Archive -Path "$tempDir\extracted\*" -DestinationPath $outputZip -Force
Copy-Item $outputZip $outputDocx -Force

# Cleanup
Remove-Item "ref_temp.docx" -Force -ErrorAction SilentlyContinue
Remove-Item $tempDir -Recurse -Force -ErrorAction SilentlyContinue

Write-Output "Custom reference template created: $outputDocx"
