<?php

  $data = file_get_contents(__DIR__ . '/contacts.json');
  $contacts = json_decode($data, true);

  //var_dump($contacts); exit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contacts</title>
</head>
<body>
  <table>
    <tr>
      <td>Имя</td>
      <td>Фамилия</td>
      <td>Адрес</td>
      <td>Телефон</td>
    </tr>
    <?php foreach ($contacts as $contact) { ?>
      <tr>
        <td><?php echo $contact['firstName']; ?></td>
        <td><?php echo $contact['lastName']; ?></td>
        <td><?php echo $contact['address']; ?></td>
        <td><?php echo $contact['phoneNumber']; ?></td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>