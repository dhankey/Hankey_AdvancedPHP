<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <style type="text/css">
            textarea {
                width: 500px;
                height: 100px;
            }
            
            textarea[name="results"] {
                 height: 300px;
            }
        </style>
        
        <h1>Rest API Demo</h1>
        <div style="float:left; margin-right: 40px;">
        Verb/HTTP Method:<br />
        <select name="verb">
            <option value="GET">GET</option>
            <option value="POST">POST</option>
            <option value="PUT">PUT</option>
            <option value="DELETE">DELETE</option>
        </select>
        <br />
        <br />
        Resource for endpoint:<br />
        <input name="resource" value="corps" />
        <br />
        <br />
        Data(optional):<br />   
        id <br /><input type="text" name="id" value="" />
        <br /><br />
        corp <br /><input type="text" name="corp" value="" />
        <br /><br />
        incorp_dt <br /><input type="date" name="incorp_dt" value="" />
        <br /><br />
        email <br /><input type="text" name="email" value="" />
        <br /><br />
        owner <br /><input type="text" name="owner" value="" />
        <br /><br />
        phone <br /><input type="number"  maxlength="10" min="0" name="phone">
        <br /><br />
        location <br /><input type="text" name="location">
        <br />
        <br />
        <button>Make Call</button></div>
        <div><h3>Results</h3>
        
        <textarea name="results"></textarea>
        
        <script type="text/javascript">
        
            var callBtn = document.querySelector('button');
            
            callBtn.addEventListener('click', makeCall);
        
            function makeCall() {
                var verbfield = document.querySelector('select[name="verb"]');
                var verb = verbfield.options[verbfield.selectedIndex].value;
                var resource = document.querySelector('input[name="resource"]').value;
                var data = {
                    'id' : document.querySelector('input[name="id"]').value,
                    'corp' : document.querySelector('input[name="corp"]').value,
                    'incorp_dt' : document.querySelector('input[name="incorp_dt"]').value,
                    'email' : document.querySelector('input[name="email"]').value,
                    'owner' : document.querySelector('input[name="owner"]').value,
                    'phone' : document.querySelector('input[name="phone"]').value,
                    'location' : document.querySelector('input[name="location"]').value
                };            
                var results = document.querySelector('textarea[name="results"]');

                var xmlhttp = new XMLHttpRequest();

                var url = './api/v2/' + resource;

                xmlhttp.open(verb, url, true);

                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState === 4 ) {

                        console.log(xmlhttp.responseText);
                        results.value = xmlhttp.responseText;
                    } else {
                        // waiting for the call to complete
                    }
                };
                //var username = 'test';
               // xmlhttp.setRequestHeader("Authorization", "Basic " + btoa(username + "
               // "));

                 if ( verb === 'GET' ) {
                      xmlhttp.send(null);
                 } else {
                    xmlhttp.setRequestHeader('Content-type','application/json;charset=UTF-8');
                    xmlhttp.send(JSON.stringify(data));
                }
            }
        </script>
        
        </div>
    </body>
</html>
