<div>
  <div class="from-group col-md-6">
  <label for="full_name">Full Name:</label>
  <input class="form-control" id="full_name" name="full_name" type="text" value = "<?=((isset($user_data['email']))?$user_data['full_name']:'');?>"readonly required>
</div>
<div class="from-group col-md-6">
  <label for="phone">phone:</label>
  <input class="form-control" id="phone" name="phone" type="number" value = "<?=((isset($user_data['phone']))?$user_data['phone']:'');?>" required>
</div>
<div class="from-group col-md-6">
  <label for="email">Email:</label>
  <input class="form-control" id="email" name="email" type="email" value = "<?=((isset($user_data['email']))?$user_data['email']:'');?>"readonly>
</div>
<div class="from-group col-md-6">
  <label for="street">Street Address:</label>
  <input class="form-control" id="street" name="street" type="text" data-stripe = "address_line1" value = "<?=((isset($user_data['email']))?$user_data['street']:'');?>"required>
</div>
<div class="from-group col-md-6">
  <label for="street2">Street Address 2:</label>
  <input class="form-control" id="street2" name="street2" type="text" data-stripe = "address_line2" value = "<?=((isset($user_data['email']))?$user_data['street2']:'');?>"required>
</div>
<div class="from-group col-md-6">
  <label for="city">City:</label>
  <input class="form-control" id="city" name="city" type="text" data-stripe = "address_city" value = "<?=((isset($user_data['email']))?$user_data['city']:'');?>"required>
</div>
<div class="from-group col-md-6">
  <label for="state">State:</label>
  <input class="form-control" id="state" name="state" type="text" data-stripe = "address_state" value = "<?=((isset($user_data['email']))?$user_data['state']:'');?>"required>
</div>
<div class="from-group col-md-6">
  <label for="zip_code">Postal Code:</label>
  <input class="form-control" id="zip_code" name="zip_code" type="text" data-stripe = "address_zip" value = "<?=((isset($user_data['email']))?$user_data['zip_code']:'0000');?>">
</div>
<div class="from-group col-md-6">
  <label for="country">Country:</label>
  <input class="form-control" id="country" name="country" type="text" data-stripe = "address_country" value = "<?=((isset($user_data['email']))?$user_data['country']:'');?>" required>
</div>
</div>
