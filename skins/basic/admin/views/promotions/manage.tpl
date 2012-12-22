{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="promotion_form">

{include file="common_templates/pagination.tpl" save_current_page=true save_current_url=true}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table sortable hidden-inputs">
<tr>
	<th width="1%" class="center">
		<input type="checkbox" name="check_all" value="Y" title="{$lang.check_uncheck_all}" class="checkbox cm-check-items" /></th>
	
	{if !"COMPANY_ID"|defined}
		<th>&nbsp;</th>
	{/if}
	
	<th width="60%">
		<a class="cm-ajax{if $search.sort_by == "name"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=name&amp;sort_order=`$search.sort_order`"|fn_url}" rev="pagination_contents">{$lang.name}</a></th>
	<th width="10%">
		<a class="cm-ajax{if $search.sort_by == "priority"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=priority&amp;sort_order=`$search.sort_order`"|fn_url}" rev="pagination_contents">{$lang.priority}</a></th>
	<th width="10%">
		<a class="cm-ajax{if $search.sort_by == "zone"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=zone&amp;sort_order=`$search.sort_order`"|fn_url}" rev="pagination_contents">{$lang.zone}</a></th>
	<th width="12%">
		<a class="cm-ajax{if $search.sort_by == "status"} sort-link-{$search.sort_order}{/if}" href="{"`$c_url`&amp;sort_by=status&amp;sort_order=`$search.sort_order`"|fn_url}" rev="pagination_contents">{$lang.status}</a></th>
	<th>&nbsp;</th>
</tr>
{foreach from=$promotions item=promotion}
<tr {cycle values="class=\"table-row\", "}>
	<td class="center">
		<input name="promotion_ids[]" type="checkbox" value="{$promotion.promotion_id}" class="checkbox cm-item" /></td>
	<td>
		<input type="text" name="promotions[{$promotion.promotion_id}][name]" size="50" value="{$promotion.name}" class="input-text" /> 
	</td>
	
		{if !"COMPANY_ID"|defined}
		<td>
			{include file="views/companies/components/company_name.tpl" company_name=$promotion.company_name company_id=$promotion.company_id}
		</td>
		{/if}
	
	<td>
		<input type="text" name="promotions[{$promotion.promotion_id}][priority]" size="50" value="{$promotion.priority}" class="input-text-short" /></td>
	<td>
		{$lang[$promotion.zone]}</td>
	<td>
		{include file="common_templates/select_popup.tpl" id=$promotion.promotion_id status=$promotion.status hidden=true object_id_name="promotion_id" table="promotions"}
	</td>
	<td class="nowrap">
		{capture name="tools_items"}
		<li><a class="cm-confirm" href="{"promotions.delete?promotion_id=`$promotion.promotion_id`"|fn_url}">{$lang.delete}</a></li>
		{/capture}
		{include file="common_templates/table_tools_list.tpl" prefix=$promotion.promotion_id tools_list=$smarty.capture.tools_items href="promotions.update?promotion_id=`$promotion.promotion_id`"}
		</td>
</tr>
{foreachelse}
<tr class="no-items">
	<td colspan="6"><p>{$lang.no_data}</p></td>
</tr>
{/foreach}
</table>

{include file="common_templates/pagination.tpl"}

{if $promotions}
<div class="buttons-container buttons-bg">
	<div class="float-left">
		{capture name="tools_list"}
		<ul>
			<li><a name="dispatch[promotions.delete]" class="cm-process-items cm-confirm" rev="promotion_form">{$lang.delete_selected}</a></li>
		</ul>
		{/capture}
		{include file="buttons/save.tpl" but_name="dispatch[promotions.m_update]" but_role="button_main"}
		{include file="common_templates/tools.tpl" prefix="main" hide_actions=true tools_list=$smarty.capture.tools_list display="inline" link_text=$lang.choose_action}
	</div>
</div>	
{/if}

</form>

{capture name="tools"}
	{include file="common_templates/tools.tpl" tool_href="promotions.add?zone=catalog" prefix="top" link_text=$lang.add_catalog_promotion hide_tools=true}
	
	{include file="common_templates/tools.tpl" tool_href="promotions.add?zone=cart" prefix="top" link_text=$lang.add_cart_promotion hide_tools=true}
	
{/capture}

{/capture}
{include file="common_templates/mainbox.tpl" title=$lang.promotions content=$smarty.capture.mainbox tools=$smarty.capture.tools select_languages=true}
