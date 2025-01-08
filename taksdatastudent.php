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
    <title>Task Data</title>
    <link rel="stylesheet" href="styles6.css">
    <style>
        body {
            font-family: Arial, sans-serif;
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
            margin-right: 8px;
        }
        

        button {
            background-color: #729bbd;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .status.in-progress {
            background-color: orange; 
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



            <table class="table table-striped table-bordered">
              <thead> 
                <tr> 
                  <th scope="col">NO</th> 
                  <th scope="col">Schedule Title</th> 
                  <th scope="col">Date</th> 
                  <th scope="col">Status</th> 
                  <th scope="col">Note</th> 
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
                    </tr> 
                  <?php 
                  } 
                  ?> 
              </tbody> 
            </table>
        </div> 
    </div>
    <script>
        const status1 = document.getElementById('status1');

        status1.addEventListener('click', () => {
            status1.textContent = "Done";
            status1.style.backgroundColor = "lightgreen"; 
        });
    </script>
    <!-- ini ganti profile -->
    <script>
      const previewImg = document.getElementById('previewImg');
const profileImage = document.getElementById('profileImage');

profileImage.addEventListener('change', () => {
    const file = profileImage.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
    </script>
</body>
</html>