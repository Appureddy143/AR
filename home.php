<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Ariva India | 3D & AR Product Viewer</title>

<!-- Google Model Viewer for 3D + AR -->
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
    <button class="icon-btn" title="Orders">🛍</button>
    <button class="icon-btn" title="Profile">👤</button>
    <button class="icon-btn" title="Wishlist">❤️</button>
    <button class="icon-btn" title="Cart">🛒</button>
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
                  auto-rotate
                  shadow-intensity="1"
                  exposure="1.0"
                  poster="images/loading.gif">
    </model-viewer>
    <p style="text-align:center; margin-top:10px;">Rotate, zoom, or view in AR (mobile supported)</p>
  </div>
</div>

<footer>© 2025 Ariva India | Experience Products in 3D & AR</footer>

<script>
// Product Data (using LOCAL GLB files)
const products = [
  {
    name: "Modern Sofa",
    price: 24999,
    image: "images/sofa2.jpg",
    model: "models/sofa.glb"
  },
  {
    name: "Outdoor Chair",
    price: 5999,
    image: "images/chair_outdoor.jpg",
    model: "models/chair_outdoor.glb"
  },
  {
    name: "Arm Chair",
    price: 9999,
    image: "images/armchair2.jpg",
    model: "models/arm_chair_furniture.glb"
  },
  {
    name: "Closet",
    price: 10999,
    image: "images/closet.jpg",
    model: "models/closet.glb"
  },
  {
    name: "Bed",
    price: 11999,
    image: "images/bed 2.jpg",
    model: "models/bed 2.glb"
  },
    {
    name: "Ottoman",
    price: 11999,
    image: "images/ottoman.jpg",
    model: "models/ottoman.glb"
  },
  {
    name: "Leather Couch",
    price: 25999,
    image: "images/leather_couch.jpg",
    model: "models/leather_couch.glb"
  },
  {
    name: "Dresser",
    price: 17999,
    image: "images/dresser.jpg",
    model: "models/dresser.glb"
  },
  {
    name: "Modern Sofa",
    price: 19999,
    image: "images/modern_sofa.jpg",
    model: "models/modern_sofa.glb"
  },
  {
    name: "Office Chair",
    price: 8999,
    image: "images/office chair.png",
    model: "models/office chair.glb"
  },
  {
    name: "Outdoor Sofa",
    price: 19999,
    image: "images/outdoor_sofa.jpg",
    model: "models/outdoors_sofa.glb"
  },
  {
    name: "Sofa",
    price: 10999,
    image: "images/sofa2.jpg",
    model: "models/sofa2.glb"
  },
  {
    name: "TV Stand",
    price: 14999,
    image: "images/tv_stand.jpg",
    model: "models/tv_stand.glb"
  }
];

// Render product cards
const grid = document.getElementById('productGrid');
products.forEach(p => {
  const card = document.createElement('div');
  card.className = 'product-card';
  card.innerHTML = `
    <img src="${p.image}" alt="${p.name}">
    <div class="product-name">${p.name}</div>
    <div class="product-price">₹${p.price.toLocaleString()}</div>
    <button class="btn" onclick="openModelView('${p.name}', '${p.model}')">👁 View in 3D / AR</button>
  `;
  grid.appendChild(card);
});

// Modal control
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

// Optional: handle load errors
const viewer = document.getElementById('modelViewer');
viewer.addEventListener('error', () => {
  alert('⚠️ Unable to load 3D model. Check if the file exists in /models/');
});
</script>

</body>
</html>
