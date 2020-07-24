<input type="hidden" name="sub_total" value="<?=$sub_total;?>">
<input type="hidden" name="tax" value="<?=$tax;?>">
<input type="hidden" name="discount" value="<?=((isset($discountT))?$discountT:'');?>">
<input type="hidden" name="grand_total" value="<?=$grand_total;?>">
<input type="hidden" name="cart_id" value="<?=$cart_id;?>">
<input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':'').'from'. $globalsettings['company_name'];?>">
