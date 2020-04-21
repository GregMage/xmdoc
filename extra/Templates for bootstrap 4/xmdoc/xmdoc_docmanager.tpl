<!doctype html>
<html lang="<{$xoops_langcode}>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>">
    <meta http-equiv="content-language" content="<{$xoops_langcode}>">
    <title><{$xoops_sitename}> <{$lang_imgmanager}></title>
    <{$image_form.javascript}>
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl xoops.css}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl modules/system/css/imagemanager.css}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl modules/system/css/admin.css}>">
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl media/font-awesome/css/font-awesome.min.css}>">
	<{if $bootstrap_css != ''}>
	<link rel="stylesheet" type="text/css" media="screen" href="<{$bootstrap_css}>">
	<{/if}>
</head>
<body onload="window.resizeTo(<{$xsize|default:1024}>, <{$ysize|default:768}>);window.moveTo(400,300);">
<{if $bootstrap_css != ''}>

	<div class="m-3">

		<div class="card text-center mb-3">
			<{if $selected}>
				<div class="card-header">
					<{$seldoc_count}>
					<{if $seldoc_count > 1}>
						<{$smarty.const._MA_XMDOC_FORMDOC_SELECTED}>
					<{else}>
						<{$smarty.const._MA_XMDOC_FORMDOC_1SELECTED}>
					<{/if}>
				</div>
				<div class="card-body">
					<div class="row">
						<{foreach item=seldoc from=$seldoc}>
							<div class="col-6 col-sm-3 col-lg-2 p-1">	
								<div class="card">								
									<div class="card-body text-center text-truncate"><strong><{$seldoc.name}></strong><br><{$seldoc.logo}></div>
								</div>
							</div>
						<{/foreach}>
					</div>
				</div>
				<div class="card-footer">
					<form class="text-center" name="selreset" id="selreset" action="docmanager.php" method="post">
						<input type="hidden" name="selectreset" value="true" />
						<input type='submit' class='formButton' name='subselect'  id='subselect' value='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>' title='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>'  />
						<input value="<{$smarty.const._MA_XMDOC_FORMDOC_VALIDATE}>" type="button" onclick="window.close();"/>
					</form>
				</div>
			<{else}>
				<div class="card-header"><{$smarty.const._MA_XMDOC_FORMDOC_NODOCSELECTED}></div>
			<{/if}>
		</div>
		
		<div class="card text-center mb-3">
			<div class="card-header"><{$smarty.const._MA_XMDOC_FORMDOC_ADD}></div>
			<div class="card-body">
				<div class="row mx-2 d-flex align-items-center">
					<div class="col-9 border-right">
						<{if $form}>
							<div class="xmform mb-3">
								<h5><{$smarty.const._MA_XMDOC_SEARCH}></h5>
								<{$form}>
							</div>
						<{/if}>
					</div>
					<div class="col-3">
						<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=add" class="btn btn-primary btn-sm" target="_blank" role="button" aria-pressed="true" title="<{$smarty.const._MA_XMDOC_DOCUMENT_ADD}>">
							<{$smarty.const._MA_XMDOC_DOCUMENT_ADD}>
						</a>
					</div>
				</div>
					<{if $error_message != ''}>
						<div class="errorMsg text-left mt-2">
							<{$error_message}>
						</div>
					<{/if}>
					<{if $document != ""}>
						<div class="">
							<form name="formsel" id="formsel" action="docmanager.php" method="post">
								
								<!--<table cellspacing="0" id="imagemain">-->
								<table class="table table-hover table-striped table-bordered mt-4" id="">
									<thead>
										<tr class="table-secondary">
											<th class="text-center" colspan="4" ><{$smarty.const._MA_XMDOC_FORMDOC_LISTDOCUMENT}></th>	
										</tr>
										<tr class="table-secondary">
											<th class="text-center"><{$smarty.const._MA_XMDOC_FORMDOC_SELECT}></th>
											<th class="text-center"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
											<th class="text-center d-none d-sm-table-cell"><{$smarty.const._MA_XMDOC_DOCUMENT_DESC}></th>
											<th class="text-center"><{$smarty.const._MA_XMDOC_FORMDOC_CHECKLINK}></th>
										</tr>
									<thead>
									<tbody>
									<{foreach item=document from=$document}>
										<tr class="table-primary" scope="row">
											<td class="align-middle text-center">

<!--
												<input type="checkbox" name="selDocs[]" id="selDocs<{$document.id}>"  title="Selectio documents" value="<{$document.id}>"  />
-->												
												
												
												<fieldset>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="selDocs[]" id="selDocs<{$document.id}>" class="custom-control-input" value="<{$document.id}>" >
															<label class="custom-control-label" for="selDocs<{$document.id}>"></label>
														</div>
													</div>
												</fieldset>
											</td>
											<td class="align-middle text-center">
												<{$document.name}><br /><{$document.logo}>
											</td>
											<td class="align-middle text-left d-none d-sm-table-cell">
												<{$document.description|truncateHtml:60:'...'}>
											</td>
											<td class="align-middle text-center">
												<a title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
													<span class="fa fa-link fa-3x"></span>
												</a>
											</td>
										</tr>
									<{/foreach}>
									</tbody>
								</table>
							<input type='submit' class='formButton' name='select'  id='select' value='<{$smarty.const._MA_XMDOC_FORMDOC_SELECT}>' title='<{$smarty.const._MA_XMDOC_FORMDOC_SELECT}>'  />
							</form>
						</div>
					<{/if}>
			</div>
		</div>

		<div class="clear spacer"></div>
		<{if $nav_menu}>
			<div class="floatright"><{$nav_menu}></div>
			<div class="clear spacer"></div>
		<{/if}>
	</div><!-- .xmdoc -->
	<div id="footer" class="text-center">
		<input value="<{$smarty.const._CLOSE}>" type="button" onclick="window.close();"/>
	</div>

<{else}>
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
		<div id="addimage" class="txtright">
			<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=add" title="<{$smarty.const._MA_XMDOC_DOCUMENT_ADD}>" target="_blank"><{$smarty.const._MA_XMDOC_DOCUMENT_ADD}></a>
		</div>
		<{if $error_message != ''}>
			<div class="errorMsg" style="text-align: left;">
				<{$error_message}>
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
							<td class="txtleft">
								<a title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
									<h4><{$document.name}></h4>
								</a>
								<br><{$document.description}>
							</td>
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
<{/if}>
</body>
</html>
