<!--Footer Area -->
</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2019 Ameritinz Supermart</div>
<script>
jQuery(window).scroll(function(){
  if($(this).scrollTop()> 0){
    $('.navbar-fixed-top').removeClass('head-room');
  }else{
    $('.navbar-fixed-top').addClass('head-room');
  }});
// check the number of size rows is chosen first
  jQuery('#title').change(function(){
    var row = '<?php echo $sizerowVer; ?>';
    if(row == ''){
      var error = '';
      $('.sizerowcheck').prop('disabled', true);
      error += '<p class="text-danger text-center">Plz choose the number of sizes for this product first!</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else{
      $('.sizerowcheck').prop('disabled', false);
      return;
    }

  });
//update the nmber of size input row
  jQuery('#num_size_form').change(function(){
    var sizerow = jQuery('#sizerow option:selected').data("sizerow");
    jQuery("#num_size").val(sizerow);
    jQuery( "#num_size_form" ).submit();
    return false;

  });

//create and update number of rows to input product size.
  function updateSizes(){
    var sizeString = '';
    var error = '';
    var row = '<?php echo $sizerowVer; ?>';


    jQuery('#modal_errors').html("");
    for(var i=1;i<=row;i++){
      //run this if statement if the size string is not empty
      if(jQuery('#size'+i).val() !='' && jQuery('#price'+i).val() !=''&& jQuery('#qty'+i).val() !='' && jQuery('#threshold'+i).val() !=''){ //in javascript + is concatenate and period in php
        sizeString += jQuery('#size' +i).val()+':'+jQuery('#price' +i).val()+':'+jQuery('#qty'+i).val()+':'+jQuery('#threshold'+i).val()+',';
        $('.submitbtn').prop('disabled', false);
      }else{
        alert("Plz fill out all the rows. To remove unwanted rows go back and choose number of size rows needed");
        error += '<p class="text-danger text-center">Error occurs on size modal. Plz fill out all the rows. To remove unwanted rows go back and choose number of size rows needed!</p>';
          jQuery('#modal_errors').html(error);
          $('.submitbtn').prop('disabled', true);
          return;

    }

    }
    if(typeof row === 'undefined'){
      row = 0;
      alert("Error! Number of row is not choosen");
    }
    jQuery('#sizes').val(sizeString);
  }
  function get_child_options(selected){
    //if a parent is not selected then set selected to empty string
    if(typeof selected ==='undefined'){
      var selected ='';
    }
    var parentID = jQuery('#parent').val(); //get parent id by getting parent value for #parent in product.php
    // fire an ajax request to the url as a post with parentId with it as a post and on success..
    jQuery.ajax({
      url: '/ecommerce/admin/parsers/child_categories.php',
      type: 'POST',
      //pass the selected parent into the data post. selected(post key): selected (data)
      data: {parentID : parentID, selected: selected}, //ajx request return and stored in data
      //populate the the child box (on add product)with the child of the parent selected
      success: function(data){
        jQuery('#child').html(data);
      },
      error: function(){alert("Something went wrong with the child option")},
    });
  }
  //listening for select option for parent to change
  // then fire up the get_child_options fuction
jQuery('select[name="parent"]').change(function(){
  get_child_options();
});

</script>
</body>
</html>
