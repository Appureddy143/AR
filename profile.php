<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile | Ariva India</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
:root {
  --accent: #ffd600;
  --dark: #111;
  --bg: #fafafa;
  --card: #fff;
  --shadow: 0 6px 18px rgba(0,0,0,0.06);
}
body {
  font-family: Inter, sans-serif;
  background: var(--bg);
  color: #222;
  margin: 0;
}
.container {
  max-width: 500px;
  background: var(--card);
  margin: 60px auto;
  padding: 30px;
  border-radius: 12px;
  box-shadow: var(--shadow);
  text-align: center;
}
h1 {
  color: var(--dark);
  margin-bottom: 20px;
}
label {
  display: block;
  text-align: left;
  margin-top: 15px;
  font-weight: 600;
}
input, textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 15px;
  margin-top: 6px;
}
button {
  background: var(--accent);
  border: none;
  color: #000;
  padding: 10px 16px;
  font-size: 15px;
  border-radius: 6px;
  margin-top: 20px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.2s;
}
button:hover { background: #ffe44d; }

.mic-btn {
  background: crimson;
  color: white;
  border: none;
  padding: 10px 14px;
  border-radius: 50%;
  font-size: 22px;
  cursor: pointer;
  position: fixed;
  bottom: 20px;
  right: 20px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  transition: transform 0.2s ease;
}
.mic-btn:hover { transform: scale(1.1); }
.back-link {
  display: inline-block;
  text-decoration: none;
  color: #000;
  background: #ffd600;
  padding: 10px 16px;
  border-radius: 6px;
  margin-top: 25px;
}
</style>
</head>

<body>
<div class="container">
  <h1>👤 Profile</h1>

  <label for="name">Full Name</label>
  <input type="text" id="name" placeholder="Your name here">

  <label for="phone">Phone Number</label>
  <input type="tel" id="phone" placeholder="Your phone number">

  <label for="address">Address</label>
  <textarea id="address" rows="3" placeholder="Your address"></textarea>

  <button id="saveBtn">💾 Save</button>
  <button id="editBtn">✏️ Edit</button>

  <br>
  <a href="home.php" class="back-link">⬅ Back to Shop</a>
</div>

<!-- 🎤 Mic for voice input -->
<button id="micBtn" class="mic-btn" title="Voice Command">🎤</button>

<script>
// Voice recognition setup
let recognizing = false;
let recognition;
const micBtn = document.getElementById('micBtn');
const nameInput = document.getElementById('name');
const phoneInput = document.getElementById('phone');
const addressInput = document.getElementById('address');
const saveBtn = document.getElementById('saveBtn');
const editBtn = document.getElementById('editBtn');

let profileData = { name: "", phone: "", address: "" };

// Initialize recognition
function setupSpeech() {
  if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    recognition = new SpeechRecognition();
    recognition.lang = 'en-IN';
    recognition.continuous = false;
    recognition.interimResults = false;

    recognition.onstart = () => {
      recognizing = true;
      micBtn.style.background = "green";
    };
    recognition.onend = () => {
      recognizing = false;
      micBtn.style.background = "crimson";
    };
    recognition.onresult = (event) => {
      const cmd = event.results[0][0].transcript.toLowerCase().trim();
      console.log("🎤 Voice Input:", cmd);
      handleVoiceCommand(cmd);
    };

    micBtn.onclick = () => recognizing ? recognition.stop() : recognition.start();
  } else {
    alert("Voice recognition not supported in this browser");
  }
}
setupSpeech();

function speak(text) {
  const synth = window.speechSynthesis;
  if (synth) {
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = "en-IN";
    synth.speak(utter);
  }
}

// Handle Voice Commands
function handleVoiceCommand(cmd) {
  if (cmd.includes("name is") || cmd.startsWith("my name")) {
    const name = cmd.replace(/my name is|name is|name/g, '').trim();
    if (name) {
      nameInput.value = capitalize(name);
      speak("Name saved as " + name);
    }
  } 
  else if (cmd.includes("phone") || cmd.includes("number")) {
    const num = cmd.replace(/my|phone|number|is/g, '').replace(/\s+/g, '').trim();
    if (num) {
      phoneInput.value = num;
      speak("Phone number saved");
    }
  }
  else if (cmd.includes("address")) {
    const addr = cmd.replace(/my|address|is/g, '').trim();
    if (addr) {
      addressInput.value = capitalize(addr);
      speak("Address saved");
    }
  }
  else if (cmd.includes("save profile") || cmd.includes("save details") || cmd.includes("save")) {
    saveProfile();
  }
  else if (cmd.includes("edit profile") || cmd.includes("edit details") || cmd.includes("edit")) {
    enableEditing();
  }
  else {
    speak("Command not understood. You can say for example 'my name is Divya' or 'save profile'.");
  }
}

function saveProfile() {
  profileData.name = nameInput.value.trim();
  profileData.phone = phoneInput.value.trim();
  profileData.address = addressInput.value.trim();
  localStorage.setItem("profileData", JSON.stringify(profileData));
  disableEditing();
  speak("Profile saved successfully");
}

function enableEditing() {
  nameInput.disabled = false;
  phoneInput.disabled = false;
  addressInput.disabled = false;
  speak("Editing enabled");
}

function disableEditing() {
  nameInput.disabled = true;
  phoneInput.disabled = true;
  addressInput.disabled = true;
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Save button click
saveBtn.onclick = saveProfile;
editBtn.onclick = enableEditing;

// Load saved data
window.onload = () => {
  const data = localStorage.getItem("profileData");
  if (data) {
    profileData = JSON.parse(data);
    nameInput.value = profileData.name;
    phoneInput.value = profileData.phone;
    addressInput.value = profileData.address;
    disableEditing();
  }
};
</script>
</body>
</html>
