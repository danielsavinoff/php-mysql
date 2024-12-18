<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./assets/styles.css" />
  <title>Document</title>
</head>
<body>
  <?php
    include_once __DIR__ . '/db/db.php';
    
    $columns = $product->getAllColumns()->fetchAll();
    $data = $product->getAll(10)->fetchAll();
    $total = $product->getCount()->fetchColumn();
    $listed = count($data);
  ?>
  <? if (is_array($columns)): ?>
    <div class="table-box">
      <table>
        <thead>
          <tr>
            <?php foreach($columns as $column){
              echo '<th>' . $column['Field'] . '</th>';
            }?>
          </tr>
        </thead>
        <tbody>
          <? if (is_array($data)): ?>
            <? foreach($data as $row): ?>
              <tr>
                <? $len = count($row) / 2 ?>
                <? for ($i = 0; $i < $len; $i++): ?>
                  <td><?= $row[$i] ?></td>
                <? endfor ?>
              </tr>
            <? endforeach ?>
          <? else: ?>
            <tr><td>No data was found.</td></tr>
          <? endif ?>
        </tbody>
      </table>  
    <? else: ?>
      The table has no columns.
    <? endif ?>
  </div>
  <p><?= $listed . ' out of ' . $total ?></p>
</body>
</html>