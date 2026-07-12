const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');
const os = require('os');

// Get default reference from pandoc as binary
const pandoc = "C:\\Users\\kayka\\AppData\\Local\\Pandoc\\pandoc.exe";
const refPath = path.join(__dirname, 'ref_temp.docx');
const outputPath = path.join(__dirname, 'reference_custom.docx');

// Use execSync to get binary output
const buf = execSync(`"${pandoc}" --print-default-data-file reference.docx`, { stdio: ['pipe', 'pipe', 'inherit'] });
fs.writeFileSync(refPath, buf);

// Extract ZIP using a simple approach - call PowerShell to unzip/rezip
const tempDir = fs.mkdtempSync(path.join(os.tmpdir(), 'docx_ref_'));
const extractedDir = path.join(tempDir, 'extracted');

// Copy to zip name for extraction
const zipPath = path.join(tempDir, 'ref.zip');
fs.copyFileSync(refPath, zipPath);

// Extract using PowerShell Expand-Archive
execSync(`powershell -ExecutionPolicy Bypass -Command "Expand-Archive -Path '${zipPath}' -DestinationPath '${extractedDir}' -Force"`, { stdio: 'inherit' });

// Read and modify styles.xml
const stylesPath = path.join(extractedDir, 'word', 'styles.xml');
let stylesXml = fs.readFileSync(stylesPath, 'utf8');

// Replace font families
const fontReplacements = [
    ['w:asciiFont="Calibri"', 'w:asciiFont="Times New Roman"'],
    ['w:hAnsiFont="Calibri"', 'w:hAnsiFont="Times New Roman"'],
    ['w:asciiFont="Cambria"', 'w:asciiFont="Times New Roman"'],
    ['w:hAnsiFont="Cambria"', 'w:hAnsiFont="Times New Roman"'],
    ['w:asciiFont="Calibri Light"', 'w:asciiFont="Times New Roman"'],
    ['w:hAnsiFont="Calibri Light"', 'w:hAnsiFont="Times New Roman"'],
    ['w:asciiTheme="majorHAnsi"', 'w:asciiFont="Times New Roman"'],
    ['w:hAnsiTheme="majorHAnsi"', 'w:hAnsiFont="Times New Roman"'],
    ['w:asciiTheme="minorHAnsi"', 'w:asciiFont="Times New Roman"'],
    ['w:hAnsiTheme="minorHAnsi"', 'w:hAnsiFont="Times New Roman"'],
];

for (const [oldVal, newVal] of fontReplacements) {
    while (stylesXml.includes(oldVal)) {
        stylesXml = stylesXml.replace(oldVal, newVal);
    }
}

// Style modifications
const styleMods = [
    {
        id: 'Normal',
        insertAfter: '<w:style w:type="paragraph" w:default="1" w:styleId="Normal">',
        text: '<w:pPr><w:spacing w:line="360" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr>'
    },
    {
        id: 'Heading1',
        insertAfter: '<w:style w:type="paragraph" w:styleId="Heading1">',
        text: '<w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="240" w:after="120"/></w:pPr><w:rPr><w:b/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr>'
    },
    {
        id: 'Heading2',
        insertAfter: '<w:style w:type="paragraph" w:styleId="Heading2">',
        text: '<w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="200" w:after="100"/></w:pPr><w:rPr><w:b/><w:sz w:val="28"/><w:szCs w:val="28"/></w:rPr>'
    },
    {
        id: 'Heading3',
        insertAfter: '<w:style w:type="paragraph" w:styleId="Heading3">',
        text: '<w:pPr><w:spacing w:line="360" w:lineRule="auto" w:before="160" w:after="80"/></w:pPr><w:rPr><w:b/><w:sz w:val="26"/><w:szCs w:val="26"/></w:rPr>'
    }
];

for (const mod of styleMods) {
    const idx = stylesXml.indexOf(mod.insertAfter);
    if (idx !== -1) {
        const afterLen = mod.insertAfter.length;
        stylesXml = stylesXml.slice(0, idx + afterLen) + mod.text + stylesXml.slice(idx + afterLen);
    }
}

fs.writeFileSync(stylesPath, stylesXml, 'utf8');
console.log('styles.xml modified successfully');

// Read and modify document.xml for defaults
const docPath = path.join(extractedDir, 'word', 'document.xml');
let docXml = fs.readFileSync(docPath, 'utf8');
docXml = docXml.replace('<w:body>', '<w:body><w:pPrDefault><w:pPr><w:spacing w:line="360" w:lineRule="auto"/></w:pPr></w:pPrDefault><w:rPrDefault><w:rPr><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:rPrDefault>');
fs.writeFileSync(docPath, docXml, 'utf8');
console.log('document.xml modified successfully');

// Repackage using PowerShell Compress-Archive (output to .zip, then rename)
const outZip = path.join(tempDir, 'output.zip');
execSync(`powershell -ExecutionPolicy Bypass -Command "Compress-Archive -Path '${extractedDir}\\*' -DestinationPath '${outZip}' -Force"`, { stdio: 'inherit' });

fs.copyFileSync(outZip, outputPath);
console.log(`Custom reference template created: ${outputPath}`);

// Cleanup
fs.unlinkSync(refPath);
fs.rmSync(tempDir, { recursive: true, force: true });
console.log('Temp files cleaned up');
