<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Ariva India | 3D & AR Product Viewer</title>

<!-- Google Model Viewer -->
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
.icon-row { display:flex; gap:12px; align-items:center; }
.icon-btn {
  background:none;
  border:0;
  color:#fff;
  font-size:20px;
  cursor:pointer;
  padding:6px;
  border-radius:6px;
  text-decoration:none;
  transition:background .2s;
}
.icon-btn:hover { background:rgba(255,255,255,0.15); }

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
#micBtn {
  margin-left:8px;
  font-size:22px;
}
</style>
</head>
<body>

<!-- ====== TOP BAR ====== -->
<div class="top-bar">
  <div class="logo-text">ARIVA</div>
  <div class="icon-row">
    <a href="orders.php" class="icon-btn" title="Orders">🛍</a>
    <a href="profile.php" class="icon-btn" title="Profile">👤</a>
    <a href="wishlist.php" class="icon-btn" title="Wishlist">❤️</a>
    <a href="cart.php" class="icon-btn" title="Cart">🛒</a>
    <button class="icon-btn" id="micBtn" title="Voice Command">🎤</button>
  </div>
</div>

<!-- ====== MAIN CONTENT ====== -->
<div class="container">
  <h2>Shop with 3D & AR Experience</h2>
  <div class="product-grid" id="productGrid"></div>
</div>

<!-- ====== 3D MODAL ====== -->
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

<!-- ====== PRODUCT & VIEWER SCRIPT ====== -->
<script>
// Product Data (using LOCAL GLB files)
const products = [
  {
    name: "Modern Sofa",
    price: 24999,
    image: "models/sofa2.jpg",
    model: "models/sofa.glb"
  },
  {
    name: "Outdoor Chair",
    price: 5999,
    image: "models/chair_outdoor.jpg",
    model: "models/chair_outdoor.glb"
  },
  {
    name: "Closet",
    price: 10999,
    image: "models/closet.jpg",
    model: "models/closet.glb"
  },
  {
    name: "Bed",
    price: 11999,
    image: "models/bed 2.jpg",
    model: "models/bed 2.glb"
  },
    {
    name: "Ottoman",
    price: 11999,
    image: "models/ottoman.jpg",
    model: "models/ottoman.glb"
  },
  {
    name: "Leather Couch",
    price: 25999,
    image: "models/leather_couch.png",
    model: "models/leather_couch.glb"
  },
  {
    name: "Dresser",
    price: 17999,
    image: "models/dresser.jpg",
    model: "models/dresser.glb"
  },
  {
    name: "Modern Sofa",
    price: 19999,
    image: "models/modern_sofa.jpg",
    model: "models/modern_sofa.glb"
  },
  {
    name: "Office Chair",
    price: 8999,
    image: "models/office chair.png",
    model: "models/office chair.glb"
  },
  {
    name: "Outdoor Sofa",
    price: 19999,
    image: "models/outdoor_sofa.jpg",
    model: "models/outdoors_sofa.glb"
  },
  {
    name: "Sofa",
    price: 10999,
    image: "models/sofa2.jpg",
    model: "models/sofa2.glb"
  },
  {
    name: "TV Stand",
    price: 14999,
    image: "models/tv_stand.jpg",
    model: "models/tv_stand.glb"
  }, 
 {
    name: "glasses",
    price: 599,
    image: "models/glasses.jpg",
    model: "models/00741558210359.glb"
  }, 
 {
    name: "Ring",
    price: 14999,
    image: "models/ring_turtle.jpg",
    model: "models/ring_with_turtle.glb"
  }, 
 {
    name: "Earrings",
    price: 199,
    image: "models/daisy_earrings.jpg",
    model: "models/daisy_hoop_earrings_-_silver_and_gold.glb"
  }, 
 {
    name: "Bracelet",
    price: 299,
    image: "models/bracelet.jpg",
    model: "models/bracelet.glb"
  }, 
 {
    name: "Indian jewellery",
    price: 999,
    image: "models/Indian_jewellery.jpg",
    model: "models/Indian_jewellery.glb"
  },
{
    name: "CMA Sunscreen",
    price: 699,
    image: "models/sunscreen.jpg",
    model: "models/cosmetic_product.glb"
  },
{
    name: "CC Cream",
    price: 99,
    image: "models/biege_cream.jpg",
    model: "models/cosmetics_beige_cream_tube.glb"
  },
{
    name: "Serum",
    price: 499,
    image: "models/serum.jpg",
    model: "models/cosmetic_serum_bottle.glb"
  },
{
    name: "Lipstick",
    price: 99,
    image: "models/lipstick.jpg",
    model: "models/lipstick.glb"
  },
{
    name: "TF Lipstick",
    price: 149,
    image: "models/lipstick_brown.jpg",
    model: "models/lipstick_by_tom_ford.glb"
  },
{
    name: "compact powder",
    price: 199,
    image: "models/compact.jpg",
    model: "models/cosmetic_-_powder.glb"
  },
{
    name: "Necklace",
    price: 149,
    image: "models/necklace.jpg",
    model: "models/necklace_b.glb"
  },
{
    name: "Cuban Chain",
    price: 1999,
    image: "models/cuban_chain.jpg",
    model: "models/cuban_chain_3d_model.glb"
  }
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
    <button class="btn" onclick="openModelView('${p.name}', '${p.model}')">👁 View in 3D / AR</button>
  `;
  grid.appendChild(card);
});

// 3D Modal
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

<!-- ====== VOICE CONTROL SCRIPT ====== -->
<script>
let recognizing = false;
let recognition;
let cart = [];
const micBtn = document.getElementById('micBtn');

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  recognition = new SpeechRecognition();
  recognition.continuous = false;
  recognition.lang = 'en-IN';
  recognition.interimResults = false;

  recognition.onstart = () => {
    recognizing = true;
    micBtn.style.background = "#ffd600";
  };
  recognition.onend = () => {
    recognizing = false;
    micBtn.style.background = "none";
  };
  recognition.onerror = event => {
    alert('Voice recognition error: ' + event.error);
  };

  recognition.onresult = event => {
    let cmd = event.results[0][0].transcript.toLowerCase().trim();
    console.log("🎤 Voice Command:", cmd);
    handleVoiceCommand(cmd);
  };

  micBtn.onclick = () => recognizing ? recognition.stop() : recognition.start();
} else {
  micBtn.style.display = "none";
  alert("Sorry, your browser does not support voice recognition.");
}

// === Handle Commands ===
function handleVoiceCommand(cmd) {
  if (cmd.includes("open cart")) return navigateTo("cart.php");
  if (cmd.includes("open wishlist")) return navigateTo("wishlist.php");
  if (cmd.includes("open profile")) return navigateTo("profile.php");
  if (cmd.includes("open orders")) return navigateTo("orders.php");

  if (cmd.startsWith("show") || cmd.startsWith("find")) {
    let item = cmd.replace("show", "").replace("find", "").trim();
    return highlightProduct(item);
  }

  if ((cmd.includes("open") && cmd.includes("3d")) || (cmd.includes("open") && cmd.includes("ar"))) {
    let item = cmd.replace("open", "").replace("in 3d", "").replace("in ar", "").trim();
    return openProductIn3D(item);
  }

  if (cmd.startsWith("add")) {
    let item = cmd.replace("add", "").replace("to cart", "").trim();
    return addToCart(item);
  }

  if (cmd.includes("close model") || cmd.includes("close viewer")) {
    speak("Closing viewer");
    return closeModelView();
  }

  speak("Sorry, I didn't understand that command.");
}

// === Helpers ===
function navigateTo(page) {
  speak("Opening " + page.replace(".php", ""));
  window.location.href = page;
}
function highlightProduct(name) {
  let found = false;
  document.querySelectorAll(".product-card").forEach(card => {
    if(card.innerText.toLowerCase().includes(name)) {
      card.scrollIntoView({behavior:'smooth'});
      card.style.border = "2px solid var(--accent)";
      found = true;
      speak("Showing " + name);
      setTimeout(()=>card.style.border="", 3000);
    }
  });
  if(!found) speak("Couldn't find any product matching " + name);
}
function openProductIn3D(name) {
  let found = false;
  products.forEach(p => {
    if (p.name.toLowerCase().includes(name)) {
      openModelView(p.name, p.model);
      found = true;
      speak("Opening " + p.name + " in 3D viewer");
    }
  });
  if(!found) speak("No 3D model found for " + name);
}
function addToCart(name) {
  let found = products.find(p => p.name.toLowerCase().includes(name));
  if (found) {
    cart.push(found);
    speak(`Added ${found.name} to your cart.`);
  } else {
    speak("Couldn't find any product matching " + name);
  }
}
function speak(text) {
  const synth = window.speechSynthesis;
  if (synth) {
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = 'en-IN';
    synth.speak(utter);
  } else alert(text);
}
</script>

</body>
</html>


