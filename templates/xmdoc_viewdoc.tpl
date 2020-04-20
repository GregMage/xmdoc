<{if $xmdoc_viewdocs == true}>
    <{foreach item=viewdocument from=$document}>
        <div class="col-sm-4 col-md-4 xm-minibox">
            <div class="xm-document-logo">
                <img src="<{$viewdocument.logo}>" alt="<{$viewdocument.name}>" style="max-width:120px">
            </div>
            <a class="xm-document-title" title="<{$viewdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$viewdocument.categoryid}>&amp;doc_id=<{$viewdocument.id}>" target="_blank">
                <{$viewdocument.name}>
            </a>
			<div class="xm-document-description">
				<{$viewdocument.description_short}>
			</div>
			<div class="xm-document-view">
				<{if $use_modal == 1}>
				<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="modal" data-target="#myModal<{$viewdocument.id}>"></button>
				<{else}>
				<a href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$viewdocument.id}>" target="_blank">
					<button type="button" class="btn btn-default btn-xs glyphicon glyphicon-eye-open"></button>
				</a>
				<{/if}>
			</div>
            <a class="btn btn-primary btn-xs col-md-9" title="<{$viewdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$viewdocument.categoryid}>&amp;doc_id=<{$viewdocument.id}>" target="_blank">
                <{$smarty.const._MA_XMDOC_DOWNLOAD}>
            </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal<{$viewdocument.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="viewdocument">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><{$viewdocument.name}></h4>
                    </div>
                    <div class="modal-body">
                        <div class="media">
                            <div class="media-left">
								<div class="xm-document-logo">
                                    <img class="media-object" src="<{$viewdocument.logo}>" alt="<{$viewdocument.name}>" style="max-width:120px">
								</div>
                            </div>
                            <div class="media-body">
                                <{$viewdocument.description}>
                                <{if $viewdocument.showinfo == 1}>
                                <div class="xm-document-view-top">
                                    <div class="row xm-document-view">
                                        <div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_DATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_DATE}>: <{$viewdocument.date}>
                                        </div>
                                        <div class="col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$viewdocument.author}>
                                        </div>
                                    </div>
                                    <{if $viewdocument.mdate}>
                                    <div class="row xm-document-view">
                                        <div class="col-md-12"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$viewdocument.mdate}>
                                        </div>
                                    </div>
                                    <{/if}>
									<{if $viewdocument.size != ''}>
									<div class="row xm-document-view">
										<div class="col-md-12"><span class="glyphicon glyphicon-resize-full" title="<{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>"></span>
											<{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>: <{$viewdocument.size}>
										</div>
									</div>
									<{/if}>
                                    <div class="row xm-document-view">
                                        <div class="col-md-6"><span class="glyphicon glyphicon-download-alt" title="<{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>"></span>
                                            <{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$viewdocument.counter}>
                                        </div>
										<{if $viewdocument.dorating == 1}>
										<div class="col-md-6">
											<{include file="db:xmsocial_rating.tpl" down_xmsocial=$viewdocument.xmsocial_arr}>
										</div>
										<{/if}>
                                    </div>
									<div class="xm-document-general-button">
										<div class="btn-group" role="group" aria-label="...">
											<{if $viewdocument.perm_edit == true}>
											<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$viewdocument.id}>">
												<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
											</a>
											<{/if}>
											<{if $viewdocument.perm_del == true}>
											<a href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$viewdocument.id}>">
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
<!-- .xmdoc -->