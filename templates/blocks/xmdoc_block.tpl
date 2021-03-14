<{if $block.document|default:'' != ''}>
<{foreach item=blockdocument from=$block.document}>
	<div class="col-sm-4 col-md-4 xm-minibox">
		<div class="xm-document-logo">
			<img src="<{$blockdocument.logo}>" alt="<{$blockdocument.name}>" style="max-width:120px">
		</div>
		<a class="xm-document-title" title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
			<{$blockdocument.name}>
		</a>

		<div class="xm-document-description">
			<{$blockdocument.description_short}>
		</div>
		<div class="xm-document-view">
			<{if $block.use_modal == 1}>
			<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$blockdocument.id}>"></button>
			<{else}>
			<a href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$blockdocument.id}>" target="_blank">
				<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open"></button>
			</a>
			<{/if}>
		</div>
		<a class="btn btn-primary btn-xs col-md-12" title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
			<{$smarty.const._MA_XMDOC_DOWNLOAD}>
		</a>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal<{$blockdocument.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><{$blockdocument.name}></h4>
				</div>
				<div class="modal-body">
					<div class="media">
						<div class="media-left">
							<div class="xm-document-logo">
								<img class="media-object" src="<{$blockdocument.logo}>" alt="<{$blockdocument.name}>" style="max-width:120px">
							</div>
						</div>
						<div class="media-body">
							<{$blockdocument.description}>
							<{if $blockdocument.showinfo == 1}>
							<div class="xm-document-view-top">
								<div class="row xm-document-view">
									<div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>"></span>
										<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>: <{$blockdocument.date}>
									</div>
									<div class="col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>"></span>
										<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$blockdocument.author}>
									</div>
								</div>
								<{if $blockdocument.mdate|default:''}>
								<div class="row xm-document-view">
									<div class="col-md-12"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
										<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$blockdocument.mdate}>
									</div>
								</div>
								<{/if}>
								<{if $blockdocument.size != ''}>
								<div class="row xm-document-view">
									<div class="col-md-12"><span class="glyphicon glyphicon-resize-full" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
										<{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>: <{$blockdocument.size}>
									</div>
								</div>
								<{/if}>
								<div class="row xm-document-view">
									<div class="col-md-6"><span class="glyphicon glyphicon-download-alt" title="<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>"></span>
										<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$blockdocument.counter}>
									</div>
									<{if $blockdocument.dorating == 1}>
										<div class="col-md-6">
											<{include file="db:xmsocial_rating.tpl" down_xmsocial=$blockdocument.xmsocial_arr}>
										</div>
									<{/if}>
								</div>
								<div class="xm-document-general-button">
									<div class="btn-group" role="group" aria-label="...">
										<{if $blockdocument.perm_edit == true}>
										<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$blockdocument.id}>">
											<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
										</a>
										<{/if}>
										<{if $blockdocument.perm_del == true}>
										<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$blockdocument.id}>">
											<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> <{$smarty.const._MA_XMDOC_DEL}></button>
										</a>
										<{/if}>
									</div>
								</div>
							</div>
							<{/if}>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
				</div>
			</div>
		</div>
	</div>
<{/foreach}>
<{/if}>
<div class="clearfix"></div>