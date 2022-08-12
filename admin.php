<?php
/*
    Bella Hovis  
    CSCI 297 Scripting Languages   
    Assignment: File Manipulation 
    Description: Program will have adimin page(s) (without authorization) to add remove, and modify enteries from a csv file. 
*/
?> 

<html>
    <head>
        <title>Admin Page</title>
    </head>
    <body> 

      

         <!-- create the form where the user can put information for company adding -->
         <form action="admin.php" method="POST">
            <label for="adminAction">Choose An Action :</label>
            <select id="adminAction" name="adminAction">
                <option value="Add">Add</option>
                <option value="Remove">Remove</option>
                <option value="Modify">Modify</option>
            </select>
            <label>Company Name: <input type="text" name="companyName"></label><br>
            <label>Company Phone: <input type="text" name="companyPhone"></label><br>
            <label>New Company Name: <input type="text" name="companyNameNew"></label><br>
            <label>New Company Phone: <input type="text" name="companyPhoneNew"></label><br>
            <button type="submit">Submit</button>
        </form>

        <?php
          
            //add company listing 
            if(isset($_POST['adminAction']) && $_POST['adminAction'] == 'Add' &&  isset($_POST['companyName']) && isset($_POST['companyPhone'])){
                if($_POST['companyName'] != '' && $_POST['companyPhone'] != ''){
                    
                    //open file
                    $callList = fopen("callList.csv", "a");
                    $companies = array();

                    if(!is_resource($callList))
                    {
                        echo "Could not open file while adding";
                         exit();
                    }
                    
                    
                    //add listing 
                    $addName = $_POST['companyName'];
                    $addNum = $_POST['companyPhone'];
                    $add = " \n$addName,$addNum";
                    fwrite($callList, $add);

                     //close file
                    fclose($callList);
                }

            }
        
            //Remove company listing 

            if(isset($_POST['adminAction']) && $_POST['adminAction'] == 'Remove' && isset($_POST['companyName']) && isset($_POST['companyPhone'])){
                if($_POST['companyName'] != '' && $_POST['companyPhone'] != ''){
                    
                    //open file
                    $callList = fopen("callList.csv", "r");
                    $companies = array();

                    if(!is_resource($callList))
                    {
                        echo "Could not open file while removing";
                         exit();
                    }

                    while($line = fgets($callList))
                    {
                        $companies[] = explode(",", $line);
                    }
                    
                     //close file
                     fclose($callList);

                    //remove listing 
                    $removeName = $_POST['companyName'];
                    $removeNum = $_POST['companyPhone'];
                    $indexToRemove = array_search($removeName, array_column($companies, 0));

                    if($indexToRemove !== false){
                    unset($companies[$indexToRemove]);
                   }
                   else{
                    echo "Could not find company to remove";
                   }
                    
                    
                    $callList = fopen("callList.csv", "w"); //open file in write to delete it 
                    
                    foreach($companies as $value){
                        $valueString = implode(",",$value);
                        fwrite($callList, $valueString);
                    }
                
                    //close file
                     fclose($callList);
                    
                }

            }
      
            //Modify company listing 
            if(isset($_POST['adminAction']) && $_POST['adminAction'] == 'Modify' && isset($_POST['companyName']) && isset($_POST['companyPhone']) && isset($_POST['companyNameNew']) && isset($_POST['companyPhoneNew'])){
                if($_POST['companyName'] != '' && $_POST['companyPhone'] != '' && $_POST['companyNameNew'] != '' && $_POST['companyPhoneNew'] != ''){
                  
                    //open file and add new info
                    $callList = fopen("callList.csv", "a");

                    if(!is_resource($callList))
                    {
                        echo "Could not open file while modifying";
                         exit();
                    }

                    //write new info 
                    $addNameNew = $_POST['companyNameNew'];
                    $addNumNew = $_POST['companyPhoneNew'];
                    $addUpdated = "\n$addNameNew,$addNumNew";
                    fwrite($callList, $addUpdated );
                    fclose($callList); 

                    //read in companies
                    $callList = fopen("callList.csv", "r");
                    $companies = array();
                    
                    if(!is_resource($callList))
                    {
                        echo "Could not open file while modifying";
                         exit();
                    }

                    while($line = fgets($callList))
                    {
                        $companies[] = explode(",", $line);
                    }
                  
                    
                    //close file
                    fclose($callList);

                    //remove old entry of company
                    $removeName = $_POST['companyName'];
                    $removeNum = $_POST['companyPhone'];
                    $indexToRemove = array_search($removeName, array_column($companies, 0));

                    if($indexToRemove !== false){
                        unset($companies[$indexToRemove]);
                       }
                       else{
                        echo "Could not find company to remove";
                       }
                   
                    $callList = fopen("callList.csv", "w"); //open file in write to delete it 
                    foreach($companies as $value){
                        $valueString = implode(",",$value);
                        fwrite($callList, $valueString);
                    }

                    //close file
                    fclose($callList);

                }
            }

            
        ?>

    </body>
</html>