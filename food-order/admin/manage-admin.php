<link rel="stylesheet" href="../css/admin.css">
<?php include('partials/menu.php'); ?>


        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br><br>

                <?php 

                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];//Display message
                        unset($_SESSION['add']);//remove message
                    }
                

                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];//Display message
                        unset($_SESSION['delete']);//remove message
                    }

                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];//Display message
                        unset($_SESSION['update']);//remove message
                    }

                    if(isset($_SESSION['user-not-found'])){
                        echo $_SESSION['user-not-found'];//Display message
                        unset($_SESSION['user-not-found']);//remove message
                    }

                    if(isset($_SESSION['pwd-not-match'])){
                        echo $_SESSION['pwd-not-match'];//Display message
                        unset($_SESSION['pwd-not-match']);//remove message
                    }
                    
                    if(isset($_SESSION['change-pwd'])){
                        echo $_SESSION['change-pwd'];//Display message
                        unset($_SESSION['change-pwd']);//remove message
                    }
                
                ?>
                <br><br><br>
                <!-- Button to Add Admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //query to get all admin
                        $sql = "SELECT * FROM tbl_admin";
                        //excute the query
                        $res = mysqli_query($conn,$sql);

                        //check weather the query is executed or not
                        if($res == TRUE) {
                            //count rows to check weather we have data in database or not

                            $count = mysqli_num_rows($res); // func to get all the rows in database

                            if($count>0) {
                                //We have Data in Database
                                $sn = 1;

                                while($rows = mysqli_fetch_assoc($res)){
                                    //using while loop to get all the data from database
                                    
                                    //Get individual Data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];


                                    //Display the value in our Table
                                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td> 
                        <td><?php echo $full_name; ?></td>                        
                        <td><?php echo $username; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id?>" class="btn-primary">Change Password</a>
                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondary">Update Admin</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id?>" class="btn-danger">Delete Admin</a>
                            
                        </td>
                    </tr>

                                    <?php

                                }
                            }

                            else{
                                //We do not have Data in Daatabase
                            }

                        }



                    ?>


                </table>



            </div>
            
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>