<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Wishlist | Ariva India</title>
  <style>
    body {
      font-family: Inter, sans-serif;
      text-align: center;
      padding: 50px;
      background: #fafafa;
    }
    .item {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background: #fff;
      border-radius: 8px;
      padding: 10px;
      margin: 10px auto;
      width: 250px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <h1>❤️ Wishlist</h1>
  <p>Your favorite items will be listed here.</p>

  <!-- ✅ Add this container -->
  <div id="wishlistContainer"></div>

  <br>
  <a href="home.php" style="text-decoration:none;color:#000;background:#ffd600;padding:10px 16px;border-radius:6px;">⬅ Back to Shop</a>

  <script>
    const wishlist = JSON.parse(localStorage.getItem("wishlist") || "[]");
    const container = document.getElementById("wishlistContainer");

    if (wishlist.length > 0) {
      container.innerHTML = wishlist.map(p => `
        <div class="item">
          <img src="${p.image}" width="80">
          <div>${p.name} - ₹${p.price}</div>
        </div>
      `).join("");
    } else {
      container.innerHTML = "<p>Your wishlist is empty.</p>";
    }
  </script>
</body>
</html>
