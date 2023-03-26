<?php
$start = microtime(true);
$dbh = new PDO('mysql:host=localhost;dbname=test2', 'root', 'root');
$sth = $dbh->prepare("SELECT * FROM categories");
$sth->execute();
$result_query = $sth->fetchAll();

$categories_result = [];

foreach ($result_query as $category) {
    if ($category['parent_id'] == 0) {
        $categories_result[$category['categories_id']] = $category['categories_id'];
    } else {
        $parent_id = $category['parent_id'];
        if (isset($categories_result[$parent_id])) {
            if (is_array($categories_result[$parent_id])) {
                $categories_result[$parent_id][] = $category['categories_id'];
            } else {
                $categories_result[$parent_id] = [$categories_result[$parent_id], $category['categories_id']];
            }
        }
    }
}

print_r('<pre>');
print_r($categories_result);

echo 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.';
