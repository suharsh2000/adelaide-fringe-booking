<?php
                    $servername = "localhost";
                    $username = 'root';
                    $password = '';
                    $dbname = "adelaide fringe";

                    $conn = mysqli_connect($servername,$username,$password,$conn);

                    if(!$conn){
                        die("Sorry connection was not successful".mysqli_connect_error($conn));
                    }
                    else{
                        echo ("connection was successful");
                    }
            $sql =" INSERT INTO `register` (`Fullname`, `email`, `password`, `confirm_password`) VALUES ('$fullname', '$email', '$password', '$confirm_password')";
            $result = mysqli_query($conn,$result);
            if(!$result){
                echo"The data was inserted";
            }
            else{
                echo"It was not inserted";
            }



?>