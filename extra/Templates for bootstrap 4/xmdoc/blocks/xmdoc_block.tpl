<div class="row">
	<{foreach item=blockdocument from=$block.document}>
	<div class="col-sm-12 col-md-6 col-lg-4 p-2">
		<div class="card">
			<div class="card-header text-center text-truncate d-none d-sm-block">
				<a class="text-decoration-none" title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
					<{$blockdocument.name}>
				</a>
			</div>
			<div class="card-header text-center d-block d-sm-none">
				<a class="text-decoration-none" title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
					<{$blockdocument.name}>
				</a>
			</div>
			<div class="card-body text-center">
				<div class="row d-flex justify-content-center" >
					<div class="col-12" style="height: 150px;">
						<{if $blockdocument.logo != ''}>
						<a title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
							<img class="rounded img-fluid mh-100" src="<{$blockdocument.logo}>" alt="<{$blockdocument.name}>">
						</a>
						<{/if}>
					</div>
					<div class="col-12 pt-2 text-left">	
						<hr />
						<{$blockdocument.description_short}>
						<hr />
					</div>

					<div class="col-6 col-md-11 col-xl-9 btn-group" role="group">
						<{if $block.use_modal == 1}>
							<a class="btn btn-primary" data-toggle="modal" data-target="#myModal<{$blockdocument.id}>" role="button"> <span class="fa fa-info-circle fa-lg text-light" aria-hidden="true"></span></a>
						<{else}>
							<a class="btn btn-primary" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$blockdocument.id}>" role="button">
								<span class="fa fa-info-circle fa-lg" aria-hidden="true"></span>
							</a>
						<{/if}>
						<a class="btn btn-primary d-block d-sm-none"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank" title="<{$document.name}>">
							<span class="fa fa-download fa-lg" aria-hidden="true"></span> 
						</a>
						<a class="btn btn-primary d-none d-sm-block"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank" title="<{$blockdocument.name}>">
							<span class="fa fa-download fa-lg" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
						</a>
					</div>




				</div>				
			</div>				
		</div>
	</div>
	<div class="modal" tabindex="-1" id="myModal<{$blockdocument.id}>" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><{$blockdocument.name}></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12 col-md-3">
							<{if $blockdocument.logo != ''}>
							<a title="<{$blockdocument.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$blockdocument.categoryid}>&amp;doc_id=<{$blockdocument.id}>" target="_blank">
								<img class="rounded img-fluid mh-100" src="<{$blockdocument.logo}>" alt="<{$blockdocument.name}>">
							</a>
							<{/if}>
						</div>						
						<div class="col-12 col-md-9 text-left">
							<{$blockdocument.description}>
						</div>
						<{if $blockdocument.showinfo == 1}>
						<div class="col-12 p-4">
							<div class="card">
								<div class="card-header">
									<{$smarty.const._MA_XMDOC_GENINFORMATION}>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-lg-6">
											<i class="fa fa-calendar" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_FORMDOC_DATE}>: <{$blockdocument.date}>
										</div>
										<div class="col-12 col-lg-6">
											<i class="fa fa-user" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>: <{$blockdocument.author}>
										</div>
										<{if $blockdocument.mdate}>
										<div class="col-12 col-lg-6">
											<i class="fa fa-calendar" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_FORMDOC_MDATE}>: <{$blockdocument.mdate}>
										</div>
										<{/if}>
										<{if $blockdocument.size}>
										<div class="col-12 col-lg-6">
											<i class="fa fa-expand" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_FORMDOC_SIZE}>: <{$blockdocument.size}>
										</div>
										<{/if}>
										<div class="col-12 col-lg-6">
											<i class="fa fa-download" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_FORMDOC_DOWNLOAD}>: <{$blockdocument.counter}>
										</div>
										<{if $blockdocument.dorating == 1}>
											<div class="col-12 col-lg-6">
												<{include file="db:xmsocial_rating.tpl" down_xmsocial=$blockdocument.xmsocial_arr}>
											</div>
										<{/if}>
									</div>									
								</div>
							</div>
						</div>
						<{/if}>
					</div>
					<div class="text-center">
						<div class="btn-group text-center" role="group">
							<{if $blockdocument.perm_edit == true}>
								<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$blockdocument.id}>"><i class="fa fa-edit" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_EDIT}></button>
							<{/if}>
							<{if $blockdocument.perm_del == true}>
								<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$blockdocument.id}>"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._MA_XMDOC_DEL}></button>
							<{/if}>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<{/foreach}>
</div>