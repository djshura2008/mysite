<?php
if (isset($_GET['w']) && !empty($_GET['w'])) {
    $w = protect($_GET['w']);
} else {
    ?>
    <meta http-equiv="Refresh" content="0; url='dashboard.php?cms=themes&w=list'" />
    <?php
}
if ($w == "list") {
    if (isset($_POST['addtheme'])){
      $theme =  $_POST('theme');
     $stmt = $this->connection->prepare("INSERT INTO themes (theme_id, theme_name, default) VALUES (?,?,?)");
                    $stmt->bind_param("sss", $idtheme, $themename, $default);
                    $stmt->execute();
                    $stmt->close();
   
    }
$log_directory = '../themes';

$results_array = array();

if (is_dir($log_directory))
{
        if ($handle = opendir($log_directory))
        {
                //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
                        $results_array[] = $file;
                }
                closedir($handle);
        }
}
?>
 <div class="container">
        <div class="row pt-3">
 <form role="form" id="add_theme_options" method="POST">
<div class="form-group">
<label> Select 
<select name="theme" id="theme" class="form-select" aria-label="select">
  <option selected>Select theme</option>
<?php
//Output findings
foreach($results_array as $value)
{
    if($value === '.' || $value === '..' ){
        continue;
    }
    echo '<option value="'.$value . '">'.ucfirst($value).'</option>';
   
}
?>
</select>

<div class="form-group">
 <button type="submit" id="addtheme" name="addtheme" class="btn btn-primary"><span class = "fas fa-plus-square"></span> Add theme</button>
</div>
</form>
</div>
</div>
<?php
    } elseif ($w == "add") {
        ?>
         <div class="container">
        <div class="row pt-3">
 <form role="form" id="add_theme_options" method="POST">
<div class="form-group">
<select class="form-select" aria-label="select">
  <option selected>Select theme</option>
<?php
//Output findings
foreach($results_array as $value)
{
    if($value === '.' || $value === '..' ){
        continue;
    }
    echo '<option value="'.$value . '">'.ucfirst($value).'</option>';
   
}
?>
</select>
</div>

<div class="form-group">
 <button type="submit" id="addrow" name="addrow" class="btn btn-primary"><span class = "fas fa-plus-square"></span> Add theme</button>
</div>
</form>
</div>
</div>
        <?php
   } elseif ($w == "edit") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        ?>

<script>
function componentFromStr(numStr, percent) {
    var num = Math.max(0, parseInt(numStr, 10));
    return percent ?
        Math.floor(255 * Math.min(100, num) / 100) : Math.min(255, num);
}

function rgbToHex(rgb) {
    var rgbRegex = /^rgb\(\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*,\s*(-?\d+)(%?)\s*\)$/;
    var result, r, g, b, hex = "";
    if ( (result = rgbRegex.exec(rgb)) ) {
        r = componentFromStr(result[1], result[2]);
        g = componentFromStr(result[3], result[4]);
        b = componentFromStr(result[5], result[6]);
    
        hex = "0x" + (0x1000000 + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }
    return hex;
}

document.body.innerHTML = rgbToHex("rgb(255,255,200)");
</script>

        <?php
    }}
    ?>
