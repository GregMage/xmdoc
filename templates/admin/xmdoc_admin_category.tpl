<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons "success.png"}>';
    IMG_OFF = '<{xoAdminIcons "cancel.png"}>';
</script>
<div>
    <{$renderbutton|default:''}>
</div>
<{if $error_message|default:'' != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<div>
    <{$form|default:''}>
</div>
<{if $category_count|default:0 != 0}>
    <table id="xo-xmdoc-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_CATEGORY_LOGO}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMDOC_CATEGORY_NAME}></th>
            <th class="txtleft"><{$smarty.const._MA_XMDOC_CATEGORY_DESC}></th>
			<th class="txtcenter width5"><{$smarty.const._MA_XMDOC_CATEGORY_COLOR}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_CATEGORY_SIZE}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_CATEGORY_EXTENSION}></th>            
            <th class="txtcenter width5"><{$smarty.const._MA_XMDOC_CATEGORY_WEIGHT}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMDOC_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=itemcategory from=$category}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
				<td class="txtcenter"><img src="<{$itemcategory.logo}>" alt="<{$itemcategory.name}>" style="max-width:150px"></td>
				<td class="txtleft"><a href="../index.php?doc_cid=<{$itemcategory.id}>" title="<{$itemcategory.name}>"><{$itemcategory.name}></a></td>
                <td class="txtleft"><{$itemcategory.description}></td>
				<td class="txtcenter"><{if $itemcategory.color != false}><div style="background-color:<{$itemcategory.color}>;width:50px; height:20px;margin-left: auto; margin-right: auto;"></div><{/if}></td> 
                <td class="txtcenter"><{$itemcategory.size}></td>
                <td class="txtcenter"><{$itemcategory.extensions}></td>
                <td class="txtcenter"><{$itemcategory.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$itemcategory.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$itemcategory.id}>"
                    onclick="system_setStatus( { op: 'category_update_status', category_id: <{$itemcategory.id}> }, 'sml<{$itemcategory.id}>', 'category.php' )"
                    src="<{if $itemcategory.status}><{xoAdminIcons 'success.png'}><{else}><{xoAdminIcons 'cancel.png'}><{/if}>"
                    alt="<{if $itemcategory.status}><{$smarty.const._MA_XMDOC_STATUS_NA}><{else}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"
                    title="<{if $itemcategory.status}><{$smarty.const._MA_XMDOC_STATUS_NA}><{else}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="category.php?op=edit&amp;category_id=<{$itemcategory.id}>" title="<{$smarty.const._MA_XMDOC_EDIT}>">
                        <img src="<{xoAdminIcons 'edit.png'}>" alt="<{$smarty.const._MA_XMDOC_EDIT}>"/></a>
                    <a class="tooltip" href="category.php?op=del&amp;category_id=<{$itemcategory.id}>" title="<{$smarty.const._MA_XMDOC_DEL}>">
                        <img src="<{xoAdminIcons 'delete.png'}>" alt="<{$smarty.const._MA_XMDOC_DEL}>"/></a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>