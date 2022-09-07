
<!DOCTYPE html>
<html>
<header>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<style>
.menu{
    position: relative;
    width: auto;
    height: auto;
    text-align: center;
}
.dropbtn {
  background-color: #055099;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
}
.dropdown {
  position: relative;
  display: inline-block;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  text-align: center;
}
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
.dropdown-content a:hover {background-color: #ddd;}
.dropdown:hover .dropdown-content {display: block;}
.dropdown:hover .dropbtn {background-color: #06038D;}
.logo{
    
    margin: auto;
    height: auto;
    position: absolute;
    
}
.loginbtn {
    margin: auto;
    background-color: #ddd;
    border: none;
    position: absolute;
    right: 0;
}
.loginbtn a{
    text-decoration: none;
    color: black;
    font-size: 16px;
}
</style>
</header>
<body>

<div class="logo">
<h1><a href="homepage.php"><img src="uploads/kisspng-windows-98-windows-95-microsoft-windows-7-vaporwave-5b46b3e1015810.1044725315313602250055.png" width="40px" height="40px" alt=""></a></h1>
</div>

<div class="menu">
<div class="dropdown">
  <button class="dropbtn">Product</button>
  <div class="dropdown-content">
    <a href="product_create.php">Product Create</a>
    <a href="product_read.php">Product Read</a>
    <!-- <a href="product_update.php">Product Edit</a> -->
  </div>
</div>

<div class="dropdown">
  <button class="dropbtn">Customer</button>
  <div class="dropdown-content">
    <a href="customer_create.php">Customer Create</a>
    <a href="customer_read.php">Customer Read</a>
    <!-- <a href="customer_update.php">Customer Edit</a> -->
  </div>
</div>

<div class="dropdown">
  <button class="dropbtn">Orders</button>
  <div class="dropdown-content">
    <a href="create_order.php">Orders Create</a>
    <a href="order_read.php">Orders Read</a>
    <!-- <a href="customer_update.php">Customer Edit</a> -->
  </div>
</div>

<div>
  
<button class="loginbtn"><a href="logout.php">Log Out</a></button>

</div>
</div><!-- end menu -->


</body>
</html>