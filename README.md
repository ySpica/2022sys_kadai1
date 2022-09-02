# 2022システム開発 前期最終課題
1. Docker起動<br>
```
docker compose build
docker compose up
```
2. テーブルの作成<br>
```
CREATE TABLE `bbs_entries` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `body` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `image_filename` TEXT DEFAULT NULL
);
```

3. <a href="http://18.212.98.243/kadai.php">http://18.212.98.243/kadai.php</a>
