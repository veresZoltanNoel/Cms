<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {

    $article = Article::getByID($conn, $_GET['id']);

    if (! $article){
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_FILES);
    if (empty($_FILES)) {
        throw new Exception('Invalid uplaod');
    }
    try {
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is too large (from the server settings)');
            default:
                throw new Exception('An error occured');
                break;
        }

        if ($_FILES['file']['size']>1000000) {
            throw new Exception('File is too large');
        }

        $mime_types = ['image/gif','image/png','image/jpeg','image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (! in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }


        $pathinfo = pathinfo($_FILES['file']['name']);
        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z-0-9 -]/','_',$base);
        $base = mb_substr($base, 0, 200);
        $filename = $base . "." . $pathinfo['extension'];
        $destination = "../uploads/$filename";

        $i = 1;
        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/$filename";
            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

            $previous_image = $article -> image_file;

            if ($article -> setImageFile($conn, $filename)) {

                if ($previous_image) {
                    unlink("../uploads/$previous_image");
                }

                Url::redirect("/admin/edit-article-image.php?id=$article->id");

            }
        } else {
            throw new Exception('Unable to move uploaded file');

        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    }

}
?>
<?php require '../includes/header.php'; ?>

<h2>Edit article image</h2>

<?php if($article->image_file): ?>
    <img src="/uploads/<?= $article->image_file;?>">
    <a class="delete" href="delete-article-image.php?id=<?=$article->id; ?>">Delete</a>
<?php endif;?>

<?php if(isset($error)): ?>
    <p><?=$error?></p>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <div>
        <label for="file">Image file</label>
        <input type="file" name="file" id="file">
    </div>
    <button>Upload</button>
</form>

<?php require '../includes/footer.php'; ?>
