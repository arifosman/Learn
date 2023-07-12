<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>ADD STUDENT</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <div class="container-sm">
    <p class="fs-1 fw-bold">ADD STUDENT</p>

        <ul class="nav nav-tabs nav-fill mb-5">
            
            <li class="nav-item">
                <a class="nav-link" href="index.php">Attendance System</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="attendance_report.php">Attendance Report</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="add_student.php">Add Student</a>
            </li>

        </ul>
    <form method="post" action="process_add_student.php">
        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 m-auto">
                    <div class="card">
                        <div class="card-body">

                        <input type="text" id="student_name" name="student_name" class="form-control my-4 py-2" placeholder="Name" required>

                        <input type="text" id="class_name" name="class_name" class="form-control my-4 py-2" placeholder="Class" required>   

                        <div class="text-center mt-3">
                            <button class="btn btn-primary" input type="submit" name="submit" value="Add Student">Add</button>
                        </div>

                        
                        </div>



                    </div>

                </div>


            </div>
        
        </div>

    </form>      
    </div>
    
</body>
</html>
