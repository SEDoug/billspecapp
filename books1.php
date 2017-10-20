<?php

if(isset($_POST['search']))
{
   $valueToSearch = $_POST['valueToSearch'];
   // search in all table columns
   // using concat mysql function
   $query = "SELECT * FROM `File_Header` WHERE CONCAT(Column_name`, `Description`, `Length`, `Start_Position`, `End_Position`, `Value`, `Required`) LIKE '%".$valueToSearch."%'";
   $search_result = filterTable($query);

}
else {
   $query = "SELECT * FROM `File_Header`";
   $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
  $connect = mysqli_connect("localhost", "root", "123456", "billspec");
  $filter_Result = mysqli_query($connect, $query);
  return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
   <head>
       <title>BILL SPEC IMPORTER</title>
       <style>
           table,tr,th,td
           {
               border: 1px solid black;
           }
       </style>
   </head>
   <body>

       <form action="books1.php" method="post">
           <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
           <input type="submit" name="search" value="Filter"><br><br>

           <table>
               <tr>
                   <th>Column_name</th>
                   <th>Description</th>
                   <th>Length</th>
                   <th>Start_Position</th>
                   <th>End_Position</th>
                   <th>Value</th>
                   <th>Required</th>
               </tr>

     <!-- populate table from mysql database -->
               <?php while($row = mysqli_fetch_array($search_result)):?>
               <tr>
                   <td><?php echo $row['Column_name'];?></td>
                   <td><?php echo $row['Description'];?></td>
                   <td><?php echo $row['Length'];?></td>
                   <td><?php echo $row['Start_Position'];?></td>
                   <td><?php echo $row['End_Position'];?></td>
                   <td><?php echo $row['Value'];?></td>
                   <td><?php echo $row['Required'];?></td>
               </tr>
               <?php endwhile;?>
           </table>
       </form>

   </body>
</html>
