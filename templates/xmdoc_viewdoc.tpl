<{if $adddoc == true}>
<div class="xmdoc-widget-bar d-flex justify-content-end mb-2">
	<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="collapse" data-target="#xmdocAddPanel<{$mod}><{$docitemid}>" aria-expanded="false" aria-controls="xmdocAddPanel<{$mod}><{$docitemid}>" title="<{$smarty.const._MA_XMDOC_LINK}>">
		<span class="fa fa-plus" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_LINK}>
	</button>
</div>
<div class="collapse mb-3" id="xmdocAddPanel<{$mod}><{$docitemid}>">
	<div class="card card-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#xmdocTabLink<{$mod}><{$docitemid}>" role="tab"><span class="fa fa-link"></span> <{$smarty.const._MA_XMDOC_LINKEXISTING|default:'Lier un document existant'}></a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#xmdocTabUpload<{$mod}><{$docitemid}>" role="tab"><span class="fa fa-upload"></span> <{$smarty.const._MA_XMDOC_UPLOADNEW|default:'Téléverser un nouveau document'}></a></li>
		</ul>
		<div class="tab-content mt-3">
			<div class="tab-pane fade show active" id="xmdocTabLink<{$mod}><{$docitemid}>" role="tabpanel">
				<div class="xmdoc-docpicker"
					 data-ajax-url="<{$xmdoc_ajax_url}>"
					 data-token-name="<{$xmdoc_token_name}>"
					 data-token="<{$xmdoc_token}>"
					 data-mod="<{$xmdoc_from_mod}>"
					 data-item-id="<{$xmdoc_from_itemid}>"
					 data-reload-on-change="1"
					 data-lbl-link="<{$smarty.const._MA_XMDOC_LINK_LBL|default:'Lier'}>"
					 data-lbl-unlink="<{$smarty.const._MA_XMDOC_UNLINK|default:'Délier'}>"
					 data-lbl-empty="<{$smarty.const._MA_XMDOC_NORESULT|default:'Aucun résultat'}>"
					 data-lbl-error="<{$smarty.const._MA_XMDOC_AJAXERROR|default:'Erreur'}>"
					 data-lbl-confirm="<{$smarty.const._MA_XMDOC_CONFIRMUNLINK|default:'Confirmer ?'}>">
					<div class="form-row">
						<div class="col-md-4 mb-2">
							<select class="form-control form-control-sm xmdoc-search-cat">
								<option value="">-</option>
								<{foreach from=$xmdoc_categories_submit item=c}>
								<option value="<{$c.id}>"><{$c.name}></option>
								<{/foreach}>
							</select>
						</div>
						<div class="col-md-6 mb-2">
							<input type="text" class="form-control form-control-sm xmdoc-search-q" placeholder="<{$smarty.const._MA_XMDOC_SEARCH_PLACEHOLDER|default:'Rechercher...'}>">
						</div>
						<div class="col-md-2 mb-2">
							<button type="button" class="btn btn-sm btn-secondary btn-block xmdoc-search-btn"><span class="fa fa-search"></span> <{$smarty.const._MA_XMDOC_SEARCH|default:'Rechercher'}></button>
						</div>
					</div>
					<div class="xmdoc-results border rounded p-2" style="min-height:60px;max-height:280px;overflow:auto"></div>
				</div>
			</div>
			<div class="tab-pane fade" id="xmdocTabUpload<{$mod}><{$docitemid}>" role="tabpanel">
				<form method="post" action="<{$xmdoc_action_url}>" enctype="multipart/form-data" class="xmdoc-quick-upload">
					<input type="hidden" name="op" value="save">
					<input type="hidden" name="<{$xmdoc_token_name}>" value="<{$xmdoc_token}>">
					<input type="hidden" name="from_mod" value="<{$xmdoc_from_mod}>">
					<input type="hidden" name="from_itemid" value="<{$xmdoc_from_itemid}>">
					<input type="hidden" name="document_id" value="0">
					<div class="form-row">
						<div class="col-md-4 mb-2">
							<label class="small mb-1"><{$smarty.const._MA_XMDOC_DOCUMENT_CATEGORY}></label>
							<select class="form-control form-control-sm" name="document_category" required>
								<{foreach from=$xmdoc_categories_submit item=c}>
								<option value="<{$c.id}>"><{$c.name}></option>
								<{/foreach}>
							</select>
						</div>
						<div class="col-md-8 mb-2">
							<label class="small mb-1"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></label>
							<input type="text" class="form-control form-control-sm" name="document_name" required>
						</div>
						<div class="col-md-8 mb-2">
							<label class="small mb-1"><{$smarty.const._MA_XMDOC_DOCUMENT_FILE|default:'Fichier'}></label>
							<input type="file" class="form-control-file" name="document_document" required>
						</div>
						<div class="col-md-4 mb-2 align-self-end">
							<button type="submit" class="btn btn-sm btn-primary btn-block"><span class="fa fa-upload"></span> <{$smarty.const._MA_XMDOC_UPLOADNEW|default:'Téléverser'}></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<{/if}>
<{if $xmdoc_viewdocs == true}>

<{if $xmdoc_categories|default:array()|@count > 0}>
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
				<table class="table table-hover table-sm xmdoc-doc-list">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="text-center" style="width:48px">&nbsp;</th>
							<th scope="col" class="text-left"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
							<th scope="col" class="text-right d-none d-md-table-cell" style="width:120px"><{$smarty.const._MA_XMDOC_DOCUMENT_SIZE|default:'Taille'}></th>
							<th scope="col" class="text-right d-none d-lg-table-cell" style="width:160px"><{$smarty.const._MA_XMDOC_FORMDOC_DATE_BT}></th>
							<th scope="col" class="text-center" style="width:60px"><span class="fa fa-info-circle fa-lg" aria-hidden="true"></span></th>
						</tr>
					</thead>
					<tbody>
				<{else}>
				<div class="row">
				<{/if}>
				<{foreach item=doc from=$cat.docs}>
					<{if $xmdoc_viewlist == true}>
					<tr>
						<td class="text-center align-middle">
							<a title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank" class="text-decoration-none">
								<span class="fa fa-lg xmdoc-ft xmdoc-ft-<{$doc.filetype}> fa-<{if $doc.filetype == 'pdf'}>file-pdf-o<{elseif $doc.filetype == 'image'}>file-image-o<{elseif $doc.filetype == 'word'}>file-word-o<{elseif $doc.filetype == 'excel'}>file-excel-o<{elseif $doc.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $doc.filetype == 'archive'}>file-archive-o<{elseif $doc.filetype == 'video'}>file-video-o<{elseif $doc.filetype == 'audio'}>file-audio-o<{elseif $doc.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
							</a>
						</td>
						<td class="text-left align-middle">
							<a class="text-decoration-none" title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank">
								<{$doc.name}>
							</a>
							<div class="small text-muted d-md-none">
								<{if $doc.size != ''}><span class="fa fa-archive"></span> <{$doc.size}><{/if}>
								<span class="mx-1">&middot;</span><span class="fa fa-calendar"></span> <{$doc.date}>
							</div>
						</td>
						<td class="text-right align-middle d-none d-md-table-cell text-muted small"><{$doc.size}></td>
						<td class="text-right align-middle d-none d-lg-table-cell text-muted small"><{$doc.date}></td>
						<td class="text-center align-middle">
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
									<div class="col-12 py-2">
										<a title="<{$doc.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$doc.categoryid}>&amp;doc_id=<{$doc.id}>" target="_blank" class="text-decoration-none">
											<span class="fa fa-3x xmdoc-ft xmdoc-ft-<{$doc.filetype}> fa-<{if $doc.filetype == 'pdf'}>file-pdf-o<{elseif $doc.filetype == 'image'}>file-image-o<{elseif $doc.filetype == 'word'}>file-word-o<{elseif $doc.filetype == 'excel'}>file-excel-o<{elseif $doc.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $doc.filetype == 'archive'}>file-archive-o<{elseif $doc.filetype == 'video'}>file-video-o<{elseif $doc.filetype == 'audio'}>file-audio-o<{elseif $doc.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
											<{if $doc.size != ''}><div class="small text-muted mt-1"><{$doc.size}></div><{/if}>
										</a>
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
										<div class="col-md-3 d-flex justify-content-center align-items-center">
											<figure class="figure mt-3 text-center">
												<span class="fa fa-5x xmdoc-ft xmdoc-ft-<{$doc.filetype}> fa-<{if $doc.filetype == 'pdf'}>file-pdf-o<{elseif $doc.filetype == 'image'}>file-image-o<{elseif $doc.filetype == 'word'}>file-word-o<{elseif $doc.filetype == 'excel'}>file-excel-o<{elseif $doc.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $doc.filetype == 'archive'}>file-archive-o<{elseif $doc.filetype == 'video'}>file-video-o<{elseif $doc.filetype == 'audio'}>file-audio-o<{elseif $doc.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
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
										<{if $doc.filetype == 'pdf'}>
										<div class="row mt-3">
											<div class="col-12">
												<embed src="<{$doc.download_url}>" type="application/pdf" width="100%" height="500px" />
											</div>
										</div>
										<{elseif $doc.filetype == 'image'}>
										<div class="row mt-3">
											<div class="col-12 text-center">
												<img src="<{$doc.download_url}>" alt="<{$doc.name}>" class="img-fluid rounded" />
											</div>
										</div>
										<{/if}>
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
											<button type="button" class="btn btn-secondary xmdoc-edit-doc-btn" data-doc-id="<{$doc.id}>" data-ajaxdoc-url="<{$xmdoc_ajaxdoc_url}>" data-token-name="<{$xmdoc_token_name}>" data-token="<{$xmdoc_token}>" data-toggle="modal" data-target="#xmdocEditModal"><span class="fa fa-edit" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_EDITDOC|default:_MA_XMDOC_EDIT}></button>
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

<{if $adddoc == true}>
<!-- Shared modal for AJAX document edition -->
<div class="modal fade" id="xmdocEditModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><{$smarty.const._MA_XMDOC_EDITDOC|default:_MA_XMDOC_EDIT}></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="text-center text-muted py-4 xmdoc-edit-loading"><span class="fa fa-spinner fa-spin fa-2x"></span></div>
				<div class="xmdoc-edit-form-container"></div>
				<div class="xmdoc-edit-error alert alert-danger" style="display:none"></div>
			</div>
		</div>
	</div>
</div>
<{/if}>