<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cart | Ariva India</title>
<style>
body {
  font-family: Inter, sans-serif;
  background: #fafafa;
  text-align: center;
  padding: 40px;
}
a {
  text-decoration: none;
  color: #000;
  background: #ffd600;
  padding: 10px 16px;
  border-radius: 6px;
}
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
.item img { border-radius: 6px; }
button {
  background: #ff5252;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
}
button:hover {
  background: #e53935;
}
</style>
</head>
<body>

<h1>🛒 Your Cart</h1>
  
<p>Items added via voice or buttons will appear here.</p>

<div id="cartContainer"></div>

<br>
<a href="home.php">⬅ Back to Shop</a>

<script>
// ---- Load Cart ----
let cart = JSON.parse(localStorage.getItem("cart") || "[]");
const container = document.getElementById("cartContainer");

function displayCart() {
  if (cart.length > 0) {
    container.innerHTML = cart.map((p, i) => `
      <div class="item">
        <img src="${p.image}" width="80" height="80">
        <div>
          <div><strong>${p.name}</strong></div>
          <div>₹${p.price.toLocaleString()}</div>
        </div>
        <button onclick="removeItem(${i})">Remove</button>
      </div>
    `).join("");
  } else {
    container.innerHTML = "<p>Your cart is empty.</p>";
  }
}

// ---- Remove Function ----
function removeItem(index) {
  const removed = cart[index].name;
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  displayCart();
  speak(removed + " removed from cart");
}

// ---- Voice Support ----
function speak(text) {
  const msg = new SpeechSynthesisUtterance(text);
  window.speechSynthesis.speak(msg);
}

// ---- Voice Commands ----
if ("webkitSpeechRecognition" in window) {
  const recognition = new webkitSpeechRecognition();
  recognition.continuous = true;
  recognition.lang = "en-IN";

  recognition.onresult = function (event) {
    const command = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
    console.log("Voice command:", command);

    if (command.includes("remove")) {
      const itemName = command.replace("remove", "").replace("from cart", "").trim();
      removeByName(itemName);
    } else if (command.includes("go back") || command.includes("home")) {
      speak("Going back to home");
      setTimeout(() => { window.location.href = "home.php"; }, 500);
    }else if (command.includes("clear cart")) {
      clearCart();
    }
  };

  recognition.onerror = (event) => console.log("Recognition error:", event.error);
}

// Start when user clicks button
document.getElementById("startVoice").addEventListener("click", () => {
  if (recognition) {

  recognition.start();
}
  
});
// ---- Remove by name ----
function removeByName(name) {
  const index = cart.findIndex(p => p.name.toLowerCase().includes(name));
  if (index !== -1) {
    removeItem(index);
  } else {
    speak(name + " not found in cart");
  }
}

// ---- Display initial cart ----
displayCart();
</script>

</body>
</html>
