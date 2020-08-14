<label class="text-warning"for="rating">Rating:</label>
<?php if($product['product_average_rating'] >= 5 ){ ?>
  <span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
  <span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
  <?= nl2br ($product['product_average_rating']); ?>
  <?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>
<?php  } else if($product['product_average_rating'] > 4){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
<span class="fa fa-star checkedRating"></span><span class="fa fa-star-half-o checkedRating"></span>
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>
<?php  } else if($product['product_average_rating'] == 4){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
<span class="fa fa-star checkedRating"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] > 3){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
<span class="fa fa-star-half-o checkedRating"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] == 3){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star checkedRating"></span>
<span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] > 2){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star-half-o checkedRating"></span>
<span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] == 2){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star checkedRating"></span><span class="fa fa-star uncheckedcheckedRaing"></span>
<span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] > 1){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star-half-o checkedRating"></span><span class="fa fa-star uncheckedcheckedRaing"></span>
<span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else if($product['product_average_rating'] == 1){?>
<span class="fa fa-star checkedRating"><span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing"></span>
<span class="fa fa-star uncheckedcheckedRaing"></span><span class="fa fa-star uncheckedcheckedRaing">
</span> <?= nl2br ($product['product_average_rating']); ?>
<?php  echo " =>From "; ?> <?php echo($product['product_rating_counter']); echo " Registered Users";?>

<?php  } else{?>
 <span class="bg-info "> This product have not been rated</span>
<?php } ?>
