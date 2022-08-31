# 2022システム開発 前期最終課題
<h2>手順</h2>

<h3>1. Docker起動</h3>
<h3>2. テーブルの作成</h3>
```
CREATE TABLE `bbs_entries` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`body` TEXT NOT NULL,
`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
`image_filename` TEXT DEFAULT NULL
);
```
<br>
<h3>3. <a href="http://IP_ADDRESS/kadai.php">http://IP_ADDRESS/kadai.php</a></h3>

