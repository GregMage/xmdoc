<!doctype html>
<html lang="<{$xoops_langcode}>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>">
    <meta http-equiv="content-language" content="<{$xoops_langcode}>">
    <title><{$xoops_sitename}> <{$lang_imgmanager}></title>
    <{$image_form.javascript}>
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl xoops.css}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl modules/system/css/imagemanager.css}>">
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl media/font-awesome/css/font-awesome.min.css}>">
</head>

<body onload="window.resizeTo(<{$xsize|default:800}>, <{$ysize|default:800}>);">
<div class="xmdoc">
	<{if $selected}>
		<h2><{$smarty.const._MA_XMDOC_FORMDOC_SELECTED}></h2>
		<table cellspacing="0" id="imagemain">
			<tr>
			<{foreach item=seldoc from=$seldoc}>			
				<td class="txtcenter"><{$seldoc.name}><br><{$seldoc.logo}></td>
				<{if $seldoc.count is div by 4}>
				</tr>
				<tr>
				<{/if}>
			<{/foreach}>
			</tr>
		</table>
		<form name="selreset" id="selreset" action="docmanager.php" method="post">
			<input type="hidden" name="selectreset" value="true" />
			<input type='submit' class='formButton' name='subselect'  id='subselect' value='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>' title='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>'  />
			<input value="<{$smarty.const._SUBMIT}>" type="button" onclick="window.close();"/>
		</form>
	<{/if}>
	<{if $form}>
		<div class="xmform">
			<h2><{$smarty.const._MA_XMDOC_SEARCH}></h2>
			<{$form}>
		</div>
	<{/if}>
	<{if $document != ""}>
        <h3 class="tdm-title"><{$smarty.const._MA_XMDOC_FORMDOC_LISTDOCUMENT}>:</h3>
		<form name="formsel" id="formsel" action="docmanager.php" method="post">
			<table cellspacing="0" id="imagemain">
				<tr>
					<th class="txtcenter width5"><{$smarty.const._MA_XMDOC_FORMDOC_SELECT}></th>
					<th class="txtcenter width10"><{$smarty.const._MA_XMDOC_DOCUMENT_LOGO}></th>
					<th class="txtleft width15"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
				</tr>
				<tbody>
				
				<{foreach item=document from=$document}>
					<tr class="<{cycle values='even,odd'}> alignmiddle">
						<td class="txtcenter"><input type="checkbox" name="selDocs[]" id="selDocs<{$document.id}>"  title="Selectio documents" value="<{$document.id}>"  /></td>
						<td class="txtcenter"><{$document.logo}></td>
						<td class="txtleft"><h4><{$document.name}></h4><br><{$document.description}></td>
					</tr>
				<{/foreach}>

				</tbody>
			</table>
		<input type='submit' class='formButton' name='select'  id='select' value='<{$smarty.const._MA_XMDOC_FORMDOC_SELECT}>' title='<{$smarty.const._MA_XMDOC_FORMDOC_SELECT}>'  />
		</form>
    <{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
</div><!-- .xmdoc -->
<div id="footer">
    <input value="<{$smarty.const._CLOSE}>" type="button" onclick="window.close();"/>
</div>

</body>
</html>
