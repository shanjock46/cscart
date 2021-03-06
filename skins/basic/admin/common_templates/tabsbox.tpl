{script src="js/tabs.js"}

{if !$active_tab}
	{assign var="active_tab" value=$smarty.request.selected_section}
{/if}

{assign var="empty_tab_ids" value=$content|empty_tabs}

{if $navigation.tabs}
<div class="tabs cm-j-tabs{if $track} cm-track{/if}">
	<ul>
	{foreach from=$navigation.tabs item=tab key=key name=tabs}
		{if (!$tabs_section || $tabs_section == $tab.section) && ($tab.hidden || !$key|in_array:$empty_tab_ids)}
		<li id="{$key}{$id_suffix}" class="{if $tab.hidden == "Y"}hidden {/if}{if $tab.js}cm-js{elseif $tab.ajax}cm-js cm-ajax{/if}{if $key == $active_tab} cm-active{/if}"><a {if $tab.href}href="{$tab.href|fn_url}"{/if}>{$tab.title}</a>{if $key == $active_tab}{$active_tab_extra}{/if}</li>
		{/if}
	{/foreach}
	</ul>
</div>
<div class="cm-tabs-content">
	{$content}
</div>
{else}
	{$content}
{/if}