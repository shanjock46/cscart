
{assign var="lang_available_for_vendor_supplier" value=$lang.available_for_vendor}
{assign var="lang_new_vendor_supplier" value=$lang.new_vendor}
{assign var="lang_editing_vendor_supplier" value=$lang.editing_vendor}





{include file="views/profiles/components/profiles_scripts.tpl"}

{capture name="mainbox"}

{capture name="tabsbox"}
{** /Item menu section **}

<form action="{""|fn_url}" method="post" class="{$form_class}" id="company_update_form" enctype="multipart/form-data"> {* company update form *}
{* class="cm-form-highlight"*}
<input type="hidden" name="fake" value="1" />
<input type="hidden" name="selected_section" id="selected_section" value="{$smarty.request.selected_section}" />
<input type="hidden" name="company_id" value="{$company_data.company_id}" />

{** General info section **}
<div id="content_detailed"> {* content detailed *}
<fieldset>


{if $mode == "add" && !"COMPANY_ID"|defined}
	{include file="common_templates/subheader.tpl" title=$lang.use_existing_store}
	
	<div class="form-field">
		<label for="exists_store">{$lang.store}:</label>
		<input type="hidden" name="company_data[clone_from]" id="exists_store" value="" onchange="fn_switch_store_settings(this);" />
		{include file="common_templates/ajax_select_object.tpl" data_url="companies.get_companies_list?show_all=Y&default_label=none" text=$lang.none result_elm="exists_store" id="exists_store_selector"}
	</div>
	
	<div id="clone_settings_container" class="hidden">
		<hr />
		
		{foreach from=$clone_schema key="object" item="object_data"}
			<div class="form-field">
				{assign var="label" value="clone_`$object`"}
				<label for="clone_{$object}">{$lang.$label}{if $object_data.tooltip}{include file="common_templates/tooltip.tpl" tooltip=$lang[$object_data.tooltip]}{/if}:</label>
				<input type="checkbox" name="company_data[clone][{$object}]" id="clone_{$object}" {if $object_data.checked_by_default}checked="checked"{/if} class="cm-dependence-{$object}" value="Y" class="checkbox" {if $object_data.dependence}onchange="fn_check_dependence('{$object_data.dependence}', this.checked)" onclick="fn_check_dependence('{$object_data.dependence}', this.checked)"{/if} />
				{if $object_data.checked_by_default}&nbsp;<span class="small-note">({$lang.recommended})</span>{/if}
			</div>
		{/foreach}
	</div>
{/if}


{include file="common_templates/subheader.tpl" title=$lang.information}

{hook name="companies:general_information"}
<div class="form-field">
	<label for="company_description_company" class="cm-required">{$lang.company}:</label>
	<input type="text" name="company_data[company]" id="company_description_company" size="32" value="{$company_data.company}" class="input-text" />
</div>


<div class="form-field">
	<label for="company_storefront" class="cm-required">{$lang.storefront_url}:</label>
	{if "COMPANY_ID"|defined}
		http://{$company_data.storefront}
	{else}
		http://<input type="text" name="company_data[storefront]" id="company_storefront" size="32" value="{$company_data.storefront}" class="input-text" />
	{/if}
</div>
<div class="form-field">
	<label for="company_secure_storefront">{$lang.secure_storefront_url}:</label>
	{if "COMPANY_ID"|defined}
		https://{$company_data.secure_storefront}
	{else}
		https://<input type="text" name="company_data[secure_storefront]" id="company_secure_storefront" size="32" value="{$company_data.secure_storefront}" class="input-text" />
	{/if}
</div>







	{if $smarty.const.MODE == "add"}
		{literal}
		<script type="text/javascript">
		//<![CDATA[
		function fn_toggle_required_fields() {

			if ($('#company_description_vendor_admin').attr('checked')) {
				$('#company_description_username').removeAttr('disabled');
				$('#company_description_first_name').removeAttr('disabled');
				$('#company_description_last_name').removeAttr('disabled');

				$('.cm-profile-field').each(function(index){
					$('#' + $(this).attr('for')).removeAttr('disabled');
				});

			} else {
				$('#company_description_username').attr('disabled', true);
				$('#company_description_first_name').attr('disabled', true);
				$('#company_description_last_name').attr('disabled', true);

				$('.cm-profile-field').each(function(index){
					$('#' + $(this).attr('for')).attr('disabled', true);
				});
			}
		}
		
		function fn_switch_store_settings(elm)
		{
			jelm = $(elm);
			var close = true;
			if (jelm.val() != 'all' && jelm.val() != '') {
				close = false;
			}
			
			$('#clone_settings_container').toggleBy(close);
		}
		
		function fn_check_dependence(object, enabled)
		{
			if (enabled) {
				$('.cm-dependence-' + object).attr('checked', 'checked').attr('readonly', 'readonly').bind('click', function(e) {return false;});
			} else {
				$('.cm-dependence-' + object).removeAttr('readonly').unbind('click');
			}
		}
		//]]>
		</script>
		{/literal}
		
		{if $smarty.const.PRODUCT_TYPE != "ULTIMATE"}
			<div class="form-field">
				<label for="company_description_vendor_admin">{$lang.create_administrator_account}:</label>
				<input type="checkbox" name="company_data[is_create_vendor_admin]" id="company_description_vendor_admin" checked="checked" value="Y" onchange="fn_toggle_required_fields();" class="checkbox" />
			</div>
			{if $settings.General.use_email_as_login != 'Y'}
			<div class="form-field" id="company_description_admin">
				<label for="company_description_username" class="cm-required">{$lang.account_name}:</label>
				<input type="text" name="company_data[admin_username]" id="company_description_username" size="32" value="{$company_data.admin_username}" class="input-text" />
			</div>
			<div class="form-field">
				<label for="company_description_first_name" class="cm-required">{$lang.first_name}:</label>
				<input type="text" name="company_data[admin_firstname]" id="company_description_first_name" size="32" value="{$company_data.admin_first_name}" class="input-text" />
			</div>
			<div class="form-field">
				<label for="company_description_last_name" class="cm-required">{$lang.last_name}:</label>
				<input type="text" name="company_data[admin_lastname]" id="company_description_last_name" size="32" value="{$company_data.admin_last_name}" class="input-text" />
			</div>
		{/if}
		{/if}
	{/if}
	{if !"COMPANY_ID"|defined && $smarty.const.PRODUCT_TYPE == "MULTIVENDOR"}
	<div class="form-field">
		<label for="company_vendor_commission">{$lang.vendor_commission}:</label>
		<input type="text" name="company_data[commission]" id="company_vendor_commission" value="{$company_data.commission}" class="input-text-medium" />
		<select name="company_data[commission_type]">
			<option value="A" {if $company_data.commission_type == "A"}selected="selected"{/if}>{$currencies.$primary_currency.symbol}</option>
			<option value="P" {if $company_data.commission_type == "P"}selected="selected"{/if}>%</option>
		</select>
	</div>
	{/if}







	{include file="common_templates/subheader.tpl" title="`$lang.settings`: `$lang.company`"}
	
	{foreach from=$company_settings key="field_id" item="item"}
		{include file="common_templates/settings_fields.tpl" item=$item section='Company' html_id="field_`$section`_`$item.name`_`$item.object_id`" html_name="update[`$item.object_id`]"}
	{/foreach}


{/hook}

</fieldset>
</div> {* /content detailed *}
{** /General info section **}



{** Company description section **}
<div id="content_description" class="hidden"> {* content description *}
<fieldset>
{hook name="companies:description"}
<div class="form-field">
	<label for="company_description">{$lang.description}:</label>
	<textarea id="company_description" name="company_data[company_description]" cols="55" rows="8" class="cm-wysiwyg input-textarea-long">{$company_data.company_description}</textarea>
	
</div>
{/hook}
</fieldset>
</div> {* /content description *}
{** /Company description section **}









{** Company regions settings section **}
<div id="content_regions" class="hidden"> {* content regions *}
	<fieldset>
		<div class="form-field">
			<label for="company_redirect">{$lang.redirect_customer_from_storefront}:</label>
			<input type="hidden" name="company_data[redirect_customer]" value="N" checked="checked" class="checkbox" />
			<input type="checkbox" name="company_data[redirect_customer]" id="sw_company_redirect" {if $company_data.redirect_customer == "Y"}checked="checked"{/if} value="Y" class="checkbox cm-switch-availability cm-switch-inverse" />
		</div>

		<div class="form-field" id="company_redirect">
			<label for="company_entry_page">{$lang.entry_page}:</label>
			<select name="company_data[entry_page]" id="company_entry_page" {if $company_data.redirect_customer == "Y"}disabled="disabled"{/if}>
				<option value="none" {if $company_data.entry_page == "none"}selected="selected"{/if}>{$lang.none}</option>
				<option value="index" {if $company_data.entry_page == "index"}selected="selected"{/if}>{$lang.index}</option>
				<option value="all_pages" {if $company_data.entry_page == "all_pages"}selected="selected"{/if}>{$lang.all_pages}</option>
			</select>
		</div>
		
		{include file="common_templates/double_selectboxes.tpl"
			title=$lang.countries
			first_name="company_data[countries_list]"
			first_data=$company_data.countries_list
			second_name="all_countries"
			second_data=$countries_list
			required="N"
		}
	</fieldset>
</div>
{** /Company regions settings section **}

{if $smarty.const.MODE == "add"}
	<div id="content_skin_selector" class="hidden"> {* content skin selector *}
		<div class="form-field">
			<label for="customer_skin">{$lang.text_customer_skin}:</label>
			<select id="customer_skin" name="skin_data[customer]" onchange="$('#c_screenshot').attr('src', '{$config.current_path}/var/skins_repository/'+this.value+'/customer_screenshot.png');">
				{foreach from=$available_skins item=s key=k}
					{if $s.customer == "Y"}
						<option value="{$k}" {if $settings.skin_name_customer == $k}selected="selected"{/if}>{$s.description}</option>
					{/if}
				{/foreach}
			</select>
		</div>
		
		<div class="form-field">
			<div class="break">
				<img class="solid-border" width="300" id="c_screenshot" src="" />
			</div>
		</div>
		
		<script type="text/javascript">
		//<![CDATA[
		$(function() {$ldelim}
			$('#c_screenshot').attr('src', '{$config.current_path}/var/skins_repository/' + $('#customer_skin').val() + '/customer_screenshot.png');
		{$rdelim});
		//]]>
		</script>
	</div>
{/if}






<div id="content_addons" class="hidden">
	{hook name="companies:detailed_content"}{/hook}
</div>

{hook name="companies:tabs_content"}{/hook}

{** Form submit section **}

<div class="buttons-container cm-toggle-button buttons-bg">
	{if $mode == "add"}
		{include file="buttons/save_cancel.tpl" but_name="dispatch[companies.add]"}
	{else}
		{include file="buttons/save_cancel.tpl" but_name="dispatch[companies.update]"}
	{/if}
</div>
{** /Form submit section **}

</form> {* /product update form *}

{hook name="companies:tabs_extra"}{/hook}

{/capture}
{include file="common_templates/tabsbox.tpl" content=$smarty.capture.tabsbox group_name=$controller active_tab=$smarty.request.selected_section track=true}

{/capture}

{if $mode == "add"}
	{include file="common_templates/mainbox.tpl" title=$lang_new_vendor_supplier content=$smarty.capture.mainbox}
{else}
	{include file="common_templates/mainbox.tpl" title="`$lang_editing_vendor_supplier`:&nbsp;`$company_data.company`" content=$smarty.capture.mainbox select_languages=true}
{/if}