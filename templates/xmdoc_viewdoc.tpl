<{if $adddoc == true}>
<div style="display: flex; justify-content: flex-end;">
	<button type='button' class='btn btn-sm btn-outline-secondary' onclick='openWithSelfMain("<{$xoops_url}>/modules/xmdoc/docmanager.php?op=add&docitemid=<{$docitemid}>&mod=<{$mod}>","docmanager",400,430);' onmouseover='style.cursor="hand"' title='<{$smarty.const._MA_XMDOC_LINK}>'><span class="fa fa-link" aria-hidden="true"></span></button>
</div>
<{/if}>
<{if $xmdoc_viewdocs == true}>

<{if $xmdoc_categories|@count > 0}>
	<ul class="nav nav-tabs" id="xmdocTabs" role="tablist">
		<{foreach from=$xmdoc_categories item=cat name=tabs}>
			<li class="nav-item">
				<a class="nav-link<{if $smarty.foreach.tabs.first}> active<{/if}>" id="tab-<{$cat.id}>" data-toggle="tab" href="#pane-<{$cat.id}>" role="tab" aria-controls="pane-<{$cat.id}>" aria-selected="<{if $smarty.foreach.tabs.first}>true<{else}>false<{/if}>"><{$cat.name}></a>
			</li>
		<{/foreach}>
	</ul>

	<div class="tab-content mt-3">
		<{foreach from=$xmdoc_categories item=cat name=panes}>
			<div class="tab-pane fade<{if $smarty.foreach.panes.first}> show active<{/if}>" id="pane-<{$cat.id}>" role="tabpanel" aria-labelledby="tab-<{$cat.id}>">
				<{if $xmdoc_viewlist == true}>
				<table class="table table-hover">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="text-center col-3"><{$smarty.const._MA_XMDOC_DOCUMENT_LOGO}></th>
							<th scope="col" class="text-left col-8"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
							<th scope="col" class="text-center col-1"><span class="fa fa-info-circle fa-lg" aria-hidden="true"></span></th>
						</tr>
					</thead>
					<tbody>
				<{else}>
				<div class="row">
				<{/if}>
				<{foreach item=doc from=$cat.docs}>
					<{if $xmdoc_viewlist == true}>
					<tr>
						<td class="text-center">
						<{if $doc.logo != ''}>
							<a title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
								<img class="rounded img-fluid mh-100" src="<{$doc.logo}>" alt="<{$doc.name}>" style="max-width:<{$xmdoc_logosize}>px">
							</a>
						<{/if}>
						</td>
						<td class="text-left">
							<a class="text-decoration-none" title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
								<{$doc.name}>
							</a>
						</td>
						<td class="text-center">
							<{if $use_modal == 1}>
								<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<{$doc.id}>" role="button"> <span class="fa fa-info-circle fa-lg text-light" aria-hidden="true"></span></a>
							<{else}>
								<a class="btn btn-primary btn-sm" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$doc.id}>" role="button" target="_blank">
									<span class="fa fa-info-circle fa-lg" aria-hidden="true"></span>
								</a>
							<{/if}>
						</td>
					</tr>
					<{else}>
					<div class="col-12 col-md-6 col-lg-4 p-2">
						<div class="card" <{if $doc.color != false}>style="border-color : <{$doc.color}>;"<{/if}>>
							<div class="card-header text-center text-truncate d-none d-sm-block" <{if $doc.color != false}>style="background-color : <{$doc.color}>;"<{/if}>>
								<a class="text-decoration-none" title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
									<h5 class="mb-0"><{$doc.name}></h5>
								</a>
							</div>
							<div class="card-header text-center d-block d-sm-none" <{if $doc.color != false}>style="background-color : <{$doc.color}>;"<{/if}>>
								<a class="text-decoration-none" title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
								<h5 class="mb-0"><{$doc.name}></h5>
								</a>
							</div>
							<div class="card-body text-center">
								<div class="row d-flex justify-content-center" >
									<div class="col-12" style="height: 150px;">
										<{if $doc.logo != ''}>
										<a title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
											<img class="rounded img-fluid mh-100" src="<{$doc.logo}>" alt="<{$doc.name}>">
										</a>
										<{/if}>
									</div>
									<div class="col-12 text-left">
										<hr />
										<{$doc.description_short}>
										<hr />
									</div>
									<div class="col-10 col-md-11 col-xl-10 btn-group" role="group">
										<{if $use_modal == 1}>
											<a class="btn btn-primary" data-toggle="modal" data-target="#myModal<{$doc.id}>" role="button"> <span class="fa fa-info-circle fa-lg text-light" aria-hidden="true"></span></a>
										<{else}>
											<a class="btn btn-primary" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$doc.id}>" role="button" target="_blank">
												<span class="fa fa-info-circle fa-lg" aria-hidden="true"></span>
											</a>
										<{/if}>
										<a class="btn btn-primary d-block d-sm-none"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank" title="<{$doc.name}>">
											<span class="fa fa-download fa-lg" aria-hidden="true"></span>
										</a>
										<a class="btn btn-primary d-none d-sm-block"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank" title="<{$doc.name}>">
											<span class="fa fa-download fa-lg" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<{/if}>
					<div class="modal" tabindex="-1" id="myModal<{$doc.id}>" role="dialog">
						<div class="modal-dialog modal-lg" role="viewdocument">
							<div class="modal-content">
								<div class="modal-header d-flex justify-content-between">
									<h5 class="modal-title"><{$doc.name}></h5>
									<div class="row text-right">
										<div class="col">
											<{if $doc.showinfo == 1}>
												<span class="badge badge-secondary fa-lg text-primary ml-1"><span class="fa fa-download" aria-hidden="true"></span><small> <{$doc.counter}></small></span>
												<{if $doc.size != ''}>
													<span class="badge badge-secondary fa-lg text-primary ml-1 mt-1 mt-lg-0"><span class="fa fa-archive" aria-hidden="true"></span><small> <{$doc.size}></small></span>
												<{/if}>
											<{/if}>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
									</div>
								</div>
								<div class="modal-body">
									<{if $doc.showinfo == 1}>
										<div class="row border-bottom border-secondary mx-1 pl-1">
											<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
												<span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_DATE_BT}>
												<figcaption class="figure-caption text-center"><{$doc.date}></figcaption>
											</figure>
											<{if $doc.mdate|default:false}>
											<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
												<span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_MDATE_BT}>
												<figcaption class="figure-caption text-center"><{$doc.mdate}></figcaption>
											</figure>
											<{/if}>
											<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
												<span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>
												<figcaption class="figure-caption text-center"><{$doc.author}></figcaption>
											</figure>
											<{if $doc.dorating == 1}>
											<figure class="text-muted m-1 pr-2 text-center border-right border-secondary">
												<{include file="db:xmsocial_rating.tpl" down_xmsocial=$doc.xmsocial_arr}>
												<figcaption class="figure-caption text-center"></figcaption>
											</figure>
											<{/if}>
										</div>
									<{/if}>
										<div class="row">
											<div class="col-md-3 d-flex justify-content-center">
												<figure class="figure mt-3">
													<img src="<{$doc.logo}>" class="figure-img img-fluid rounded mx-auto d-block" alt="<{$doc.name}>">
													<figcaption class="figure-caption text-center"><h5 class="mt-0"><{$doc.name}></h5></figcaption>
												</figure>
											</div>
											<div class="col-md-9 align-self-center">
													<{if $doc.description_end}>
														<{$doc.description_short}>
														<hr />
														<{$doc.description_end}>
													<{else}>
														<{$doc.description}>
													<{/if}>
											</div>
										</div>
								</div>
								<div class="modal-footer d-flex justify-content-center">
									<a class="btn btn-primary" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank" title="<{$doc.name}>">
										<span class="fa fa-download fa-lg" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
									</a>
								</div>
								<{if ($doc.perm_edit == true) || ($doc.perm_del == true)}>
									<div class="modal-footer d-flex justify-content-center">
										<div class="btn-group text-center" role="group">
											<{if $doc.perm_edit == true}>
												<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$doc.id}>"><span class="fa fa-edit" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
											<{/if}>
											<{if $doc.perm_del == true}>
												<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$doc.id}>"><span class="fa fa-trash" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DEL}></button>
											<{/if}>
										</div>
									</div>
								<{/if}>
							</div>
						</div>
					</div>
				<{/foreach}>
				<{if $xmdoc_viewlist == true}>
					</tbody>
				</table>
				<{else}>
				</div>
				<{/if}>
			</div>
		<{/foreach}>
	</div>
<{/if}>
<{/if}>