<?php
//INSERT INTO `notes` (`sno`, `title`, `des`, `tstamp`) VALUES (NULL, 'i want be an IAS officer', 'its my dream', current_timestamp());
//connect to the Database
$insert = false;
$delete = false;
$update = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername , $username , $password , $database);
if(!$conn)
{
  die("sorry we failed to connect -->".mysqli_querry_error());
}

if(isset($_GET['delete']))
{
  $sno = $_GET['delete'];
  //echo $sno;
  $delete = true;
  $sql = "Delete FROM `notes` WHERE `sno`= $sno";
  $result = mysqli_query($conn , $sql);
}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
  
    if(isset($_POST['snoEdit']))
    {
      //update the record
      $sno = $_POST['snoEdit'];
      $title = $_POST["titleEdit"];
      $des = $_POST["desEdit"];
    
      $sql = "UPDATE `notes` SET `title` = '$title' , `des` = '$des'  WHERE `notes`.`sno` = $sno";
      $result = mysqli_query($conn , $sql);
      if($result)
      {
        //echo "we updated the record";
        $update = true;
      }
      else
      echo "we could not update the record successfullly";
    }
    else
    {
      $title = $_POST["title"];
      $des = $_POST["des"];
    
      $sql = "INSERT INTO `notes` (`title`, `des`) VALUES ('$title', '$des')";
      $result = mysqli_query($conn , $sql);
      if($result)
      {
        $insert = true;
      }
      else
      {
        echo "The record was not inserted successfully because  of this error -->". mysqli_error($conn);
      }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!---->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" 
    crossorigin="anonymous">

   

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" class="cs">
   

<title>iNotes  -  Notes taking made easy</title>

  </head>
  <body>
  <!-- Edit modal -->
<!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal">Edit Notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action = "/CRUD/index.php" method = "POST">
      <div class="modal-body">
       <input type = "hidden" name = "snoEdit" id = "snoEdit">
          <div class="form-group">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" name = "titleEdit" class="form-control" id="titleEdit"  aria-describedby="emailHelp">
            
          </div>
          <br>
          <div class="form-group">
            <label for = "des" class ="form-label">Note Description</label>
            <textarea class = "form-control" name = "desEdit"  id="desEdit"    row = "3">
            </textarea>
          </div>
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src = "/CRUD/php.PNG" height = "40px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
              
                
              
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

       <?php
       if($insert)
       {
       include 'rohit.php';
       }
       ?>  

       <?php
       if($delete)
       {
       include 'rohit.php';
       }
       ?>  

      <?php
       if($update)
       {
       include 'rohit.php';
       }
       ?> 
      
      <div class="container my-5 ">
        <h2>Add a Note to iNotes</h2>
        <form action = "/CRUD/index.php" method = "POST">
          <div class="form-group">
            <label for="title" class="form-label"><Title></Title></label>
            <input type="text" name = "title" class="form-control" id="title" aria-describedby="emailHelp">
            
          </div>
          <br>
          <div class="form-group">
            <label for = "des" class ="form-label">Note Description</label>
            <textarea class = "form-control" name = "des"  id="des"  row = "10">
            </textarea>
          </div>
         <br>
         <button type="submit" class="btn btn-primary">Add Note</button>
       </form>
        </div>

        <div class="container my-4">
<table class="table" id="myTable">

  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
              $sql = "SELECT * FROM `notes`";
              $result = mysqli_query($conn, $sql);
              $sno=0;
              while($row = mysqli_fetch_assoc($result))
              {
                $sno = $sno+1;
                echo "<tr>
                <th scope='row'>". $sno ."</th>
                <td>". $row['title'] ."</td>
                <td>". $row['des'] ."</td>
                <td><button class = 'edit btn btn-sm btn-primary' id = ".$row['sno'].">Edit</button>
                <button class = 'delete btn btn-sm btn-primary' id = d".$row['sno'].">Delete</button></td>
              </tr>";
              } 
          ?>
  </tbody>
</table>
        </div>
    <hr>
        

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
       integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
       crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" 
    integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" 
    crossorigin="anonymous"></script>


   <link  href ="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity = "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
    crossorigin = "anonymous">

   <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    
    <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
      } );
    </script> 
     <script>
edits = document.getElementsByClassName('edit');
Array.from(edits).forEach(element => {
  element.addEventListener("click",(e)=>{
    console.log("edit", );
    tr = e.target.parentNode.parentNode;
    title = tr.getElementsByTagName("td")[0].innerText;
    des = tr.getElementsByTagName("td")[1].innerText;
    console.log(title , des);
    titleEdit.value = title;
    desEdit.value = des;
    snoEdit.value = e.target.id;
    console.log(e.target.id);
    $('#editModal').modal('toggle');
  })
})

deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach(element => {
  element.addEventListener("click",(e)=>{
    console.log("edit", );
    sno = e.target.id.substr(1,);
    if(confirm("Are you sure you want to delete this note!k"))
    {
      console.log("yes");
      window.location = `/CRUD/index.php?delete=${sno}`;

    }
    else
    {
      console.log("no");
    }
  })
})
</script>
  </body>
</html>