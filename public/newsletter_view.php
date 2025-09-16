<?php
require_once __DIR__ . '/../config.php';

// Yahan future me agar aap alag alag newsletter show karna chaho to DB se load kar sakte ho
// Abhi ke liye static HTML rakhenge (jo mail me gaya tha)

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Newsletter - Indian Market Analysis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9; font-family:Arial, sans-serif; padding:30px;">
  <div class="container">
    <div class="card shadow-lg border-0 rounded-3 p-4">

      <!-- Market Analysis -->
      <div style="background:#ffffff; border-radius:10px; padding:15px; margin-bottom:15px; 
                  box-shadow:0 2px 6px rgba(0,0,0,0.05);">
        <h3 style="margin:0 0 10px 0; color:#1b5e20; font-size:18px;">Indian Market Analysis</h3>
        <table width="100%" style="font-size:14px;">
          <tr><td style="color:#2e7d32; font-weight:bold;">NIFTY 50</td><td style="color:#2e7d32;">+0.8%</td></tr>
          <tr><td style="color:#2e7d32; font-weight:bold;">SENSEX</td><td style="color:#2e7d32;">+1.2%</td></tr>
          <tr><td style="color:#c62828; font-weight:bold;">Bank NIFTY</td><td style="color:#c62828;">-0.3%</td></tr>
        </table>
        <ul style="margin:12px 0 0 20px; padding:0; color:#444; font-size:14px;">
          <li>IT sector leads gains on strong Q3 results</li>
          <li>Auto stocks mixed as festive season sales data awaited</li>
          <li>FII inflows continue for third consecutive week</li>
          <li>Rupee strengthens against dollar</li>
        </ul>
      </div>

      <!-- Sector Performance -->
      <div style="background:#e8f5e9; border-radius:10px; padding:15px; font-size:14px; margin-bottom:15px;">
        <h4 style="margin:0 0 10px 0; color:#1b5e20;">Sector Performance</h4>
        <p style="margin:4px 0; color:#2e7d32;">Information Technology +2.1%</p>
        <p style="margin:4px 0; color:#1565c0;">Pharmaceuticals +1.5%</p>
        <p style="margin:4px 0; color:#c62828;">Banking & Finance -0.6%</p>
      </div>

    </div>
  </div>
</body>
</html>
