<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">



  <title>HCC</title>
</head>

<body>
  <?php if (count($errors) > 0) : ?>

    <div class="error text-danger">

      <?php foreach ($errors as $error) : ?>

        <p class="alert alert-danger"><?php echo $error ?></p>

      <?php endforeach ?>

    </div>

  <?php endif ?>


</body>

</html>