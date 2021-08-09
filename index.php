<?php
if ( !isset( $_SESSION['selected'] ) ) {
    $_SESSION['selected'] = 'student';
}
include 'functions.php';
include 'connect.php';

//Pull data for update form

//Student form section
if ( isset( $_GET['edit'] ) ) {
    $edit = $_GET['edit'];
    $id = $_GET['id'];
    if ( $edit == 'std' ) {
        $_SESSION['selected']='student';
        $squery = "SELECT * FROM student where RN='$id'";
        $sresult = $conn->query( $squery );
        if ( mysqli_num_rows( $sresult ) ) {
            while( $srow = mysqli_fetch_assoc( $sresult ) ) {
                $roll = $srow['RN'];
                $name = $srow['Name'];
                $dob = $srow['DOB'];
                $address = $srow['Address'];
                $phone = $srow['PhNo'];
                $email = $srow['Email'];
            }
        }
    }

//Department form section
    if ( $edit == 'dpt' ) {
        $dquery = "SELECT * FROM department where DID='$id'";
        $_SESSION['selected']='department';
        $dresult = $conn->query( $dquery );
        if ( mysqli_num_rows( $dresult ) ) {
            while( $drow = mysqli_fetch_assoc( $dresult ) ) {
                $dptid = $drow['DID'];
                $dptname = $drow['DName'];
                $orgid= $drow['ORGID'];
            }
        }
    }
    
//Location form section
    if ($edit=='loc'){
        $query = "SELECT * FROM location where LOC='$id'";
        $_SESSION['selected']='location';
        $result = $conn->query( $query );
        if ( mysqli_num_rows( $result ) ) {
            while( $drow = mysqli_fetch_assoc( $result ) ) {
                $locid = $drow['LOC'];
                $locname = $drow['LName'];
            }
        }
    }
    
//Organization form section
    if ($edit=='org'){
        $query = "SELECT * FROM organization where ORGID='$id'"; 
        $_SESSION['selected']='organization';
        $result = $conn->query( $query );
        if ( mysqli_num_rows( $result ) ) {
            while( $drow = mysqli_fetch_assoc( $result ) ) {
                $orgid = $drow['ORGID'];
                $orgname = $drow['ORGName'];
                $loc = $drow['LOC'];
            }
        }
    }
    
}
?>

<!--HTML Section-->
<HTML>
<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--    Jquery bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
</head>

<body>
    <!--    Navigation section-->
    <div class="container-fluid text-center bg-secondary text-light" style="padding:20 0 20">
        <div class="container-fluid">
            <h3 class="navbar-text">Registration Portal</h3>
            <hr style="border:1px solid white;" />
        </div>
    </div>
    <style>
        .nav-pills li button {
            color: white !important;
            font-size: 16px;
        }

        .nav-pills li button.active {
            background-color: white !important;
            color: black !important;
            border-radius: 8px 8px 0 0 !important;
            font-size: 20px;
        }

    </style>
    <div class="container-fluid bg-secondary" style="margin-top:-40px;">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if(!isset($_SESSION['selected'])){echo 'active';} elseif(isset($_SESSION['selected']) && $_SESSION['selected']=='student'){echo 'active';}?>" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Student</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if(isset($_SESSION['selected']) && $_SESSION['selected']=='department'){echo 'active';}?>" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Department</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if(isset($_SESSION['selected']) && $_SESSION['selected']=='location'){echo 'active';}?>" id="pills-location-tab" data-bs-toggle="pill" data-bs-target="#pills-location" type="button" role="tab" aria-controls="pills-location" aria-selected="false">Location</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if(isset($_SESSION['selected']) && $_SESSION['selected']=='organization'){echo 'active';}?>" id="pills-organization-tab" data-bs-toggle="pill" data-bs-target="#pills-organization" type="button" role="tab" aria-controls="pills-organization" aria-selected="false">Organization</button>
            </li>
        </ul>
    </div>

    <!--    End of navigation section-->

    <!--    Aleart Section-->

    <!--    Student aleart section-->
    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'std-exist' ) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>
            Student already added!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'std-updated' ) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Student record updated successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'std-added' ) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Student added successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'std-deleted' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Student deleted successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <!--    Department alert section-->
    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'dpt-exist' ) {?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>
            Department already added!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'dpt-updated' ) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Department record updated successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'dpt-added' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Department added successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>
    <?php
        if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'dpt-deleted' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Department deleted successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>

     <!--    Location alert section-->
     <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'location-exist' ) {?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>
            Location already added!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'loc-updated' ) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Location record updated successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'location-added' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Location added successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>
    <?php
        if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'loc-deleted' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Location deleted successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>

     <!--    Organization alert section-->
     <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'org-exist' ) {?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>
            Organization already added!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'org-updated' ) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Organization record updated successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <?php if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'org-added' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Organization added successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>
    <?php
        if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'org-deleted' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Organization deleted successfully!
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>

    <!-- Phone Error aleart Section -->
    <?php
        if ( isset( $_SESSION['message'] ) && $_SESSION['message'] == 'errphone' ) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>
            Enter Valid Phon No.
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php }?>



    <?php $_SESSION['message'] = ''; ?>

    <!--    Alert section end-->

    <!--    Student form Section-->

    <br />
    <div class="tab-content" id="pills-tabContent">
        <div class="container-fluid shadow p-4 mb-5 bg-body rounded tab-pane fade <?php if(!isset($_SESSION['selected'])){echo 'show active';} elseif(isset($_SESSION['selected']) && $_SESSION['selected']=='student'){echo 'show active';}else{echo 'fade';} ?>" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row">
                <div class="col-4" style="max-width=40em">
                    <center>
                        <?php if ( isset( $edit ) && $edit == 'std' ): ?>
                        <h2>Update Student</h2>
                        <?php else: ?>
                        <h2>Add Student</h2>
                        <?php endif;?>
                    </center>
                    <hr />
                    <br>
                    <form id="registration" action="functions.php" method="POST">
                        <div class="mb-3">
                            <label for="studentname" class="form-label">Student Name</label>
                            <input type="text" value="<?php if(isset($edit) && $edit=='std'): echo $name; endif; ?>" class="form-control" placeholder="Full Name" name="studentname" id="studentname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" oninvalid="this.setCustomValidity('Please Enter valid Email')" value="<?php if(isset($edit) && $edit=='std'): echo $email; endif; ?>" class="form-control" placeholder="abc@y.com" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" value="<?php if(isset($edit) && $edit=='std'): echo $address; endif; ?>" class="form-control" placeholder="Address" name="address" id="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" value="<?php if(isset($edit) && $edit=='std'): echo $phone; endif; ?>" minlength="10" maxlength="10" class="form-control" placeholder="Phone" name="phone" id="phone" required>
                        </div>
                        <?php if(!isset($edit)){ ?>
                        <div class="row">
                            <div class="col">
                                <label for="email" class="form-label">Semester</label>
                                <select class="form-select" id="semester" name="semester" aria-label="Default select example">
                                    <option <?php if(!isset($edit)): echo 'selected'; endif; ?> >Select Semester</option>
                                    <option value="1" <?php if(isset($edit) && $edit=='std' && $semester=='1'): echo 'selected'; endif; ?> >1</option>
                                    <option value="2" <?php if(isset($edit) && $edit=='std' && $semester=='2'): echo 'selected'; endif; ?> >2</option>
                                    <option value="3" <?php if(isset($edit) && $edit=='std' && $semester=='3'): echo 'selected'; endif; ?> >3</option>
                                    <option value="4" <?php if(isset($edit) && $edit=='std' && $semester=='4'): echo 'selected'; endif; ?> >4</option>
                                    <option value="5" <?php if(isset($edit) && $edit=='std' && $semester=='5'): echo 'selected'; endif; ?> >5</option>
                                    <option value="6" <?php if(isset($edit) && $edit=='std' && $semester=='6'): echo 'selected'; endif; ?> >6</option>
                                </select>
                            </div>
                        
                            <?php if(!isset($edit)): ?>
                                <div class="col">
                                    <label for="email" class="form-label">TRP ( Optional )</label>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="trpbutton">
                                            Click here for TRP
                                        </button>
                                    </div>
                                </div>
                                <input type="text" value="" id="rntrp" name="rntrp" readonly hidden>
                            <?php ; endif;?>
                        </div>
                        <div>
                            <label for="orgname" class="form-label">Organization Name</label>
                            <select class="form-select" aria-label="Default select example" id="orgname" name="orgname">
                                <option <?php if ( !isset( $edit ) ) {echo 'selected';}?>>
                                    Select Organization
                                </option>
                                <?php
                                    $query = "SELECT * from organization";
                                    $result = $conn->query( $query );
                                    if ( $result ) {
                                        if ( mysqli_num_rows( $result )>0 ) {
                                            while( $row = mysqli_fetch_assoc( $result ) ) {?>
                                            <option value="<?php echo $row['ORGID']; ?>"><?php echo $row['ORGName'];?>
                                            </option>
                                <?php }}}?>
                            </select>
                        </div>
                        <br />
                        <div>
                            <label for="deptname" class="form-label">Department Name</label>
                            <select class="form-select" aria-label="Default select example" id="deptname" name="deptname">
                                <option <?php if ( !isset( $edit ) ) {echo 'selected';}?>>
                                    Select Department Name
                                </option>
                                <?php
                            $query = "SELECT * from department";
                            $result = $conn->query( $query );
                            if ( $result ) {
                                if ( mysqli_num_rows( $result )>0 ) {
                                    while( $row = mysqli_fetch_assoc( $result ) ) {?>
                                <option value="<?php echo $row['DID']; ?>" ><?php echo $row['DName'];?>
                                </option>
                                <?php }}}?>
                            </select>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col">
                                <label for="admissionyear" class="form-label">Admitted On</label>
                                <select id="admissionyear" name="admissionyear" class="form-select" aria-label="Default select example"></select>
                            </div>
                            <div class="col">
                                <label for="dob" class="form-label">DOB (Atleast 17 year old)</label>
                                <input type="date" oninvalid="this.setCustomValidity('Please Enter valid DOB')" class="form-control" name="dob" max="2004-12-31" id="dob" required>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ( isset( $edit ) && $edit == 'std' ) {?>
                        <input type="text" value="<?php echo $roll; ?>" id="updatestd" name="updatestd" readonly hidden>
                        <?php } else {?>
                        <input type="text" value="std-add" id="add" name="add" readonly hidden>
                        <?php }?>
                        <br>
                        <div class="d-grid gap-2">
                            <?php if ( isset( $edit ) && $edit == 'std' ): ?>
                            <button type="submit" class="btn btn-secondary">Update</button>
                            <p>Cancel Updation? <a href="index.php" style="text-decoration:none;">Click Here</a></p>
                            <?php else: ?>
                            <button type="submit" id="submit" class="btn btn-secondary">Add</button>
                            <?php endif ?>
                        </div>
                    </form>
                </div>

                <!--                End of Student form section-->

                <!--                Start of Student Table Section-->

                <div class="col-8 text-center">
                    <div class="container-fluid">
                        <style>
                            hr {
                                border: 1px solid black;
                            }
                        </style>
                        <h2>Student Record</h2>
                        <hr />
                        <?php
                        $sql = "SELECT * FROM student";
                        $result = $conn->query( $sql );
                        if ( $result ) {
                            if ( mysqli_num_rows( $result ) == 0 ) {
                                $_SESSION['registered'] = 0;
                                echo '<h3>No student record found!</h3>';
                                echo '<p><a href="#firstname" style="text-decoration:none;">Add student</a></p>';
                            } else {?>
                        <div class="table-responsive">
                            <table class="table text-center table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Roll No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone No.</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">DOB</th>
                                        <th scope="col">Admission Year</th>
                                        <th scope="col">TPR</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while( $row = mysqli_fetch_assoc( $result ) ) {?>
                                    <tr>
                                        <td><?php echo $row['RN']?></td>
                                        <td><?php echo $row['Name']?></td>
                                        <td><?php echo $row['Semester'];?></td>
                                        <td><?php echo $row['Email']?></td>
                                        <td><?php echo $row['PhNo']?></td>
                                        <td><?php echo $row['Address']?></td>
                                        <td><?php echo $row['DOB']?></td>
                                        <td><?php echo $row['AdmissionYr']?></td>
                                        <td><?php echo $row['RNTPR']?></td>
                                        <td>
                                            <div class='d-grid gap-2 d-md-block'>
                                                <a href="index.php?id=<?php echo $row['RN']?>&edit=std" style='background:none;border:none;text-decoration:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                        <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z' />
                                                    </svg>
                                                </a>
                                                <a href="functions.php?stdid=<?php echo $row['RN']?>" style='background:none;border:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z' />
                                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' />
                                                    </svg>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>

        <!--        End of student block section-->

        <!--Start of Department Block -->

        <!--        Department form section-->

        <div class="container-sm shadow p-3 mb-5 bg-body rounded tab-pane <?php if(!isset($_SESSION['selected'])){echo 'show';} elseif($_SESSION['selected']=='department'){echo 'show active';} else{echo 'fade';}?>" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab ">
            <div class="row">
                <div class="col-4" style="max-width=40em">
                    <center>
                        <?php if ( isset( $edit ) && $edit == 'dpt' ) {?>
                        <h2>Update Department</h2>
                        <?php } else {?>
                        <h2>Add Department</h2>
                        <?php }?>
                    </center>
                    <hr />
                    <br>
                    <form id="registration" action="functions.php" method="POST">
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" value="<?php if(isset($edit) && $edit=='dpt'){ echo $dptname; }?>" class="form-control" name="department_name" id="department_name" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department ID</label>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" value="<?php if(isset($edit) && $edit=='dpt'){ echo $dptid; }?>" class="form-control" name="department_id" id="department_id" placeholder="AAA" maxlength="3" required>
                        </div>
                        <?php if ( isset( $edit ) && $edit == 'dpt' ) {?>
                        <input type="text" id="dptupdate" name="dptupdate" value="<?php echo $id;?>" readonly hidden>
                        <?php } else {?>
                        <input type="text" id="dptadd" name="dptadd" value="dptadd" readonly hidden>
                        <?php }?>
                        <div>
                            <label for="organization" class="form-label">Organization Name</label>
                            <select class="form-select" aria-label="Default select example" id="orgID" name="orgID">
                                <option <?php if ( !isset( $edit ) ) {echo 'selected';}?>>
                                    Select Organization
                                </option>
                                <?php
                                $query = "SELECT * from organization";
                                $result = $conn->query( $query );
                                if ( $result ) {
                                    if ( mysqli_num_rows( $result )>0 ) {
                                        while( $row = mysqli_fetch_assoc( $result ) ) {?>
                                            <option value="<?php echo $row['ORGID']; ?>" <?php if ( isset( $edit ) && $edit == 'dpt' && $row['ORGID'] == $orgid ) 
                                            { echo 'selected';}?>>
                                                <?php echo $row['ORGName'];?>
                                            </option>
                                <?php } } } ?>
                            </select>
                        </div>
                        <br />
                        <br>
                        <div class="d-grid gap-2">
                            <?php if ( isset( $edit ) && $edit == 'dpt' ) { ?>
                            <button type="submit" class="btn btn-secondary">Update</button>
                            <p>Cancel Updation? <a href="index.php" style="text-decoration:none;">Click Here</a></p>
                            <?php } else { ?>
                            <button type="submit" class="btn btn-secondary">Add</button>
                            <?php }?>
                        </div>
                    </form>
                </div>

                <!--                End of department form section-->

                <!--                Start of department table section-->

                <div class="col-8 text-center">
                    <div class="container-fluid">
                        <h2>Department Record</h2>
                        <hr />
                        <?php
                        $sql = "SELECT * FROM department";
                        $result = $conn->query( $sql );
                        if ( $result ) {
                            if ( mysqli_num_rows( $result ) == 0 ) {
                                $_SESSION['registered'] = 0;
                                echo '<h3>No department record found!</h3>';
                                echo '<p><a href = "#department_name" style = "text-decoration:none;">Add department</a></p>';
                            } else {
                                ?>
                        <div class="table-responsive">
                            <table class="table text-center table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Department ID</th>
                                        <th scope="col">Department Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    <?php while( $row = mysqli_fetch_assoc( $result ) ) { ?>
                                    <tr>
                                        <td><?php echo $row['DID']?></td>
                                        <td><?php echo $row['DName']; ?></td>
                                        <td>
                                            <div class='d-grid gap-2 d-md-block'>
                                                <a href='index.php?id=<?php echo $row['DID']?>&edit=dpt' style='background:none;border:none;text-decoration:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                        <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z' />
                                                    </svg>
                                                </a>
                                                <a href='functions.php?dptid=<?php echo $row['DID']?>' style='background:none;border:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z' />
                                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' />
                                                    </svg>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <!--                End of Department table section-->
            </div>
        </div>
        <!--                End of Department Section-->
        

        <!--                Start of Location Section-->
        
        <div class="container-sm shadow p-4 mb-5 bg-body rounded tab-pane <?php if(!isset($_SESSION['selected'])){echo 'show';} elseif($_SESSION['selected']=='location'){echo 'show active';} else{echo 'fade';}?>" id="pills-location" role="tabpanel" aria-labelledby="pills-location-tab">
            <div class="row">
                <div class="col-4" style="max-width=40em">
                    <center>
                        <?php if ( isset( $edit ) && $edit == 'loc' ): ?>

                        <h2>Update Location</h2>
                        <?php else: ?>
                        <h2>Add Location</h2>
                        <?php endif;?>
                    </center>
                    <hr />
                    <br>

                    <form id="registration" action="functions.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <label for="locname" class="form-label">Location Name</label>
                                <input type="text" value="<?php if(isset($edit) && $edit=='loc'): echo $locname; endif; ?>" class="form-control" placeholder="Name" name="locname" id="locname" required>
                            </div>
                        </div>
                        <br />
                        <?php if ( isset( $edit ) && $edit == 'loc' ) { ?>
                        <input type="text" value="<?php echo $id; ?>" id="locupdate" name="locupdate" readonly hidden>
                        <?php } else { ?>
                        <input type="text" value="add" id="locadd" name="locadd" readonly hidden>
                        <?php } ?>
                        <br />
                        <div class="d-grid gap-2">
                            <?php if ( isset( $edit ) && $edit == 'loc' ): ?>
                            <button type="submit" class="btn btn-secondary">Update</button>
                            <p>Cancel Updation? <a href="index.php" style="text-decoration:none;">Click Here</a></p>
                            <?php else: ?>
                            <button type="submit" class="btn btn-secondary">Add</button>
                            <?php endif ?>
                        </div>
                    </form>
                </div>

                <!--                End of location form section-->

                <!--                Start of location Table Section-->

                <div class="col-8 text-center">
                    <div class="container-fluid">
                        <style>
                            hr { border: 1px solid black; }
                        </style>

                        <h2>Location Record</h2>
                        <hr />
                        <?php
                            $sql = "SELECT * FROM location";
                            $result = $conn->query( $sql );
                            if ( $result ) {
                                if ( mysqli_num_rows( $result ) == 0 ) {
                                    echo '<h3>No student record found!</h3>';
                                    echo '<p><a href = "#locname" style = "text-decoration:none;">Add Location</a></p>';
                                } else { ?>
                        <div class="table-responsive">
                            <table class="table text-center table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">LOC</th>
                                        <th scope="col">Location Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    <?php while( $row = mysqli_fetch_assoc( $result ) ) { ?>
                                        <tr>
                                        <td><?php echo $row['LOC']?></td>
                                        <td><?php echo $row['LName']?></td>
                                        <td>
                                            <div class='d-grid gap-2 d-md-block'>
                                                <a href="index.php?id=<?php echo $row['LOC']?>&edit=loc" style='background:none; border:none;text-decoration:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                        <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z' />
                                                    </svg>
                                                </a>
                                                <a href='functions.php?locid=<?php echo $row['LOC']?>' style='background:none;border:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z' />
                                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--                End of location section-->

        <!--                Start of Organization Section-->
        <div class="container-sm shadow p-4 mb-5 bg-body rounded tab-pane <?php if(!isset($_SESSION['selected'])){echo 'show';}elseif($_SESSION['selected']=='organization'){echo 'show active';} else{echo 'fade';} ?>" id="pills-organization" role="tabpanel" aria-labelledby="pills-organization-tab">
            <div class="row">
                <div class="col-4" style="max-width=40em">
                    <center>
                        <?php if ( isset( $edit ) && $edit == 'org' ): ?>

                        <h2>Update Organization</h2>

                        <?php else: ?>

                        <h2>Add Organization</h2>
                        <?php endif;
                                                                                            ?>
                    </center>
                    <hr />
                    <br>

                    <form id="registration" action="functions.php" method="POST">
                        <div class="mb-3">
                            <label for="orgname" class="form-label">Organization Name</label>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" value="<?php if(isset($edit) && $edit=='org'){ echo $orgname; }?>" class="form-control" name="orgname" id="orgname" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="orgID" class="form-label">Organization ID</label>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" value="<?php if(isset($edit) && $edit=='org'){ echo $orgid; }?>" class="form-control" name="orgID" id="orgID" placeholder="Organization ID" maxlength="3" required>
                        </div>

                        <?php if ( isset( $edit ) && $edit == 'org' ) {
                                                                                                ?>
                        <input type="text" value="<?php echo $id; ?>" id="orgupdate" name="orgupdate" readonly hidden>
                        <?php } else { ?>
                        <input type="text" value="orgadd" id="orgadd" name="orgadd" readonly hidden>
                        <?php }?>
                        <div>
                            <label for="department" class="form-label">Location</label>
                            <select class="form-select" aria-label="Default select example" id="orglocation" name="orglocation" required>
                                <option <?php if ( !isset( $edit ) ) {echo 'selected';}?>>Select Location</option>
                                <?php
                                    $query = "SELECT * from location";
                                    $result = $conn->query( $query );
                                    if ( $result ) {
                                        if ( mysqli_num_rows( $result )>0 ) {
                                            while( $row = mysqli_fetch_assoc( $result ) ) {?>
                                            <option value="<?php echo $row['LOC']; ?>" <?php if ( isset( $edit ) && $edit == 'org' && $row['LOC'] == $loc ) {echo 'selected';}?>>
                                                <?php echo $row['LName'];?>
                                            </option>
                                    <?php } }}?>
                            </select>
                        </div>
                        <br />
                        <br>
                        <div class="d-grid gap-2">
                            <?php if ( isset( $edit ) && $edit == 'org' ): ?>
                            <button type="submit" class="btn btn-secondary">Update</button>
                            <p>Cancel Updation? <a href="index.php" style="text-decoration:none;">Click Here</a></p>
                            <?php else: ?>
                            <button type="submit" class="btn btn-secondary">Add</button>
                            <?php endif ?>
                        </div>
                    </form>
                </div>

                <!--                End of Organization form section-->

                <!--                Start of Organization Table Section-->

                <div class="col-8 text-center">
                    <div class="container-fluid">
                        <style>
                            hr {
                                border: 1px solid black;
                            }

                        </style>
                        <h2>Organization Record</h2>
                        <hr />
                        <?php
                        $sql = "SELECT * FROM organization";
                        $result = $conn->query( $sql );
                        if ( $result ) {
                            if ( mysqli_num_rows( $result ) == 0 ) {
                                echo '<h3>No student record found!</h3>';
                                echo '<p><a href = "#orgname" style = "text-decoration:none;">Add Organization</a></p>';
                            } else {?>
                        <div class="table-responsive">
                            <table class="table text-center table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Org ID</th>
                                        <th scope="col">Organization Name</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    <?php while( $row = mysqli_fetch_assoc( $result ) ) {
                                                                                        ?>
                                    <tr>
                                        <td><?php echo $row['ORGID']?></td>
                                        <td><?php echo $row['ORGName']?></td>
                                        <td>
                                            <?php
                                            $loc_id = $row['LOC'];
                                            $query = "SELECT * FROM location where LOC='$loc_id'";
                                            $qresult = $conn->query( $query );
                                            if ( $qresult ) {
                                                if ( mysqli_num_rows( $qresult )>0 ) {
                                                    while( $lrow = mysqli_fetch_assoc( $qresult ) ) {
                                                        echo $lrow['LName'];
                                                    }
                                                }
                                            }?>
                                        </td>
                                        <td>
                                            <div class='d-grid gap-2 d-md-block'>
                                                <a href="index.php?id=<?php echo $row['ORGID']?>&edit=org" style='background:none;border:none;text-decoration:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                        <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z' />
                                                    </svg>
                                                </a>
                                                <a href='functions.php?orgid=<?php echo $row['ORGID']?>' style='background:none;border:none;'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z' />
                                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z' />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>
        <!--                End of Organization section-->

<!--TRP Modal section-->

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List of students for TRP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    
<!--    JQuery section-->
    
    <script type="text/javascript">
        window.onload = function() {
            var ddlYears = document.getElementById("admissionyear");
            var currentYear = (new Date()).getFullYear();
            for (var i = 1990; i <= currentYear; i++) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                ddlYears.appendChild(option);
            }
        };

        $('#trpbutton').click(function() {
            $('#exampleModal').modal('show');
            var sem = $('#semester').children("option:selected").val();

            $.ajax({
                type: 'POST', // the method (could be GET btw)
                url: 'functions.php', // The file where my php code is
                data: {
                    'semester': sem
                },
                success: function(response) {
                    $('.modal-body').html(response);
                    $('#savebtn').click(function() {
                        var id = $('input[name = "trpradio"]:checked').val();
                        $('#trpbutton').html(id);
                        $('#rntrp').val(id);
                        $('#exampleModal').modal('hide');
                    });
                }
            });
        });
        $('#registration').validate();

        
    </script>
</body>
</HTML>
