<!--Footer Area -->
</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2019 Ameritinz Supermart</div>
<script>
  function updateSizes(){
    var sizeString = '';
    for(var i=1;i<=4;i++){
      //run this if statement if the size string is not empty
      if(jQuery('#size'+i).val() !=''){ //in javascript + is concatenate and period in php
        sizeString += jQuery('#size' +i).val()+':'+jQuery('#qty'+i).val()+',';
    }

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
      url: '/tutorial/admin/parsers/child_categories.php',
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
