<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add an address</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <?php

        require_once '../functions/dbcon.php';
        require_once '../functions/util.php';
        
        // Post Variables
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $address = filter_input(INPUT_POST, 'address');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        $dob = filter_input(INPUT_POST, 'dob');

        // Regex Varaibles
        $basicRegex = '/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/';
        $zipRegex = '/^\d{5}(?:[-\s]\d{4})?$/';
        $emailRegex = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';

        if(isPostRequest()) 
        {    
            $message = array();

            // Checking if empty and valid      
            if(empty($name)) 
            {
                array_push($message,'Sorry name is empty');
            } 
            elseif(!preg_match($basicRegex, $name))
            {
                array_push($message,'Sorry name is not valid');
            }

            if (empty($email)) 
            {
                array_push($message,'Sorry email is empty');
            }
            elseif(!preg_match($emailRegex, $email))
            {
                array_push($message,'Sorry email is not valid');
            }

            if (empty($address)) 
            {
                array_push($message,'Sorry address is empty');
            }
            elseif(!preg_match($basicRegex, $address))
            {
                array_push($message,'Sorry address is not valid');
            }

            if (empty($city)) 
            {
                array_push($message,'Sorry city is empty');
            }
            elseif(!preg_match($basicRegex, $city))
            {
                array_push($message,'Sorry city is not valid');
            }

            if (empty($zip)) 
            {
                array_push($message,'Sorry zip is empty');
            }
            elseif(!preg_match($zipRegex, $zip))
            {
                array_push($message,'Sorry zip is not valid');
            }

            // Add Address
            if(count($message) === 0)
            {
                if(addAddress($name, $email, $address, $city, $state, $zip, $dob))
                {
                    array_push($message,'Succesfully Added');
                }
            }

            include './errors.php';
        }
       
        ?>

        <div class="container">
            <h3>Add an address</h3>
            <form action="#" method="post">   
               Name: <br /><input name="name" value="<?php echo $name ?>" /> <br /><br />
               Email: <br /><input name="email" value="<?php echo $email ?>" /> <br /><br />
               Address: <br /><input name="address" value="<?php echo $address ?>" /> <br /><br />
               City: <br /><input name="city" value="<?php echo $city ?>" /> <br /><br />
               State: <br />
                            <select name="state" id="state">
                                <option value="AL" id="AL">Alabama</option>
                                <option value="AK" id="AK">Alaska</option>
                                <option value="AZ" id="AZ">Arizona</option>
                                <option value="AR" id="AR">Arkansas</option>
                                <option value="CA" id="CA">California</option>
                                <option value="CO" id="CO">Colorado</option>
                                <option value="CT" id="CT">Connecticut</option>
                                <option value="DE" id="DE">Delaware</option>
                                <option value="DC" id="DC">District Of Columbia</option>
                                <option value="FL" id="FL">Florida</option>
                                <option value="GA" id="GA">Georgia</option>
                                <option value="HI" id="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>    <br /><br />

                            <script type="text/javascript">
                                // Used to put the state drop down list back to the correct state
                                var phpState = "<?php echo $state; ?>";
                                var ddl = document.getElementById("state");

                                for(var i = 0; i < 52; i++)
                                {
                                    if(ddl.options[i].value == phpState)
                                    {
                                        ddl.options[i].selected = true;
                                    }
                                }

                            </script>

               Zip: <br /><input name="zip" value="<?php echo $zip ?>" /> <br /><br />
               DOB: <br /><input type="date" name="dob" value="<?php echo $dob ?>" /> <br /><br />

               <input type="submit" value="Submit" class="btn btn-primary" />
            </form>

            <a href="../index.php">Back to home</a>
        </div>

    </body>
</html>