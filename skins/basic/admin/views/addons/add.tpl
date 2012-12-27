<div id="content_add_new_addon">
<form action="{""|fn_url}" method="post" name="update_addons_form" class="cm-form-highlight cm-disable-empty-files{if ""|fn_check_form_permissions} cm-hide-inputs{/if}" enctype="multipart/form-data">
<input type="hidden" class="cm-no-hide-input" name="redirect_url" value="{$smarty.request.return_url}" />


<div class="buttons-container">

        {include file="buttons/save_cancel.tpl" but_name="dispatch[addons.manage]" cancel_action="close" hide_first_button=false}
</div>

</form>
</div>
