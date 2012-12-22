<div class="other-pay clearfix">
	<ul class="paym-methods">
		{foreach from=$payments item="payment"}
			<li><input id="payment_{$payment.payment_id}" class="radio valign" type="radio" name="payment_id" value="{$payment.payment_id}" {if $cart.payment_id == $payment.payment_id}checked="checked"{/if} onchange="$.ajaxRequest('{"checkout.update_payment?payment_id=`$payment.payment_id`&active_tab=`$tab_id`"|fn_url:'C':'rel':'&amp;'}', {literal}{method: 'POST', caching: false, force_exec: true, full_render: true, result_ids: {/literal}'checkout*,content_payments*'{literal}}{/literal});" /><div class="radio1"><h5><label for="payment_{$payment.payment_id}">{$payment.payment}</label></h5>{$payment.description}</div></li>

			{assign var="payment_data" value=$payment.payment_id|fn_get_payment_method_data}
			
			{if $payment_data.template && $payment_data.template != "cc_outside.tpl" && $cart.payment_id == $payment.payment_id}
				<div>
					{include file="views/orders/components/payments/`$payment_data.template`"}
				</div>
			{/if}

			{if $cart.payment_id == $payment.payment_id}
				{capture name="group_payment"}N{/capture}
			{/if}

		{/foreach}
	</ul>
	{if $active_tab == 'tab3'}
		<div class="other-text">
			<h2>{$lang.what_is_other_payment_options}</h2>
			<p>{$lang.other_payment_text}</p>
		</div>
	{/if}
</div>
