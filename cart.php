<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cart | Ariva India</title>
<style>
body { font-family:Inter, sans-serif; background:#fafafa; text-align:center; padding:50px; }
a { text-decoration:none; color:#000; background:#ffd600; padding:10px 16px; border-radius:6px; }
.item {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
  background: #fff;
  padding: 12px;
  margin: 10px auto;
  max-width: 400px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.item img {
  border-radius: 6px;
}
</style>
</head>
<body>

<h1>🛒 Your Cart</h1>
<p>Items added via voice or buttons will appear here.</p>

<!-- This container must exist -->
<div id="cartContainer"></div>

<br>
<a href="index.php">⬅ Back to Shop</a>

<script>
// Load cart from localStorage
const cart = JSON.parse(localStorage.getItem("cart") || "[]");
const container = document.getElementById("cartContainer");

// Display items if available
if (cart.length > 0) {
  container.innerHTML = cart.map(p => `
    <div class="item">
      <img src="${p.image}" width="80" height="80">
      <div>
        <div><strong>${p.name}</strong></div>
        <div>₹${p.price.toLocaleString()}</div>
      </div>
    </div>
  `).join("");
} else {
  container.innerHTML = "<p>Your cart is empty.</p>";
}
</script>

</body>
</html>
