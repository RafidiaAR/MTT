<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Admin JualBeli MTT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Shoppy Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- Custom Theme files -->
<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!--js-->
<script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script> 
<!--icons-css-->
<link href="<?php echo base_url() ?>assets/css/font-awesome.css" rel="stylesheet"> 
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
<!--static chart-->
<script src="<?php echo base_url() ?>assets/js/Chart.min.js"></script>
<!--//charts-->
<!-- geo chart -->
    <script src="//cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script>window.modernizr || document.write('<script src="lib/modernizr/modernizr-custom.js"><\/script>')</script>
    <!--<script src="lib/html5shiv/html5shiv.js"></script>-->
     <!-- Chartinator  -->
    <script src="<?php echo base_url() ?>assets/js/chartinator.js" ></script>
    <script type="text/javascript">
        jQuery(function ($) {

            var chart3 = $('#geoChart').chartinator({
                tableSel: '.geoChart',

                columns: [{role: 'tooltip', type: 'string'}],
         
                colIndexes: [2],
             
                rows: [
                    ['China - 2015'],
                    ['Colombia - 2015'],
                    ['France - 2015'],
                    ['Italy - 2015'],
                    ['Japan - 2015'],
                    ['Kazakhstan - 2015'],
                    ['Mexico - 2015'],
                    ['Poland - 2015'],
                    ['Russia - 2015'],
                    ['Spain - 2015'],
                    ['Tanzania - 2015'],
                    ['Turkey - 2015']],
              
                ignoreCol: [2],
              
                chartType: 'GeoChart',
              
                chartAspectRatio: 1.5,
             
                chartZoom: 1.75,
             
                chartOffset: [-12,0],
             
                chartOptions: {
                  
                    width: null,
                 
                    backgroundColor: '#fff',
                 
                    datalessRegionColor: '#F5F5F5',
               
                    region: 'world',
                  
                    resolution: 'countries',
                 
                    legend: 'none',

                    colorAxis: {
                       
                        colors: ['#679CCA', '#337AB7']
                    },
                    tooltip: {
                     
                        trigger: 'focus',

                        isHtml: true
                    }
                }

               
            });                       
        });
    </script>
<!--geo chart-->

<!--skycons-icons-->
<script src="<?php echo base_url() ?>assets/js/skycons.js"></script>
<!--//skycons-icons-->
</head>
<body>  
<div class="page-container">  
   <div class="left-content">
     <div class="mother-grid-inner">
            <!--header start here-->
        <div class="header-main ">
          <div class="header-left">
              <div class="logo-name">
                   <a href="<?php echo base_url()?>/index.php/Page/"> <h1>JualBeli MTT</h1> 
                  <!--<img id="logo" src="" alt="Logo"/>--> 
                  </a>                
              </div>
              <!--search-box-->
                <!-- <div class="search-box">
                  <form>
                    <input type="text" placeholder="Search..." required=""> 
                    <input type="submit" value="">          
                  </form>
                </div> --><!--//end-search-box-->
              <div class="clearfix"> </div>
             </div>
             <div class="header-right">
              <div class="profile_details_left"><!--notifications of menu start -->
                <ul class="nofitications-dropdown">
                 <!--  <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <div class="notification_header">
                          <h3>You have 3 new messages</h3>
                        </div>
                      </li>
                      <li><a href="#">
                         <div class="user_img"><img src="<?php echo base_url() ?>assets/images/p4.png" alt=""></div>
                         <div class="notification_desc">
                        <p>Lorem ipsum dolor</p>
                        <p><span>1 hour ago</span></p>
                        </div>
                         <div class="clearfix"></div> 
                      </a></li>
                      <li class="odd"><a href="#">
                        <div class="user_img"><img src="images/p2.png" alt=""></div>
                         <div class="notification_desc">
                        <p>Lorem ipsum dolor </p>
                        <p><span>1 hour ago</span></p>
                        </div>
                        <div class="clearfix"></div>  
                      </a></li>
                      <li><a href="#">
                         <div class="user_img"><img src="images/p3.png" alt=""></div>
                         <div class="notification_desc">
                        <p>Lorem ipsum dolor</p>
                        <p><span>1 hour ago</span></p>
                        </div>
                         <div class="clearfix"></div> 
                      </a></li>
                      <li>
                        <div class="notification_bottom">
                          <a href="#">See all messages</a>
                        </div> 
                      </li>
                    </ul>
                  </li> -->
                  <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge"><?php echo $trans;?></span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <div class="notification_header">
                          <h3>You have <?php echo $trans;?> new notification</h3>
                        </div>
                      </li>
                      <li><a href="#">
                        <div class="user_img"><img src="images/p5.png" alt=""></div>
                         <div class="notification_desc">
                        <p>Ada pemesanan dari <span>ADMIN</span></p>
                        <p><span>1 hour ago</span></p>
                        </div>
                        <div class="clearfix"></div>  
                       </a></li>    
                       <li>
                        <div class="notification_bottom">
                          <a href="<?php echo base_url();?>index.php/Progress/transaction">See all notifications</a>
                        </div> 
                      </li>
                    </ul>
                  </li> 
                  <!-- <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">9</span></a>
                    <ul class="dropdown-menu">
                      <li>
                        <div class="notification_header">
                          <h3>You have 8 pending task</h3>
                        </div>
                      </li>
                      <li><a href="#">
                        <div class="task-info">
                          <span class="task-desc">Database update</span><span class="percentage">40%</span>
                          <div class="clearfix"></div>  
                        </div>
                        <div class="progress progress-striped active">
                          <div class="bar yellow" style="width:40%;"></div>
                        </div>
                      </a></li>
                      <li><a href="#">
                        <div class="task-info">
                          <span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
                           <div class="clearfix"></div> 
                        </div>
                        <div class="progress progress-striped active">
                           <div class="bar green" style="width:90%;"></div>
                        </div>
                      </a></li>
                      <li><a href="#">
                        <div class="task-info">
                          <span class="task-desc">Mobile App</span><span class="percentage">33%</span>
                          <div class="clearfix"></div>  
                        </div>
                         <div class="progress progress-striped active">
                           <div class="bar red" style="width: 33%;"></div>
                        </div>
                      </a></li>
                      <li><a href="#">
                        <div class="task-info">
                          <span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
                           <div class="clearfix"></div> 
                        </div>
                        <div class="progress progress-striped active">
                           <div class="bar  blue" style="width: 80%;"></div>
                        </div>
                      </a></li>
                      <li>
                        <div class="notification_bottom">
                          <a href="#">See all pending tasks</a>
                        </div> 
                      </li>
                    </ul>
                  </li>  -->
                </ul>
                <div class="clearfix"> </div>
              </div>
              <!--notification menu end -->
              <div class="profile_details">   
                <ul>
                  <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <div class="profile_img"> 
                        <span class="prfil-img"><img src="images/p1.png" alt=""> </span> 
                        <div class="user-name">
                          <p><?php echo $username;?></p>
                          <span><?php echo $nameAccess; ?></span>
                        </div>
                        <i class="fa fa-angle-down lnr"></i>
                        <i class="fa fa-angle-up lnr"></i>
                        <div class="clearfix"></div>  
                      </div>  
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                     
                      <li> <a href="<?php echo base_url();?>index.php/progress/profile"><i class="fa fa-user"></i> Profile</a> </li> 
                      <li> <a href="<?php echo base_url(); ?>index.php/Auth/Logout"><i class="fa fa-sign-out"></i> Logout</a> </li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="clearfix"> </div>       
            </div>
             <div class="clearfix"> </div>  
        </div>
<!--heder end here-->
<!-- script-for sticky-nav -->
    <script>
    $(document).ready(function() {
       var navoffeset=$("header-main").offset().top;
       $(window).scroll(function(){
        var scrollpos=$(window).scrollTop(); 
        if(scrollpos >=navoffeset){
          $(".header-main").addClass("fixed");
        }else{
          $(".header-main").removeClass("fixed");
        }
       });
       
    });
    </script>
    <!-- /script-for sticky-nav -->
<!--inner block start here-->
<?php $this->load->view($main_view); ?>

<div class="clearfix"> </div>
<!--inner block end here-->
<!--copy rights start here-->
<div class="copyrights">
   <p>© 2017 JualBeli MTT. All Rights Reserved | Design by  <a href="http://mtt.or.id/" target="_blank">MTT Digital</a> </p>
</div>  
<!--COPY rights end here-->
</div>
</div>
<!--slider menu-->
<!-- Administraion SideBar Start -->
<?php if($this->session->userdata('leveluser') == 1) : ?>
<div class="sidebar-menu">
        <div class="logo"> <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="#"> <span id="logo" ></span> 
            <!--<img id="logo" src="" alt="Logo"/>--> 
        </a> </div>     
        <div class="menu ">
          <ul id="menu" >
            <li id="menu-home" ><a href="<?php echo base_url(); ?>index.php/page" title="Dashboard"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="<?php echo base_url(); ?>index.php/Admin/Product_List"><i class="fa fa-list" title="Products"></i><span>Products</span><span class="fa fa-angle-right" style="float: right"></span></a>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/Product_List">All Product  <span class="badge"><?php echo $A_AmountProduct; ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/progress/add_product">Add Product </a></li>                
              </ul>
            </li>
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/Admin/List_Merchant" title="Feedback"><i class="fa fa-user"></i><span>User </span><span class="fa fa-angle-right" style="float: right"></span></a>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/List_Merchant">Merchant <span class="badge"><?php echo $CMerchant; ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/List_Buyer">Buyer <span class="badge"><?php echo $CBuyer; ?></span></a></li>                
              </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php/Admin/Transaction_Masuk"><i class="fa fa-cart-arrow-down" title="Transaction"></i><span>Transaction
            </span><span class="fa fa-angle-right" style="float: right"></span></a>
              <ul>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/Transaction_Masuk">Order Masuk <span class="badge"><?php echo $Confirm;?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/Transaction_Kirim">Proses Kirim <span class="badge"><?php echo $Sent; ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/Transaction_Success">Selesai <span class="badge"><?php echo $Finish ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/Admin/Transaction_Batal">Order Dibatalkan <span class="badge"><?php echo $Cancel ?></span></a></li>                
              </ul>
            </li>
            <!--  <li><a href="#"><i class="fa fa-envelope"></i><span>Message</span><span class="fa fa-angle-right" style="float: right"></span></a>
               <ul id="menu-academico-sub" >
                  <li id="menu-academico-avaliacoes" ><a href="inbox.html">Inbox</a></li>
                  <li id="menu-academico-boletim" ><a href="inbox-details.html">Send email</a></li>
                 </ul>
            </li> -->
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/Admin/Discussion" title="Discussion"><i class="fa fa-comments"></i><span>Discussion</span><span class="badge">1</span></a></li>
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/Admin/Feedback" title="Feedback"><i class="fa fa-arrow-circle-down"></i><span>Feedback</span></a></li>
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/Admin/Broadcast" title="Feedback" data-toggle="modal" data-target="#Broadcast"><i class="fa fa-bullhorn"></i><span>Broadcast</span></a></li>

          </ul>
        </div>
   </div>
  <div class="clearfix"> </div>
</div>
<?php endif ?>
<!-- Administration SideBar End -->
<!-- Merchant SideBar Start -->
<?php if($this->session->userdata('leveluser') == 0 || $this->session->userdata('leveluser') == NULL ): ?>
<div class="sidebar-menu">
        <div class="logo"> <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="#"> <span id="logo" ></span> 
            <!--<img id="logo" src="" alt="Logo"/>--> 
        </a> </div>     
        <div class="menu ">
          <ul id="menu" >
            <li id="menu-home" ><a href="<?php echo base_url(); ?>index.php/page" title="Dashboard"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="#"><i class="fa fa-list" title="Products"></i><span>Products</span><span class="fa fa-angle-right" style="float: right"></span></a>
              <ul>
                <li><a href="<?php echo base_url(); ?>index.php/page/product_list">Products List</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/progress/add_product">Add Product</a></li>                
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-cart-arrow-down" title="Transaction"></i><span>Transaction
            <span class="badge"><?php echo $Confirm; ?> </span> 
            </span><span class="fa fa-angle-right" style="float: right"></span></a>
              <ul>
                <li><a href="<?php echo base_url(); ?>index.php/progress/transaction">Order Masuk <span class="badge"><?php echo $Confirm;?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/progress/OrderSent">Proses Kirim <span class="badge"><?php echo $Sent; ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/progress/OrderFinish">Selesai <span class="badge"><?php echo $Finish ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/progress/OrderCancel">Order Dibatalkan <span class="badge"><?php echo $Cancel ?></span></a></li>                
              </ul>
            </li>
            <!--  <li><a href="#"><i class="fa fa-envelope"></i><span>Message</span><span class="fa fa-angle-right" style="float: right"></span></a>
               <ul id="menu-academico-sub" >
                  <li id="menu-academico-avaliacoes" ><a href="inbox.html">Inbox</a></li>
                  <li id="menu-academico-boletim" ><a href="inbox-details.html">Send email</a></li>
                 </ul>
            </li> -->
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/progress/discussion" title="Discussion"><i class="fa fa-comments"></i><span>Discussion</span><span class="badge">1</span></a></li>
            <li id="menu-comunicacao" ><a href="<?php echo base_url(); ?>index.php/progress/feedback" title="Feedback"><i class="fa fa-arrow-circle-down"></i><span>Feedback</span></a></li>

          </ul>
        </div>
   </div>
  <div class="clearfix"> </div>
</div>
<?php endif ?>
<!-- Merchant SideBar End -->  


  


<script>
var toggle = true;
            
$(".sidebar-icon").click(function() {                
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
    $("#menu span").css({"position":"absolute"});
  }
  else
  {
    $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
    }, 400);
  }               
                toggle = !toggle;
            });
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<!--scrolling js-->
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
    <!--//scrolling js-->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"> </script>
<!-- mother grid end here-->
</body>
</html>      