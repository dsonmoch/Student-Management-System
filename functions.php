<?php
session_start();
include "connect.php";

//Add Student section

if ( isset( $_POST['add'] ) ) {
    $random = rand( 100, 999 );
    $studentname = $_POST['studentname'];
    $email = $_POST['email'];
    $orgname = $_POST['orgname'];
    $deptname = $_POST['deptname'];
    $semester = $_POST['semester'];
    $admissionyear = $_POST['admissionyear'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $trp = $_POST['rntrp'];
    $roll = $deptname.$admissionyear.$random;

    if ( $trp == '' ) {
        $trp = 'Unavailable';
    }
    if($phone < 10){
        $_SESSION['message'] = 'errphone';
        header( "Location: index.php" );
    }else{
        $query = "SELECT * FROM student where email='$email' and name='$studentname'" ;
    $result = $conn->query( $query );
    $row = mysqli_num_rows( $result );
    if ( $row > 0 ) {
        $_SESSION['message'] = 'std-exist';
        $_SESSION['selected'] = 'student';
        header( "Location: index.php" );
    } else {
        $sql = "INSERT INTO student".
        "(RN,Name,AdmissionYr,DOB,Semester,Address,PhNo,Email,RNTPR)"."VALUES".
        "('$roll','$studentname','$admissionyear','$dob','$semester','$address','$phone','$email','$trp')";

        if ( $conn->query( $sql ) ) {
            $_SESSION['message'] = 'std-added';
            $_SESSION['selected'] = 'student';
            header( "Location: index.php" );
        } else {
            echo "Error".mysqli_error( $conn );
        }
    }
    }

    
}

//Student update section

if ( isset( $_POST['updatestd'] ) ) {
    $roll = $_POST['updatestd'];
    $name = $_POST['studentname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $qury = "UPDATE student set Name='$name', Address='$address', PhNo='$phone', Email='$email' where RN='$roll'";
    if ( $conn->query( $qury ) ) {
        $_SESSION['message'] = 'std-updated';
        $_SESSION['selected'] = 'student';
        header( "Location: index.php" );
    } else {
        echo "Error".mysqli_error( $conn );
    }
}

//Student delete section

if ( isset( $_GET['stdid'] ) ) {
    $stdid = $_GET['stdid'];
    $query = "DELETE FROM student where RN='$stdid'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'std-deleted';
        $_SESSION['selected'] = 'student';
        header( "Location: index.php" );
    } else {
        echo 'Unable to delete'.mysqli_error( $conn );
    }
}

//TRP section
if ( isset( $_POST['semester'] ) ) {
    $sem = $_POST['semester'];
    $count = 1;
    if ( $sem == 'Select Semester' ) {
        echo "<p>Select Semester for TRP</p>";
        echo '<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savebtn" class="btn btn-primary disabled">Save</button>
              </div>';
    } else {
        $sql = "SELECT * FROM student where Semester='$sem'";
        $result = $conn->query( $sql );
        if ( $result ) {
            if ( mysqli_num_rows( $result ) == 0 ) {
                echo '<p>No student record found for TRP!</p>';
            } else {
                while( $row = mysqli_fetch_assoc( $result ) ) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" value="'.$row['RN'].'" name="trpradio" id="radio'.$count.'">';
                    echo '<label class="form-check-label" for="flexRadioDefault1">';
                    echo $count.'. '.$row['RN'].' - '.$row['Name'];
                    echo '</label>';
                    echo '</div>';
                    $count++;
                }
                echo '<div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="savebtn" class="btn btn-primary">Save</button>
                              </div>';
            }
        }
    }
}

//Department add section

if ( isset( $_POST['dptadd'] ) ) {
    $departmentName = $_POST['department_name'];
    $departmentID = $_POST['department_id'];
    $orgID = $_POST['orgID'];
    $departmentID = $orgID.$departmentID;

    $query = "SELECT * FROM department where and DName='$departmentName' and ORGID='$orgID'";
    $result = $conn->query( $query );
    $row = mysqli_num_rows( $result );
    if ( $row>0 ) {
        $_SESSION['message'] = 'dpt-exist';
        $_SESSION['selected'] = 'department';
        header( "Location: index.php" );
    } else {
        $sql = "INSERT INTO department".
        "(DID,DName,ORGID)"."VALUES".
        "('$departmentID','$departmentName','$orgID')";
        if ( $conn->query( $sql ) ) {
            $_SESSION['message'] = 'dpt-added';
            $_SESSION['selected'] = 'department';
            header( "Location:index.php" );
        } else {
            echo "Error".mysqli_error( $conn );
        }
    }
}

//Department delete section

if ( isset( $_GET['dptid'] ) ) {
    $id = $_GET['dptid'];
    $query = "DELETE FROM department where DID='$id'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'dpt-deleted';
        $_SESSION['selected'] = 'department';
        header( "Location: index.php" );
    } else {
        echo 'Unable to delete'.mysqli_error( $conn );
    }
}

//Department update section
if ( isset( $_POST['dptupdate'] ) ) {
    $id = $_POST['dptupdate'];
    $deptname = $_POST['department_name'];
    $deptid = $_POST['department_id'];
    $orgid = $_POST['orgID'];
    $deptid = $orgid.$deptid;

    $quary = "UPDATE department set  
        DID='$deptid',DName='$deptname', ORGID='$orgid' where DID='$id'";
    if ( $conn->query( $quary ) ) {
        $_SESSION['message'] = 'dpt-updated';
        $_SESSION['selected'] = 'department';
        header( "Location: index.php" );
    } else {
        echo "Error".mysqli_error( $conn );
    }
}

//Add Location section

if ( isset( $_POST['locadd'] ) ) {
    $locname = $_POST['locname'];

    $query = "SELECT * FROM location where LName='$locname'" ;
    $result = $conn->query( $query );
    $row = mysqli_num_rows( $result );
    if ( $row > 0 ) {
        $_SESSION['message'] = 'location-exist';
        $_SESSION['selected'] = 'location';
        header( "Location: index.php" );
    } else {
        $sql = "INSERT INTO location".
        "(LName)"."VALUES".
        "('$locname')";

        if ( $conn->query( $sql ) ) {
            $_SESSION['message'] = 'location-added';
            $_SESSION['selected'] = 'location';
            header( "Location: index.php" );
        } else {
            echo "Error".mysqli_error( $conn );
        }

    }

}

//Delete Location section

if ( isset( $_GET['locid'] ) ) {
    $locid = $_GET['locid'];
    $query = "DELETE FROM location where LOC='$locid'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'loc-deleted';
        $_SESSION['selected'] = 'location';
        header( "Location: index.php" );
    } else {
        echo 'Unable to delete'.mysqli_error( $conn );
    }
}

//Update Location Section
if ( isset( $_POST['locupdate'] ) ) {
    $id = $_POST['locupdate'];
    $locname = $_POST['locname'];

    $query = "UPDATE location set  
        LName='$locname' where LOC='$id'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'loc-updated';
        $_SESSION['selected'] = 'location';
        header( "Location: index.php" );
    } else {
        echo "Error".mysqli_error( $conn );
    }
}

//Add organization section

if ( isset( $_POST['orgadd'] ) ) {
    $orgname = $_POST['orgname'];
    $orgid = $_POST['orgID'];
    $orgloc = $_POST['orglocation'];

    $query = "SELECT * FROM organization where ORGID='$orgid' and ORGName='$orgname' and LOC='$orgloc'" ;
    $result = $conn->query( $query );
    $row = mysqli_num_rows( $result );
    if ( $row > 0 ) {
        $_SESSION['message'] = 'org-exist';
        $_SESSION['selected'] = 'organization';
        header( "Location: index.php" );
    } else {
        $sql = "INSERT INTO organization".
        "(ORGID,ORGName,LOC)"."VALUES".
        "('$orgid','$orgname','$orgloc')";

        if ( $conn->query( $sql ) ) {
            $_SESSION['message'] = 'org-added';
            $_SESSION['selected'] = 'organization';
            header( "Location: index.php" );
        } else {
            echo "Error".mysqli_error( $conn );
        }

    }

}

//Delete organization section

if ( isset( $_GET['orgid'] ) ) {
    $orgid = $_GET['orgid'];
    $query = "DELETE FROM organization where ORGID='$orgid'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'org-deleted';
        $_SESSION['selected'] = 'organization';
        header( "Location: index.php" );
    } else {
        echo 'Unable to delete'.mysqli_error( $conn );
    }
}

//Update Organization section

if ( isset( $_POST['orgupdate'] ) ) {
    $id = $_POST['orgupdate'];
    $orgname = $_POST['orgname'];
    $orglocation = $_POST['orglocation'];
    $orgid = $_POST['orgID'];

    $query = "UPDATE organization set  
        ORGID='$orgid',ORGName='$orgname',LOC='$orglocation' where ORGID='$id'";
    if ( $conn->query( $query ) ) {
        $_SESSION['message'] = 'org-updated';
        $_SESSION['selected'] = 'organization';
        header( "Location: index.php" );
    } else {
        echo "Error".mysqli_error( $conn );
    }
}

?>
