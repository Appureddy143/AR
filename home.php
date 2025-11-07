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

.container {
  padding:20px;
  max-width:1200px;
  margin:0 auto;
}
h2 { text-align:center; margin-bottom:10px; }

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

/* small style for wishlist heart inside product card */
.product-actions { display:flex; justify-content:center; gap:8px; flex-wrap:wrap; margin-top:8px; align-items:center; }
.icon-heart { font-size:18px; background:none; border:0; cursor:pointer; padding:6px; border-radius:6px; }
.icon-heart.active { color:red; }
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
  { name: "Modern Sofa", price: 24999, image: "models/sofa2.jpg", model: "models/sofa.glb" },
  { name: "Outdoor Chair", price: 5999, image: "models/chair_outdoor.jpg", model: "models/chair_outdoor.glb" },
  { name: "Closet", price: 10999, image: "models/closet.jpg", model: "models/closet.glb" },
  { name: "Bed", price: 11999, image: "models/bed 2.jpg", model: "models/bed 2.glb" },
  { name: "Ottoman", price: 11999, image: "models/ottoman.jpg", model: "models/ottoman.glb" },
  { name: "Leather Couch", price: 25999, image: "models/leather_couch.png", model: "models/leather_couch.glb" },
  { name: "Dresser", price: 17999, image: "models/dresser.jpg", model: "models/dresser.glb" },
  { name: "Modern Sofa", price: 19999, image: "models/modern_sofa.jpg", model: "models/modern_sofa.glb" },
  { name: "Office Chair", price: 8999, image: "models/office chair.png", model: "models/office chair.glb" },
  { name: "Outdoor Sofa", price: 19999, image: "models/outdoor_sofa.jpg", model: "models/outdoors_sofa.glb" },
  { name: "Sofa", price: 10999, image: "models/sofa2.jpg", model: "models/sofa2.glb" },
  { name: "TV Stand", price: 14999, image: "models/tv_stand.jpg", model: "models/tv_stand.glb" },
  { name: "Ring", price: 14999, image: "models/ring_turtle.jpg", model: "models/ring_with_turtle.glb" },
  { name: "Earrings", price: 199, image: "models/daisy_earrings.jpg", model: "models/daisy_hoop_earrings_-_silver_and_gold.glb" },
  { name: "Bracelet", price: 299, image: "models/bracelet.jpg", model: "models/bracelet.glb" },
  { name: "Indian jewellery", price: 999, image: "models/Indian_jewellery.jpg", model: "models/Indian_jewellery.glb" },
  { name: "CMA Sunscreen", price: 699, image: "models/sunscreen.jpg", model: "models/cosmetic_product.glb" },
  { name: "CC Cream", price: 99, image: "models/biege_cream.jpg", model: "models/cosmetics_beige_cream_tube.glb" },
  { name: "Serum", price: 499, image: "models/serum.jpg", model: "models/cosmetic_serum_bottle.glb" },
  { name: "Lipstick", price: 99, image: "models/lipstick.jpg", model: "models/lipstick.glb" },
  { name: "TF Lipstick", price: 149, image: "models/lipstick_brown.jpg", model: "models/lipstick_by_tom_ford.glb" },
  { name: "compact powder", price: 199, image: "models/compact.jpg", model: "models/cosmetic_-_powder.glb" },
  { name: "Necklace", price: 149, image: "models/necklace.jpg", model: "models/necklace_b.glb" },
  { name: "Cuban Chain", price: 1999, image: "models/cuban_chain.jpg", model: "models/cuban_chain_3d_model.glb" },
  { name: "Sun Glasses", price: 399, image: "models/glasses.jpg", model: "models/00741558210359.glb" },
  { name: "Rect Sun glasses", price: 499, image: "models/sun_glasses.jpg", model: "models/sun_glasses.glb" },
  { name: "Geometric Sun Glasses", price: 599, image: "models/sunglasses1.jpg", model: "models/sun_glasses(1).glb" },
  { name: "Round Sun glasses", price: 399, image: "models/sunglasses.jpg", model: "models/sunglasses.glb" },
  { name: "Spy Sun Glasses", price: 999, image: "models/sunglasses_spy.jpg", model: "models/glasses_spy_tron_2_-_gafas_pbr.glb" },
  { name: "Narrow Frame Sun Glasses", price: 699, image: "models/sunglasses_low.jpg", model: "models/sun_glasses_-_low_poly.glb" },
];

// state
let cart = [];
let wishlist = [];
// --- Persistent storage helpers ---
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}
function loadCart() {
  const data = localStorage.getItem("cart");
  if (data) cart = JSON.parse(data);
}
function saveWishlist() {
  localStorage.setItem("wishlist", JSON.stringify(wishlist));
}
function loadWishlist() {
  const data = localStorage.getItem("wishlist");
  if (data) wishlist = JSON.parse(data);
}

// Load saved data on page start
loadCart();
loadWishlist();

// Render products
const grid = document.getElementById('productGrid');
products.forEach((p, idx) => {
  const card = document.createElement('div');
  card.className = 'product-card';
  // Use data-index attribute to reference product reliably
  card.setAttribute('data-index', idx);
  card.innerHTML = `
    <img src="${p.image}" alt="${p.name}">
    <div class="product-name">${p.name}</div>
    <div class="product-price">₹${p.price.toLocaleString()}</div>
    <div class="product-actions">
      <button class="btn" onclick="openModelView('${escapeQuotes(p.name)}', '${escapeQuotes(p.model)}')">👁 View in 3D / AR</button>
      <button class="btn" onclick="addToCart('${escapeQuotes(p.name)}')">🛒 Add to Cart</button>
      <button class="btn" onclick="buyNow('${escapeQuotes(p.name)}')">💳 Buy Now</button>
      <button class="icon-heart" id="heart-${idx}" onclick="toggleWishlistIndex(${idx})" title="Add to Wishlist">❤️</button>
    </div>
  `;
  grid.appendChild(card);
});

// helper to escape single quotes inside names for onclick strings
function escapeQuotes(str) {
  return String(str).replace(/'/g, "\\'");
}

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

// Wishlist toggle by product index (reliable)
function addToCart(name) {
  if (!name) { speak("Please tell which product to add"); return; }
  const item = products.find(p => p.name.toLowerCase().includes(name.toLowerCase()));
  if (item) {
    cart.push(item);
    saveCart();
    speak(`Added ${item.name} to your cart.`);
    console.log("Cart:", cart);
  } else {
    speak("Couldn't find any product matching " + name);
  }
}

function toggleWishlistIndex(idx) {
  const item = products[idx];
  const heartEl = document.getElementById(`heart-${idx}`);
  const exists = wishlist.find(p => p.name === item.name);
  if (!exists) {
    wishlist.push(item);
    saveWishlist();
    heartEl.classList.add('active');
    speak(`${item.name} added to wishlist`);
  } else {
    wishlist = wishlist.filter(p => p.name !== item.name);
    saveWishlist();
    heartEl.classList.remove('active');
    speak(`${item.name} removed from wishlist`);
  }
}



// buyNow: navigate to checkout with encoded product name
function buyNow(name) {
  if (!name) { speak("Please tell which product to buy"); return; }
  const item = products.find(p => p.name.toLowerCase().includes(name.toLowerCase()));
  if (item) {
    speak(`Proceeding to buy ${item.name}`);
    window.location.href = `checkout.php?product=${encodeURIComponent(item.name)}`;
  } else {
    // fallback: still navigate with the raw name
    window.location.href = `checkout.php?product=${encodeURIComponent(name)}`;
  }
}

// small helper when voice wishlist command uses addToWishlist
function addToWishlistByName(name) {
  const item = products.find(p => p.name.toLowerCase().includes(name.toLowerCase()));
  if (item) {
    // find index to mark heart active
    const idx = products.findIndex(p => p.name === item.name);
    if (idx >= 0) {
      const heartEl = document.getElementById(`heart-${idx}`);
      if (heartEl && !heartEl.classList.contains('active')) heartEl.classList.add('active');
    }
    if (!wishlist.find(p => p.name === item.name)) wishlist.push(item);
    speak(`Added ${item.name} to your wishlist`);
  } else {
    speak("Couldn't find any product matching " + name);
  }
}

// Speak helper
function speak(text) {
  const synth = window.speechSynthesis;
  if (synth) {
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = 'en-IN';
    synth.speak(utter);
  } else {
    console.log("Speak:", text);
  }
}
</script>

<!-- ====== VOICE CONTROL SCRIPT ====== -->
<script>
let recognizing = false;
let recognition;
const micBtn = document.getElementById('micBtn');

function setupSpeechRecognition() {
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
      console.error('Voice recognition error:', event);
      speak('Voice recognition error: ' + event.error);
    };

    recognition.onresult = event => {
      let cmd = event.results[0][0].transcript.toLowerCase().trim();
      console.log("🎤 Voice Command:", cmd);
      handleVoiceCommand(cmd);
    };

    micBtn.onclick = () => recognizing ? recognition.stop() : recognition.start();
  } else {
    micBtn.style.display = "none";
    // Not too noisy on unsupported browsers
    console.warn("SpeechRecognition not supported");
  }
}
setupSpeechRecognition();

// Normalize and remove filler words, helper
function cleanCommand(cmd) {
  return cmd.replace(/please/g, '').replace(/now/g, '').replace(/\bthe\b/g, '').replace(/\bon\b/g, '').trim();
}

// === Handle Commands ===
function handleVoiceCommand(rawCmd) {
  const cmd = cleanCommand(rawCmd);
  // navigation
  if (cmd.includes("open cart") || cmd.includes("go to cart")) return navigateTo("cart.php");
  if (cmd.includes("open wishlist") || cmd.includes("go to wishlist")) return navigateTo("wishlist.php");
  if (cmd.includes("open profile")) return navigateTo("profile.php");
  if (cmd.includes("open orders")) return navigateTo("orders.php");

  // close viewer
  if (cmd.includes("close model") || cmd.includes("close viewer") || cmd.includes("close 3d")) {
    speak("Closing viewer");
    return closeModelView();
  }

  // 3D / AR open (phrases like "open sofa in 3d" or "open sofa in ar")
  if ((cmd.includes("open") && (cmd.includes("3d") || cmd.includes("ar"))) || cmd.includes("view in 3d") || cmd.includes("view in ar")) {
    // Extract product name: remove 'open', 'in 3d', 'in ar', 'view', 'show'
    let item = cmd.replace(/open|view|show/g, '').replace(/in 3d|in ar|3d|ar/g, '').trim();
    if (item) return openProductIn3D(item);
  }

  // Buy commands: "buy lipstick" or "buy lipstick now"
  if (cmd.startsWith("buy ") || cmd.startsWith("purchase ") || cmd.startsWith("i want to buy ")) {
    // remove leading words
    let item = cmd.replace(/^(buy|purchase|i want to buy)\s+/g, '').trim();
    if (item) return buyNow(item);
  }

  // Add to wishlist voice: "add ring to wishlist" or "wishlist ring"
  if (cmd.includes("wishlist") || cmd.includes("favorite") || cmd.includes("add to wishlist") || cmd.includes("add heart")) {
    // remove words
    let item = cmd.replace(/add|to|wishlist|favorite|heart|please/g, '').trim();
    if (!item) {
      // maybe user said "open wishlist"
      if (cmd.includes("open wishlist")) return navigateTo("wishlist.php");
      speak("Please say which product to add to wishlist.");
      return;
    }
    return addToWishlistByName(item);
  }

  // Add to cart: "add sofa to cart" or "add to cart sofa"
  if (cmd.includes("add") && cmd.includes("cart") || cmd.includes("add to cart")) {
    let item = cmd.replace(/add|to|cart|please/g, '').trim();
    if (item) return addToCart(item);
  }
  // Also allow "add [product]" (without 'to cart') to add to cart
  if (cmd.startsWith("add ")) {
    let item = cmd.replace(/^add\s+/g, '').trim();
    // if it's not a wishlist command
    if (!(item.includes("wishlist") || item.includes("favorite"))) return addToCart(item);
  }

  // Fallback: search/show product
  if (cmd.startsWith("show ") || cmd.startsWith("find ")) {
    let item = cmd.replace(/^(show|find)\s+/g, '').trim();
    return highlightProduct(item);
  }

  speak("Sorry, I didn't understand that command.");
}

// Helpers (some were defined earlier in other script block; ensure accessible)
function navigateTo(page) {
  speak("Opening " + page.replace(".php", ""));
  setTimeout(() => {
    window.location.href = page;
  }, 500); // small delay so speech starts but doesn't block navigation
}

function highlightProduct(name) {
  if(!name) { speak("Please say product name"); return; }
  const needle = name.toLowerCase();
  let found = false;
  document.querySelectorAll(".product-card").forEach(card => {
    if(card.innerText.toLowerCase().includes(needle)) {
      card.scrollIntoView({behavior:'smooth', block: 'center'});
      card.style.border = "2px solid var(--accent)";
      found = true;
      speak("Showing " + name);
      setTimeout(()=>card.style.border="", 3000);
    }
  });
  if(!found) speak("Couldn't find any product matching " + name);
}
function openProductIn3D(name) {
  if(!name) { speak("Please say product name"); return; }
  const needle = name.toLowerCase();
  let found = false;
  for (const p of products) {
    if (p.name.toLowerCase().includes(needle)) {
      openModelView(p.name, p.model);
      found = true;
      speak("Opening " + p.name + " in 3D viewer");
      break;
    }
  }
  if(!found) speak("No 3D model found for " + name);
}

// addToCart is defined in previous script tag but ensure accessible here (it is)

// addToWishlistByName defined in previous script tag

</script>

</body>
</html>
