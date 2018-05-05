<?php

require_once ('DBConfig.php');

if (!isset($_POST['Submit'])) {

?>
<html>

<script type="text/javascript">

function GotoHome(){
    window.location = 'index.php?';
}

</script>
<body>
        CSV Format(first line will be ignored, Separator: ","): hosts_name, hosts_ip, hosts_mac, hosts_wakeups_id, hosts_groups_id, hosts_satellites_id, hosts_active
        <br/>
        <br/>
        <form action="" method="post" enctype="multipart/form-data">
            Choose Host Import File: <br />
            <input name="csv" type="file" id="csv" /> <br/> <br/>
            <input type="submit" name="Submit" value="Submit" />
        </form>
        <form id="frmgroups" method="POST" action="index.php" >
        <input class="btn" type="submit" name="save" id="cancel" value="Cancel"
                    onclick=" return GotoHome();"/>
        </form>
    </body>
</html>
<?php
}
else {
if ($_FILES[csv][size] > 0) {
    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file, "r");
    $i = 0;
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if ($i > 0) {
            //delete spaces
            $data[0] = trim($data[0], "\xA0, \x20");
            $data[1] = trim($data[1], "\xA0, \x20");
            $data[2] = trim($data[2], "\xA0, \x20");
            $data[3] = trim($data[3], "\xA0, \x20");
            $data[4] = trim($data[4], "\xA0, \x20");
            $data[5] = trim($data[5], "\xA0, \x20");
            $data[6] = trim($data[6], "\xA0, \x20");

            //check MAC, maybe modify
            if ($data[2][2] != ":")
            {
                $mac = (str_split($data[2],2));
               if(!(count($mac) == 6))
               {
                    echo $data[2] . " wrong MAC Format. Import until wrong mac OK!";
                    exit();
               }
                $data[2] = $mac[0]. ":" . $mac[1] . ":" . $mac[2]. ":" . $mac[3] . ":" . $mac[4]. ":" . $mac[5];
            }
            //delete spaces
            $data[0] = trim($data[0]);
            $data[1] = trim($data[1]);
            $data[2] = trim($data[2]);
            $data[3] = trim($data[3]);
            $data[4] = trim($data[4]);
            $data[5] = trim($data[5]);
            $data[6] = trim($data[6]);

        $sql = "INSERT into
            hosts(hosts_name, hosts_ip, hosts_mac, hosts_wakeups_id, hosts_groups_id, hosts_satellites_id, hosts_active)
            values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]', '$data[6]')";
            if (!mysqli_query($link, $sql))
            {
                echo 'Error Saving Data. ' . mysqli_error($link);
                exit();
            }
        }
        sleep(1);
        $i++;

    }
    fclose($handle);
    print "Import done";
    echo '<form method="post" action="index.php">
          <input type="submit" value="Home" />
          </form>
          </html>';

  }
  else { echo "No File Selected. PLS Go Back an select a file!"; }
}
?>
