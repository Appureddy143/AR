<?php
// index.php
// You can later connect this to a database or backend logic.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Ariva India | Smart Shopping with 3D & AR</title>

<!-- 3D/AR model-viewer library -->
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

<style>
:root {
  --accent:#ffd600;
  --dark:#111;
  --bg:#fafafa;
  --card:#fff;
  --shadow:0 6px 18px rgba(0,0,0,0.06);
  --text:#222;
}
* { box-sizing:border-box; }
body {
  margin:0;
  font-family: Inter, system-ui, sans-serif;
  background:var(--bg);
  color:var(--text);
}

/* Top Bar */
.top-bar {
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:12px 20px;
  background:var(--dark);
  color:#fff;
}
.logo-text {
  font-size:24px;
  font-weight:700;
  letter-spacing:2px;
  color:var(--accent);
}
.icon-row { display:flex; gap:12px; }
.icon-btn {
  background:none;
  border:0;
  color:#fff;
  font-size:20px;
  cursor:pointer;
}

/* Container */
.container {
  padding:20px;
  max-width:1200px;
  margin:0 auto;
}
h2 { text-align:center; margin-bottom:10px; }

/* Product Grid */
.product-grid {
  display:flex;
  flex-wrap:wrap;
  gap:16px;
  justify-content:center;
}
.product-card {
  width:260px;
  background:var(--card);
  border-radius:12px;
  box-shadow:var(--shadow);
  padding:14px;
  text-align:center;
  transition:transform .2s;
}
.product-card:hover { transform:translateY(-5px); }
.product-card img {
  width:100%;
  height:180px;
  object-fit:cover;
  border-radius:8px;
}
.product-name { font-weight:600; margin-top:10px; }
.product-price { color:var(--dark); font-weight:700; margin:6px 0; }

/* Buttons */
.btn {
  border:0;
  background:var(--accent);
  color:#000;
  padding:8px 12px;
  border-radius:6px;
  font-weight:600;
  cursor:pointer;
  transition:background .2s;
}
.btn:hover { background:#ffe44d; }

/* 3D Modal */
.modal-bg {
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.5);
  justify-content:center;
  align-items:center;
  z-index:999;
}
.modal {
  background:#fff;
  border-radius:12px;
  max-width:600px;
  width:90%;
  padding:20px;
  position:relative;
}
.close-btn {
  position:absolute;
  top:10px;
  right:14px;
  border:none;
  background:none;
  font-size:22px;
  cursor:pointer;
  color:#444;
}
model-viewer {
  width:100%;
  height:400px;
  background:#f4f4f4;
  border-radius:10px;
}
footer {
  text-align:center;
  padding:16px;
  background:var(--dark);
  color:#fff;
  font-size:14px;
  margin-top:30px;
}
</style>
</head>
<body>

<div class="top-bar">
  <div class="logo-text">ARIVA</div>
  <div class="icon-row">
    <button class="icon-btn">🛍</button>
    <button class="icon-btn">👤</button>
    <button class="icon-btn">❤️</button>
    <button class="icon-btn">🛒</button>
  </div>
</div>

<div class="container">
  <h2>Shop with 3D & AR Experience</h2>
  <div class="product-grid" id="productGrid"></div>
</div>

<!-- 3D Modal -->
<div class="modal-bg" id="modelModal">
  <div class="modal">
    <button class="close-btn" onclick="closeModelView()">×</button>
    <h3 id="modelTitle"></h3>
    <model-viewer id="modelViewer"
                  src=""
                  alt="3D Model"
                  ar
                  ar-modes="webxr scene-viewer quick-look"
                  camera-controls
                  auto-rotate>
    </model-viewer>
    <p style="text-align:center; margin-top:10px;">You can rotate, zoom, or view in AR (on mobile)</p>
  </div>
</div>

<footer>© 2025 Ariva India | Experience Products in 3D & AR</footer>

<script>
// Product Data with 3D Models
const products = [
  {
    name: "Modern Sofa",
    price: 24999,
    image: "https://www.shutterstock.com/image-photo/modern-fashionable-stylish-pink-sofa-600nw-1377591560.jpg",
    model: "https://modelviewer.dev/shared-assets/models/Chair.glb",
  },
  {
    name: "Smartphone X10",
    price: 69999,
    image: "https://images.samsung.com/is/image/samsung/p6pim/in/sm-s926bzkgins/gallery/in-galaxy-s24-plus-sm-s926-sm-s926bzkgins-thumb-539332521",
    model: "https://modelviewer.dev/shared-assets/models/Pixel4.glb",
  },
  {
    name: "Diamond Ring",
    price: 49999,
    image: "https://www.shutterstock.com/image-photo/diamond-ring-isolated-on-white-600nw-485418181.jpg",
    model: "https://modelviewer.dev/shared-assets/models/Diamond.glb",
  },
  {
    name: "LED Smart TV",
    price: 45999,
    image: "https://images.samsung.com/is/image/samsung/p6pim/in/ua55du8000klxl/gallery/in-uhd-4k-tv-du8000-465457-du8000-ua55du8000klxl-thumb-539426797",
    model: "https://modelviewer.dev/shared-assets/models/TV.glb",
  },
  {
    name: "Table Lamp",
    price: 999,
    image: "https://thumbs.dreamstime.com/b/old-table-lamp-isolated-white-background-108616690.jpg",
    model: "https://modelviewer.dev/shared-assets/models/Lamp.glb",
  },
  {
    name: "Luxury Watch",
    price: 11999,
    image: "https://cdn.thewatchcompany.com/media/catalog/product/cache/1/image/700x/602f0fa2c1f0d1ba5e241f914e856ff9/r/o/rolex-oyster-perpetual-36-silver-126000-silver-oyster-5.jpg",
    model: "https://modelviewer.dev/shared-assets/models/Watch.glb",
  },
];

// Render products
const grid = document.getElementById('productGrid');
products.forEach(p => {
  const card = document.createElement('div');
  card.className = 'product-card';
  card.innerHTML = `
    <img src="${p.image}" alt="${p.name}">
    <div class="product-name">${p.name}</div>
    <div class="product-price">₹${p.price.toLocaleString()}</div>
    <button class="btn" onclick="openModelView('${p.name}','${p.model}')">👁 View in 3D / AR</button>
  `;
  grid.appendChild(card);
});

// Modal functions
function openModelView(name, modelUrl) {
  document.getElementById('modelTitle').textContent = name;
  const viewer = document.getElementById('modelViewer');
  viewer.setAttribute('src', modelUrl);
  document.getElementById('modelModal').style.display = 'flex';
}
function closeModelView() {
  document.getElementById('modelModal').style.display = 'none';
  document.getElementById('modelViewer').removeAttribute('src');
}
</script>

</body>
</html>
