<?php
include 'koneksi.php';
    $title= $_POST['title'];
    $date= $_POST['date'];
    $note= $_POST['note'];
    $result = mysqli_query($koneksi, "UPDATE dailyschedule SET title='$title', date='$date', note= '$note', 
    angkatan= '$angkatan' WHERE nim= '$nim'");
  header("Location: 6task_data.php")
?>