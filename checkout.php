<?php
// checkout.php
$product = isset($_GET['product']) ? htmlspecialchars($_GET['product']) : "Unknown Product";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout | Ariva India</title>

<style>
:root {
  --accent:#ffd600;
  --dark:#111;
  --bg:#fafafa;
  --card:#fff;
  --shadow:0 6px 18px rgba(0,0,0,0.06);
  --text:#222;
}
body {
  margin:0;
  font-family: Inter, system-ui, sans-serif;
  background:var(--bg);
  color:var(--text);
}
.checkout-container {
  max-width:500px;
  margin:50px auto;
  background:var(--card);
  padding:30px;
  border-radius:12px;
  box-shadow:var(--shadow);
}
h2 {
  text-align:center;
  margin-bottom:10px;
}
.product-info {
  background:#f7f7f7;
  padding:12px;
  border-radius:8px;
  margin-bottom:20px;
  text-align:center;
  font-weight:600;
}
.payment-options {
  display:flex;
  flex-direction:column;
  gap:12px;
}
.payment-options label {
  display:flex;
  align-items:center;
  gap:10px;
  background:#fff;
  padding:10px;
  border:2px solid #ddd;
  border-radius:8px;
  cursor:pointer;
  transition:0.2s;
}
.payment-options input[type="radio"] {
  transform:scale(1.2);
}
.payment-options label:hover {
  border-color:var(--accent);
  background:#fff9d9;
}
.btn {
  width:100%;
  border:none;
  background:var(--accent);
  color:#000;
  padding:12px;
  border-radius:8px;
  font-weight:600;
  cursor:pointer;
  font-size:16px;
  margin-top:16px;
}
.btn:hover {
  background:#ffe44d;
}
.success {
  display:none;
  text-align:center;
  margin-top:20px;
  font-size:18px;
  color:green;
  font-weight:600;
}
.voice-btn {
  display:block;
  margin:25px auto 0;
  background:#111;
  color:#fff;
  border:none;
  border-radius:50%;
  width:60px;
  height:60px;
  font-size:24px;
  cursor:pointer;
  transition:0.3s;
}
.voice-btn.listening {
  background:red;
  animation:pulse 1.2s infinite;
}
@keyframes pulse {
  0% {box-shadow:0 0 0 0 rgba(255,0,0,0.5);}
  70% {box-shadow:0 0 0 15px rgba(255,0,0,0);}
  100% {box-shadow:0 0 0 0 rgba(255,0,0,0);}
}
</style>
</head>
<body>

<div class="checkout-container">
  <h2>Checkout</h2>
  <div class="product-info">You are buying: <br> <span style="color:var(--accent);"><?= $product ?></span></div>

  <h3>Select Payment Method</h3>
  <div class="payment-options">
    <label><input type="radio" name="payment" value="Cash"> 💵 Cash on Delivery</label>
    <label><input type="radio" name="payment" value="UPI"> 📱 UPI Payment</label>
    <label><input type="radio" name="payment" value="Card"> 💳 Credit / Debit Card</label>
  </div>

  <button class="btn" onclick="confirmPayment()">Confirm Payment</button>
  <div class="success" id="successMsg">✅ Payment Successful! Thank you for shopping with Ariva India.</div>

  <!-- 🎤 Voice Button -->
  <button class="voice-btn" id="voiceBtn" title="Voice Command">🎤</button>
</div>

<script>
// ---------- SPEECH SYNTHESIS ----------
function speak(text) {
  const synth = window.speechSynthesis;
  if (synth) {
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = 'en-IN';
    synth.speak(utter);
  } else {
    alert(text);
  }
}

// ---------- CONFIRM PAYMENT ----------
function confirmPayment() {
  const method = document.querySelector('input[name="payment"]:checked');
  if(!method){
    speak("Please select a payment method");
    alert("Please select a payment method.");
    return;
  }
  const paymentType = method.value;
  speak(`You selected ${paymentType} payment. Payment successful.`);
  document.getElementById("successMsg").style.display = "block";
  setTimeout(() => {
    window.location.href = "index.php";
  }, 4000);
}

// ---------- VOICE RECOGNITION ----------
const voiceBtn = document.getElementById("voiceBtn");
let recognition;

if ('webkitSpeechRecognition' in window) {
  recognition = new webkitSpeechRecognition();
  recognition.lang = 'en-IN';
  recognition.continuous = false;
  recognition.interimResults = false;

  recognition.onresult = function(e) {
    const command = e.results[0][0].transcript.toLowerCase();
    handleVoiceCommand(command);
  };

  recognition.onend = () => {
    voiceBtn.classList.remove("listening");
  };
}

voiceBtn.onclick = () => {
  if (!recognition) {
    alert("Voice recognition not supported in this browser");
    return;
  }
  voiceBtn.classList.add("listening");
  speak("Listening for your command");
  recognition.start();
};

// ---------- COMMAND HANDLER ----------
function handleVoiceCommand(cmd) {
  console.log("Voice command:", cmd);
  
  if (cmd.includes("cash")) {
    document.querySelector('input[value="Cash"]').checked = true;
    speak("Cash on delivery selected");
    return;
  }

  if (cmd.includes("upi")) {
    document.querySelector('input[value="UPI"]').checked = true;
    speak("UPI payment selected");
    return;
  }

  if (cmd.includes("card") || cmd.includes("credit") || cmd.includes("debit")) {
    document.querySelector('input[value="Card"]').checked = true;
    speak("Card payment selected");
    return;
  }

  if (cmd.includes("confirm") || cmd.includes("pay now") || cmd.includes("make payment")) {
    confirmPayment();
    return;
  }

  if (cmd.includes("go back") || cmd.includes("home")) {
    speak("Returning to home page");
    window.location.href = "index.php";
    return;
  }

  speak("Sorry, I did not understand your command.");
}
</script>

</body>
</html>
