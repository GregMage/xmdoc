<script type="text/javascript">
    IMG_ON = "<{xoAdminIcons 'success.png'}>";
    IMG_OFF = "<{xoAdminIcons 'cancel.png'}>";
</script>
<div>
    <{$renderbutton|default:''}>
</div>
<{if $tips|default:'' != ''}>
    <div class="tips ui-corner-all">
        <img class="floatleft tooltip" src="<{xoAdminIcons 'tips.png'}>" alt="<{$smarty.const._AM_SYSTEM_TIPS}>" title="<{$smarty.const._AM_SYSTEM_TIPS}>"/>

        <div class="floatleft">
            <h4><{$smarty.const._MA_XMDOC_DOCUMENT_DOCUMENT}></h4>
            <ul>
                <li><{$smarty.const._MA_XMDOC_CATEGORY_SIZE}>: <{$size}></li>
                <li><{$smarty.const._MA_XMDOC_CATEGORY_EXTENSION}>: <{$extensions}></li>
            </ul>
        </div>
        <div class="clear">&nbsp;</div>
    </div>
<{/if}>
<{if $error_message|default:'' != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $warning_message|default:'' != ''}>
    <div class="xm-warning-msg xo-actions">
        <{$warning_message}>
		<a class="tooltip" href="document.php?status=2" title="<{$smarty.const._MA_XMDOC_VIEW}>">
			<img src="<{xoAdminIcons 'view.png'}>" alt="<{$smarty.const._MA_XMDOC_VIEW}>">
		</a>
    </div>
<{/if}>
<{if $form|default:false}>
    <div>
        <{$form}>
    </div>
<{/if}>
<{if $filter|default:false}>
	<div align="right">
		<form id="form_document_tri" name="form_document_tri" method="get" action="document.php">
			<{$smarty.const._MA_XMDOC_DOCUMENT_CATEGORY}>
			<select name="category_filter" id="category_filter" onchange="location='document.php?start=<{$start}>&status=<{$status}>&category='+this.options[this.selectedIndex].value">
				<{$category_options}>
			<select>
			<{$smarty.const._MA_XMDOC_STATUS}>
			<select name="status_filter" id="status_filter" onchange="location='document.php?start=<{$start}>&category=<{$category}>&status='+this.options[this.selectedIndex].value">
				<{$status_options}>
			<select>
		</form>
	</div>
<{/if}>
<{if $document_count|default:0 != 0}>
    <table id="xo-xmdoc-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_DOCUMENT_LOGO}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMDOC_DOCUMENT_CATEGORY}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
            <th class="txtleft"><{$smarty.const._MA_XMDOC_DOCUMENT_DESC}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_DOCUMENT_SHOWINFO}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMDOC_DOCUMENT_WEIGHT}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMDOC_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMDOC_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=itemdocument from=$document}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><img src="<{$itemdocument.logo}>" alt="<{$itemdocument.name}>" style="max-width:150px"></td>
				<td class="txtleft"><a href="../index.php?doc_cid=<{$itemdocument.categoryid}>" title="<{$itemdocument.category}>"><{$itemdocument.category}></a></td>
				<{if $modal == true}>
					<td class="txtleft"><a href="../document.php?doc_id=<{$itemdocument.id}>" title="<{$itemdocument.name}>"><{$itemdocument.name}></a></td>
				<{else}>
					<td class="txtleft"><{$itemdocument.name}></td>
				<{/if}>
                <td class="txtleft"><{$itemdocument.description}></td>
                <td class="txtcenter"><{$itemdocument.counter}></td>
                <{if $itemdocument.showinfo == 0}>
                    <td class="txtcenter"><span style="color: red; font-weight:bold;"><{$smarty.const._NO}><span></td>
                <{else}>
                    <td class="txtcenter"><span style="color: green; font-weight:bold;"><{$smarty.const._YES}><span></td>
                <{/if}>
                <td class="txtcenter"><{$itemdocument.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$itemdocument.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$itemdocument.id}>"
                    onclick="system_setStatus( { op: 'document_update_status', document_id: <{$itemdocument.id}>, document_status: <{$itemdocument.status}> }, 'sml<{$itemdocument.id}>', 'document.php' )"
                    src="<{if $itemdocument.status == 1}><{xoAdminIcons 'success.png'}><{/if}><{if $itemdocument.status == 0}><{xoAdminIcons 'cancel.png'}><{/if}><{if $itemdocument.status == 2}><{xoAdminIcons 'messagebox_warning.png'}><{/if}>"
                    alt="<{if $itemdocument.status == 1}><{$smarty.const._MA_XMDOC_STATUS_NA}><{/if}><{if $itemdocument.status == 0 || $itemdocument.status == 2}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"
                    title="<{if $itemdocument.status == 1}><{$smarty.const._MA_XMDOC_STATUS_NA}><{/if}><{if $itemdocument.status == 0 || $itemdocument.status == 2}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
					<{if $usemodal == 0}>
					<a class="tooltip" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$itemdocument.id}>" title="<{$smarty.const._MA_XMDOC_VIEW}>">
                        <img src="<{xoAdminIcons 'view.png'}>" alt="<{$smarty.const._MA_XMDOC_VIEW}>"/></a>
					<{/if}>
                    <a class="tooltip" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$itemdocument.categoryid}>&amp;doc_id=<{$itemdocument.id}>" title="<{$smarty.const._MA_XMDOC_DOWNLOAD}>" target="_blank">
                        <img src="<{xoAdminIcons 'attach.png'}>" alt="<{$smarty.const._MA_XMDOC_DOWNLOAD}>"/></a>
                    <a class="tooltip" href="document.php?op=edit&amp;document_id=<{$itemdocument.id}>" title="<{$smarty.const._MA_XMDOC_EDIT}>">
                        <img src="<{xoAdminIcons 'edit.png'}>" alt="<{$smarty.const._MA_XMDOC_EDIT}>"/></a>
                    <a class="tooltip" href="document.php?op=del&amp;document_id=<{$itemdocument.id}>" title="<{$smarty.const._MA_XMDOC_DEL}>">
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