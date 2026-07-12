const fs = require('fs');

// SVG for Home Page Wireframe
const w = 900, h = 700;

function rect(x, y, w, h, fill, stroke, r) {
    return `  <rect x="${x}" y="${y}" width="${w}" height="${h}" fill="${fill}" stroke="${stroke}" rx="${r||0}" />`;
}

function text(x, y, content, size='14', bold='normal', color='#333') {
    return `  <text x="${x}" y="${y}" font-family="Arial, sans-serif" font-size="${size}px" font-weight="${bold}" fill="${color}">${content}</text>`;
}

const svg = `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${w} ${h}" width="${w}" height="${h}">
  <style>
    .label { font-family: Arial, sans-serif; font-size: 11px; fill: #666; }
    .header-txt { font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; fill: #fff; }
  </style>

  <!-- Header / Logo Bar -->
  <rect x="0" y="0" width="${w}" height="60" fill="#C62828" />
  <text x="30" y="38" font-family="Arial, sans-serif" font-size="22px" font-weight="bold" fill="#fff">BloodConnect</text>
  
  <!-- Header links -->
  <text x="620" y="38" font-family="Arial, sans-serif" font-size="13px" fill="#FFCDD2" cursor="pointer">Home</text>
  <text x="670" y="38" font-family="Arial, sans-serif" font-size="13px" fill="#FFCDD2" cursor="pointer">About</text>
  <text x="725" y="38" font-family="Arial, sans-serif" font-size="13px" fill="#FFCDD2" cursor="pointer">Requests</text>
  <text x="795" y="38" font-family="Arial, sans-serif" font-size="13px" fill="#FFCDD2" cursor="pointer">Login</text>

  <!-- Hero Section -->
  <rect x="0" y="60" width="${w}" height="180" fill="#FFEBEE" />
  <text x="450" y="120" font-family="Arial, sans-serif" font-size="28px" font-weight="bold" fill="#C62828" text-anchor="middle">Save Lives — Donate Blood</text>
  <text x="450" y="150" font-family="Arial, sans-serif" font-size="15px" fill="#555" text-anchor="middle">Every donation can save up to three lives. Join us in making a difference.</text>
  
  <!-- CTA Buttons -->
  <rect x="300" y="175" width="140" height="40" fill="#C62828" rx="4" />
  <text x="370" y="200" font-family="Arial, sans-serif" font-size="14px" font-weight="bold" fill="#fff" text-anchor="middle">Register as Donor</text>
  <rect x="460" y="175" width="140" height="40" fill="#fff" stroke="#C62828" stroke-width="2" rx="4" />
  <text x="530" y="200" font-family="Arial, sans-serif" font-size="14px" font-weight="bold" fill="#C62828" text-anchor="middle">Request Blood</text>

  <!-- Stats Section -->
  <text x="450" y="285" font-family="Arial, sans-serif" font-size="20px" font-weight="bold" fill="#333" text-anchor="middle">Quick Stats</text>

  <!-- Stats boxes -->
  <rect x="50" y="305" width="250" height="80" fill="#E8F5E9" rx="6" />
  <text x="175" y="340" font-family="Arial, sans-serif" font-size="24px" font-weight="bold" fill="#2E7D32" text-anchor="middle">1,247</text>
  <text x="175" y="365" font-family="Arial, sans-serif" font-size="13px" fill="#555" text-anchor="middle">Registered Donors</text>

  <rect x="325" y="305" width="250" height="80" fill="#E3F2FD" rx="6" />
  <text x="450" y="340" font-family="Arial, sans-serif" font-size="24px" font-weight="bold" fill="#1565C0" text-anchor="middle">856</text>
  <text x="450" y="365" font-family="Arial, sans-serif" font-size="13px" fill="#555" text-anchor="middle">Requests Fulfilled</text>

  <rect x="600" y="305" width="250" height="80" fill="#FFF3E0" rx="6" />
  <text x="725" y="340" font-family="Arial, sans-serif" font-size="24px" font-weight="bold" fill="#E65100" text-anchor="middle">12</text>
  <text x="725" y="365" font-family="Arial, sans-serif" font-size="13px" fill="#555" text-anchor="middle">Active Requests</text>

  <!-- Recent Requests Section -->
  <text x="30" y="435" font-family="Arial, sans-serif" font-size="18px" font-weight="bold" fill="#333">Recent Blood Requests</text>
  
  <!-- Table / List -->
  <rect x="30" y="455" width="840" height="30" fill="#F5F5F5" rx="4" />
  <text x="50" y="475" font-family="Arial, sans-serif" font-size="12px" font-weight="bold" fill="#555">Blood Type</text>
  <text x="180" y="475" font-family="Arial, sans-serif" font-size="12px" font-weight="bold" fill="#555">Hospital</text>
  <text x="360" y="475" font-family="Arial, sans-serif" font-size="12px" font-weight="bold" fill="#555">Urgency</text>
  <text x="500" y="475" font-family="Arial, sans-serif" font-size="12px" font-weight="bold" fill="#555">Quantity</text>
  <text x="630" y="475" font-family="Arial, sans-serif" font-size="12px" font-weight="bold" fill="#555">Status</text>

  <!-- Row 1 -->
  <line x1="30" y1="485" x2="870" y2="485" stroke="#E0E0E0" />
  <text x="50" y="500" font-family="Arial, sans-serif" font-size="12px" fill="#333">A+</text>
  <text x="180" y="500" font-family="Arial, sans-serif" font-size="12px" fill="#333">Manila General Hospital</text>
  <text x="360" y="500" font-family="Arial, sans-serif" font-size="12px" fill="#D32F2F" font-weight="bold">URGENT</text>
  <text x="500" y="500" font-family="Arial, sans-serif" font-size="12px" fill="#333">500 ml</text>
  <rect x="620" y="490" width="55" height="16" fill="#FFF9C4" rx="3" />
  <text x="647" y="502" font-family="Arial, sans-serif" font-size="10px" fill="#F57F17" text-anchor="middle">Pending</text>

  <!-- Row 2 -->
  <line x1="30" y1="515" x2="870" y2="515" stroke="#E0E0E0" />
  <text x="50" y="530" font-family="Arial, sans-serif" font-size="12px" fill="#333">O-</text>
  <text x="180" y="530" font-family="Arial, sans-serif" font-size="12px" fill="#333">Quezon City Medical</text>
  <text x="360" y="530" font-family="Arial, sans-serif" font-size="12px" fill="#333">Normal</text>
  <text x="500" y="530" font-family="Arial, sans-serif" font-size="12px" fill="#333">350 ml</text>
  <rect x="620" y="520" width="55" height="16" fill="#E8F5E9" rx="3" />
  <text x="647" y="532" font-family="Arial, sans-serif" font-size="10px" fill="#2E7D32" text-anchor="middle">Matched</text>

  <!-- Row 3 -->
  <line x1="30" y1="545" x2="870" y2="545" stroke="#E0E0E0" />
  <text x="50" y="560" font-family="Arial, sans-serif" font-size="12px" fill="#333">B+</text>
  <text x="180" y="560" font-family="Arial, sans-serif" font-size="12px" fill="#333">Makati Medical Center</text>
  <text x="360" y="560" font-family="Arial, sans-serif" font-size="12px" fill="#D32F2F" font-weight="bold">URGENT</text>
  <text x="500" y="560" font-family="Arial, sans-serif" font-size="12px" fill="#333">450 ml</text>
  <rect x="620" y="550" width="55" height="16" fill="#FFEBEE" rx="3" />
  <text x="647" y="562" font-family="Arial, sans-serif" font-size="10px" fill="#C62828" text-anchor="middle">Open</text>

  <!-- Footer -->
  <rect x="0" y="650" width="${w}" height="50" fill="#424242" />
  <text x="450" y="678" font-family="Arial, sans-serif" font-size="12px" fill="#9E9E9E" text-anchor="middle">&copy; 2026 BloodConnect. All rights reserved.</text>

  <!-- Wireframe labels -->
  <text x="20" y="20" font-family="Arial, sans-serif" font-size="10px" fill="#999">Header / Navigation Bar</text>
  <text x="20" y="75" font-family="Arial, sans-serif" font-size="10px" fill="#999">Hero Section (Campaign Banner)</text>
  <text x="20" y="300" font-family="Arial, sans-serif" font-size="10px" fill="#999">Statistics Overview</text>
  <text x="20" y="450" font-family="Arial, sans-serif" font-size="10px" fill="#999">Recent Requests List</text>
  <text x="20" y="660" font-family="Arial, sans-serif" font-size="10px" fill="#999">Footer</text>
</svg>`;

fs.writeFileSync('figures/figure3_4_wireframe.svg', svg);
console.log('Wireframe SVG created:', 'figures/figure3_4_wireframe.svg');
