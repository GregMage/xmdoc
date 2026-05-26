<{if $cat|default:false}>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php"><{$index_module}></a></li>
			<li class="breadcrumb-item active" aria-current="page"><{$category_name}></li>
		</ol>
	</nav>
<{else}>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active" aria-current="page"><{$index_module}></li>
		</ol>
	</nav>
<{/if}>
<{if $index_header|default:'' != ''}>
    <div class="row">
        <div class="col-sm-12">
            <{$index_header}>
			<hr />
        </div>
    </div>
<{/if}>
<div align="center">
	<{if $index_cat == 2 || $index_cat == 3}>
	<h3><{$smarty.const._MA_XMDOC_CATEGORY_LIST}></h3>
	<div class="xm-category row">
	<{foreach item=categories from=$cat_array}>
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 p-2
			<{if $cat && $categories.id == $doc_cid}>
				bg-secondary
			<{/if}>">
			<a title="<{$categories.name}>" href="<{$xoops_url}>/modules/xmdoc/index.php?doc_cid=<{$categories.id}>">
				<div class="card xmdoc-border" <{if $categories.color != false}>style="border-color : <{$categories.color}>;"<{/if}>>
					<div class="card-header text-center" <{if $categories.color != false}>style="background-color : <{$categories.color}>;"<{/if}>>
						<h6 class="mb-0 text-white"><{$categories.name}></h6>
					</div>
					<div class="card-body h-md-550 text-center">
						<div class="row" style="height: 90px;">
							<div class="col-12 h-75">
								<{if $categories.logo != ''}>
									<img class="rounded img-fluid mh-100" src="<{$categories.logo}>" alt="<{$categories.name}>">
								<{/if}>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>
	<{/foreach}>
	</div>
	<{/if}>
</div>
<{if $cat}>
<hr />
	<div class="row mb-2 align-items-center">
		<{if $category_logo != ''}>
		<div class="col-auto">
			<img class="rounded" src="<{$category_logo}>" alt="<{$category_name}>" style="max-height:64px;max-width:120px;">
		</div>
		<{/if}>
		<div class="col">
			<h4 class="mt-0 mb-1"><{$category_name}></h4>
			<{$category_description}>
		</div>
	</div>
<{/if}>
<{if $document_count|default:0 != 0}>
	<form method="get" action="index.php" class="d-flex justify-content-end align-items-center flex-wrap mb-2 mt-2">
		<{if $index_cat == 1 || $index_cat == 3}>
		<div class="form-group mr-3 mb-1">
			<label class="mr-1 small"><{$smarty.const._MA_XMDOC_INDEX_SELECTCATEGORY}>&nbsp;</label>
			<select class="form-control form-control-sm" name="doc_cid" onchange="this.form.submit()">
				<{$doc_cid_options}>
			</select>
		</div>
		<{else}>
		<input type="hidden" name="doc_cid" value="<{$doc_cid}>">
		<{/if}>
		<div class="form-group mb-1">
			<div class="input-group input-group-sm">
				<input type="text" name="doc_search" id="xmdoc-search-name" class="form-control" placeholder="Filtrer par nom..." value="<{$doc_search|default:''}>" autocomplete="off" style="min-width:200px;">
				<div class="input-group-append">
					<button class="btn btn-secondary" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
				</div>
			</div>
		</div>
	</form>
	<{if $viewlist == true}>
	<table class="table table-hover">
		<thead class="thead-light">
			<tr>
				<th scope="col" class="text-center" style="width:3rem;"><span class="fa fa-file fa-lg" aria-hidden="true"></span></th>
				<th scope="col" class="text-left"><{$smarty.const._MA_XMDOC_DOCUMENT_NAME}></th>
				<th scope="col" class="text-left d-none d-md-table-cell"><{$smarty.const._MA_XMDOC_DOCUMENT_CATEGORY}></th>
				<th scope="col" class="text-center" style="width:4rem;"><span class="fa fa-info-circle fa-lg" aria-hidden="true"></span></th>
			</tr>
		</thead>
		<tbody id="xmdoc-doc-list">
	<{else}>
	<div class="row">
	<{/if}>
		<{foreach item=document from=$documents}>
		<{if $viewlist == true}>
			<tr data-docname="<{$document.name|escape:'html'}>">
				<td class="text-center">
					<span class="fa fa-2x xmdoc-ft xmdoc-ft-<{$document.filetype}> fa-<{if $document.filetype == 'pdf'}>file-pdf-o<{elseif $document.filetype == 'image'}>file-image-o<{elseif $document.filetype == 'word'}>file-word-o<{elseif $document.filetype == 'excel'}>file-excel-o<{elseif $document.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $document.filetype == 'archive'}>file-archive-o<{elseif $document.filetype == 'video'}>file-video-o<{elseif $document.filetype == 'audio'}>file-audio-o<{elseif $document.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
				</td>
					<td class="text-left">
					<a class="text-decoration-none" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
						<{$document.name}>
					</a>
				</td>
				<td class="text-left d-none d-md-table-cell"><{$document.category}></td>
				<td class="text-center">
					<{if $use_modal == 1}>
						<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<{$document.id}>" role="button"> <span class="fa fa-info-circle fa-lg text-light" aria-hidden="true"></span></a>
					<{else}>
						<a class="btn btn-primary btn-sm" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$document.id}>" role="button" target="_blank">
							<span class="fa fa-info-circle fa-lg" aria-hidden="true"></span>
						</a>
					<{/if}>
				</td>
			</tr>
			<{else}>
			<div class="col-sm-12 col-md-6 col-lg-4 p-2 xmdoc-doc-item" data-docname="<{$document.name|escape:'html'}>">
				<div class="card xmdoc-border" <{if $document.color != false}>style="border-color : <{$document.color}>;"<{/if}>>
					<div class="card-header text-center text-truncate d-none d-sm-block" <{if $document.color != false}>style="background-color : <{$document.color}>;"<{/if}>>
						<div class="d-flex justify-content-center text-center">
							<a class="text-decoration-none" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
								<h5 class="mb-0"><{$document.name}></h5>
							</a>
						</div>
					</div>
					<div class="card-header text-center d-block d-sm-none" <{if $document.color != false}>style="background-color : <{$document.color}>;"<{/if}>>
						<div class="d-flex justify-content-center text-center">
							<a class="text-decoration-none" title="<{$document.name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank">
								<h5 class="mb-0"><{$document.name}></h5>
							</a>
						</div>
					</div>
					<div class="card-body text-center">
						<div class="row d-flex justify-content-center">
						<div class="col-12 text-center py-2">
							<span class="fa fa-3x xmdoc-ft xmdoc-ft-<{$document.filetype}> fa-<{if $document.filetype == 'pdf'}>file-pdf-o<{elseif $document.filetype == 'image'}>file-image-o<{elseif $document.filetype == 'word'}>file-word-o<{elseif $document.filetype == 'excel'}>file-excel-o<{elseif $document.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $document.filetype == 'archive'}>file-archive-o<{elseif $document.filetype == 'video'}>file-video-o<{elseif $document.filetype == 'audio'}>file-audio-o<{elseif $document.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
							<{if $document.size != ''}><div class="small text-muted mt-1"><{$document.size}></div><{/if}>
							</div>
							<div class="col-12 text-left">
								<hr />
								<{$document.description_short}>
								<hr />
							</div>
							<div class="col-6 col-md-11 col-xl-9 btn-group" role="group">
								<{if $use_modal == 1}>
									<a class="btn btn-primary" data-toggle="modal" data-target="#myModal<{$document.id}>" role="button"> <span class="fa fa-info-circle fa-lg text-light" aria-hidden="true"></span></a>
								<{else}>
									<a class="btn btn-primary" href="<{$xoops_url}>/modules/xmdoc/document.php?doc_id=<{$document.id}>" role="button">
										<span class="fa fa-info-circle fa-lg" aria-hidden="true"></span>
									</a>
								<{/if}>
								<a class="btn btn-primary d-block d-sm-none"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank" title="<{$document.name}>">
									<span class="fa fa-download fa-lg" aria-hidden="true"></span>
								</a>
								<a class="btn btn-primary d-none d-sm-block"  href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank" title="<{$document.name}>">
									<span class="fa fa-download fa-lg" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<{/if}>
			<div class="modal" tabindex="-1" id="myModal<{$document.id}>" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header d-flex justify-content-between">
							<h5 class="modal-title"><{$document.name}></h5>
							<div class="row text-right">
								<div class="col">
									<{if $document.showinfo == 1}>
										<span class="badge badge-secondary fa-lg text-primary ml-1"><span class="fa fa-download" aria-hidden="true"></span><small> <{$document.counter}></small></span>
										<{if $document.size != ''}>
											<span class="badge badge-secondary fa-lg text-primary ml-1 mt-1 mt-lg-0"><span class="fa fa-archive" aria-hidden="true"></span><small> <{$document.size}></small></span>
										<{/if}>
									<{/if}>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<{if $document.showinfo == 1}>
								<div class="row border-bottom border-secondary mx-1 pl-1">
									<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
										  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_DATE_BT}>
										  <figcaption class="figure-caption text-center"><{$document.date}></figcaption>
									</figure>
									<{if $document.mdate|default:''}>
									<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
										  <span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_MDATE_BT}>
										  <figcaption class="figure-caption text-center"><{$document.mdate}></figcaption>
									</figure>
									<{/if}>
									<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
										  <span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>
										  <figcaption class="figure-caption text-center"><{$document.author}></figcaption>
									</figure>
									<{if $document.dorating == 1}>
									<figure class="text-muted m-1 pr-2 text-center border-right border-secondary">
										<{include file="db:xmsocial_rating.tpl" down_xmsocial=$document.xmsocial_arr}>
										<figcaption class="figure-caption text-center"></figcaption>
									</figure>
									<{/if}>
								</div>
							<{/if}>
								<div class="row">
								<div class="col-md-3 d-flex justify-content-center align-items-center">
									<div class="text-center py-3">
										<span class="fa fa-5x xmdoc-ft xmdoc-ft-<{$document.filetype}> fa-<{if $document.filetype == 'pdf'}>file-pdf-o<{elseif $document.filetype == 'image'}>file-image-o<{elseif $document.filetype == 'word'}>file-word-o<{elseif $document.filetype == 'excel'}>file-excel-o<{elseif $document.filetype == 'powerpoint'}>file-powerpoint-o<{elseif $document.filetype == 'archive'}>file-archive-o<{elseif $document.filetype == 'video'}>file-video-o<{elseif $document.filetype == 'audio'}>file-audio-o<{elseif $document.filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
										<{if $document.size != ''}><div class="small text-muted mt-1"><{$document.size}></div><{/if}>
									</div>
								</div>
								<div class="col-md-9 align-self-center">
										<{if $document.description_end}>
											<{$document.description_short}>
											<hr />
											<{$document.description_end}>
										<{else}>
											<{$document.description}>
										<{/if}>
								</div>
							</div>
							<{if $document.filetype == 'pdf'}>
							<div class="row mt-3">
								<div class="col-12">
									<embed src="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" type="application/pdf" width="100%" style="height:65vh;min-height:400px;" />
								</div>
							</div>
							<{elseif $document.filetype == 'image'}>
							<div class="row mt-3">
								<div class="col-12 text-center">
									<img src="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" alt="<{$document.name}>" class="img-fluid rounded" />
								</div>
							</div>
							<{/if}>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<a class="btn btn-primary" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$document.categoryid}>&amp;doc_id=<{$document.id}>" target="_blank" title="<{$document.name}>">
								<span class="fa fa-download fa-lg" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
							</a>
						</div>
						<{if ($document.perm_edit == true) || ($document.perm_del == true)}>
							<div class="modal-footer d-flex justify-content-center">
								<div class="btn-group text-center" role="group">
									<{if $document.perm_edit == true}>
										<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=edit&amp;document_id=<{$document.id}>"><span class="fa fa-edit" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_EDIT}></button>
									<{/if}>
									<{if $document.perm_del == true}>
										<button type="button" class="btn btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmdoc/action.php?op=del&amp;document_id=<{$document.id}>"><span class="fa fa-trash" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DEL}></button>
									<{/if}>
								</div>
							</div>
						<{/if}>
					</div>
				</div>
			</div>
		<{/foreach}>
	<{if $viewlist == true}>
		</tbody>
	</table>
	<{else}>
	</div>
	<{/if}>
	<{if $nav_menu|default:false}>
		<div class="row">
			<div class="col-sm-12" style="padding-bottom: 10px; padding-top: 5px; padding-right: 60px; text-align: right;">
				<{$nav_menu}>
			</div>
		</div>
	<{/if}>
<{else}>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<{$smarty.const._MA_XMDOC_ERROR_NODOCUMENT}>
	</div>
<{/if}>

<{if $index_footer|default:'' != ''}>
    <div class="row pb-2">
        <div class="col-sm-12">
            <hr />
			<{$index_footer}>
        </div>
    </div>
<{/if}>
<script>
(function() {
	var inp = document.getElementById('xmdoc-search-name');
	if (!inp) return;
	var timer;
	inp.addEventListener('keyup', function(e) {
		if (e.key === 'Escape') { inp.value = ''; inp.form.submit(); return; }
		clearTimeout(timer);
		timer = setTimeout(function() { inp.form.submit(); }, 600);
	});
})();
// Auto-ouverture modale depuis résultats de recherche
(function() {
	var params = new URLSearchParams(window.location.search);
	var docId = params.get('open_doc');
	if (!docId) return;
	var modal = document.getElementById('myModal' + docId);
	if (modal && typeof $ !== 'undefined') {
		$(modal).modal('show');
	}
})();
</script>
