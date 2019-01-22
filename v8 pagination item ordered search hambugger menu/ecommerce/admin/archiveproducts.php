<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce/core/init.php';
//check if user is logged in on any of the pages
if(!is_logged_in()){
  login_error_redirect();
}

include 'includes/head.php';
include 'includes/navigation.php';
$sql ="SELECT * FROM products WHERE archive = 1";
$archive_results =$db->query($sql);

if(isset($_GET['archiveRestore'])){
  if(check_staff_permission('editor')){
      $a_id=sanitize($_GET['archiveRestore']);
    $db->query("UPDATE products SET archive = 0 WHERE id='$a_id'");
    header('Location: archiveproducts.php');
    }else{
      $message = "Please! You do not have sufficient clearance to unarchive product.";
        permission_ungranted('archiveProducts.php',$message);
      }
}
?>
<h2 class="text-center">Archive Products</h2>
<a href="products.php?add=1" class ="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Archive</th></thead>
<tbody>
  <?php while($archiveProduct =mysqli_fetch_assoc($archive_results)):
    $childID = $archiveProduct['categories'];
    $category_sql = "SELECT * FROM categories WHERE id = '$childID'";
    $result = $db->query($category_sql);
    $child = mysqli_fetch_assoc($result);
    $parentID = $child['parent'];
    $parent_sql = "SELECT * FROM categories WHERE id = '$parentID'";
    $parent_result =$db->query($parent_sql);
    $parent = mysqli_fetch_assoc($parent_result);
    $category = $parent['category'].'-'.$child['category'];
    // set and unset featured product
    if(isset($_GET['archiveFeatured'])){
      $a_id =(int)$_GET['id'];
      $a_featured = (int)$_GET['archiveFeatured'];
      $a_featuredsql = "UPDATE products SET featured = '$a_featured' WHERE id = '$a_id'";
      $db->query($a_featuredsql);
      header('Location: archiveproducts.php');
    }


  ?>
    <tr>
        <td>
          <a href ="archiveproducts.php?archiveRestore=<?=$archiveProduct['id'];?>" class= "btn btn-xs btn-default"><span class="glyphicon glyphicon-send"></span><a/>
        </td>
      <td><?=$archiveProduct['title'];?></td>
      <td><?=money($archiveProduct['price']);?></</td> <!--the money function is in helper class to add the dollar sign -->
      <td><?=$category;?></td>
      <td><a href = "archiveProducts.php?archiveFeatured=<?=(($archiveProduct['featured']== 0)?'1':'0');?>&id=<?=$archiveProduct['id'];?>" class = "btn btn-xs btn-default">
        <span class = "glyphicon glyphicon-<?=(($archiveProduct['featured']==1)?'minus':'plus');?>"></span>
      </a>&nbsp <?=(($archiveProduct['featured'] == 1)?'Featured Product':'');?></td>
      <td><?=$archiveProduct['archive']; ?></td>
    </tr>
  <?php endwhile; ?>
</tbody>

</table>

<?php include 'includes/footer.php'; ?>
