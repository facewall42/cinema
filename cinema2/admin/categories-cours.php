<?php

// VERSION DU PROF OU DE MAMADOU ON SAIT PAS TROP ------------------------------------------------------

require_once '../inc/functions.inc.php';

function updateCategory(int $id, string $name, string $description) :void {
    $cnx = dbConnect();
    $sql = "UPDATE categories  SET name = :name, description = :description WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,
        ':name' => $name,
        ':description' => $description
    ));
  }

  function showCategoryViaId(int $id) :mixed{
    $cnx = dbConnect();
    $sql = "SELECT * FROM categories WHERE id_category = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id" => $id
    ));
    $result = $request->fetch();
    return $result;
  }
  
$info = '';

if (!isset($_SESSION['user'])) {
  header('location: auth.php');
  exit;
} else {
  if ($_SESSION['user']['role'] == 'user') {
    header('location: profile.php');
  }
}

// Suppression et mofification d'une catégorie

if (isset($_GET) && isset($_GET['action']) &&  isset($_GET['id_category']) && !empty($_GET['action']) && !empty($_GET['id_category'])) {


  $idCategory = htmlentities($_GET['id_category']);


  if (is_numeric($idCategory)) {

    $categorie = showCategoryViaId($idCategory);

    if ($categorie) {


      // if ($_GET['action'] == 'delete') {

      //     deleteCategory($idCategory);

      // }
      if ($_GET['action'] != 'update') {

        header('location:categories.php');
      }
    } else {

      header('location:categories.php');
    }
  } else {

    header('location:categories.php');
  }
}

if (!empty($_POST)) {
  $check = true;
  foreach ($_POST as $key => $value) {
    if (empty($value)) {
      $check = false;
    }
  }
  if ($check == false) {
    $info .= alert("Please fill in all fields!", "danger");
  } else {
    if (!isset($_POST['name']) || strlen(trim($_POST['name'])) < 3 || preg_match('/[0-9]/', $_POST['name'])) {
      $info .= alert('The category field is invalid!', 'danger');
    }

    if (!isset($_POST['description']) || strlen(trim($_POST['description'])) < 20) {
      $info .= alert('The description field is invalid!', 'danger');
    } elseif ($info == '') {

      $name = htmlspecialchars(trim($_POST['name']));

      $description = htmlspecialchars(trim($_POST['description']));

      $dbCategory = categoryExist($name);

      if ($dbCategory) {
        $info .= alert('Category already exists', 'danger');
      } else {

        // if (isset($_GET) && $_GET['action'] == 'update' &&  !empty($_GET['id_category'])) {
        if ($categorie) {


          $id_category = htmlentities($_GET['id_category']);
          updateCategory($id_category, $name, $description);
          header('location: categories.php');
          exit;
        } else {
          addCategory($name, $description);
          $info .= alert('Category added successfully', 'success');
          header('location: categories.php');
          exit;
        }
      }
    }
  }
}

$categories = getAllCategories();

require_once '../inc/header.inc.php';
?>

<div class="row mt-2">
  <div class="col-sm-12 col-md-6 mt-5">
    <h2 class="text-center fw-bolder mb-5 text-danger">Categories Management</h2>
    <?= $info; ?>
    <form action="" method="post" class="back">

      <div class="row">
        <div class="col-md-8 mb-5">
          <label for="name" class="form-label text-white">Category name</label>

          <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($categorie['name'] ?? '') ?>">

        </div>
        <div class="col-md-12 mb-5">
          <label for="description" class="form-label text-white"">Description</label>
          <textarea id=" description" name="description" class="form-control" rows="10"><?= isset($categorie) ? $categorie['description'] : '' ?> </textarea>
        </div>

      </div>
      <div class="row justify-content-center">
        <button type="submit" class="btn btn-danger p-3 fs-6 fw-bold"><?= isset($categorie) ? 'Modifier une catégorie' : ' Ajouter une catégorie' ?></button>
      </div>
    </form>
  </div>
<?php //debug($categorie); ?>
  <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">
    <h2 class="text-center fw-bolder mb-5 text-danger">Categories list</h2>
    <table class="table table-dark table-bordered mt-5 ">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Delete</th>
          <th>Modify</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category) {
          // var_dump($category);

        ?>
          <tr>
            <td><?= $category['id_category']; ?></td>
            <td><?= $category['name']; ?></td>
            <td><?= $category['description']; ?></td>

            <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
            <td class="text-center"><a href="?action=update&id_category=<?= $category['id_category'] ?>"><i class="bi bi-pen-fill"></i></a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php require_once '../inc/footer.inc.php'; ?>