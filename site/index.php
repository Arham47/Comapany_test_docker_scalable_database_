<?php

$servername = "db";
$username = "root";
$password = "12345";
$dbname = "docker_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$keysArray = [];

if (($open = fopen("source-1.csv", "r")) !== false)
{

    while (($data = fgetcsv($open, 1000, ",")) !== false)
    {
        $array[] = $data;

    }
       foreach ($array[0] as $a)
    {
        $b = str_replace(' ', '_', $a);
        array_push($keysArray, $b);
        // $name .= $b . " VARCHAR(30) NOT NULL,";
        
    }
    //use in end
    // $name=substr($name, 0, -1);
    //for
    $json = file_get_contents('source-2.json');

    // Decode the JSON file
    $json_data = json_decode($json, true);
  
    // print_r($json_data);
    // for($i=1)
    // Display data
    $source2 = 'source-2.csv';
    // File pointer in writable mode
    $file_pointer = fopen($source2, 'w');
    // Traverse through the associative
    // array using for each loop
    $keys = array_keys($json_data[0]);
    // print_r($keys);
    foreach ($keys as $a)
    {
        $b = str_replace(' ', '_', $a);

        array_push($keysArray, $b);
        // $name .= $b . " VARCHAR(30) NOT NULL,";
        
    }
    $source3 = 'source-3.csv';
    $json1 = file_get_contents('source-3.json');

    // Decode the JSON file
    $json_data1 = json_decode($json1, true);

   

    // File pointer in writable mode
    // $file_pointer = fopen($source3, 'w');
    // Traverse through the associative
    // array using for each loop
    $keys = array_keys($json_data1[0]);
    // print_r($keys);
    foreach ($keys as $a)
    {
        $b = str_replace(' ', '_', $a);
        array_push($keysArray, $b);
        // $name .= $b . " VARCHAR(30) NOT NULL,";
        
    };

    //  echo $name;
    $file = fopen('source-2.csv', 'w');
    // foreach ($keysArray as $line) {
    //put data into csv file
    fputcsv($file, $keysArray);
    // }
    fclose($file);
    // print_r($keysArray);
    $c = array_unique($keysArray);
    $name8 = "";
    foreach ($c as $a)
    {
        $name7 = str_replace(' ', '_', $a);

        $name8 .= $name7 . " VARCHAR(30),";
    }
    $name8 = substr($name8, 0, -1);

    // foreach($json_data as $i){
    //   // Write the data to the CSV file
    //   fputcsv($file_pointer, $i);
    // }
    // fclose($file_pointer);
    

    $sql = "CREATE TABLE carsCsv (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     " . $name8 . ")";
    if ($conn->query($sql) === true)
    {
        echo "Table carsCsv created successfully";
    }
    else
    {
        echo "Error creating table: " . $conn->error;
    }

    // converting json to csv
    $csv = 'source-2.csv';

    // File pointer in writable mode
    $file_pointer = fopen($csv, 'w');

    // Traverse through the associative
    // array using for each loop
    // foreach($keysArray as $i){
    fputcsv($file_pointer, $keysArray);
    // exit();
    // Write the data to the CSV file
    // }
    foreach ($json_data as $i)
    {
        // fputcsv($file_pointer, $i);
        $n = 1;
        // exit();
        foreach ($json_data1 as $o)
        {
            $x = array_merge($array[$n], $i, $o);
            fputcsv($file_pointer, $x);
            break;

            // exit();
            // Write the data to the CSV file
            
        }
        $n++;
        // Write the data to the CSV file
        
    }
    // Close the file pointer.
    echo "unified file of one csv and 2 json file is created";
    $name = "";
    // print_r($array);
    //inserting data of source -1

    for ($i = 1;$i <= sizeof($array) - 1;$i++)
    {
        $str = '';
        for ($j = 0;$j <= sizeof($array[0]) - 1;$j++)
        {
            if ($i == 1)
            {
                $name .= $array[0][$j] . ",";
                $bname = substr($name, 0, -1);
                $bname = str_replace(' ', '_', $bname);

            }

            $str .= "'" . $array[$i][$j] . "',";

        }
        $bstr = substr($str, 0, -1);

        $sql = "INSERT INTO `carscsv`( " . $bname . ") VALUES (" . $bstr . ")";
        // echo $sql;
        if ($conn->query($sql) === true)
        {
            echo "Table carsCsv data added source 1 successfully";
        }
        else
        {
            echo "Error adding  table: " . $conn->error;
        }
    }
    $name1 = "";
    $value1 = "";
    //inserting data of source -2
    for ($i = 0;$i <= sizeof($json_data) - 1;$i++)
    {
        foreach ($json_data[$i] as $key => $val)
        {
            $name1 .= $key . ',';
            $name1 = str_replace(' ', '_', $name1);
            $value1 .= "'" . $val . "',";

        }
        $value1 = substr($value1, 0, -1);
        $name1 = substr($name1, 0, -1);
        $sql = "INSERT INTO `carscsv`( " . $name1 . ") VALUES (" . $value1 . ")";
        if ($conn->query($sql) === true)
        {
            echo "Table carsCsv data added source 2 successfully";
            $name1 = "";
            $value1 = "";
        }
        else
        {
            echo "Error adding  table: " . $conn->error;
        }
    }
    $name2 = "";
    $value2 = "";
    // inserting data of source 3
    for ($i = 0;$i <= sizeof($json_data1) - 1;$i++)
    {
        foreach ($json_data1[$i] as $key => $val)
        {
            $name2 .= $key . ',';
            $name2 = str_replace(' ', '_', $name2);
            $value2 .= "'" . $val . "',";

        }
        $value2 = substr($value2, 0, -1);
        $name2 = substr($name2, 0, -1);
        $sql = "INSERT INTO `carscsv`( " . $name2 . ") VALUES (" . $value2 . ")";
        if ($conn->query($sql) === true)
        {
            $name2 = "";
            $value2 = "";
            echo "Table carsCsv data added source 3 successfully";
        }
        else
        {
            echo "Error adding  table: " . $conn->error;
        }
    }
  


    fclose($file_pointer);
    fclose($open);

}
// form to add car
echo '<form action="index.php" method= "post">
<h1>add car</h1>
';
foreach($c as $l){
    echo '<input type="text" id="'.$l.'"  name="'.$l.'" value="">
    <label for="'.$l.'">'.$l.'</label><br>';
}

echo '
</br>
<input type="submit" name="submit" value="add">
</form>';
echo '<form action="index.php" method="post">
<input type="submit" name="submit" value="retrieve">
</form>';
if(isset($_POST['submit']) && $_POST['submit']=="add"){
    $value11="";
    $name11="";
    foreach($_POST as $add){
      $value11.="'".$add."',";
    }

    $value11 = substr($value11, 0, -7);
    // echo $value11;
    foreach($c as $l){
        $name11.=$l.',';
    }    
    $name11 = substr($name11, 0, -1);
    // echo $name11;
    $sql = "INSERT INTO `carscsv`( " . $name11 . ") VALUES (" . $value11 . ")";

    if ($conn->query($sql) === true)
    {
        echo "Car successfully added";
        $name1 = "";
        $value1 = "";
    }
    else
    {
        echo "Error adding  table: " . $conn->error;
    }

   

}
// to retrieve data from data base
if(isset($_POST['submit']) && $_POST['submit']=="retrieve"){
    $sql="SELECT * FROM `carscsv`";
    if ($result=$conn->query($sql))
    { while($row=$result->fetch_assoc()){
       $header="";
       $data.="";
       $count=0;
        foreach($row as $key=>$val){
            
            $n=0;
           $header.="<th>".$key."</th>";

           $count++;
           if($key=='id'){
            $n++;
            if($n==2){
                break;
            }
           }
           

        }
        $data.="<tr>";
        foreach($row as $key=>$val){
            
           
           $data.="<td>".$val."</td>";

           
           

        }
        $data.="</tr>";
    }
   echo $count;
        
        // $header=
    //   for
        echo "<table>
        <tr>
      ".$header."
        </tr>
      ".$data."
    
      </table>
      ";
    }
    else
    {
        echo "Error adding  table: " . $conn->error;
    }
}

// echo "<pre>";
//To display array data
// var_dump($array[0]);
// echo "</pre>";
$conn->close();

?>
