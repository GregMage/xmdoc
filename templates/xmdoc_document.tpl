<div class="xmdoc">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php"><{$index_module}></a></li>
			<li class="breadcrumb-item"><a href="index.php?doc_cid=<{$category_id}>"><{$category_name}></a></li>
			<li class="breadcrumb-item active"><{$name}></li>
		</ol>

	<{if $status == 2}>
		<div class="alert alert-warning" role="alert">
			<{$smarty.const._MA_XMDOC_INFO_NEWSWAITING}>
		</div>
	<{/if}>
	<{if $status == 0}>
		<div class="alert alert-danger" role="alert">
			<{$smarty.const._MA_XMDOC_INFO_NEWSDISABLE}>
		</div>
	<{/if}>

	<div class="row mb-2">
		<div class="col-md-12">
			<div class="card xmdoc-border" <{if $category_color != false}>style="border-color : <{$category_color}>;"<{/if}>>
				<div class="card-header" <{if $category_color != false}>style="background-color : <{$category_color}>;"<{/if}>>
					<div class="d-flex justify-content-between">
						<h3 class="mb-0 text-white"><{$name}></h3>

						<{if $showinfo == 1}>
							<div class="row align-items-center text-right">
								<div class="col">
									<span class="badge badge-secondary fa-lg text-primary ml-1"><span class="fa fa-download" aria-hidden="true"></span><small> <{$counter}></small></span>
									<{if $size != ''}>
										<span class="badge badge-secondary fa-lg text-primary ml-1 mt-1 mt-lg-0"><span class="fa fa-archive" aria-hidden="true"></span><small> <{$size}></small></span>
									<{/if}>
								</div>
							</div>
						<{/if}>
					</div>
				</div>

				<{if $showinfo == 1}>
					<div class="row border-bottom border-secondary mx-1 pl-1">
						<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
							  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_DATE_BT}>
							  <figcaption class="figure-caption text-center"><{$date}></figcaption>
						</figure>

						<{if $mdate|default:false}>
						<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
							  <span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_MDATE_BT}>
							  <figcaption class="figure-caption text-center"><{$mdate}></figcaption>
						</figure>
						<{/if}>

						<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
							  <span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_FORMDOC_AUTHOR}>
							  <figcaption class="figure-caption text-center"><{$author}></figcaption>
						</figure>

						<{if $dorating == 1}>
						<figure class="text-muted m-1 pr-2 text-center border-right border-secondary">
							<{include file="db:xmsocial_rating.tpl" down_xmsocial=$xmsocial_arr}>
							<figcaption class="figure-caption text-center"></figcaption>
						</figure>
						<{/if}>
					</div>
				<{/if}>

				<div class="card-body">
					<div class="row">
						<div class="col-md-3 d-flex justify-content-center align-items-center">
							<div class="text-center py-3">
								<span class="fa fa-5x xmdoc-ft xmdoc-ft-<{$filetype}> fa-<{if $filetype == 'pdf'}>file-pdf-o<{elseif $filetype == 'image'}>file-image-o<{elseif $filetype == 'word'}>file-word-o<{elseif $filetype == 'excel'}>file-excel-o<{elseif $filetype == 'powerpoint'}>file-powerpoint-o<{elseif $filetype == 'archive'}>file-archive-o<{elseif $filetype == 'video'}>file-video-o<{elseif $filetype == 'audio'}>file-audio-o<{elseif $filetype == 'text'}>file-text-o<{else}>file-o<{/if}>" aria-hidden="true"></span>
								<{if $size != ''}><div class="small text-muted mt-1"><{$size}></div><{/if}>
							</div>
						</div>
						<div class="col-md-9 align-self-center">
								<{if $description_end}>
									<{$description_short}>
									<hr />
									<{$description_end}>
								<{else}>
									<{$description}>
								<{/if}>
						</div>
					</div>
					<{if $filetype == 'pdf'}>
					<div class="row mt-3">
						<div class="col-12">
							<embed src="<{$download_url}>" type="application/pdf" width="100%" style="height:75vh;min-height:500px;" />
						</div>
					</div>
					<{elseif $filetype == 'image'}>
					<div class="row mt-3">
						<div class="col-12 text-center">
							<img src="<{$download_url}>" alt="<{$name}>" class="img-fluid rounded" />
						</div>
					</div>
					<{/if}>
				</div>

				<div class="card-footer d-flex justify-content-center" <{if $category_color != false}>style="background-color : <{$category_color}>;"<{/if}>>
					<a class="btn btn-primary btn-lg" title="<{$name}>" href="<{$xoops_url}>/modules/xmdoc/download.php?cat_id=<{$category_id}>&amp;doc_id=<{$doc_id}>" target="_blank">
						<span class="fa fa-download fa-2x" aria-hidden="true"></span> <{$smarty.const._MA_XMDOC_DOWNLOAD}>
					</a>
				</div>

			</div>
		</div>
	</div>

	<hr />

	<{if ($perm_edit == true) || ($perm_del == true)}>
	<div class="col-12 pl-4 pr-4 pb-2">
				<div class="text-center pt-2">
					<div class="btn-group text-center role="group">
						<{if $perm_edit == true}>
							<a class="btn btn-secondary" href="action.php?op=edit&amp;document_id=<{$doc_id}>"><span class="fa fa-edit" aria-hidden="true"></span> Modifier</a>
						<{/if}>
						<{if $perm_del == true}>
							<a class="btn btn-secondary" href="action.php?op=del&amp;document_id=<{$doc_id}>"><span class="fa fa-trash" aria-hidden="true"></span> Effacer</a>
						<{/if}>
					</div>
				</div>
	</div>
	<{/if}>

</div><!-- .xmdoc -->