<?php
// admin.php - Upload new products

$imgDir = __DIR__ . '/uploads/images/';
$modelDir = __DIR__ . '/uploads/models/';
if (!is_dir($imgDir)) mkdir($imgDir, 0777, true);
if (!is_dir($modelDir)) mkdir($modelDir, 0777, true);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];

    // Upload image
    $imgPath = '';
    if (!empty($_FILES['image']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        $target = $imgDir . $imgName;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $imgPath = 'uploads/images/' . $imgName;
    }

    // Upload model
    $modelPath = '';
    if (!empty($_FILES['model']['name'])) {
        $modelName = time() . '_' . basename($_FILES['model']['name']);
        $target = $modelDir . $modelName;
        move_uploaded_file($_FILES['model']['tmp_name'], $target);
        $modelPath = 'uploads/models/' . $modelName;
    }

    // Save product to JSON
    $file = __DIR__ . '/products.json';
    $products = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $products[] = ['name'=>$name,'price'=>$price,'image'=>$imgPath,'model'=>$modelPath];
    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
    $msg = "✅ Product '{$name}' uploaded successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Ariva Product Upload</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f4f4f4;
  margin: 0;
}
.container {
  max-width: 600px;
  margin: 60px auto;
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}
h2 { text-align: center; color: #111; }
label { display:block; font-weight:600; margin-top:10px; }
input, button {
  width:100%;
  padding:10px;
  border-radius:6px;
  border:1px solid #ccc;
  margin-top:6px;
}
button {
  background:#ffd600;
  border:none;
  color:#111;
  font-weight:700;
  cursor:pointer;
}
button:hover { background:#ffe44d; }
.msg { text-align:center; color:green; font-weight:bold; margin-bottom:10px; }
a.back { text-decoration:none; display:block; text-align:center; margin-top:12px; color:#333; }
</style>
</head>
<body>
<div class="container">
  <h2>Upload New Product</h2>
  <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>

  <form method="post" enctype="multipart/form-data">
    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Price (₹)</label>
    <input type="number" name="price" step="0.01" required>

    <label>Product Image (.jpg, .png)</label>
    <input type="file" name="image" accept="image/*" required>

    <label>3D Model (.glb, .gltf)</label>
    <input type="file" name="model" accept=".glb,.gltf" required>

    <button type="submit">Upload Product</button>
  </form>

  <a class="back" href="index.php">← Back to Store</a>
</div>
</body>
</html>
