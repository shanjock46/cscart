<fieldset>

<div class="form-field">
	<label for="ship_ems_mode">{$lang.ems_mode}:</label>
	<select id="ship_ems_mode" name="shipping_data[params][mode]">
		<option value="regions" {if $shipping.params.mode == "regions"}selected="selected"{/if}>{$lang.regions}</option>
		<option value="cities" {if $shipping.params.mode == "cities"}selected="selected"{/if}>{$lang.cities}</option>
	</select>
</div>
	
</fieldset>