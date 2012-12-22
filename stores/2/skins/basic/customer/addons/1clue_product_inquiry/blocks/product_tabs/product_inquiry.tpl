{** block-description:product_inquiry **}

<div id="content_product_inquiry">
<form name="product_inquiry_form" action="{""|fn_url}" method="post">
<input type="hidden" name="selected_section" value="product_inquiry" />
<input type="hidden" name="redirect_url" value="{$config.current_url}" />
<input type="hidden" name="inquiry_data[product]" value="{$product.product|escape:html}" />
<input type="hidden" name="inquiry_data[product_code]" value="{$product.product_code|unescape}" />
<input type="hidden" name="inquiry_data[product_url]" value="{"product.view?product_id=`$products.product_id`"|fn_url:'C':'http':'&'}" />

<div class="form-field">
	<label for="send_yourname">{$lang.your_name}:</label>
	<input id="send_yourname" size="50" class="input-text" type="text" name="inquiry_data[from_name]" value="{if $inquiry_data.from_name}{$inquiry_data.from_name}{elseif $auth.user_id}{$user_info.firstname} {$user_info.lastname}{/if}" />
</div>

<div class="form-field">
	<label for="send_youremail" class="cm-email cm-required">{$lang.your_email}:</label>
	<input id="send_youremail" class="input-text" size="50" type="text" name="inquiry_data[from_email]" value="{if $inquiry_data.from_email}{$inquiry_data.from_email}{elseif $auth.user_id}{$user_info.email}{/if}" />
</div>

<div class="form-field">
	<label for="send_notes" class="cm-required">{$lang.your_message}:</label>
	<textarea id="send_notes"  class="input-textarea" rows="5" cols="72" name="inquiry_data[notes]">{if $inquiry_data.notes}{$inquiry_data.notes}{/if}</textarea>
</div>
{if $addons.1clue_product_inquiry.use_image_verification == "Y"}
	{include file="common_templates/image_verification.tpl" id="product_inquiry" align="left"}
{/if}

<div class="buttons-container">
	{include file="buttons/button.tpl" but_text=$lang.send but_name="dispatch[product_inquiry.send]"}
</div>

</form>
</div>
