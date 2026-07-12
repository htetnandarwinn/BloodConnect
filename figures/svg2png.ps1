param(
    [string]$svgPath,
    [string]$pngPath
)

Add-Type -AssemblyName System.Windows.Forms
Add-Type -AssemblyName System.Drawing

$svgContent = Get-Content -Path $svgPath -Raw

# Create HTML page with SVG embedded
$html = @"
<html><body style='margin:0;padding:0;'>
$svgContent
</body></html>
"@

$htmlPath = [System.IO.Path]::GetTempFileName() + ".html"
Set-Content -Path $htmlPath -Value $html -Encoding UTF8

$webBrowser = New-Object System.Windows.Forms.WebBrowser
$webBrowser.ScrollBarsEnabled = $false
$webBrowser.Size = New-Object System.Drawing.Size(900, 700)
$webBrowser.Navigate([Uri]"file:///$($htmlPath.Replace('\','/'))")

# Wait for page to load
while ($webBrowser.ReadyState -ne 'Complete') {
    [System.Windows.Forms.Application]::DoEvents()
    Start-Sleep -Milliseconds 100
}

# Additional wait for SVG rendering
Start-Sleep -Seconds 2

# Capture bitmap
$bitmap = New-Object System.Drawing.Bitmap(900, 700)
$bitmap.SetResolution(150, 150)
$graphics = [System.Drawing.Graphics]::FromImage($bitmap)
$webBrowser.DrawToBitmap($bitmap, [System.Drawing.Rectangle]::new(0, 0, 900, 700))
$graphics.Dispose()
$bitmap.Save($pngPath, [System.Drawing.Imaging.ImageFormat]::Png)
$bitmap.Dispose()
$webBrowser.Dispose()

Remove-Item -Path $htmlPath -Force
Write-Output "Converted: $svgPath -> $pngPath"
