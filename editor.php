
<?php

 require('head.php');
 require('db_connect.php');
 session_start();

 $image_up='';
 $user_id = $_SESSION['user_id'];
 $user_name =$_SESSION['user_name'];
 $text='';
 $url='';
 $x='';
 $y='';
 $txt='';

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_POST['enter'])){
  $text=$_POST['text'];
  $txt="text";
  setcookie($txt,$text);
 
}

if(isset($_GET['id']) && $_GET['id']!=''){
    $id=get_safe_value($conn,$_GET['id']);
    $res=mysqli_query($conn,"select * from uploads where id='$id'");
    $ress=mysqli_query($conn,"select * from images where id='$id'");
	$check=mysqli_num_rows($res);
  if($check>0){
		$row=mysqli_fetch_assoc($res);
    $image_up='upload/'.$row['image_up'];
    
if(isset($_POST['save'])){
  
  $img = imagecreatefromjpeg($image_up);
  
  //  WRITE TEXT

  $tsxt=$_COOKIE["text"];
  $fontFile ="fonts/Arial.ttf" ;
  $fontSize = 20;
  $fontColor = imagecolorallocate($img, 0, 0, 0);
  $x= $_COOKIE["left"];
  $y= $_COOKIE["Top"];
  $num = $x;
  $intx = (int)$num;
  $num = $y;
  $inty = (int)$num;
  $posX = $intx;
  $posY = $inty;
  $angle = 0;

  imagestring($img,$fontSize,$intx,$inty,$tsxt,$fontColor);


  //  SAVE TO A FILE

$quality = 100; // 0 to 100
$name=uniqid().'.jpeg';
imagejpeg($img,"memescreated/".$name,$quality);
imagedestroy($img);
 $sql="INSERT INTO `createdmemes`( `filter`, `memes`) VALUES ('$user_name','$name')";
  mysqli_query($conn,$sql);
  header("Location: mymemes.php");
  }
    
  }else{
    $rows=mysqli_fetch_assoc($ress);
    $url=$rows['url'];
    
if(isset($_POST['save'])){
  
  $img = imagecreatefromjpeg($url);
  
  //  WRITE TEXT

  $tsxt=$_COOKIE["text"];
  $fontFile ="fonts/Arial.ttf" ;
  $fontSize = 20;
  $fontColor = imagecolorallocate($img, 0, 0, 0);
  $x= $_COOKIE["left"];
  $y= $_COOKIE["Top"];
  $num = $x;
  $intx = (int)$num;
  $num = $y;
  $inty = (int)$num;
  $posX = $intx;
  $posY = $inty;
  $angle = 0;

  imagestring($img,$fontSize,$intx,$inty,$tsxt,$fontColor);


  //  SAVE TO A FILE

$quality = 100; // 0 to 100
$name=uniqid().'.jpeg';
imagejpeg($img,"memescreated/".$name,$quality);
imagedestroy($img);
 $sql="INSERT INTO `createdmemes`( `filter`, `memes`) VALUES ('$user_name','$name')";
  mysqli_query($conn,$sql);
  header("Location: mymemes.php");
  }
  }
}



?>
<body>
<div class="header">
   
   <div class="container main-header">
       <a href="index.php" class="logo">
           <img src="images/logo.png" alt="not found">
           <h4>Project</h4>
       </a>
       <nav class="navbar">
           <span class="menu" id="menu"><i class="fas fa-bars"></i></span>
           <ul class="menu-drp" id="menu-drp">
               <a href="index.php" class="inactive active">Home</a>
               <a href="mymemes.php" class="inactive btn-nav">My Memes</a>
               <div class="user-details">
                  <button  class="inactive " id="btn1"><?php echo $user_name  ?></button>
                  <div class="user-detail-drpdwn">
                  <a href="user_details.php" class="inactive bdr">User Details</a>
                  <a href="endsession.php" class="inactive bdr">Logout</a> 
                   </div>
               </div>
           </ul>
       </nav>
   </div>
</div>

<div class="container1">
  <img class="img1" src="<?php echo $image_up.$url ?>" alt="" >
  
   <p id="#img1" class="hover-text" style="position:absolute;"><?php echo $text;   ?></p>
</div>
<div class="container1 form-text">
<form method="post" action="">
  <label for="text">Enter your text:</label>
  <input type="text" name="text" id="">
  <button class="inactive btn-nav" name="enter" type="submit">Enter</button>
</form>
</div>
<div class="container1 form-text">
<form method="post" action="">
  <label for="submit">Save your Meme:</label>
  <button class="inactive btn-nav" name="save" type="submit">Save</button>
</form>
</div>


   <script src="js/jquery.js"></script> 
  <script src="js/jquery-ui.js"></script>
   
<script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="js/plugins.js" type="text/javascript"></script>
      <script src="js/main.js" type="text/javascript"></script>
      <script type="text/javascript">
           (function(){
  $("#btn1").on("click", function() {
    $(".user-detail-drpdwn").fadeToggle( "fast", "linear" ).css('display', 'flex');
  }); 
})();
$('.img1').filter(function(index){return $(this).attr('src')==='';}).hide();
$('.img2').filter(function(index){return $(this).attr('src')==='';}).hide();
</script>
        
<script>
    (function ($) {

// Detect touch support
$.support.touch = 'ontouchend' in document;

// Ignore browsers without touch support
if (!$.support.touch) {
  return;
}

var mouseProto = $.ui.mouse.prototype,
    _mouseInit = mouseProto._mouseInit,
    _mouseDestroy = mouseProto._mouseDestroy,
    touchHandled;

/**
 * Simulate a mouse event based on a corresponding touch event
 * @param {Object} event A touch event
 * @param {String} simulatedType The corresponding mouse event
 */
function simulateMouseEvent (event, simulatedType) {

  // Ignore multi-touch events
  if (event.originalEvent.touches.length > 1) {
    return;
  }

  event.preventDefault();

  var touch = event.originalEvent.changedTouches[0],
      simulatedEvent = document.createEvent('MouseEvents');
  
  // Initialize the simulated mouse event using the touch event's coordinates
  simulatedEvent.initMouseEvent(
    simulatedType,    // type
    true,             // bubbles                    
    true,             // cancelable                 
    window,           // view                       
    1,                // detail                     
    touch.screenX,    // screenX                    
    touch.screenY,    // screenY                    
    touch.clientX,    // clientX                    
    touch.clientY,    // clientY                    
    false,            // ctrlKey                    
    false,            // altKey                     
    false,            // shiftKey                   
    false,            // metaKey                    
    0,                // button                     
    null              // relatedTarget              
  );

  // Dispatch the simulated event to the target element
  event.target.dispatchEvent(simulatedEvent);
}

/**
 * Handle the jQuery UI hover-text's touchstart events
 * @param {Object} event The hover-text element's touchstart event
 */
mouseProto._touchStart = function (event) {

  var self = this;

  // Ignore the event if another hover-text is already being handled
  if (touchHandled || !self._mouseCapture(event.originalEvent.changedTouches[0])) {
    return;
  }

  // Set the flag to prevent other hover-texts from inheriting the touch event
  touchHandled = true;

  // Track movement to determine if interaction was a click
  self._touchMoved = false;

  // Simulate the mouseover event
  simulateMouseEvent(event, 'mouseover');

  // Simulate the mousemove event
  simulateMouseEvent(event, 'mousemove');

  // Simulate the mousedown event
  simulateMouseEvent(event, 'mousedown');
};

/**
 * Handle the jQuery UI hover-text's touchmove events
 * @param {Object} event The document's touchmove event
 */
mouseProto._touchMove = function (event) {

  // Ignore event if not handled
  if (!touchHandled) {
    return;
  }

  // Interaction was not a click
  this._touchMoved = true;

  // Simulate the mousemove event
  simulateMouseEvent(event, 'mousemove');
};

/**
 * Handle the jQuery UI hover-text's touchend events
 * @param {Object} event The document's touchend event
 */
mouseProto._touchEnd = function (event) {

  // Ignore event if not handled
  if (!touchHandled) {
    return;
  }

  // Simulate the mouseup event
  simulateMouseEvent(event, 'mouseup');

  // Simulate the mouseout event
  simulateMouseEvent(event, 'mouseout');

  // If the touch interaction did not move, it should trigger a click
  if (!this._touchMoved) {

    // Simulate the click event
    simulateMouseEvent(event, 'click');
  }

  // Unset the flag to allow other hover-texts to inherit the touch event
  touchHandled = false;
};

/**
 * A duck punch of the $.ui.mouse _mouseInit method to support touch events.
 * This method extends the hover-text with bound touch event handlers that
 * translate touch events to mouse events and pass them to the hover-text's
 * original mouse event handling methods.
 */
mouseProto._mouseInit = function () {
  
  var self = this;

  // Delegate the touch handlers to the hover-text's element
  self.element.bind({
    touchstart: $.proxy(self, '_touchStart'),
    touchmove: $.proxy(self, '_touchMove'),
    touchend: $.proxy(self, '_touchEnd')
  });

  // Call the original $.ui.mouse init method
  _mouseInit.call(self);
};

/**
 * Remove the touch event handlers
 */
mouseProto._mouseDestroy = function () {
  
  var self = this;

  // Delegate the touch handlers to the hover-text's element
  self.element.unbind({
    touchstart: $.proxy(self, '_touchStart'),
    touchmove: $.proxy(self, '_touchMove'),
    touchend: $.proxy(self, '_touchEnd')
  });

  // Call the original $.ui.mouse destroy method
  _mouseDestroy.call(self);
};

})(jQuery);
$(document).ready(function(){ 
$('.hover-text').draggable({
  containment: "parent",
  stop: function() {
    var top = $('.hover-text').css("top");
    var left = $('.hover-text').css("left");
    console.log("X:"+left+" Y:"+top);
    document.cookie = ("Top=" + top);
    document.cookie = ("left=" + left);
    //  alert("Top:" + top);
    // alert("Left:" + left);
  }, 
});

//alert(bodyColor);
});
// $(document).ready(function() {
//     $("#img1").click(function(e) {
//         e.preventDefault();
//         var offset = $(this).offset();
//         var x = e.clientX - offset.left;
//         var y = e.clientY - offset.top;
  
//         console.log("X:"+x+" Y:"+y);
//     })
// });
</script>
</body>
</html>