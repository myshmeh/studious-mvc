<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Home</title>
</head>
<body>
  <h1>Welcome</h1>
  <p>called from Controllers/Home.php!</p>
  <p>Name:
  <?php echo htmlspecialchars($name); ?>
  </p>
  <ul>
    <?php foreach($coulours as $coulour){ ?>
      <li><?php echo htmlspecialchars($coulour); ?></li>
    <?php }?>
  </ul>
</body>
</html>
