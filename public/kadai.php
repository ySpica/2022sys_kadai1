<?php // kadai.php
$dbh = new PDO('mysql:host=mysql;dbname=techc', 'root', '');

if (isset($_POST['body'])) {

  $image_filename = null;
  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
    if (preg_match('/^image\//', $_FILES['image']['type']) !== 1) {
      header("HTTP/1.1 302 Found");
      header("Location: ./kadai.php");
    }

    $pathinfo = pathinfo($_FILES['image']['name']);
    $extension = $pathinfo['extension'];
    $image_filename = strval(time()) . bin2hex(random_bytes(25)) . '.' . $extension;
    $filepath =  '/var/www/upload/image/' . $image_filename;
    move_uploaded_file($_FILES['image']['tmp_name'], $filepath);
  }

  $insert_sth = $dbh->prepare("INSERT INTO bbs_entries (body, image_filename) VALUES (:body, :image_filename)");
  $insert_sth->execute([
    ':body' => $_POST['body'],
    ':image_filename' => $image_filename,
  ]);

  header("HTTP/1.1 302 Found");
  header("Location: ./kadai.php");
  return;
}

$select_sth = $dbh->prepare('SELECT * FROM bbs_entries ORDER BY created_at DESC');
$select_sth->execute();
?>

<link rel="stylesheet" href="./css/style.css">
<h2>Web掲示板サービス</h2>
<form method="POST" action="./kadai.php" enctype="multipart/form-data">
  テキスト: <textarea name="body"></textarea>
  <div style="margin: 1em 0;">
    画像ファイル: <input type="file" id="media_file" name="image" accept="image/*" capture="camera" class="form-control-file">
  </div>
  <button type="submit">送信</button>
</form>
<hr>

<!-- script -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-image-upload-resizer.js"></script>
<script>
    $('#media_file').imageUploadResizer({
        max_width: 800, // Defaults 1000
        max_height: 600, // Defaults 1000
        quality: 0.8, // Defaults 1
        do_not_resize: ['gif', 'svg'], // Defaults []
    });
</script>

<?php foreach($select_sth as $entry): ?>
  <dl style="margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #ccc;">
    <dt>番号</dt>
    <dd><?= $entry['id'] ?></dd>
    <dt>投稿日時</dt>
    <dd><?= $entry['created_at'] ?></dd>
    <dt>テキスト</dt>
    <dd>
      <?= nl2br(htmlspecialchars($entry['body'])) ?>
      <?php if(!empty($entry['image_filename'])): ?>
      <div>
        <img src="/image/<?= $entry['image_filename'] ?>" style="max-height: 10em;">
      </div>
      <?php endif; ?>
    </dd>
  </dl>
<?php endforeach ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const image = document.getElementById("image");
  image.addEventListener("change", () => {
    if (image.files.length < 1) {
      // no selected file
      return;
    }
    if (image.files[0].size > 5 * 1024 * 1024) {
      // above 5MB
      alert("5MB以下のファイルを選択してください。");
      image.value = "";
    }
  });
});
</script>
