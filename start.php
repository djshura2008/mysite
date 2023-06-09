<?php
$_SESSION['language'] = '';
$initweb = 'http://' . $_SERVER['HTTP_HOST'] . '/';
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
$url_path = parse_url($escaped_url, PHP_URL_PATH);
$basename = pathinfo($url_path, PATHINFO_BASENAME);
$active = 1;
$startpage = 1;
$nm = '';

if ($initweb === $url) {
    $spg = $conn->prepare("SELECT * FROM page WHERE startpage = ? AND active = ? ");
    $spg->bind_param("ii", $startpage, $active);
    $spg->execute();
    $rs = $spg->get_result();
    $nm = $rs->num_rows;
    $rpx = $rs->fetch_assoc();
} elseif (isset($_GET['page']) && !empty($_GET['page'])) {
    $id = (int) $_GET['page'];
    $spg = $conn->prepare("SELECT * FROM page WHERE id = ? AND active = ? ");
    $spg->bind_param("ii", $active, $id);
    $spg->execute();
    $rs = $spg->get_result();
    $rpx = $rs->fetch_assoc();
    $namelink = $base . $rpx['link'];
    header("Location: $namelink");
    exit();
} elseif (isset($basename) && !empty($basename)) {
    $spg = $conn->prepare("SELECT * FROM page WHERE link = ? AND active = ? ");
    $spg->bind_param("si", $basename, $active);
    $spg->execute();
    $rs = $spg->get_result();
    $nm = $rs->num_rows;

    if ($nm > 0) {
        $rpx = $rs->fetch_assoc();
    } else {
        $spg = $conn->prepare("SELECT * FROM page WHERE startpage = ? AND active = ? ");
        $spg->bind_param("ii", $startpage, $active);
        $spg->execute();
        $rs = $spg->get_result();
        $nm = $rs->num_rows;
        $rpx = $rs->fetch_assoc();
    }
}

if ($nm > 0) {
    $bid = $rpx['id'];
    $title = $rpx['title'];
    $plink = $rpx['link'];
    $keyword = $rpx['keyword'];
    $classification = $rpx['classification'];
    $description = $rpx['description'];
    $cont = $rpx['type'];
    $menu = $rpx['menu'];
    $content = $rpx['content'];
    $style = $rpx['style'];
    $prnt = $rpx['parent'];
    $lng = $rpx['language'];

    $language = $_SESSION["language"] = $lng;
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<?php include 'elements/metalink.php'; 

 if (!empty($description)) { ?>
                <meta name="description" content="<?php echo $description; ?>" />
            <?php } else { ?>
                <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>" />
                <?php
            }
            if (!empty($keyword)) {
                ?>
                <meta name="keywords" content="<?php echo $keyword; ?>" />
            <?php } else { ?>
                <meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>" />
                <?php
            }
            if (!empty($classification)) {
                ?>
                <meta name="classification" content="<?php echo $classification; ?>" />
            <?php } else { ?>
                <meta name="classification" content="<?php echo SITE_CLASSIFICATION; ?>" />
            <?php } ?>
            <title><?php echo $title; ?></title>
<link href="<?php echo SITE_PATH; ?>assets/css/theme.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo SITE_PATH; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH; ?>assets/plugins/font-awesome/css/font-awesome.min.css" />
            <script src="<?php echo SITE_PATH; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?php echo SITE_PATH; ?>assets/js/popper.min.js" type="text/javascript"></script> 
           <script src="<?php echo SITE_PATH; ?>assets/plugins/jquery/jquery.min.js" type="text/javascript"></script>
           <script>
               jQuery.htmlPrefilter = function( html ) {
                    return html;
                };
                     
           </script>
        <style type="text/css">
        .dropdown:hover >.dropdown-menu{
          display: block !important;
        }

        .dropdown-submenu:hover > .dropdown-menu{
          display: block !important;
            left: 100%;
            margin-top: -37px;
        }

        .dropdown-item{
          font-size: small; /* 13px */
        }

        .dropdown-toggle::after{
          font-size: var(--font-md);
          margin-bottom: -2px;
        }

        .dropdown-menu li a.active{
          color:#fff;
        }

        .custom-toggle-arrow{
              font-size: 18px;
              margin-top: 1px;
              line-height: 12px;
        }

        .dropdown-hover-all .dropdown-menu, .dropdown-hover>.dropdown-menu.dropend {
                margin-left: -1px !important
        }

        .dropdown-menu li {
        position: relative;
        }

        .dropdown-menu .dropdown-submenu {
        display: none;
        position: absolute;
        left: 100%;
        top: -7px;
        }

        .dropdown-menu .dropdown-submenu-left {
        right: 100%;
        left: auto;
        }

        .dropdown-menu > li:hover > .dropdown-submenu {
        display: block;
        }

        .dropdown-hover:hover>.dropdown-menu {
        display: inline-block;
        }

        .dropdown-hover>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
        }
        /* ============ desktop view ============ */
        @media all and (min-width: 992px) {

                .dropdown-menu li{
                        position: relative;
                }
                .dropdown-menu .dropdown-submenu{ 
                        display: none;
                        position: absolute;
                        left:100%; top:-7px;
                }
                .dropdown-menu .dropdown-submenu-left{ 
                        right:100%; left:auto;
                }

                .dropdown-menu > li:hover{ background-color: #f1f1f1 }
                .dropdown-menu > li:hover > .dropdown-submenu{
                        display: block;
                }
        }	
        /* ============ desktop view .end// ============ */

        /* ============ small devices ============ */
        @media (max-width: 991px) {

        .dropdown-menu .dropdown-submenu{
                        margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
        }

        }	
        /* ============ small devices .end// ============ */

        </style>
        <script src="<?php echo SITE_PATH; ?>assets/js/menu.js" type="text/javascript"></script>
                   <style>
                       #wrapper, .container-fluid{
                           margin:0;
                           padding:0;
                       }

                       <?php
                       echo decodeContent($style). "\n";
                       ?>
                   </style>
               </head>
               <body>
                   <div id="wrapper"> 
                       <?php
                       require 'elements/menu.php';
                       ?>
                       <div class='container-fluid'>
                           <?php
                           echo decodeContent($content) . "\n";
                           ?>
                       </div>
                   </div>
                   <script>
                       $( document ).ready(function() {
                           $( '#wrapper body' ).remove();                     
                                });
                       //Start
                      // A simple script was added that removes the ids inside the wrapper added by Grapesjs, if you don't want this script you can remove.
                       setTimeout(function(){
                                $('#wrapper').find('*').removeAttr("id");
                                
                        }, 0);
                      //End
                   </script>
               </body>
           </html>
    <?php
} else {
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>   
            <?php include 'elements/metalink.php'; ?>     
            <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>" />           
            <meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>" />           
            <meta name="classification" content="<?php echo SITE_CLASSIFICATION; ?>" />

            <title><?php echo SITE_NAME; ?></title>
            <link href="<?php echo SITE_PATH; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" type="text/css" href="<?php echo SITE_PATH; ?>assets/font-awesome/css/font-awesome.min.css" />
            <script src="<?php echo SITE_PATH; ?>assets/plugins/jquery/jquery.min.js" type="text/javascript"></script>
            <script src="<?php echo SITE_PATH; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?php echo SITE_PATH; ?>assets/js/popper.min.js" type="text/javascript"></script> 
        </head>
        <body>
            <div class="wrapper"> 
                <?php
                require 'elements/navbar.php';
                ?>
                <div class='container'>
                    <div class="row">
                        <div  class="col-12 text-center">
                            <?php echo $initweb . ' - ' . SITE_PATH; ?>
                            <h3> Start creating your first page of content </h3>
                            <a href="signin/login.php">Login</a> - <a href="admin/dashboard.php">Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
           
        </body>
    </html>
    <?php
}
?>

