param(
    [string]$refDocx = "reference_template.docx",
    [string]$outputDocx = "reference_custom.docx"
)

Add-Type -AssemblyName System.IO.Compression

# Open the reference docx as a ZIP archive
$zip = [System.IO.Compression.ZipArchive]::new(
    [System.IO.File]::Open($refDocx, [System.IO.FileMode]::Open, [System.IO.FileAccess]::ReadWrite),
    [System.IO.Compression.ZipArchiveMode]::Update
)

# Find and modify styles.xml
$stylesEntry = $zip.Entries | Where-Object { $_.Name -eq "styles.xml" }

if ($stylesEntry) {
    $reader = [System.IO.StreamReader]::new($stylesEntry.Open())
    $stylesXml = $reader.ReadToEnd()
    $reader.Dispose()

    # Replace font from Calibri/Cambria to Times New Roman
    $stylesXml = $stylesXml -replace 'w:asciiFont="Calibri"', 'w:asciiFont="Times New Roman"'
    $stylesXml = $stylesXml -replace 'w:hAnsiFont="Calibri"', 'w:hAnsiFont="Times New Roman"'
    $stylesXml = $stylesXml -replace 'w:asciiFont="Cambria"', 'w:asciiFont="Times New Roman"'
    $stylesXml = $stylesXml -replace 'w:hAnsiFont="Cambria"', 'w:hAnsiFont="Times New Roman"'
    $stylesXml = $stylesXml -replace 'w:asciiFont="Calibri Light"', 'w:asciiFont="Times New Roman"'
    $stylesXml = $stylesXml -replace 'w:hAnsiFont="Calibri Light"', 'w:hAnsiFont="Times New Roman"'

    # Set body font size to 12pt for Normal style
    $stylesXml = $stylesXml -replace '<w:style w:type="paragraph" w:default="1" w:styleId="Normal">', '<w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:pPr><w:spacing w:line="360" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr>'

    # Set line spacing for Normal table style  
    $stylesXml = $stylesXml -replace '<w:style w:type="table" w:default="1" w:styleId="Table">', '<w:style w:type="table" w:default="1" w:styleId="Table"><w:pPr><w:spacing w:line="240" w:lineRule="auto"/></w:pPr>'

    # Write back
    $writer = [System.IO.StreamWriter]::new($stylesEntry.Open())
    $writer.Write($stylesXml)
    $writer.Dispose()
    
    Write-Output "Styles updated successfully"
} else {
    Write-Output "styles.xml not found in DOCX"
}

$zip.Dispose()

# Copy the modified file
Copy-Item $refDocx $outputDocx -Force
Write-Output "Custom reference template created: $outputDocx"
