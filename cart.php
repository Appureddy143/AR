<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cart | Ariva India</title>
<style>
body { font-family:Inter, sans-serif; background:#fafafa; text-align:center; padding:50px; }
a { text-decoration:none; color:#000; background:#ffd600; padding:10px 16px; border-radius:6px; }
</style>
</head>
<body>
<h1>🛒 Your Cart</h1>
<p>Items added via voice or buttons will appear here.</p>
<a href="home.php">⬅ Back to Shop</a>
</body>
  <script>
const cart = JSON.parse(localStorage.getItem("cart") || "[]");
const wishlist = JSON.parse(localStorage.getItem("wishlist") || "[]");

const container = document.getElementById("cartContainer"); // or wishlistContainer
if (container && cart.length > 0) {
  container.innerHTML = cart.map(p => `
    <div class="item">
      <img src="${p.image}" width="80">
      <div>${p.name} - ₹${p.price}</div>
    </div>
  `).join("");
} else if (container) {
  container.innerHTML = "<p>Your cart is empty.</p>";
}
</script>

</html>
