<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons success.png}>';
    IMG_OFF = '<{xoAdminIcons cancel.png}>';
</script>
<div>
    <{$renderbutton}>
</div>
<{if $tips != ''}>
    <div class="tips ui-corner-all">
        <img class="floatleft tooltip" src="<{xoAdminIcons tips.png}>" alt="<{$smarty.const._AM_SYSTEM_TIPS}>" title="<{$smarty.const._AM_SYSTEM_TIPS}>"/>

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
<{if $error_message != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $form}>
    <div>
        <{$form}>
    </div>
<{/if}>
<{if $filter}>
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
<{if $document_count != 0}>
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
        <{foreach item=document from=$document}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><img src="<{$document.logo}>" alt="<{$document.name}>" style="max-width:150px"></td>
                <td class="txtleft"><{$document.category}></td>
                <td class="txtleft"><{$document.name}></td>
                <td class="txtleft"><{$document.description}></td>
                <td class="txtcenter"><{$document.counter}></td>
                <{if $document.showinfo == 0}>
                    <td class="txtcenter"><span style="color: red; font-weight:bold;"><{$smarty.const._NO}><span></td>
                <{else}>
                    <td class="txtcenter"><span style="color: green; font-weight:bold;"><{$smarty.const._YES}><span></td>
                <{/if}>
                <td class="txtcenter"><{$document.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$document.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$document.id}>"
                    onclick="system_setStatus( { op: 'document_update_status', document_id: <{$document.id}> }, 'sml<{$document.id}>', 'document.php' )"
                    src="<{if $document.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $document.status}><{$smarty.const._MA_XMDOC_STATUS_NA}><{else}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"
                    title="<{if $document.status}><{$smarty.const._MA_XMDOC_STATUS_NA}><{else}><{$smarty.const._MA_XMDOC_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" title="<{$smarty.const._MA_XMDOC_VIEW}>" target="_blank">
                        <img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._MA_XMDOC_VIEW}>"/>
                    </a>
                    <a class="tooltip" href="document.php?op=edit&amp;document_id=<{$document.id}>" title="<{$smarty.const._MA_XMDOC_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMDOC_EDIT}>"/>
                    </a>
                    <a class="tooltip" href="document.php?op=del&amp;document_id=<{$document.id}>" title="<{$smarty.const._MA_XMDOC_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMDOC_DEL}>"/>
                    </a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>