<div>
  <div class="form-group col-md-3">
  <label for="name">Name on Card:</label>
  <input type="text" id="name" class="form-control" data-stripe = "name">
</div>
<div class="form-group col-md-3">
  <label for="number">Card Number:</label>
  <input type="text" id="number" class="form-control" data-stripe = "number">
</div>
<div class="form-group col-md-2">
  <label for="cvc">CVC</label>
  <input type="text" id="cvc" class="form-control" data-stripe = "cvc">
</div>
<div class="form-group col-md-2">
  <label for="exp-month">Expire Month:</label>
  <select id="exp-month" class="form-control" data-stripe = "exp_month">
    <option value=""></option>
    <?php  for($i =1; $i<13; $i++): ?>
    <option value="<?=$i;?>"><?=$i;?></option>
    <?php endfor; ?>
  </select>
</div>
<div class="form-group col-md-2">
  <label for="exp-year">Expire Year:</label>
  <select id ="exp-year" class="form-control" data-stripe = "exp_year">
    <option value=""></option>
    <?php $yr = date("Y");?>
    <?php for($i =0; $i<11; $i++):?>
      <option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
    <?php endfor; ?>
  </select>
</div>
</div>
