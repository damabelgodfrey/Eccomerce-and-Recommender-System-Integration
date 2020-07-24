<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/staff-init.php';
if(!is_staff_logged_in()){
  login_error_redirect();
}
if(!check_staff_permission('editor')){
  error_redirect('index','You do not have clearance to view that page');
}
include 'includes/head.php';
include 'includes/navigation.php';
 ?>
<Style>

	.color-wrapper {
		position: relative;
		width: 100%;
		margin: 20px auto;
	}

	.color-wrapper p {
		margin-bottom: 5px;
	}

	input.call-picker {
    border: 1px solid #AAA;
  color: #666;
  text-transform: uppercase;
  float: left;
  outline: none;
  padding: 10px;
  text-transform: uppercase;
  width: 100%;
  height: auto;
  cursor: pointer;

	}

	.color-picker {
		width: 100%;
		background: #F3F3F3;
		padding: 5px;
    margin-top: 1px;
		border: 5px solid #fff;
		box-shadow: 0px 0px 3px 1px red;
		position: absolute;
    z-index: 1000;
	}

	.color-holder {
		cursor: pointer;
		border: 1px solid #AAA;
    width: 100%;
	}
.call-pticker{
  padding-top: 5px;
  padding-bottom: 5px;
  margin-top: 5px;
  margin-bottom: 5px;
}
	.color-picker .color-item {
		cursor: pointer;
		width: 35px;
		height: 35px;
		list-style-type: none;
		float: left;
		margin: 2px;
		border: 1px solid #DDD;
		transition: transform .2s; /* Animation */
    z-index: 1000;
	}

	.color-picker .color-item:hover {
		border: 1px solid none;
		transform: scale(2.0);

	}
	.footerspacing{
		position: absolute;
	}
	.box .button-color{
		color: black;
	}

  .box #announcement{
    color: black;
  }
  .col-xs-4, .col-xs-8{
  padding-right: 0px;
padding-left: 0px;
  }
</Style>
<?php
$flag = 0;
//delete  announcements
if(isset($_GET['delete'])){
  if(check_staff_permission('admin')){
  $delete_id = sanitize($_GET['delete']);
  $deleteannouncementResults= $db->query("DELETE FROM announcement WHERE id='$delete_id'");
  $db->query("UPDATE announcement SET id =id -1 WHERE id > $delete_id ORDER BY id DESC");
  header('Location: appearance');
  }else{
    $message = "Please! You do not have sufficient clearance to delete product.";
    permission_ungranted('appearance',$message);
  }
}
// set and unset featured appearance
if(isset($_GET['status'])){
  $id =(int)$_GET['id'];
  $status = (int)$_GET['status'];
  $status2 = 0;
  $statussql = "UPDATE announcement SET status = '$status' WHERE id = '$id'";
  //$statussql2 = "UPDATE announcement SET status = '$status2' WHERE id != '$id'";
  $db->query($statussql);
  //$db->query($statussql2);
  header('Location: appearance');
  $message = ' Updating Status was successful.';
  succes_redirect('appearance',$message);
}
if(isset($_GET['setcolor'])){
	if (isset($_POST['AnnouncementT_color'])) {
		$colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
		$colorssql = "UPDATE announcement SET tcolor = '$colourset'";
    $message = ' Updating announcement text color was successful.';
	}elseif(isset($_POST['navB_color'])){
    $colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
    $colorssql = "UPDATE appearance SET navB_color = '$colourset'";
  }elseif(isset($_POST['navT_color'])){
    $colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
		$colorssql = "UPDATE appearance SET navT_color = '$colourset'";
    $message = ' Updating navigation bar text color was successful.';
    }elseif(isset($_POST['navdropB_color'])){
    $colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
		$colorssql = "UPDATE appearance SET navdropB_color = '$colourset'";
    $message = ' Updating navigation dropdownbar background color was successful.';
    }elseif(isset($_POST['navdropT_color'])){
    $colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
		$colorssql = "UPDATE appearance SET navdropT_color = '$colourset'";
    $message = ' Updating navigation dropdown Text color was successful.';
    }elseif(isset($_POST['navdropheader_color'])){
    $colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'white');
		$colorssql = "UPDATE appearance SET navdropheader_color = '$colourset'";
    $message = ' Updating navigation dropdown header Text color was successful.';
    }else{
		$colourset =((isset($_POST['custom_color']) && $_POST['custom_color'] != '')?sanitize($_POST['custom_color']):'lightgrey');
		$colorssql = "UPDATE announcement SET bcolor = '$colourset'";
    $message = ' Updating announcements background color was successful.';
    	}
  $db->query($colorssql); ?>
  <?php

succes_redirect('appearance',$message);
header('Location: appearance');
}
$arrayR[] = array();
$announcementQ = $db->query("SELECT * FROM announcement WHERE status = 1 ORDER BY id LIMIT 6");
while($row = mysqli_fetch_assoc($announcementQ)){
  $arrayR[] =$row['username'].'??$'.$row['announcement'].'??$'.$row['url'];

}
if(isset($_GET['add']) || isset($_GET['edit'])){
  if(check_staff_permission('admin')){
  $username =$staff_data['first'];
  $announcement =((isset($_POST['announcement']) && $_POST['announcement'] != '')?sanitize($_POST['announcement']):'');
  $linkUrl =((isset($_POST['url']) && $_POST['url'] != '')?sanitize($_POST['url']):'');

  //$announcement_image = ''; // if get is not set
  // store edit id if edit button is clicked
    if(isset($_GET['edit'])){
          $edit_id =(int)$_GET['edit'];
          $EditannouncementResults = $db->query("SELECT * FROM announcement WHERE id='$edit_id'");
          $announcementQ = mysqli_fetch_assoc($EditannouncementResults);
          $announcement = ((isset($_POST['username']) && $_POST['username'] != '')?sanitize($_POST['username']):$announcementQ['username']);
          $announcement = ((isset($_POST['announcement']) && $_POST['announcement'] != '')?sanitize($_POST['announcement']):$announcementQ['announcement']);
          $linkUrl = ((isset($_POST['url']) && $_POST['url'] != '')?sanitize($_POST['url']):$announcementQ['url']);
        }

    if($_POST){
      $errors=array();
      $required = array('username','announcement'); //required field on the add announcement date_create_from_format
        foreach($required as $field){
          if($_POST[$field] ==''){
            $errors[]= 'All fields with Asterisk are required.';
            $flag = 1;
            break;

          }
        }

      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        if(isset($_GET['add'])){
          $id =1;
          //add new announcement at top of page
          $db->query("UPDATE announcement SET id =id +1 ORDER BY id DESC");
          $insertSql = "INSERT INTO announcement (`id`,`username`,`announcement`,`url`)
          VALUES ('$id','$username','$announcement','$linkUrl')";
          $message = ' Adding announcement was successful.';

        }
        if(isset($_GET['edit'])){
          $insertSql = "UPDATE announcement SET `username` ='$username', `announcement` ='$announcement', `url` = '$linkUrl'
          WHERE id='$edit_id'";
          $message = ' Update was successful.';

        }
       $db->query($insertSql);
       header('Location: appearance');
       succes_redirect('appearance',$message);
      }
    }
      ?><p></p>
			<div class="box">
      <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>Announcements</h2><hr>
    <!-- if edit is clicked set the post option to edit id else set to add announcement( add=1)-->
      <form action="appearance?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
        <div class="form-group col-md-3">
          <label for="caption">Username*:</label>
          <input type="text" id="username" name="username" class="form-control" value="<?=$username;?>"  required readonly>
        </div>
       <div class="form-group col-md-6">
         <label for="caption">Announcement*:</label><br>
         <?php if ($announcement == ''){ ?>
           <textarea name="announcement" id="announcement" cols="80" rows="4" placeholder="Enter Announcement" required>
         </textarea>
         <?php }else{ ?>
         <textarea name="announcement" id="announcement" cols="80" rows="4" required>
         <?=$announcement;?>
       </textarea>
     <?php } ?>
     </div>
       <!-- label -->
       <div class="form-group col-md-3">
         <label for="url">Link Url*:</label>
         <input type="text" id="url" name="url" class="form-control" value="<?=$linkUrl;?>" placeholder="Enter link url">
       </div>
         <div class= "form-group pull-right">
           <a href="appearance" class="btn btn-default">Cancel</a>
           <input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Announcement" class="btn btn-success">
         </div><div class="clearfix"></div>
         </div>
      </form>
      </div>
    <?php
  }else{
    $message = "Please! You do not have sufficient clearance to perform that action.";
    permission_ungranted('appearance',$message);
  }
}else{
  ?>
<p></p>
<div class="col-md-12">

<div class="row ">
		<div class="color-wrapper">
		<form action="appearance?setcolor" method="POST" enctype="multipart/form-data">
		 <div class="col-md-12 form-group button-color box">
		   <div class="color-holder call-picker" style="color: black">
         <div class="col-xs-4">
           <input type="label" name="custom_color" placeholder="choose Color" id="pickcolor" class="call-picker " required>

         </div>
         <div class="col-xs-8">
           <input type="label" name="show_color" placeholder="" id="showcolor" class="call-picker displayc-picker">

         </div>

         <input type="submit" value="NavB_color"name="navB_color" class="call-pticker">&nbsp&nbsp
         <input type="submit" value="NavT_color"name="navT_color" class="call-pticker">&nbsp&nbsp
         <input type="submit" value="NavdropB_color"name="navdropB_color" class="call-pticker">&nbsp&nbsp
         <input type="submit" value="NavdropT_color"name="navdropT_color" class="call-pticker">&nbsp&nbsp
         <input type="submit" value="Navdropheader_color"name="navdropheader_color" class="call-pticker">&nbsp&nbsp
		     <input type="submit" value="AnnouncementB_color" name="AnnouncementB_color"class="call-pticker">&nbsp&nbsp
				 <input type="submit" value="AnnouncementT_color"name="AnnouncementT_color" class="call-pticker">&nbsp&nbsp


		   </div>
		</div>
		<div class="col-md-12 ">
		<div class="color-picker" id="color-picker" style="display: none"></div>
		</div>
		</form>
		</div>
	</div>
</div>
<div class="box">
<?php
$announcementQ = $db->query("SELECT * FROM announcement WHERE status = 1");
$announcement = mysqli_num_rows($announcementQ);
if($announcement > 0){
$announcement = mysqli_fetch_assoc($announcementQ);
?>
<div class="nav-top text-center" style="background-color:<?=$announcement['bcolor'];?>  ;">
        <p></p>
       <marquee behavior="scroll" align="middle" direction="left" scrollamount="4" onmouseover="this.stop()" onmouseout="this.start()" style="color: <?=$announcement['tcolor'];?>;">

         <?php foreach ($announcementQ as $announcementR):
         ?>
         <a href="<?=$announcementR['url'];?>" style="color: <?=$announcementR['tcolor'];?>;"  class=""> <?=$announcementR['announcement'];?></a>&nbsp&nbsp&nbsp&nbsp
         <?php
         endforeach;
     ?>
     </marquee>
 </div>
<?php  }else{ ?>
  <div class="nav-top text-center" style="background-color:grey;?>  ;">
    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
      <div class=" col-md-12" style="color: white;?>">
       <p>
         <a href="sales" class="btn btn-sm btn-block">Click here to shop sales up to 50% off now..</a>
       </p>
     </div>
   </marquee>
</div>
<?php }?>
	</div>
<?php } ?>
</div>
<?php

$announcementQ = $db->query("SELECT * FROM announcement  ORDER BY id LIMIT 6");
 ?>
<p></p>
<div class="box">
<h2 class="text-center">Announcement</h2>
<a href="appearance?add=1" class ="btn btn-success pull-right" id="add-product-btn">Add Announcement</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <tbody><th>Action</th><th>Username</th><th>Announcement</th><th>Link URL</th><th>Status</th></thead>
<tbody>
    <?php while($announcement =mysqli_fetch_assoc($announcementQ)):?>

    <tr>
        <td>
          <a href ="appearance?edit=<?=$announcement['id'];?>" class= "btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span><a/>
          <a href ="appearance?delete=<?=$announcement['id'];?>" class= "btn btn-xs btn-danger " onclick="return deleletconfirm()"><span class="glyphicon glyphicon-remove"></span><a/>
        </td>
      <td><?=$announcement['username'];?></td>
      <td><?=$announcement['announcement'];?></</td> <!--the money function is in helper class to add the dollar sign -->
      <td><?=$announcement['url'];?></td>
      <td><a href = "appearance?status=<?=(($announcement['status']== 0)?'1':'0');?>&id=<?=$announcement['id'];?>" class = "btn btn-xs <?=(($announcement['status'] == 1)?'btn-success':'btn-default');?>">
        <span class = "glyphicon glyphicon-<?=(($announcement['status']==1)?'minus':'plus');?>"></span>
      </a> <?=(($announcement['status'] == 1)?'':'OFF');?></td>


    </tr>
  <?php endwhile; ?>
</tbody>

</table>
</div><p><b></b></p>
<p></p>
<?php  include 'includes/footer.php'; ?>
<script>
function deleletconfirm(){
  var del=confirm("Are you sure you want to delete this announcement?");
if (del==true){
//   alert ("record deleted")
}
return del;
}

var colorList = [ 'CD5C5C','F08080','FA8072',
'E9967A',
'FFA07A',
'DC143C',
'FF0000',
'B22222',
'8B0000',
'FFC0CB',
'FFB6C1',
'FF69B4',
'FF1493',
'C71585',
'DB7093',
'FFA07A',
'FF7F50',
'FF6347',
'FF4500',
'FF8C00',
'FFA500',
'FFD700',
'FFFF00',
'FFFFE0',
'FFFACD',
'FAFAD2',
'FFEFD5',
'FFE4B5',
'FFDAB9',
'EEE8AA',
'F0E68C',
'BDB76B',
'E6E6FA',
'D8BFD8',
'DDA0DD',
'EE82EE',
'DA70D6',
'FF00FF',
'FF00FF',
'BA55D3',
'9370DB',
'663399',
'8A2BE2',
'9400D3',
'9932CC',
'8B008B',
'800080',
'4B0082',
'6A5ACD',
'483D8B',
'7B68EE',
'ADFF2F',
'7FFF00',
'7CFC00',
'00FF00',
'32CD32',
'98FB98',
'90EE90',
'00FA9A',
'00FF7F',
'3CB371',
'2E8B57',
'228B22',
'008000',
'006400',
'9ACD32',
'6B8E23',
'808000',
'556B2F',
'66CDAA',
'8FBC8B',
'20B2AA',
'008B8B',
'008080',
'00FFFF',
'00FFFF',
'E0FFFF',
'AFEEEE',
'7FFFD4',
'40E0D0',
'48D1CC',
'00CED1',
'5F9EA0',
'4682B4',
'B0C4DE',
'B0E0E6',
'ADD8E6',
'87CEEB',
'87CEFA',
'00BFFF',
'1E90FF',
'6495ED',
'7B68EE',
'4169E1',
'0000FF',
'0000CD',
'00008B',
'000080',
'191970',
'FFF8DC',
'FFEBCD',
'FFE4C4',
'FFDEAD',
'F5DEB3',
'DEB887',
'D2B48C',
'BC8F8F',
'F4A460',
'DAA520',
'B8860B',
'CD853F',
'D2691E',
'8B4513',
'A0522D',
'A52A2A',
'800000',
'FFFFFF',
'FFFAFA',
'F0FFF0',
'F5FFFA',
'F0FFFF',
'F0F8FF',
'F8F8FF',
'F5F5F5',
'FFF5EE',
'F5F5DC',
'FDF5E6',
'FFFAF0',
'FFFFF0',
'FAEBD7',
'FAF0E6',
'FFF0F5',
'FFE4E1',
'DCDCDC',
'D3D3D3',
'C0C0C0',
'A9A9A9',
'808080',
'696969',
'778899',
'708090',
'2F4F4F',
'000000', ];
var colorList = colorList.reverse();
var picker = $('#color-picker');

for (var i = 0; i < colorList.length; i++ ) {
  picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
}

$('body').click(function () {
  picker.fadeOut();
});

$('.call-picker').click(function(event) {
  event.stopPropagation();
  picker.fadeIn();
  picker.children('li').hover(function() {
    var codeHex = $(this).data('hex');
    $('.displayc-picker').css('background-color', codeHex);
    $('#pickcolor').val(codeHex);
  });
});


</script>
