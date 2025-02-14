<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$role = $_SESSION['role'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <title>Task Data</title>
  <link rel="stylesheet" href="styles_6.css">
  <style>
    body {
            font-family: Arial, sans-serif;
            width: 100vw;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 20%;
            background-color: #f4f4f4;
            padding: 20px;
        }

    .main-content {
      flex: 1;
      padding: 20px;
      position: relative;
    }

    .main-content h1 {
      font-size: 1.8em;
      color: black;
      display: flex;
      align-items: center;
    }

    .main-content h1::before {
      content: "";
      margin-right: 2px;
    }

    .content {
      margin-left: 20%;
      /* Offset the content to make space for the sidebar */
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
  <aside class="sidebar">
            <div class="profile">
                <div class="avatar"></div>
                <p class="navbar-brand text-white" href="#">WELCOME <?php echo strtoupper(string: $_SESSION['username']); ?></p>
            </div>
            <nav class="menu">
                <button onclick="location.href='dashboard.php'">Dashboard</button>

                <?php if($role === "dosen"): ?> 
                    <button onclick="location.href='taksdatadosen.php'">Create Task</button>
                <?php endif;?>

                <?php if($role === "mahasiswa"): ?>
                    <button onclick="location.href='taksdatastudent.php'">Task Data</button>
                    <button onclick="location.href='notifications.php'">Notifications</button>    
                <?php endif; ?> 
                
                
                <button onclick="location.href='history.php'">History</button>
            </nav>
        </aside>


    <div class="main-content">
      <h1>Task Data In Progress</h1>
      <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
        <i class="fas fa-plus-circle me-2"></i>Add Schedule
      </button>

      <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">NO</th>
        <th scope="col">Schedule Title</th>
        <th scope="col">Date</th>
        <th scope="col">Status</th>
        <th scope="col">Note</th>
        <th scope="col">Action</th>
      </tr>

    </thead>
    <tbody>
      <?php 
                include 'koneksi.php'; 
                $query = mysqli_query($koneksi, "SELECT * FROM task"); 
                $no = 1; 
                while ($data = mysqli_fetch_assoc($query)) { 
                    ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $data['title']; ?></td>
        <td><?php echo $data['datee']; ?></td>
        <td><?php echo $data['statuss']; ?><button id="status1" class="status in-progress">In Progress</button></td>
        <td><?php echo $data['note']; ?></td>
        <td>
          <div class="button-group">
            <button class="btn btn-success btn-sm me-1 edit-button" data-bs-toggle="modal"
              data-bs-target="#editDataModal" data-title="<?php echo $data['title']; ?>"
              data-datee="<?php echo $data['datee']; ?>" data-note="<?php echo $data['note']; ?>">
              <i class="fas fa-edit">Edit</i>
            </button>
            <a href="hapus_task.php?title=<?php echo $data['title']; ?>" class="btn btn-danger btn-sm">
              <i class="fas fa-trash-alt"></i>Delete</a>
            </div>
        </td>
      </tr>
      <?php 
                  } 
                  ?>
    </tbody>
  </table>

    </div>
  </div>

  <!-- Modal tambah data -->

  <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDataLabel">Add Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="tambah_task.php" method="POST">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
              <label for="datee" class="form-label">Date and Time</label>
              <input type="datetime-local" class="form-control" id="datee" name="datee" required>
            </div>

            <div class="mb-3">
              <label for="note" class="form-label">Note</label>
              <input type="text" class="form-control" id="note" name="note" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" ariahidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDataLabel">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="ubah_task.php" method="POST">
            <div class="mb-3">
              <label for="edit-title" class="form-label">Title</label>
              <input type="text" class="form-control" id="edit-title" name="title" required>
            </div>
            <div class="mb-3">
               <label for="edit-datee" class="form-label">Date and Time</label>
               <input type="datetime-local" class="form-control" id="edit-datee" name="datee" required>
            </div>

            <div class="mb-3">
              <label for="edit-note" class="form-label">Note</label>
              <input type="text" class="form-control" id="edit-note" name="note" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const editButtons = document.querySelectorALL('.edit-button');
      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          const title = this.getAttribute('data-title');
          const datee = this.getAttribute('data-datee');
          const note = this.getAttribute('data-note');

          document.getElementById('edit-title').value = title;
          document.getElementById('edit-datee').value = datee;
          document.getElementById('edit-note').value = note;
        });
      });
    });
  </script>
  <!-- ini button status -->
  <script>
    const status1 = document.getElementById('status1');

    status1.addEventListener('click', () => {
      status1.textContent = "Done";
      status1.style.backgroundColor = "lightgreen";
    });
  </script>
</body>

</html>